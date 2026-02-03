<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExerciseGroup;
use App\Models\GroupExercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExerciseGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
            }

            // Using member_id because authenticated user is likely a Member instance
            $query = ExerciseGroup::where('member_id', $user->member_id);

            // Filter by active status
            if ($request->has('is_active')) {
                // filter_var handles strings 'true', 'false', '1', '0', 'on', 'off' nicely
                $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
            }

            // Sorting
            if ($request->has('sort')) {
                switch ($request->sort) {
                    case 'oldest':
                        $query->oldest();
                        break;
                    case 'a-z':
                        $query->orderBy('title', 'asc');
                        break;
                    case 'z-a':
                        $query->orderBy('title', 'desc');
                        break;
                    case 'latest':
                    default:
                        $query->latest();
                        break;
                }
            } else {
                $query->latest();
            }

            $groups = $query->withCount('groupExercises')->paginate(20);

            return response()->json([
                'status' => true,
                'message' => 'Exercise groups retrieved successfully',
                'data' => $groups
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while retrieving exercise groups',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'exercises' => 'array',
                'exercises.*' => 'required|exists:master_exercises,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            
            DB::beginTransaction();

            $group = ExerciseGroup::create([
                'member_id' => $user->member_id,
                'title' => $request->title,
                'is_active' => true 
            ]);

            if ($request->has('exercises')) {
                foreach ($request->exercises as $exerciseData) {
                    GroupExercise::create([
                        'group_id' => $group->id,
                        'master_exercise_id' => $exerciseData
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Exercise group created successfully',
                'data' => $group->load('groupExercises.masterExercise')
            ], 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating the exercise group',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        try {
            // Eager load with potential filtering on the nested relationship
            $group = ExerciseGroup::with(['groupExercises' => function ($query) use ($request) {
                if ($request->has('muscle_group_id')) {
                    $query->whereHas('masterExercise', function ($q) use ($request) {
                        $q->where('muscle_group_id', $request->muscle_group_id);
                    });
                }
                $query->with('masterExercise');
            }])->find($id);

            if (!$group) {
                return response()->json(['status' => false, 'message' => 'Exercise group not found'], 404);
            }

            // Optional: Check if the user owns this group
            if ($group->member_id !== Auth::user()->member_id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized access to this group'], 403);
            }

            return response()->json([
                'status' => true,
                'message' => 'Exercise group retrieved successfully',
                'data' => $group
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while retrieving the exercise group',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'sometimes|required|string|max:255',
                'is_active' => 'sometimes|boolean',
                'exercises' => 'sometimes|array',
                'exercises.*' => 'required|exists:master_exercises,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $group = ExerciseGroup::find($id);

            if (!$group) {
                return response()->json(['status' => false, 'message' => 'Exercise group not found'], 404);
            }

            if ($group->member_id !== Auth::user()->member_id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized update to this group'], 403);
            }

            DB::beginTransaction();

            $group->update($request->only(['title', 'is_active']));

            if ($request->has('exercises')) {
                // $group->groupExercises()->delete();

                foreach ($request->exercises as $exerciseData) {
                    $existing = GroupExercise::where('group_id', $group->id)->where('master_exercise_id', $exerciseData)->first();
                    if ($existing) {
                        continue;
                    }
                    GroupExercise::create([
                        'group_id' => $group->id,
                        'master_exercise_id' => $exerciseData
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Exercise group updated successfully',
                'data' => $group->load('groupExercises.masterExercise')
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating the exercise group',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $group = ExerciseGroup::find($id);

            if (!$group) {
                return response()->json(['status' => false, 'message' => 'Exercise group not found'], 404);
            }

            if ($group->member_id !== Auth::user()->member_id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized delete to this group'], 403);
            }

            $group->delete();

            return response()->json([
                'status' => true,
                'message' => 'Exercise group deleted successfully'
            ], 200);

        } catch (\Throwable $th) {
             return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting the exercise group',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function removeExercise(Request $request, $id)
    {
        try {
            // $validator = Validator::make($request->all(), [
            //     'group_id' => 'required|exists:exercise_groups,id',
            //     'master_exercise_id' => 'required|exists:master_exercises,id',
            // ]);

            // if ($validator->fails()) {
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'Validation error',
            //         'errors' => $validator->errors()
            //     ], 422);
            // }

            $deleted = GroupExercise::find($id);

            if (!$deleted) {
                return response()->json([
                    'status' => false,
                    'message' => 'Exercise not found in this group'
                ], 404);
            }

            $group = ExerciseGroup::find($deleted->group_id);

            if ($group->member_id !== Auth::user()->member_id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized action'], 403);
            }

            if ($deleted->delete()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Exercise removed from group successfully'
                ], 200);
            } else {
                 return response()->json([
                    'status' => false,
                    'message' => 'Exercise not found in this group'
                ], 404);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while removing the exercise',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
