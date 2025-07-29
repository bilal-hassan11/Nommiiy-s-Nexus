<?php

namespace App\Http\Controllers;

use App\Models\BlogDisplaySetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlogDisplaySettingController extends Controller
{
    /**
     * Display the current blog display settings.
     * We'll assume a single configuration record,
     * so we find the first one or create a default.
     */
    public function show()
    {
        $settings = BlogDisplaySetting::firstOrCreate(
            [], // If no record exists, create one with default values
            [
                'merchant' => 'MJB',
                'currency' => 'BDT',
                'display_on_top' => 'yes'
            ]
        );

        return response()->json($settings);
    }

    /**
     * Store or update the blog display settings.
     */
    public function storeOrUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'merchant' => ['required', 'string', Rule::in(['MJB'])], // Add more merchants if needed
            'currency' => ['required', 'string', Rule::in(['BDT', 'NPR'])],
            'display_on_top' => ['required', 'string', Rule::in(['yes', 'no'])],
        ]);

        // Find the first (and likely only) settings record, or create it if it doesn't exist
        $settings = BlogDisplaySetting::firstOrCreate([]);

        // Update its attributes
        $settings->update($validatedData);

        return response()->json($settings, 200); // 200 OK for update
    }
}