<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\LoginRequest; // Import the new request class

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {


        try {
            // Find the user by email
            $user = User::where('email', $request->email)->where('status', 'active')->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid credentials.',
                ], 422);
            }

            $token = $user->createToken('Login Token')->plainTextToken;

            // Return success response with token and user data
            return response()->json([
                'message' => 'Login successful',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => $user->status,
                ],
                'token' => $token,
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'An unexpected error occurred.',
            ], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function logout()
    {
        try {
            // Get the authenticated user
            $user = Auth::user();
              // Check if user exists (in case of an issue with authentication)
              if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            // Invalidate the current user's token
            if ($user) {
                $user->tokens()->delete(); // Delete all tokens for the user
            }

            return response()->json([
                'message' => 'User logged out successfully.',
            ], 200); // HTTP status code 200 for OK
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while logging out.',
            ], 500); // HTTP status code 500 for server error
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            // Validate the request data
            $validated = $request->validated();

            // Retrieve the authenticated user
            $user = Auth::user();
              // Check if user exists (in case of an issue with authentication)
              if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }


            // Update the user's password
            $user->password = Hash::make($validated['new_password']);
            $user->save();

            // Return a success response
            return response()->json([
                'message' => 'Password updated successfully.',
            ], 200); // Using HTTP status code 200 for OK

        } catch (\Exception $e) {
            // Return an error response in case of failure
            return response()->json([
                'message' => 'An unexpected error occurred.',

            ], 500); // Using HTTP status code 500 for server error
        }
    }


}
