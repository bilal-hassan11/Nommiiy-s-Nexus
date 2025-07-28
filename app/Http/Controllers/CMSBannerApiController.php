<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCMSBannerRequest;
use App\Models\CMSBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CMSBannerApiController extends Controller
{
    /**
     * Store a newly created banner in storage.
     */
    public function store(StoreCMSBannerRequest $request)
    {   
        //dd('success');
        $validatedData = $request->validated();

        // Handle mobile image upload
        $mobileImagePath = null;
        if ($request->hasFile('mobileImage')) {
            $mobileImagePath = $request->file('mobileImage')->store('banner_mobile_images', 'public');
        }

        // Handle web image upload
        $webImagePath = null;
        if ($request->hasFile('webImage')) {
            $webImagePath = $request->file('webImage')->store('banner_web_images', 'public');
        }

        $banner = CMSBanner::create([
            'merchant_id' => $validatedData['merchantId'],
            'status' => $validatedData['status'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?? null,
            'language' => $validatedData['language'],
            'index' => $validatedData['index'],
            'start_date' => $validatedData['startDate'],
            'end_date' => $validatedData['endDate'],
            'mobile_image' => $mobileImagePath,
            'web_image' => $webImagePath,
            'href' => $validatedData['href'] ?? null,
        ]);

        return response()->json([
            'message' => 'Banner added successfully!',
            'banner' => $banner
        ], 201); // 201 Created status
    }

    // You can add other CRUD methods (index, show, update, destroy) here as needed.
}