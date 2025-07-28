<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBannerRequest;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Store a newly created Banner in storage.
     */
    public function store(StoreBannerRequest $request)
    {
        $validatedData = $request->validated();

        $mobileImagePath = null;
        if ($request->hasFile('mobileImage')) {
            $mobileImagePath = $request->file('mobileImage')->store('banner_mobile_images', 'public');
        }

        $webImagePath = null;
        if ($request->hasFile('webImage')) {
            $webImagePath = $request->file('webImage')->store('banner_web_images', 'public');
        }

        $banner = Banner::create([
            'merchant_id' => $validatedData['merchantId'],
            'content_type' => $validatedData['contentType'], // NEW: Assign content_type
            'status' => $validatedData['status'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?? null,
            'language' => $validatedData['language'],
            'index' => $validatedData['index'],
            'start_date' => $validatedData['startDate'],
            'end_date' => $validatedData['endDate'],
            'mobile_image' => $mobileImagePath,
            'web_image' => $webImagePath,
            
        ]);

        return response()->json([
            'message' => 'Affiliate Banner added successfully!',
            'banner' => $banner
        ], 201);
    }

    // Add other methods (index, show, update, destroy) as needed
}