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
            $imageName = null;
            if ($request->hasFile('member_profile')) {
                $imageName = time() . '_' . $request->file('member_profile')->getClientOriginalName();
                $path = $request->file('member_profile')->storeAs('profile', $imageName, 'public');
            } 
            
            $member = Members::create([
                'member_full_name' => $validatedData['member_full_name'],
                'member_email' => $validatedData['member_email'],
                'member_password' => Hash::make($validatedData['member_password']),
                'member_profile' => $imageName ?? null,
                'member_gender' => $request->json('member_gender'),
                'member_age' => $request->json('member_age'),
                'member_weight' => $request->json('member_weight'),
                'member_weight_unit' => $request->json('member_weight_unit'),
                'member_height_ft' => $request->json('member_height_ft'),
                'member_height_in' => $request->json('member_height_in'),
                'member_goal' => $request->json('member_goal'),
                'member_exp' => $request->json('member_exp'),
                'member_excerise_place' => $request->json('member_excerise_place'),
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
        
        $user = Members::where('member_email', $request->json('email'))->first();
        
        if (!$user || !Hash::check($request->json('password'), $user->member_password)) {
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
