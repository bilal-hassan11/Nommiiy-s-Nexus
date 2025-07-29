<?php

namespace App\Http\Controllers;

use App\Models\BlogType; // Make sure you have this model
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlogTypeController extends Controller
{
    /**
     * Display a listing of the blog types.
     */
    public function index()
    {
        // For the dropdown in AddBlogContentModal
        return response()->json(BlogType::all());
    }

    /**
     * Store a newly created blog type in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'blogType' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9_ ]+$/', // Only alphabets, numbers, underscore and space
                'unique:blog_types,blog_type', // Ensure uniqueness in the 'blog_type' column
            ],
            'priority' => 'required|integer|min:1', // Priority should be an integer, minimum 1
            'locales' => 'required|array',
            'locales.en-bd' => 'nullable|string|max:255',
            'locales.bn-bd' => 'nullable|string|max:255',
            'locales.en-np' => 'nullable|string|max:255',
            'locales.ne-np' => 'nullable|string|max:255',
        ], [
            // Custom messages if needed
            'blogType.unique' => 'The blog type must be unique.',
            'blogType.regex' => 'The blog type can only contain alphabets, numbers, underscores, and spaces.',
        ]);

        $blogType = BlogType::create([
            'blog_type' => $validatedData['blogType'],
            'priority' => $validatedData['priority'],
            'locales' => $validatedData['locales'], // Store as JSON in the database
        ]);

        return response()->json($blogType, 201); // 201 Created
    }

    /**
     * Display the specified blog type.
     */
    public function show(string $id)
    {
        $blogType = BlogType::find($id);

        if (!$blogType) {
            return response()->json(['message' => 'Blog type not found'], 404);
        }

        return response()->json($blogType);
    }

    /**
     * Update the specified blog type in storage.
     */
    public function update(Request $request, string $id)
    {
        $blogType = BlogType::findOrFail($id);

        $validatedData = $request->validate([
            'blogType' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9_ ]+$/',
                Rule::unique('blog_types', 'blog_type')->ignore($blogType->id), // Ignore current record for unique check
            ],
            'priority' => 'required|integer|min:1',
            'locales' => 'required|array',
            'locales.en-bd' => 'nullable|string|max:255',
            'locales.bn-bd' => 'nullable|string|max:255',
            'locales.en-np' => 'nullable|string|max:255',
            'locales.ne-np' => 'nullable|string|max:255',
        ]);

        $blogType->update([
            'blog_type' => $validatedData['blogType'],
            'priority' => $validatedData['priority'],
            'locales' => $validatedData['locales'],
        ]);

        return response()->json($blogType);
    }

    /**
     * Remove the specified blog type from storage.
     */
    public function destroy(string $id)
    {
        $blogType = BlogType::findOrFail($id);
        $blogType->delete();

        return response()->json(null, 204); // 204 No Content
    }
}