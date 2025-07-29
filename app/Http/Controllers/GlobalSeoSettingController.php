<?php

namespace App\Http\Controllers;

use App\Models\GlobalSeoSetting; // Use the new model
use Illuminate\Http\Request;

class GlobalSeoSettingController extends Controller
{
    /**
     * Retrieve the single global SEO settings record.
     */
    public function index()
    {
        // Always try to find the first record (which should be the only one)
        // If it doesn't exist, create it so we always have a record to work with.
        $seoSettings = GlobalSeoSetting::firstOrCreate([]);

        return response()->json($seoSettings);
    }

    /**
     * Store or update the single global SEO settings record.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'seo_header' => 'nullable|string',
            'seo_homepage' => 'nullable|string',
        ]);

        // Always find the first record (or create it if it doesn't exist yet)
        $seoSettings = GlobalSeoSetting::firstOrCreate([]);

        // Fill both fields from the validated data and save.
        $seoSettings->fill($validatedData);
        $seoSettings->save();

        return response()->json($seoSettings, $seoSettings->wasRecentlyCreated ? 201 : 200);
    }
}