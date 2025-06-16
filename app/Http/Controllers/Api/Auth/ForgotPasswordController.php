<?php

namespace App\Http\Controllers\Api\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordChangedNotification;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Http\Requests\Auth\ValidateOTPRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendResetLinkRequest;


class ForgotPasswordController extends Controller
{
    // Define a class property for time variable
    protected $tokenExpirationMinutes;

    // Constructor to initialize the time variable
    public function __construct()
    {
        $this->tokenExpirationMinutes = 30;
    }

    public function sendResetLinkEmail(SendResetLinkRequest $request)
    {
        try {
            $email = $request->input('email');
            $token = Str::random(64); // Generate a random token

            PasswordReset::updateOrCreate(
                ['email' => $email],
                ['token' => $token, 'created_at' => Carbon::now()]
            );

            // Generate the reset link
            $resetLink = url('/reset-password', ['token' => $token]);


            $data = ['resetLink' => $resetLink];

            Mail::to($email)->send(new ForgotPasswordMail($data)); // Send reset email with link

            return response()->json([
                'message' => 'Please check your email for the password reset link!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([

                'message' => 'An error occurred while sending the reset link.',
            ], 500);
        }
    }

    public function showResetForm($token)
    {
        return response()->json([
            'message' => 'You are redirected to forgot password view',
        ]) ;
    }

    public function updatePassword(Request $request)
{
    // Retrieve the inputs directly from the request
    $token = $request->input('token');
    $password = $request->input('password');
    $passwordConfirmation = $request->input('password_confirmation');

    // Basic validation
    if (!$token || !$password || !$passwordConfirmation) {
        return response()->json(['message' => 'Token, password, and password confirmation are required.'], 400);
    }

    if (strlen($password) < 8) {
        return response()->json(['message' => 'Password must be at least 8 characters.'], 400);
    }

    if ($password !== $passwordConfirmation) {
        return response()->json(['message' => 'Passwords do not match.'], 400);
    }

    // Find the password reset record
    $passwordReset = DB::table('password_reset_tokens')->where('token', $token)->first();

    // Check if the token is valid
    if (!$passwordReset) {
        return response()->json(['message' => 'Invalid token.'], 400);
    }

    // Check if the token has expired (30 minutes)
    if (Carbon::parse($passwordReset->created_at)->addMinutes(30) < Carbon::now()) {
        return response()->json(['message' => 'The password reset token has expired.'], 400);
    }

    // Find the user by email
    $user = User::where('email', $passwordReset->email)->first();

    // Check if user exists
    if (!$user) {
        return response()->json(['message' => 'User not found.'], 404);
    }

    // Update the user's password
    try {
        $user->password = Hash::make($password);
        $user->save();

        // Delete the used token
        DB::table('password_reset_tokens')->where('token', $token)->delete();

        return response()->json(['message' => 'Password updated successfully.'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'An error occurred while updating the password.'], 500);
    }
}

}
