<?php

namespace App\Http\Controllers;

use App\Models\RegisterNameBlacklist;
use Illuminate\Http\Request;

class RegisterNameBlacklistController extends Controller
{
    /**
     * Display a listing of the register name blacklists.
     */
    public function index()
    {
        $blacklists = RegisterNameBlacklist::all();
        return response()->json($blacklists);
    }

    /**
     * Store a newly created register name blacklist entry in storage.
     */
    public function store(Request $request)
    {
        // --- SERVER-SIDE VALIDATION ---
        $validatedData = $request->validate([
            'fullName' => 'required|string|max:255|unique:register_name_blacklists,full_name', // Required, string, max 255, and unique in the 'full_name' column
            'remark' => 'nullable|string|max:1000', // Optional string, max 1000 chars
        ]);
        // --- END SERVER-SIDE VALIDATION ---

        try {
            $blacklistEntry = RegisterNameBlacklist::create([
                'full_name' => $validatedData['fullName'], // Map frontend 'fullName' to database 'full_name'
                'remark' => $validatedData['remark'],
            ]);

            return response()->json(['message' => 'Register name blacklist entry created successfully!', 'blacklist' => $blacklistEntry], 201);

        } catch (\Illuminate\Database\QueryException $e) {
            // This specific error code (1062 for MySQL) indicates a duplicate entry for a unique constraint
            if ($e->errorInfo[1] === 1062) {
                return response()->json(['message' => 'This full name is already in the blacklist.'], 409);
            }
            return response()->json(['message' => 'An error occurred while saving the blacklist entry.', 'error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An unexpected error occurred.', 'error' => $e->getMessage()], 500);
        }
    }

    // You can add update, show, destroy methods here later if needed
}