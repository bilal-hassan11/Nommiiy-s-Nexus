<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWebSettingRequest; // Ensure this is imported
use App\Models\WebSetting; // Ensure this is imported
use Illuminate\Support\Facades\Storage; // Ensure Storage facade is imported

class WebSettingController extends Controller
{
    /**
     * Store a newly created web setting in storage.
     */
    public function store(StoreWebSettingRequest $request)
    {
        $validatedData = $request->validated();

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Store the image in a 'web_settings_images' directory within 'public' disk
            $imagePath = $request->file('image')->store('web_settings_images', 'public');
        }

        // Create the web setting record in the database
        $webSetting = WebSetting::create([
            'merchant' => $validatedData['merchant'],
            'type' => $validatedData['type'],
            'name' => $validatedData['name'],
            'status' => $validatedData['status'],
            'image' => $imagePath, // Store the path to the uploaded image
            'remark' => $validatedData['remark'] ?? null, // Use null for nullable fields if not provided
        ]);

        // Return a successful JSON response
        return response()->json([
            'message' => 'Web Setting created successfully!',
            'web_setting' => $webSetting
        ], 201); // 201 Created status code
    }

    // You can add other methods like index(), show(), update(), destroy() here.
}