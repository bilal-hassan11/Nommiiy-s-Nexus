<?php

use App\Models\SystemUserPlan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\Tax\TaxController;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Shop\ShopController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\APi\Plans\PlanController;
use App\Http\Controllers\Api\Auth\ProfileController;

use App\Http\Controllers\Api\PurchaseOrderController;
use App\Http\Controllers\Api\Customer\CustomerController;
use App\Http\Controllers\Api\Discount\DiscountController;
use App\Http\Controllers\Api\Supplier\SupplierController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\ProductPricePdf\PdfController;
use App\Http\Controllers\Api\SystemUserPlan\SystemUserPlanController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\AddMembersController;
use App\Http\Controllers\AffiliateGroupController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\withdrawalController;
use App\Http\Controllers\WalletController;


// Group all routes under 'v1' prefix
Route::group(['prefix' => 'v1'], function () {

    Route::apiResource('members', MemberController::class);
    Route::post('/groups', [GroupController::class, 'store']);
    Route::post('/add-member', [AddMembersController::class, 'store']);
    Route::post('/add-member-tag', [AddMembersController::class, 'store']);

    Route::get('/soccer-settings', [AddMembersController::class, 'store']);
    Route::post('/deposits', [DepositController::class, 'store']);

    Route::post('/withdrawals', [withdrawalController::class, 'store']);
    Route::post('/wallet-transfers', [WalletController::class, 'store']);
    //Adjustment
    Route::post('/bonus_rebeat_adjustments', [WalletController::class, 'bonus_rebeat_adjustment_store']);
    Route::post('/walletadjustments', [WalletController::class, 'walletadjustments']);


    Route::post('/affiliate-groups', [AffiliateGroupController::class, 'store']);
    Route::post('/affiliateslist', [AffiliateGroupController::class, 'list']);

    // Public routes
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.reset');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::put('/reset_password', [ForgotPasswordController::class, 'updatePassword'])->name('password.update');


    Route::get('/customers/sample-excel', [CustomerController::class, 'downloadSampleExcel']);
    Route::get('/suppliers/sample-excel', [SupplierController::class, 'downloadSampleExcel']);
    Route::get('/shops/sample-excel', [ShopController::class, 'downloadSampleExcel']);
    Route::get('/products/sample-excel', [ProductController::class, 'downloadSampleExcel']);
    // Private routes (requires authentication)
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/customers/import', [CustomerController::class, 'import']);
        Route::post('/suppliers/import', [SupplierController::class, 'import']);
        Route::post('/shops/import', [ShopController::class, 'import']);
        Route::post('/products/import', [ProductController::class, 'import']);

        Route::get('/profile', [ProfileController::class, 'index']);
        Route::put('/profile', [ProfileController::class, 'update']);
        Route::post('/change-password', [AuthController::class, 'changePassword']);
        Route::post('/logout', [AuthController::class, 'logout']);

        // Suppliers Api

        Route::patch('/suppliers/{id}/status', [SupplierController::class, 'updateStatus']);
        Route::delete('/suppliers', [SupplierController::class, 'batchDeleteByIds']);
        Route::resource('/suppliers', SupplierController::class);

        // Catgeories APi's
        Route::resource('/categories', CategoryController::class);
        Route::delete('/categories', [CategoryController::class, 'destroyMultiple']);
        Route::resource('/roles', RoleController::class);
        Route::delete('/roles', [RoleController::class, 'destroyMultiple']);
        Route::get('/permissions', [PermissionController::class, 'index']);


        // Customers Api
        Route::patch('/customers/{id}/status', [CustomerController::class, 'updateStatus']);
        Route::delete('/customers', [CustomerController::class, 'batchDeleteByIds']);
        Route::resource('/customers', CustomerController::class);


        // Shops Api
        Route::patch('/shops/{id}/status', [ShopController::class, 'updateStatus']);
        Route::delete('/shops', [ShopController::class, 'batchDeleteByIds']);
        Route::resource('/shops', ShopController::class);

        // Users Api
        Route::delete('users', [UserController::class, 'destroyMultiple']);
        Route::patch('/users/{id}/status', [UserController::class, 'changeStatus']);
        Route::resource('users', UserController::class);

        Route::patch('/users/{id}/status', [UserController::class, 'changeStatus']);

        // Tax APi
        Route::delete('/taxes', [TaxController::class, 'batchDeleteByIds']);
        Route::resource('/taxes', TaxController::class);

        // Discount APi
        Route::delete('/discounts', [DiscountController::class, 'batchDeleteByIds']);
        Route::resource('/discounts', DiscountController::class);

        // Products pdf Route
        Route::get('/products/price-list', [ProductController::class, 'downloadProductPriceList'])->name('product.pdf.download');
        Route::get('/products/barcode-pdf', [ProductController::class, 'downloadProductBarcodeList']);
        Route::delete('products', [ProductController::class, 'destroyMultiple']);
        Route::get('/products/barcode', [ProductController::class, 'getBarcodeData']);
        Route::resource('products', ProductController::class)->except(['create', 'edit']);


        // Plans APi's
        Route::resource('/plans', PlanController::class);


        // SYstem User Plan api
        Route::patch('/system-users/plans/{id}/cancel', [SystemUserPlanController::class, 'cancel'])->name('system-user-plans.cancel');
        Route::resource('/system-users/plans', SystemUserPlanController::class);

        // PurchaseOrder APi's
        Route::get('purchase-orders/latest_order_no', [PurchaseOrderController::class, 'latestOrderNumber']);
        Route::patch('/purchase-orders/{id}/status', [PurchaseOrderController::class, 'updateOrderStatus']);
        Route::patch('/purchase-orders/{id}/status-payment', [PurchaseOrderController::class, 'updateOrderPaymentStatus']);
        Route::delete('/purchase-orders', [PurchaseOrderController::class, 'batchDelete']);
        Route::resource('/purchase-orders', PurchaseOrderController::class);
        Route::get('/download-purchase-order-view-pdf/{id}', [PurchaseOrderController::class, 'downloadPurchaseOrderViewPDF']);
    });
});






