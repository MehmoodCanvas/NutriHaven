<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExerciseLog;
use App\Models\GroupExercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ExerciseLogController extends Controller
{
    /**
     * Start a new exercise log within a group (Stopwatch Start).
     */
    public function start(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'group_exercise_id' => 'required|exists:group_exercises,id',
                'start_time' => 'required|date_format:H:i:s', // Expecting simple time string or full datetime? User said "time". Usually H:i:s. Let's assume standard H:i:s or datetime. To be safe let's take string.
                'log_date' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();

            $groupExercise = GroupExercise::find($request->group_exercise_id);
            
            // Construct full datetime from date and time
            $startDateTime = Carbon::parse($request->log_date . ' ' . $request->start_time);

            $log = ExerciseLog::create([
                'member_id' => $user->member_id,
                'master_exercise_id' => $groupExercise->master_exercise_id,
                'group_exercise_id' => $request->group_exercise_id,
                'start_time' => $startDateTime,
                'log_date' => $request->log_date,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Exercise started',
                'data' => $log
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while starting the exercise',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * End an active exercise log (Stopwatch Stop).
     */
    public function end(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'group_exercise_id' => 'required|exists:group_exercises,id',
                'end_time' => 'required|date_format:H:i:s', 
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();

            // Find the most recent active log for this group exercise and user
            $log = ExerciseLog::where('member_id', $user->member_id)
                ->where('group_exercise_id', $request->group_exercise_id)
                ->whereNull('end_time')
                ->latest('start_time')
                ->first();

            if (!$log) {
                return response()->json([
                    'status' => false,
                    'message' => 'No active exercise found to end'
                ], 404);
            }

            // Use the log's date for the end time
            $endDateTime = Carbon::parse($log->log_date->format('Y-m-d') . ' ' . $request->end_time);

            // Basic validation: End time should be after start time
            // We might need to handle day crossover if the user exercised past midnight, 
            // but for now relying on log_date implies strictly same-day logging or we'd need more complex logic.
            // If end time is "smaller" than start time string-wise but actually next day, this simple logic fails.
            // However, given the "log_date" constraint on creation, this assumes same day. 
            // If it's effectively "next day" but the time passed is just time, we can't easily know without date.
            // BUT, usually a stopwatch "time" is absolute or just time of day. 
            // If the user sends "00:15:00" and start was "23:50:00", it's technically next day.
            // With just Time, we can try to guess? 
            // Let's stick to using log_date. If result is before start_time, maybe add a day?
            
            if ($endDateTime->lt($log->start_time)) {
                // Try adding a day if it looks like midnight crossing?
                // Or just fail. User logic implies simple stopwatch.
                $endDateTime->addDay();
            }

            $log->update([
                'end_time' => $endDateTime
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Exercise ended',
                'data' => $log
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while ending the exercise',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            
            $query = ExerciseLog::where('member_id', $user->member_id)
                ->with(['masterExercise']);

            if ($request->has('date')) {
                $query->whereDate('log_date', $request->date);
            }

            if ($request->has('master_exercise_id')) {
                $query->where('master_exercise_id', $request->master_exercise_id);
            }
             
            if ($request->has('group_exercise_id')) {
                $query->where('group_exercise_id', $request->group_exercise_id);
            }

            $logs = $query->orderBy('start_time', 'desc')->paginate(20);

            return response()->json([
                'status' => true,
                'message' => 'Exercise logs retrieved successfully',
                'data' => $logs
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while retrieving exercise logs',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
