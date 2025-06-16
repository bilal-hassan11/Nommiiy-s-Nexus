<?php

namespace App\Http\Controllers;

use App\Models\AffiliateGroup; // Import the AffiliateGroup model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // Import the Storage facade

class AffiliateGroupController extends Controller
{
    /**
     * Store a newly created affiliate group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Member created successfully',
        ], 201);
        // $data = $request->validate([
        //     'merchant' => 'required|string',
        //     'name' => 'required|string|max:255',
        //     'currency' => 'required|string',
        //     'memberGroup' => 'required|string',
        //     'remark' => 'nullable|string',
        //     'defaultStatus' => 'required|string',
        //     'active' => 'required|boolean',
        //     'sequence' => 'required|integer',

        //     'noMinimum' => 'boolean',
        //     'noMaximum' => 'boolean',
        //     'minimum' => 'nullable|numeric',
        //     'maximum' => 'nullable|numeric',
        //     'dailyCount' => 'nullable|integer',
        //     'noDailyMaximum' => 'boolean',
        //     'dailyMaximumCount' => 'nullable|integer',

        //     'noMinimumDeposit' => 'boolean',
        //     'noMaximumDeposit' => 'boolean',
        //     'minimumDeposit' => 'nullable|numeric',
        //     'maximumDeposit' => 'nullable|numeric',

        //     'depositWallet' => 'boolean',
        //     'commissionWallet' => 'boolean',
        //     'minimumTransferLimit' => 'nullable|numeric',
        //     'maximumTransferLimit' => 'nullable|numeric',
        //     'dailyMaximumTransferLimit' => 'nullable|numeric',
        //     'targetMultiplier' => 'nullable|numeric',
        // ]);

        // // Map Vue keys to DB fields
        // $mappedData = [
        //     'merchant' => $data['merchant'],
        //     'name' => $data['name'],
        //     'currency' => $data['currency'],
        //     'member_group' => $data['memberGroup'],
        //     'remark' => $data['remark'] ?? null,
        //     'default_status' => $data['defaultStatus'],
        //     'active' => $data['active'],
        //     'sequence' => $data['sequence'],
        //     'no_minimum' => $data['noMinimum'] ?? false,
        //     'no_maximum' => $data['noMaximum'] ?? false,
        //     'minimum' => $data['minimum'] ?? null,
        //     'maximum' => $data['maximum'] ?? null,
        //     'daily_count' => $data['dailyCount'] ?? null,
        //     'no_daily_maximum' => $data['noDailyMaximum'] ?? false,
        //     'daily_maximum_count' => $data['dailyMaximumCount'] ?? null,
        //     'no_minimum_deposit' => $data['noMinimumDeposit'] ?? false,
        //     'no_maximum_deposit' => $data['noMaximumDeposit'] ?? false,
        //     'minimum_deposit' => $data['minimumDeposit'] ?? null,
        //     'maximum_deposit' => $data['maximumDeposit'] ?? null,
        //     'deposit_wallet' => $data['depositWallet'] ?? false,
        //     'commission_wallet' => $data['commissionWallet'] ?? false,
        //     'minimum_transfer_limit' => $data['minimumTransferLimit'] ?? null,
        //     'maximum_transfer_limit' => $data['maximumTransferLimit'] ?? null,
        //     'daily_maximum_transfer_limit' => $data['dailyMaximumTransferLimit'] ?? null,
        //     'target_multiplier' => $data['targetMultiplier'] ?? null,
        // ];

        // $group = AffiliateGroup::create($mappedData);

        // return response()->json(['message' => 'Affiliate Group created successfully.', 'data' => $group]);
    }

    public function list(Request $request)
    {
        return response()->json([
            'message' => 'Affiliate Info Added successfully',
        ], 201);
        // $data = $request->validate([
        //     'merchant' => 'required|string',
        //     'name' => 'required|string|max:255',
        //     'currency' => 'required|string',
        //     'memberGroup' => 'required|string',
        //     'remark' => 'nullable|string',
        //     'defaultStatus' => 'required|string',
        //     'active' => 'required|boolean',
        //     'sequence' => 'required|integer',

        //     'noMinimum' => 'boolean',
        //     'noMaximum' => 'boolean',
        //     'minimum' => 'nullable|numeric',
        //     'maximum' => 'nullable|numeric',
        //     'dailyCount' => 'nullable|integer',
        //     'noDailyMaximum' => 'boolean',
        //     'dailyMaximumCount' => 'nullable|integer',

        //     'noMinimumDeposit' => 'boolean',
        //     'noMaximumDeposit' => 'boolean',
        //     'minimumDeposit' => 'nullable|numeric',
        //     'maximumDeposit' => 'nullable|numeric',

        //     'depositWallet' => 'boolean',
        //     'commissionWallet' => 'boolean',
        //     'minimumTransferLimit' => 'nullable|numeric',
        //     'maximumTransferLimit' => 'nullable|numeric',
        //     'dailyMaximumTransferLimit' => 'nullable|numeric',
        //     'targetMultiplier' => 'nullable|numeric',
        // ]);

        // // Map Vue keys to DB fields
        // $mappedData = [
        //     'merchant' => $data['merchant'],
        //     'name' => $data['name'],
        //     'currency' => $data['currency'],
        //     'member_group' => $data['memberGroup'],
        //     'remark' => $data['remark'] ?? null,
        //     'default_status' => $data['defaultStatus'],
        //     'active' => $data['active'],
        //     'sequence' => $data['sequence'],
        //     'no_minimum' => $data['noMinimum'] ?? false,
        //     'no_maximum' => $data['noMaximum'] ?? false,
        //     'minimum' => $data['minimum'] ?? null,
        //     'maximum' => $data['maximum'] ?? null,
        //     'daily_count' => $data['dailyCount'] ?? null,
        //     'no_daily_maximum' => $data['noDailyMaximum'] ?? false,
        //     'daily_maximum_count' => $data['dailyMaximumCount'] ?? null,
        //     'no_minimum_deposit' => $data['noMinimumDeposit'] ?? false,
        //     'no_maximum_deposit' => $data['noMaximumDeposit'] ?? false,
        //     'minimum_deposit' => $data['minimumDeposit'] ?? null,
        //     'maximum_deposit' => $data['maximumDeposit'] ?? null,
        //     'deposit_wallet' => $data['depositWallet'] ?? false,
        //     'commission_wallet' => $data['commissionWallet'] ?? false,
        //     'minimum_transfer_limit' => $data['minimumTransferLimit'] ?? null,
        //     'maximum_transfer_limit' => $data['maximumTransferLimit'] ?? null,
        //     'daily_maximum_transfer_limit' => $data['dailyMaximumTransferLimit'] ?? null,
        //     'target_multiplier' => $data['targetMultiplier'] ?? null,
        // ];

        // $group = AffiliateGroup::create($mappedData);

        // return response()->json(['message' => 'Affiliate Group created successfully.', 'data' => $group]);
    }

    /**
     * Get all affiliate groups.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $affiliateGroups = AffiliateGroup::all();
        return response()->json($affiliateGroups, 200);
    }

    /**
     * Display the specified affiliate group.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $affiliateGroup = AffiliateGroup::find($id);

        if (!$affiliateGroup) {
            return response()->json(['message' => 'Affiliate Group not found'], 404);
        }

        return response()->json($affiliateGroup, 200);
    }

    /**
     * Update the specified affiliate group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $affiliateGroup = AffiliateGroup::find($id);

        if (!$affiliateGroup) {
            return response()->json(['message' => 'Affiliate Group not found'], 404);
        }

        // Define validation rules
        $rules = [
            'code' => 'required|string|unique:affiliate_groups,code,' . $id, // Exclude the current affiliate group's code
            'name' => 'required|string',
            'level' => 'required|integer',
            'status' => 'required|in:Default,Active,Inactive',
            'sequence' => 'required|integer',
            'remark' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Added for logo upload
        ];

        // Define custom error messages
        $messages = [
            'code.required' => 'The affiliate group code is required.',
            'code.unique' => 'The affiliate group code must be unique.',
            'name.required' => 'The affiliate group name is required.',
            'level.required' => 'The affiliate group level is required.',
            'level.integer' => 'The affiliate group level must be an integer.',
            'status.required' => 'The affiliate group status is required.',
            'status.in' => 'Invalid affiliate group status.',
            'sequence.required' => 'The sequence is required.',
            'sequence.integer' => 'The sequence must be an integer.',
            'logo.image' => 'The logo must be an image.',
            'logo.mimes' => 'The logo must be a file of type: jpeg, png, jpg, gif.',
            'logo.max' => 'The logo may not be greater than 2048 kilobytes.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return a JSON response with the errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle file upload if a new logo is provided
        if ($request->hasFile('logo')) {
            // Delete the old logo if it exists
            if ($affiliateGroup->logo && Storage::exists('public/' . $affiliateGroup->logo)) {
                Storage::delete('public/' . $affiliateGroup->logo);
            }
            $logoPath = $request->file('logo')->store('public/affiliate_group_logos');
            $logoPath = str_replace('public/', '', $logoPath);
            $affiliateGroup->logo = $logoPath;
        }

        // Update the affiliate group's attributes
        $affiliateGroup->code = $request->input('code');
        $affiliateGroup->name = $request->input('name');
        $affiliateGroup->level = $request->input('level');
        $affiliateGroup->status = $request->input('status');
        $affiliateGroup->sequence = $request->input('sequence');
        $affiliateGroup->remark = $request->input('remark');

        $affiliateGroup->save();

        // Return a JSON response with the updated affiliate group data
        return response()->json($affiliateGroup, 200);
    }

    /**
     * Remove the specified affiliate group.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $affiliateGroup = AffiliateGroup::find($id);

        if (!$affiliateGroup) {
            return response()->json(['message' => 'Affiliate Group not found'], 404);
        }

        // Delete the logo file if it exists
        if ($affiliateGroup->logo && Storage::exists('public/' . $affiliateGroup->logo)) {
            Storage::delete('public/' . $affiliateGroup->logo);
        }

        $affiliateGroup->delete();

        return response()->json(['message' => 'Affiliate Group deleted successfully'], 200);
    }
}