// public routes

Route::get('/get-data-from-strapi/{page}', function ($page) {
    // !! TODO!! MAKE THIS ENDPIONT SECURE WITH INTERNAL TOKEN SO THAT THIS ENDPOINT
    // IS NOT ACCESSIBLE WITH URL
    try {

        $urls = [
            // "homepage" => env('STRAPI_API_URL') . "/pages/1?populate[PageBuilder][populate]=*",
            "homepage" => env('STRAPI_API_URL') . "/pages/1?populate[PageBuilder][populate][0]=cards,buttons,iconsList,iconImg,images,cards.iconImg",
        ];

        $response = Http::withToken(env('STRAPI_API_TOKEN'))->get($urls[$page]);
        $data = $response->json();

        return response()->json([
            "data" => $data,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            "data" => 'something went wrong'
        ], 500);
    }
});


Route::get('/get-page-content/{page}', function ($page) {
    if ($page === 'homepage') {
        $data = [
            'HeroBanner' => [
                'buttons' => [
                    [
                        'iconName' => null,
                        'id' => 18,
                        'text' => "Start an Instant Chat",
                        "type" => "primary"
                    ],
                    [
                        'iconName' => null,
                        'id' => 19,
                        'text' => "Schedule a meeting for later",
                        "type" => "secondary"
                    ],
                ],
                'hasIconRow' => true,
                'iconsList' => [
                    [
                        'iconName' => "laravel",
                        'id' => 10,
                        'text' => "Button",
                        "type" => "circled-icon-button"
                    ],
                    [
                        'iconName' => "jira",
                        'id' => 9,
                        'text' => "Button",
                        "type" => "circled-icon-button"
                    ],
                    [
                        'iconName' => "figma",
                        'id' => 11,
                        'text' => "Button",
                        "type" => "circled-icon-button"
                    ],
                    [
                        'iconName' => "nextjs",
                        'id' => 12,
                        'text' => "Button",
                        "type" => "circled-icon-button"
                    ],
                    [
                        'iconName' => "react",
                        'id' => 13,
                        'text' => "Button",
                        "type" => "circled-icon-button"
                    ],
                    [
                        'iconName' => "javascript",
                        'id' => 14,
                        'text' => "Button",
                        "type" => "circled-icon-button"
                    ],
                ],
                'id' => 2,
                'markdown' => "# One-Stop Solution for all Your IT Needs \nAt BM-Soft, we go beyond merely offering services; we specialize in bringing your ideas to fruition. Our commitment lies in not only delivering solutions but in transforming concepts into tangible realities. ",
                'name' => "HeroBanner"
            ],
            'OurPartnersSection' => [
                'id' => 1,
                'images' => [
                    [
                        'id' => 1,
                        'path' => "/images/ourpartner/xcalibur.svg"
                    ],
                    [
                        'id' => 2,
                        'path' => "/images/ourpartner/clickup.svg"
                    ],
                    [
                        'id' => 3,
                        'path' => "/images/ourpartner/nexttrade.svg"
                    ],
                    [
                        'id' => 4,
                        'path' => "/images/ourpartner/discord.svg"
                    ],
                    [
                        'id' => 5,
                        'path' => "/images/ourpartner/hubstaff.svg"
                    ],

                ],
                'markdown' => "### Our Esteemed Partners",
                'name' => "OurPartnersSection",

            ],
            'WhatWeDoSection' => [
                'buttons' => [
                    [
                        'iconName' => null,
                        'id' => 17,
                        'text' => "View All Services",
                        "type" => "secondary"
                    ],
                ],
                'cards' => [
                    [
                        'description' => "Enhance your online presence with our custom website solutions designed to attract and engage your audience.",
                        'iconImg' => [
                            'id' => 1,
                            'path' => "/images/whatwedo/businesscreation.png",
                        ],
                        'id' => 1,
                        'styles' => null,
                        'subTitle' => null,
                        'title' => "### Business Website Creation"
                    ],
                    [
                        'description' => "Streamline your business processes with our tailored ERP solutions, optimizing efficiency and scalability",
                        'iconImg' => [
                            'id' => 1,
                            'path' => "/images/whatwedo/erpdevelopment.png",
                        ],
                        'id' => 2,
                        'styles' => null,
                        'subTitle' => null,
                        'title' => "### ERP development"
                    ],
                    [
                        'description' => "Let us Create, Optimize inventory and POS systems with our custom development solutions for seamless operations",
                        'iconImg' => [
                            'id' => 1,
                            'path' => "/images/whatwedo/pos.png",
                        ],
                        'id' => 3,
                        'styles' => null,
                        'subTitle' => null,
                        'title' => "### Inventory / POS Development"
                    ],
                    [
                        'description' => "Elevate your brand with our captivating graphic design services, creating impactful visuals that resonate with your audience",
                        'iconImg' => [
                            'id' => 1,
                            'path' => "/images/whatwedo/graphicdesigning.png",
                        ],
                        'id' => 4,
                        'styles' => null,
                        'subTitle' => null,
                        'title' => "### Graphic Designing"
                    ],
                    [
                        'description' => "Stay ahead with our custom mobile app solutions, delivering intuitive and engaging experiences for users across platforms",
                        'iconImg' => [
                            'id' => 1,
                            'path' => "/images/whatwedo/mobileapp.png",
                        ],
                        'id' => 5,
                        'styles' => null,
                        'subTitle' => null,
                        'title' => "### Mobile App Development"
                    ]
                ],
                'id' => 1,
                'markdown' => "Our Services \n## What we do? \nWe provide a diverse array of bespoke IT services, crafting innovative software solutions tailored for startups, SMBs, and large enterprises alike.By joining forces with us, you gain access to premium custom development services, empowering you with a distinct competitive advantage in the market.",
                'name' => "WhatWeDoSection"
            ],
            'TextImageSection' => [
                "id" => 2,
                "markdown" => "work \n## HOW WE DO \nWe specialize in turning your vision into reality through comprehensive support at every stage of the process. From initial consultation to ongoing top-tier technical assistance, we are committed to guiding you through every step of the journey.",
                "paragraphList" => [
                    "We prepare documentation and designs at the outset for clarity.",
                    "When developing, we employ agile methodology",
                    "Our SQA team ensures thorough testing of all components.",
                    "We assist in setting up your project live and offer lifetime support.",
                ],
                "name" => "StillConfusedCTASection",
                "image" => [
                    'id' => 1,
                    'path' => "/images/howwedosection/main.png"
                ],
            ],
            'TestimonialsSection' => [
                'buttons' => [
                    [
                        'iconName' => null,
                        'id' => 14,
                        'text' => "View All Testimonials",
                        "type" => "secondary"
                    ]
                ],
                'id' => 1,
                'markdown' => "TESTIMONIALS \n## What Our Clients Say? \nExplore testimonials from clients who've partnered with BM-Soft Solutions. Whether startup or enterprise, our personalized service and dedication to excellence have garnered rave reviews. Discover how we've propelled businesses like yours toward success.",
                'name' => "TestimonialsSection",
                "TestimonialsCards" => [
                    [
                        "id" => 7,
                        "title" => "### David willium\nCEO & Founder @ Coinbase",
                        "subTitle" => null,
                        "description" => "I believe in lifelong learning and Learn. is a great place to learn from experts. I’ve learned a lot and recommend it to all my friends and families",
                        "styles" => null,
                        'iconImg' => [
                            'id' => 1,
                            'path' => "/images/testimonials/david.png",
                        ],
                    ],
                    [
                        "id" => 8,
                        "title" => "### David willium\nCEO & Founder @ Coinbase",
                        "subTitle" => null,
                        "description" => "I believe in lifelong learning and Learn. is a great place to learn from experts. I’ve learned a lot and recommend it to all my friends and families",
                        "styles" => null,
                        'iconImg' => [
                            'id' => 1,
                            'path' => "/images/testimonials/david_2.png",
                        ],
                    ],
                    [
                        "id" => 9,
                        "title" => "### David willium\nCEO & Founder @ Coinbase",
                        "subTitle" => null,
                        "description" => "I believe in lifelong learning and Learn. is a great place to learn from experts. I’ve learned a lot and recommend it to all my friends and families",
                        "styles" => null,
                        'iconImg' => [
                            'id' => 1,
                            'path' => "/images/testimonials/david_3.png",
                        ],
                    ],
                    [
                        "id" => 10,
                        "title" => "### David willium\nCEO & Founder @ Coinbase",
                        "subTitle" => null,
                        "description" => "I believe in lifelong learning and Learn. is a great place to learn from experts. I’ve learned a lot and recommend it to all my friends and families",
                        "styles" => null,
                        'iconImg' => [
                            'id' => 1,
                            'path' => "/images/testimonials/david.png",
                        ],
                    ],
                ]
            ],
            'TextImageSection' => [
                'id' => 2,
                'markdown' => "Still Confused? \n## Relax! 😎 \nLet us to handle everything for you. Just book a call, and our professionals will connect with you via Google Meet to delve into your ideas. We'll offer insights, streamline complexities, and outline how we can address your challenges, including budget and time estimates. \nThere's no commitment—our initial consultation is entirely free. Don't delay! Schedule your call now and let's begin crafting the ideal solution for you.",
                'name' => "CTASection",
                'paragraphList' => null,
                'image' => [
                    'id' => 1,
                    'path' => "/images/ctasection/cta.svg"
                ],
                'buttons' => [
                    [
                        'iconName' => "phone",
                        'id' => 14,
                        'text' => "Schedule Call",
                        "type" => "primary"
                    ],
                    [
                        'iconName' => "mail",
                        'id' => 14,
                        'text' => "Start an Instant Chat",
                        "type" => "outline-secondary"
                    ]
                ]
            ],
            'FAQSection' => [
                "id" => 1,
                "markdown" => "FAQ\n## Frequently Asked Questions\nFind Answers to Common Queries. Dive into our FAQ section to gain insight into our services, processes, and more, ensuring clarity every step of the way.",
                "accordion" => [
                    [
                        "id" => 1,
                        "title" => "How can i participate in the ICO Token sale?",
                        "description" => "Lorem ipsum dolor sit amet consectetur. In augue ipsum tellus ultrices. Ac pharetra ultrices consectetur consequat tellus massa. Nec aliquam cras sagittis duis sed euismod arcu hac. Ornare amet ligula ornare lacus aliquam aenean. Eu lacus imperdiet urna amet congue adipiscing. Faucibus magna nisl ullamcorper in facilisis consequat aliquam."
                    ],
                    [
                        "id" => 2,
                        "title" => "What is ICO Crypto?",
                        "description" => "Lorem ipsum dolor sit amet consectetur. In augue ipsum tellus ultrices. Ac pharetra ultrices consectetur consequat tellus massa. Nec aliquam cras sagittis duis sed euismod arcu hac. Ornare amet ligula ornare lacus aliquam aenean. Eu lacus imperdiet urna amet congue adipiscing. Faucibus magna nisl ullamcorper in facilisis consequat aliquam."
                    ],
                    [
                        "id" => 3,
                        "title" => "How can i participate in the ICO Token sale?",
                        "description" => "Lorem ipsum dolor sit amet consectetur. In augue ipsum tellus ultrices. Ac pharetra ultrices consectetur consequat tellus massa. Nec aliquam cras sagittis duis sed euismod arcu hac. Ornare amet ligula ornare lacus aliquam aenean. Eu lacus imperdiet urna amet congue adipiscing. Faucibus magna nisl ullamcorper in facilisis consequat aliquam."
                    ],
                    [
                        "id" => 4,
                        "title" => "How can I purchase Bitcoin?",
                        "description" => "Lorem ipsum dolor sit amet consectetur. In augue ipsum tellus ultrices. Ac pharetra ultrices consectetur consequat tellus massa. Nec aliquam cras sagittis duis sed euismod arcu hac. Ornare amet ligula ornare lacus aliquam aenean. Eu lacus imperdiet urna amet congue adipiscing. Faucibus magna nisl ullamcorper in facilisis consequat aliquam."
                    ]
                ]
            ],
            'ContactForm' => [
                'markdown' => "CONTACT US \n ## Let’s talk about your problem.",
                'contacts' => [
                    [
                        'id' => 1,
                        'description' => "#### Our Location  \nGhouri Town, Islamabad, \nPakistan Autobahn Hyderabad, Pakistan"
                    ],
                    [
                        'id' => 2,
                        'description' => "#### Email Address \ninfo@yourdomain.com \ncontact@yourdomain.com"
                    ],
                    [
                        'id' => 3,
                        'description' => "#### Phone Number \n+92 306 4212632"
                    ],
                    [
                        'id' => 4,
                        'description' => "#### Our Location  \nTell us your problem we will get \nback to you ASAP."
                    ]

                ]
            ],
            'CTACard' => [
                'markdown' => "## Still lost? \nRelax and Let the Professionals Tackle Your Challenges. Don't hesitate—let's discuss your concerns first, and then decide on the best course of action together."
            ]

        ];

        return response()->json($data, 200);
    } elseif ($page === 'about') {
        $data = [
            'TextImageSection' => [
                'id' => 2,
                'markdown' => "## About \nBM-Soft Solutions is your premier IT partner, specializing in a wide array of services including Web Development, Web Designing, Mobile Development, Graphics Designing, Digital Marketing, SEO, and more. Our primary goal is to craft exceptional products for your customers. We achieve this by deeply comprehending both the technical and non-technical dimensions of your project, refining your ideas to perfection and delivering top-notch systems tailored precisely to your needs.",
                'name' => "AboutTopSection",
                'image' => [
                    'id' => 1,
                    'path' => "/images/about/about_vector1.svg"
                ],
            ],
            'CardsGridSection' => [
                'cards' => [
                    [
                        "title" => "### BM-Soft solutions history",
                        "description" => "BM-Soft Solutions offers comprehensive IT services including Web Development, Design, Mobile Apps, Graphics, Digital Marketing, and SEO. Our mission is simple: deliver superior products by blending technical expertise with customer-centric focus",
                        'iconImg' => [
                            'id' => 1,
                            'path' => "/images/about/history.svg",
                        ],
                    ],
                    [
                        "title" => "### BM-Soft solutions mission",
                        "description" => "BM-Soft Solutions: Elevating Success Through Innovation. As a software company, our mission is clear—to empower businesses with cutting-edge solutions. With a focus on excellence and customer satisfaction, we strive to create impactful software products that drive growth and transform industries.",
                        'iconImg' => [
                            'id' => 1,
                            'path' => "/images/about/mission.svg",
                        ],
                    ],
                    [
                        "title" => "### BM-Soft solutions vision",
                        "description" => "BM-Soft Solutions: Redefining the Future of Software Solutions. As a pioneering software company, our vision is to revolutionize industries through innovative technology. With a commitment to excellence and forward-thinking strategies, we aim to be the catalyst for positive change, shaping a brighter future for businesses worldwide",
                        'iconImg' => [
                            'id' => 1,
                            'path' => "/images/about/mission.svg",
                        ],
                    ],
                ]
            ],
            'TextImageSection-2' => [
                'id' => 3,
                'markdown' => "## We are Here to Help! \nBM-Soft Solutions has empowered numerous businesses in finding their ideal software solution. As an IT company, we offer a range of services including Web Development, Design, Mobile Apps, Graphics, Digital Marketing, and SEO. Our commitment lies in delivering exceptional products by understanding both technical and non-technical aspects, refining ideas to perfection for our clients' success.",
                'name' => "HereToHelpSection",
                'image' => [
                    'id' => 1,
                    'path' => "/images/about/about-vector2.png"
                ],
                'buttons' => [
                    [
                        'iconName' => "RightArrow",
                        'id' => 14,
                        'text' => "Get Help Here",
                        "type" => "primary"
                    ],
                ]
            ]

        ];

        return response()->json($data, 200);
    }
});
