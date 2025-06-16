<?php

namespace App\Services\Product;

use Mpdf\Mpdf;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Imports\ProductImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Database\QueryException;
use Picqer\Barcode\BarcodeGeneratorPNG;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Repositories\Product\ProductRepository;
use App\Services\Import\ImportExcelDataService;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ProductService extends ImportExcelDataService
{
    protected $productRepository;


    public function __construct(ProductRepository $productRepository)
    {

        $this->productRepository = $productRepository;
    }


    public function importExcelData(Request $request): array
    {
        $file = $request->file('file'); // Get the uploaded file

        try {

            DB::beginTransaction();
            $importResult = $this->import(new ProductImport(), $file); // Pass the import class

            if (!$importResult['success']) {
                DB::rollback();
                return $importResult; // Return if the import failed
            }


            DB::commit();

            return [
                'success' => true,
                'data' => [
                    'message' => 'Import completed successfully.',
                    'count' => $importResult['count'],
                ],
            ];
        } catch (\Exception $e) {
            // Rollback transaction in case of error
            DB::rollback();
            return [
                'success' => false,
                'message' => 'An error occurred while importing.',
                'error' => $e->getMessage(),
            ];
        }
    }

    public function createProducts(array $data): array
    {
        try {
            $product = $this->productRepository->createProducts($data);

            return [
                'success' => true,
                'data' => [
                    'message' => 'Product created successfully',
                    'data' => $product->id,
                ],
                'status' => ApiResponseCodeEnum::CREATED->value,
            ];
        } catch (QueryException $ex) {
            // Return 422 for validation-related errors, like unique constraints
            return [
                'success' => false,
                'data' => ['message' => 'Product name and barcode should be unique.'],
                'status' => ApiResponseCodeEnum::UNPROCESSABLE_ENTITY->value,
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'error' => $th->getMessage(),
                'data' => ['message' => 'An unexpected error occurred.'],
                'status' => ApiResponseCodeEnum::SERVER_ERROR->value,
            ];
        }
    }





    public function updateProducts($id, array $data): array
    {
        try {
            $this->productRepository->updateProducts($id, $data);

            return [
                'success' => true,
                'data' => [
                    'message' => 'Product Update successfully',
                ],
                'status' => ApiResponseCodeEnum::CREATED->value,
            ];
        } catch (QueryException $ex) {
            // Return 422 for validation-related errors, like unique constraints
            return [
                'success' => false,
                'data' => ['message' => 'Product name and barcode should be unique.'],
                'status' => ApiResponseCodeEnum::UNPROCESSABLE_ENTITY->value,
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'error' => $th->getMessage(),
                'data' => ['message' => 'An unexpected error occurred.'],
                'status' => ApiResponseCodeEnum::SERVER_ERROR->value,
            ];
        }
    }


    public function findById(int $id): array
    {
        try {
            $item = $this->productRepository->getById($id);

            if ($item) {
                // Transform the image path to include the public path if the image exists
                if ($item->image) {
                    $item->image = asset('storage/product/' . $item->image);
                }

                return [
                    'data' => $item,
                    'status' => ApiResponseCodeEnum::OK->value,
                ];
            }

            // Return a "not found" response if the product doesn't exist
            return [
                'data' => ['message' => 'Product not found.'],
                'status' => ApiResponseCodeEnum::NOT_FOUND->value,
            ];
        } catch (ModelNotFoundException $ex) {
            return [
                'data' => ['message' => 'Product not found.'],
                'status' => ApiResponseCodeEnum::NOT_FOUND->value,
            ];
        } catch (\Throwable $th) {
            return [
                'data' => ['message' => 'An error occurred while fetching the product.'],
                'status' => ApiResponseCodeEnum::SERVER_ERROR->value,
            ];
        }
    }
    public function deleteProduct(int $id): array
    {
        try {
            $this->productRepository->deleteProduct($id);

            return [
                'data' => ['message' => 'Product deleted successfully'],
                'status' => ApiResponseCodeEnum::OK->value,
            ];
        } catch (ModelNotFoundException $ex) {
            return [
                'data' => ['message' => 'Product not found.'],
                'status' => ApiResponseCodeEnum::NOT_FOUND->value,
            ];
        } catch (\Throwable $th) {
            return [
                'data' => ['message' => 'An unexpected error occurred.'],
                'status' => ApiResponseCodeEnum::NOT_FOUND->value,
            ];
        }
    }


    public function extractIdsFromRequest(Request $request): array
    {
        // Retrieve the 'id' query parameter
        $ids = $request->query('ids');

        // Validate the input
        if (empty($ids) || !is_array($ids) || empty($ids[0])) {
            return [
                'success' => false,
                'message' => 'Invalid input. Please provide user IDs.'
            ];
        }

        // Decode the JSON string from the first element
        $decodedIds = json_decode($ids[0], true);

        // Check for JSON decode errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'message' => 'Invalid ID format.'
            ];
        }

        return [
            'success' => true,
            'ids' => $decodedIds
        ];
    }

    public function deleteProducts(array $ids): array
    {
        // Call the repository to delete the categories
        return $this->productRepository->deleteProducts($ids);
    }




    public function paginateProductFilter(Request $request): array
    {
        try {
            $searchTerm = $request->input('name', '');
            $with = ['category'];
            $columns = ['id', 'category_id', 'name', 'image', 'barcode', 'purchase_price', 'selling_price', 'low_alert_qty', 'description', 'user_id'];
            $perPage = $request->input('per_page', 10);
            $sortOrder = $request->input('sort_order', 'desc');
            $sortBy = $request->input('sort_by', 'id');

            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';
            $sortBy = in_array($sortBy, $columns) ? $sortBy : 'id';

            $filters = ['searchTerm' => $searchTerm];

            // Get the paginated data
            $items = $this->getProductFilter(Product::class, $perPage, $with, $columns, $filters, $sortOrder, $sortBy);

            // Convert the LengthAwarePaginator to an array
            return $items->toArray();
        } catch (\Exception $e) {
            return [
                'error' => 'An error occurred while retrieving discounts.',
                'message' => $e->getMessage(),
            ];
        }
    }


    public function getProductFilter($modelClass, $perPage = 15, array $with = [], array $columns = ['*'], array $conditions = [], $sortOrder = 'asc', $sortBy = 'id')
    {
        // Fetch filtered and paginated results using repository
        $items = $this->productRepository->getProductFilter($modelClass, $perPage, $with, $columns, $conditions, $sortOrder, $sortBy);

        // Transform the image path to include public path for each user if the image exists
        foreach ($items as $item) {
            if ($item->image) {
                $item->image = asset('storage/product/' . $item->image);
            }
        }


        return $items;
    }


    public function generateProductPriceListPdf(): array
    {
        try {

            $products = $this->productRepository->getAllProductsWithCategory();


            $html = View::make('pdf.product_price_list', compact('products'))->render();

            // Initialize mPDF
            $mpdf = new Mpdf();

            // Write HTML content to the PDF
            $mpdf->WriteHTML($html);

            // Output the PDF as a string
            $pdfContent = $mpdf->Output('', 'S');

            return [
                'success' => true,
                'pdfContent' => $pdfContent
            ];
        } catch (\Exception $e) {

            return [
                'success' => false,
                'message' => 'An error occurred while generating the PDF.',
                'error' => $e->getMessage(),
            ];
        }
    }


    public function generateProductBarcodePdf()
    {
        $products = $this->productRepository->getAllProductsWithCategory();

        if ($products->isEmpty()) {
            return [
                'success' => false,
                'message' => 'No products found to generate the PDF.',
            ];
        }

        $html = '<div style="display: flex; flex-wrap: wrap;">';

        foreach ($products as $index => $product) {
            $barcode = $this->generateBarcode($product->barcode);

            $html .= '
                <div style="width: 288px; margin: 50px auto; padding: 15px; box-shadow: 0px 1.5px 2px rgba(1, 1, 1, 0.15) !important;
                    border-radius: 8px; page-break-inside: avoid;">
                    <h3 style="font-size: 18px; margin-bottom: 10px; text-align: center;">' . $product->name . '</h3>
                    <p style="font-size: 14px; margin: 0; text-align: center; color: #555;">' . $product->category->name . '</p>
                    <div style="text-align: center; margin: 10px 0;">
                        <img src="data:image/png;base64,' . $barcode . '" alt="Barcode" style="max-width: 100%; height: auto;" />
                    </div>
                    <p style="font-size: 14px; margin: 0; text-align: center; color: #555;">' . $product->barcode . '</p>
                </div>';
        }

        $html .= '</div>';

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        return [
            'success' => true,
            'pdf' => $mpdf->Output('product_barcode_list.pdf', 'S'),
        ];
    }


    private function generateBarcode($barcodeValue)
    {
        $generator = new BarcodeGeneratorPNG();
        $barcodeImage = $generator->getBarcode($barcodeValue, $generator::TYPE_CODE_128);

        return base64_encode($barcodeImage);
    }



    public function getProductByBarcode(string $barcode)
    {
        return $this->productRepository->findByBarcode($barcode);
    }



}
