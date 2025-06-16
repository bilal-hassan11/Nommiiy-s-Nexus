<?php

// app/Http/Controllers/Api/MemberController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $members = Member::all();
        return response()->json($members);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'merchant' => 'required|string',
            'player_id' => 'required|string',
            'username' => 'required|string',
            'bank_account_number' => 'required|string',
            'member_name' => 'required|string',
            'contact_number' => 'required|string',
            'referral' => 'nullable|string',
            'currency' => 'required|array',
            'kyc_status' => 'required|string',
            'status' => 'required|string',
            'email' => 'required|email',
            'member_tag' => 'nullable|string',
            'referral_link' => 'nullable|string',
        ]);

        // Convert array to comma-separated string
        $validated['currency'] = implode(',', $request->currency);

        $member = Member::create($validated);

        return response()->json($member, 201);
    }


    // Display the specified resource
    public function show($id)
    {
        $member = Member::findOrFail($id);
        return response()->json($member);
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'merchant' => 'nullable|string',
            'player_id' => 'nullable|string',
            'username' => 'nullable|string',
            'bank_account_number' => 'nullable|string',
            'member_name' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'referral' => 'nullable|string',
            'currency' => 'required|array',
            'kyc_status' => 'nullable|string',
            'status' => 'nullable|string',
            'email' => 'nullable|email',
            'member_tag' => 'nullable|string',
            'referral_link' => 'nullable|string',
            // Add any other necessary validation rules here
        ]);

        $member = Member::findOrFail($id);
        $member->update($validated);

        return response()->json($member);
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return response()->json(null, 204);
    }
}
