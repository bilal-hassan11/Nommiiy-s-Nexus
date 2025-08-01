<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemberTag; // Import your MemberTag model
use Illuminate\Validation\Rule; // Import for Rule::in

class MemberTagController extends Controller
{
    /**
     * Store a newly created member tag in storage.
     */
    public function store(Request $request)
    {   
        //dd($request->all());
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'tag_name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:member_tags,tag_name', // Ensure tag_name is unique in the 'member_tags' table
                ],
                'description' => 'nullable|string|max:1000',
                'remark' => 'nullable|string|max:1000',
                'domain_binding' => [ Rule::in(['true', 'false'])], // Laravel's 'boolean' rule accepts "true", "false", 1, 0, etc.
                'mode' => ['required', 'string', Rule::in(['single', 'batch'])], // Validate the 'mode' field
            ]);

            // Create a new MemberTag instance
            $memberTag = new MemberTag(); // Use the imported model
            $memberTag->tag_name = $validatedData['tag_name'];
            $memberTag->description = $validatedData['description'];
            $memberTag->remark = $validatedData['remark'];
            $memberTag->domain_binding = $validatedData['domain_binding'];
            // The 'mode' is typically for frontend logic or specific backend processing,
            // not usually stored directly as a column in a simple tags table.
            // If you need to store it, add a 'mode' column to your migration.

            $memberTag->save();

            // Return a success JSON response
            return response()->json([
                'message' => 'Member Tag created successfully!',
                'tag' => $memberTag, // Optionally return the created tag data
            ], 201); // 201 Created status code
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel automatically handles validation exceptions
            // and returns a 422 Unprocessable Entity response with errors.
            // Re-throwing ensures it bubbles up as expected.
            throw $e;
        } catch (\Exception $e) {
            // Catch any other general exceptions
            return response()->json([
                'message' => 'An error occurred while creating the member tag.',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }
}