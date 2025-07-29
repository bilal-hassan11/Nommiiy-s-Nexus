<?php

namespace App\Http\Controllers;

use App\Models\EventTrackingCode;
use Illuminate\Http\Request;

class EventTrackingCodeController extends Controller
{
    /**
     * Display a listing of the event tracking codes based on filters.
     */
    public function index(Request $request)
    {
        $query = EventTrackingCode::query();

        // Filter by merchant
        if ($request->has('merchant') && $request->merchant !== 'All') {
            $query->where('merchant', $request->merchant);
        }

        // Filter by platform (if array, check if any value exists in the JSON array column)
        if ($request->has('platform')) {
            $platforms = explode(',', $request->platform);
            foreach ($platforms as $platform) {
                // Using WHERE JSON_CONTAINS for JSON array column
                $query->whereJsonContains('platform', $platform);
            }
        }

        // Filter by currency
        if ($request->has('currency') && $request->currency !== 'All') {
            $query->where('currency', $request->currency);
        }

        // Filter by tracker (if array, check if any value exists in the JSON array column)
        if ($request->has('tracker')) {
            $trackers = explode(',', $request->tracker);
            foreach ($trackers as $tracker) {
                // Using WHERE JSON_CONTAINS for JSON array column
                $query->whereJsonContains('tracker', $tracker);
            }
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'All') {
            $query->where('status', $request->status);
        }

        // Filter by created_at (start date - renamed to `createdAt` in frontend)
        if ($request->has('createdAt')) {
            $query->whereDate('start_date', '>=', $request->createdAt);
        }

        // Filter by completed_at (end date - renamed to `completedAt` in frontend)
        if ($request->has('completedAt')) {
            $query->whereDate('end_date', '<=', $request->completedAt);
        }

        // Order the results (e.g., by latest first)
        $records = $query->orderBy('created_at', 'desc')->get();

        return response()->json($records);
    }

    // You can add other CRUD methods (store, show, update, destroy) here if needed for managing tracking codes
}