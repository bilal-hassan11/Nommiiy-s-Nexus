<?php

namespace App\Http\Controllers\Api;

use Mpdf\Mpdf;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Picqer\Barcode\BarcodeGeneratorPNG;
use App\Services\Product\ProductService;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\Imports\ImportExcelDataRequest;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }



    public function import(ImportExcelDataRequest $request)
    {
        $response = $this->productService->importExcelData($request);
        return response()->json($response, $response['success'] ? ApiResponseCodeEnum::CREATED->value : ApiResponseCodeEnum::SERVER_ERROR->value);
    }


    // Method to download the sample Excel file
    public function downloadSampleExcel()
    {
        $fileName = 'sample_product_import.xlsx';
        $filePath = public_path('excel_format_samples/' . $fileName); // Path to the file in the 'excel_format_samples' folder

        // Check if the file exists
        if (!file_exists($filePath)) {
            return response()->json(['message' => 'Sample file not found.'], 404);
        }

        // Prepare the headers for the response
        return response()->download($filePath, $fileName);
    }

    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        $response = $this->productService->paginateProductFilter($request);

        if (isset($response['error'])) {
            return response()->json([
                'success' => false,
                'message' => $response['error'],
                'error' => $response['message'],
            ], ApiResponseCodeEnum::SERVER_ERROR->value);
        }

        return response()->json($response, ApiResponseCodeEnum::OK->value);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        $response = $this->productService->createProducts($data);

        // Use the provided status code from the response array
        return response()->json($response, $response['status']);
    }




    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $response = $this->productService->findById($id);
        return response()->json($response, $response['status']);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $response = $this->productService->updateProducts($id, $data);
        return response()->json($response, $response['status']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $response = $this->productService->deleteProduct($id);
        return response()->json($response, $response['status']);
    }


    public function destroyMultiple(Request $request): JsonResponse
    {
        // Call the service method to extract and validate IDs
        $idResult = $this->productService->extractIdsFromRequest($request);

        // Check if the extraction was successful
        if (!$idResult['success']) {
            return response()->json(['message' => $idResult['message']], ApiResponseCodeEnum::NOT_FOUND->value);
        }

        // Proceed with deletion using the validated IDs
        $response = $this->productService->deleteProducts($idResult['ids']);

        // Return a JSON response based on success or failure
        return response()->json($response, $response['success'] ? ApiResponseCodeEnum::OK->value : ApiResponseCodeEnum::NOT_FOUND->value);
    }


    public function downloadProductPriceList(): JsonResponse|Response
    {

        $response = $this->productService->generateProductPriceListPdf();

        if ($response['success']) {
            // Return the PDF content as a download
            return response($response['pdfContent'], ApiResponseCodeEnum::OK->value)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="Products_Price_List.pdf"');
        }

        return response()->json([
            'success' => false,
            'message' => $response['message'],
            'error' => $response['error'],
        ], ApiResponseCodeEnum::SERVER_ERROR->value);
    }




    public function downloadProductBarcodeList(): JsonResponse|Response
    {

        $response = $this->productService->generateProductBarcodePdf();

        if ($response['success']) {

            return response()->make($response['pdf'], ApiResponseCodeEnum::OK->value, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="product_barcode_list.pdf"'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $response['message'],
            ], ApiResponseCodeEnum::NOT_FOUND->value);
        }
    }

    public function getBarcodeData(Request $request): JsonResponse
    {
        $request->validate([
            'barcode' => 'required|string',
        ]);

        $data = $this->productService->getProductByBarcode($request->barcode);

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product not found for the provided barcode.',
            ],ApiResponseCodeEnum::NOT_FOUND->value);
        }
    }
}
