<?php

namespace App\Http\Controllers;

use App\Models\GeneralInfoSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GeneralInfoSettingController extends Controller
{
    /**
     * Display the specified general info settings based on currency.
     */
    public function show(Request $request)
    {
        $request->validate([
            'currency' => ['required', 'string', Rule::in(['BDT', 'NPR'])],
        ]);

        $settings = GeneralInfoSetting::where('currency', $request->currency)->first();

        // If no settings found for the currency, return null
        return response()->json($settings);
    }

    /**
     * Update or create general info settings. This acts as an upsert.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'currency' => ['required', 'string', Rule::in(['BDT', 'NPR'])],
            'about_us_enabled' => 'required|boolean',
            'faq_enabled' => 'required|boolean',
            'terms_enabled' => 'required|boolean',
            'privacy_policy_enabled' => 'required|boolean',
            'responsible_gaming_enabled' => 'required|boolean',
            'disconnect_policy_enabled' => 'required|boolean',
        ]);

        // Find the settings record by currency, or create if it doesn't exist
        $settings = GeneralInfoSetting::updateOrCreate(
            ['currency' => $validatedData['currency']],
            [
                'about_us_enabled' => $validatedData['about_us_enabled'],
                'faq_enabled' => $validatedData['faq_enabled'],
                'terms_enabled' => $validatedData['terms_enabled'],
                'privacy_policy_enabled' => $validatedData['privacy_policy_enabled'],
                'responsible_gaming_enabled' => $validatedData['responsible_gaming_enabled'],
                'disconnect_policy_enabled' => $validatedData['disconnect_policy_enabled'],
            ]
        );

        return response()->json([
            'message' => 'General info settings updated successfully!',
            'data' => $settings
        ]);
    }
}