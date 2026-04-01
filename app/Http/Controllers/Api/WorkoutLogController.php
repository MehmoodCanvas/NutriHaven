<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkoutLog;
use App\Models\WorkoutPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class WorkoutLogController extends Controller
{
    /**
     * Display a listing of workout logs.
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            
            $query = WorkoutLog::where('member_id', $user->member_id);

            if ($request->has('date')) {
                $query->whereDate('log_date', $request->date);
            }

            if ($request->has('workout_plan_id')) {
                $query->where('workout_plan_id', $request->workout_plan_id);
            }

            $perPage = $request->get('per_page', 20);
            $logs = $query->orderBy('log_date', 'desc')->orderBy('start_time', 'desc')->paginate($perPage);

            return response()->json([
                'status' => true,
                'message' => 'Workout logs retrieved successfully',
                'data' => $logs
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while retrieving workout logs',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new workout log (single request with all data).
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'workout_plan_id' => 'nullable|exists:workout_plans,id',
                'start_time' => 'required', // Provide valid Y-m-d H:i:s or combine with date appropriately
                'end_time' => 'required',
                'log_date' => 'required|date',
                'log_data' => 'nullable|array',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();

            // Validate plan ownership if provided
            if ($request->has('workout_plan_id') && $request->workout_plan_id) {
                $plan = WorkoutPlan::where('id', $request->workout_plan_id)
                    ->where('member_id', $user->member_id)
                    ->first();

                if (!$plan) {
                    return response()->json([
                         'status' => false,
                         'message' => 'Workout plan not found or unauthorized'
                    ], 403);
                }
            }

            $startDateTime = Carbon::parse($request->start_time);
            $endDateTime = Carbon::parse($request->end_time);

            $log = WorkoutLog::create([
                'member_id' => $user->member_id,
                'workout_plan_id' => $request->workout_plan_id,
                'start_time' => $startDateTime,
                'end_time' => $endDateTime,
                'log_date' => $request->log_date,
                'log_data' => $request->log_data ?? []
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Workout log saved successfully',
                'data' => $log
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while saving the workout log',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
