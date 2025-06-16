<?php

namespace App\Http\Controllers;

use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AddMembersController extends Controller
{
    public function store(Request $request)
    {
        // //dd($request->all());
        // // 1. Validate the incoming request data
        // $validatedData = $request->validate([
        //     'email' => 'required|email|unique:members',
        //     'currency' => 'required|string',
        //     'countryCode' => 'required|string',
        //     'mobileNumber' => 'required|string',
        //     'fullName' => 'required|string',
        //     'username' => 'required|string|unique:members',
        //     'newPassword' => 'required|string|min:8',
        //     'forcePasswordChange' => 'boolean',
        //     'confirmPassword' => 'required|string|same:newPassword',
        //     'bank' => 'nullable|string',
        //     'accountNumber' => 'nullable|string',
        //     'accountName' => 'nullable|string',
        //     'bankBranch' => 'nullable|string',
        //     'referralCode' => 'nullable|string',
        //     'affiliateLogin' => 'nullable|string',
        // ]);

        // // 2. Hash the password
        // //$hashedPassword = bcrypt($validatedData['newPassword']);

        // // 3. Insert data directly into the database using DB::table()
        // DB::table('member')->insert([
        //     'email' => $validatedData['email'],
        //     'currency' => $validatedData['currency'],
        //     'country_code' => $validatedData['countryCode'],
        //     'mobile_number' => $validatedData['mobileNumber'],
        //     'full_name' => $validatedData['fullName'],
        //     'username' => $validatedData['username'],
        //     'password' => $validatedData['newPassword'],
        //     'force_password_change' => $validatedData['forcePasswordChange'] ,
        //     'bank' => $validatedData['bank'],
        //     'account_number' => $validatedData['accountNumber'],
        //     'account_name' => $validatedData['accountName'],
        //     'bank_branch' => $validatedData['bankBranch'],
        //     'referral_code' => $validatedData['referralCode'],
        //     'affiliate_login' => $validatedData['affiliateLogin'],
        //     'created_at' => now(), // Add created_at and updated_at
        //     'updated_at' => now(),
        // ]);

        // 4. Return a response
        return response()->json([
            'message' => 'Member created successfully',
        ], 201);
    }
}
