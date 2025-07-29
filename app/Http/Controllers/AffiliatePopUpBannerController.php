<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAffiliatePopUpBannerRequest;
use App\Models\AffiliatePopUpBanner;
use Illuminate\Support\Facades\Storage;

class AffiliatePopUpBannerController extends Controller
{
    /**
     * Store a newly created Affiliate Pop Up Banner in storage.
     */
    public function store(StoreAffiliatePopUpBannerRequest $request)
    {
        $validatedData = $request->validated();

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('mobileImage')) {
            $imagePath = $request->file('mobileImage')->store('affiliate_pop_up_banners', 'public');
        }

        // Create the new AffiliatePopUpBanner record
        $banner = AffiliatePopUpBanner::create([
            'merchant_id' => $validatedData['merchantId'],
            'status' => $validatedData['status'],
            'language' => $validatedData['language'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'link' => $validatedData['link'],
            'link_target' => $validatedData['linkTarget'],
            'start_date' => $validatedData['startDate'],
            'end_date' => $validatedData['endDate'],
            'mobile_image_path' => $imagePath, // Save the stored file path
        ]);

        return response()->json([
            'message' => 'Affiliate Pop Up Banner added successfully!',
            'banner' => $banner
        ], 201);
    }

    // You can add other CRUD methods (index, show, update, destroy) here as needed
}