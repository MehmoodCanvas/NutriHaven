<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Members;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request){
        try {
            $validatedData = $request->validate([
                'member_full_name' => 'required',
                'member_email' => 'required|email|unique:member,member_email',
                'member_password' => 'required|min:6'
            ]);
    
            $member = Members::create([
                'member_full_name' => $validatedData['member_full_name'],
                'member_email' => $validatedData['member_email'],
                'member_password' => Hash::make($validatedData['member_password']),
                'member_profile' => $request->member_profile ?? null,
                'member_gender' => $request->member_gender ?? null,
                'member_age' => $request->member_age ?? null,
                'member_weight' => $request->member_weight ?? null,
                'member_weight_unit' => $request->member_weight_unit ?? null,
                'member_height_ft' => $request->member_height_ft ?? null,
                'member_height_in' => $request->member_height_in ?? null,
                'member_goal' => $request->member_goal ?? null,
                'member_exp' => $request->member_exp ?? null,
                'member_excerise_place' => $request->member_excerise_place ?? null,
                'member_status' => 'pending',
            ]);
    
            $token = $member->createToken('member_token')->plainTextToken;
    
            return response()->json([
                'message' => 'Signup successful',
                'token' => $token,
                'user' => $member
            ], 201); 
    
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422); 
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $user = Members::where('member_email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->member_password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    
        $token = $user->createToken('member_token')->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    
       
    }
    

}
