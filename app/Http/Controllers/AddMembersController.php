<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
// use App\Models\User; // Uncomment this in a real application

class AddMemberController extends Controller
{
    /**
     * Handle the form submission to add a new member.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {   
        dd($request->all());
        // 1. Validate the incoming request data.
        // Laravel's validator is very powerful and handles many common cases automatically.
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'currency' => ['required', 'string', 'in:BDT,NPR'],
            'countryCode' => ['required', 'string'],
            'mobileNumber' => ['required', 'string'],
            'fullName' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'newPassword' => ['required', 'string', 'min:8', 'confirmed'],
            'confirmPassword' => ['required', 'string'],
            'forcePasswordChange' => ['boolean'],
            'bank' => ['nullable', 'string', 'max:255'],
            'accountNumber' => ['nullable', 'string', 'max:255'],
            'accountName' => ['nullable', 'string', 'max:255'],
            'bankBranch' => ['nullable', 'string', 'max:255'],
            'referralCode' => ['nullable', 'string', 'max:255'],
            'affiliateLogin' => ['nullable', 'string', 'max:255'],
        ]);

        // 2. Data is now validated. In a real-world scenario, you would proceed
        // with saving the user to the database.
        // The `unique:users,email` and `unique:users,username` rules
        // automatically check for existing users.
        
        // Example of creating a new user model and saving to the database:
        // $user = User::create([
        //     'email' => $request->email,
        //     'currency' => $request->currency,
        //     'country_code' => $request->countryCode,
        //     'mobile_number' => $request->mobileNumber,
        //     'full_name' => $request->fullName,
        //     'username' => $request->username,
        //     'password' => bcrypt($request->newPassword), // Always hash passwords!
        //     'force_password_change' => $request->boolean('forcePasswordChange'),
        //     'bank' => $request->bank,
        //     'account_number' => $request->accountNumber,
        //     'account_name' => $request->accountName,
        //     'bank_branch' => $request->bankBranch,
        //     'referral_code' => $request->referralCode,
        //     'affiliate_login' => $request->affiliateLogin,
        // ]);

        // 3. Return a success response.
        return response()->json([
            'message' => 'Member added successfully!',
            'member' => [
                'email' => $request->email,
                'fullName' => $request->fullName,
                'username' => $request->username,
            ]
        ], 201); // 201 Created status code is appropriate for resource creation.
    }
}
