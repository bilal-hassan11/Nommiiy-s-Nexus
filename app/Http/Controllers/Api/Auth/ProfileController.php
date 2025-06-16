<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Services\Profile\ProfileService;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Retrieve the authenticated user

            $user = Auth::user();

            // Check if user exists (in case of an issue with authentication)
            if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            // Get user role through the defined relationship
            $userWithRole = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];

            return response()->json([
                'user' => $userWithRole,
                'message' => 'Profile data retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the profile.',
            ], 500);
        }
    }


    public function update(UpdateProfileRequest $request)
    {
        try {
            // Get the authenticated user
            $user = Auth::user();
            // Check if user exists (in case of an issue with authentication)
            if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }


            // Update the user profile with validated data from UpdateProfileRequest
            $user->update($request->validated());

            // Return a success response
            return response()->json([
                'message' => 'Profile updated successfully',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return response
            return response()->json([
                'message' => 'Failed to update profile',
            ], 500);
        }
    }
}
