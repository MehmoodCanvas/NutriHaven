<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkoutPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class WorkoutPlanController extends Controller
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

            $query = WorkoutPlan::where('member_id', $user->member_id);

            // Filter by active status
            if ($request->has('is_active')) {
                $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
            }

            // Sorting
            if ($request->has('sort')) {
                switch ($request->sort) {
                    case 'oldest':
                        $query->oldest();
                        break;
                    case 'a-z':
                        $query->orderBy('name', 'asc');
                        break;
                    case 'z-a':
                        $query->orderBy('name', 'desc');
                        break;
                    case 'latest':
                    default:
                        $query->latest();
                        break;
                }
            } else {
                $query->latest();
            }

            $perPage = $request->get('per_page', 20);
            $plans = $query->paginate($perPage);

            return response()->json([
                'status' => true,
                'message' => 'Workout plans retrieved successfully',
                'data' => $plans
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while retrieving workout plans',
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
                'name' => 'nullable|string|max:255',
                'exercises_data' => 'nullable|array',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            
            $name = $request->name;
            if (empty($name)) {
                $name = 'Workout ' . Carbon::now()->format('Y-m-d H:i:s');
            }

            $plan = WorkoutPlan::create([
                'member_id' => $user->member_id,
                'name' => $name,
                'exercises_data' => $request->exercises_data ?? [],
                'is_active' => true 
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Workout plan created successfully',
                'data' => $plan
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating the workout plan',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $plan = WorkoutPlan::find($id);

            if (!$plan) {
                return response()->json(['status' => false, 'message' => 'Workout plan not found'], 404);
            }

            if ($plan->member_id !== Auth::user()->member_id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized access to this plan'], 403);
            }

            return response()->json([
                'status' => true,
                'message' => 'Workout plan retrieved successfully',
                'data' => $plan
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while retrieving the workout plan',
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
                'name' => 'nullable|string|max:255',
                'is_active' => 'sometimes|boolean',
                'exercises_data' => 'nullable|array',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $plan = WorkoutPlan::find($id);

            if (!$plan) {
                return response()->json(['status' => false, 'message' => 'Workout plan not found'], 404);
            }

            if ($plan->member_id !== Auth::user()->member_id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized update to this plan'], 403);
            }
            
            $dataToUpdate = $request->only(['is_active']);
            
            if ($request->has('name')) {
                $name = $request->name;
                if (empty($name)) {
                     $name = 'Workout ' . Carbon::now()->format('Y-m-d H:i:s');
                }
                $dataToUpdate['name'] = $name;
            }
            
            if ($request->has('exercises_data')) {
                 $dataToUpdate['exercises_data'] = $request->exercises_data ?? [];
            }

            $plan->update($dataToUpdate);

            return response()->json([
                'status' => true,
                'message' => 'Workout plan updated successfully',
                'data' => $plan
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating the workout plan',
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
            $plan = WorkoutPlan::find($id);

            if (!$plan) {
                return response()->json(['status' => false, 'message' => 'Workout plan not found'], 404);
            }

            if ($plan->member_id !== Auth::user()->member_id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized delete to this plan'], 403);
            }

            $plan->delete();

            return response()->json([
                'status' => true,
                'message' => 'Workout plan deleted successfully'
            ], 200);

        } catch (\Throwable $th) {
             return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting the workout plan',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
