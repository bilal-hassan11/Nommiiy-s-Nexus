<?php

namespace App\Http\Controllers;

use App\Models\CountryRestriction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Import for using Rule::in

class CountryRestrictionController extends Controller
{
    /**
     * Display a listing of the country restrictions.
     */
    public function index()
    {
        $restrictions = CountryRestriction::all();
        return response()->json($restrictions);
    }

    /**
     * Store a newly created country restriction in storage.
     */
    public function store(Request $request)
    {
        // --- SERVER-SIDE VALIDATION ADDED HERE ---
        $validatedData = $request->validate([
            'merchant' => [
                'required',
                'string',
                Rule::in(['All', 'MJB', 'MJB2', 'MJB3']), // Ensure merchant is one of these
            ],
            'country' => [
                'required',
                'string',
                Rule::in(['All', 'Afghanistan', 'Pakistan', 'Bangladesh', 'Nepal']), // Ensure country is one of these
            ],
            'name' => 'required|string|max:255', // Name is optional, string, max 255 chars
            'whitelist' => 'required|boolean', // Must be a boolean (true/false)
            'status' => [
                'required',
                'string',
                Rule::in(['Active', 'Inactive']), // Must be 'Active' or 'Inactive'
            ],
            'remark' => 'nullable|string|max:1000', // Remark is optional, string, max 1000 chars
        ]);
        // --- END SERVER-SIDE VALIDATION ---

        try {
            
           
           
                $restriction = CountryRestriction::create($validatedData);
                return response()->json(['message' => 'Country Restriction created successfully!', 'restriction' => $restriction], 201);
            
        } catch (\Illuminate\Database\QueryException $e) {
            // This catches unique constraint violations if the firstOrCreate logic somehow fails or if a race condition occurs.
            if ($e->errorInfo[1] === 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => 'A Restriction for this Merchant and Country already exists.'], 409);
            }
            // Generic error for other database issues
            return response()->json(['message' => 'An error occurred while saving the restriction.', 'error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Catch any other unexpected errors
            return response()->json(['message' => 'An unexpected error occurred.', 'error' => $e->getMessage()], 500);
        }
    }
}