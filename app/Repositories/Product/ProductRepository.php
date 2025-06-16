<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ProductRepository extends BaseRepository
{

    public function __construct(Product $product)
    {
        parent::__construct($product);
    }



    public function createProducts(array $data)
    {
        $product = $this->model->create($data);
        // Check if there's an image to store
        if (isset($data['image'])) {
            $this->storeImage($product, $data['image']);
        }

        return $product;
    }


    public function storeImage(Product $item, $base64Image)
    {
        $fileName = $this->getFileNameFromBase64($base64Image, 'filename');
        if ($fileName) {
            // Extract the image data
            $imageData = explode(',', $base64Image)[1];
            $imageData = base64_decode($imageData);

            // Store the image in the 'items' folder
            Storage::disk('public')->put('product/' . $fileName, $imageData);
            $item->update(['image' => $fileName]);
        }
    }



    private function getFileNameFromBase64($base64String, $outputType = 'extension')
    {
        // Define a default filename or extension
        $defaultFilename = 'file';
        $defaultExtension = 'png';

        // Check if the base64 string contains a data URI scheme with MIME type
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches)) {
            $extension = $matches[1]; // Get the image extension
        } else {
            $extension = $defaultExtension; // Use default if MIME type not found
        }


        // Determine the output type
        if ($outputType === 'extension') {
            // Generate a filename with the extension
            $filename = $defaultFilename;
        } elseif ($outputType === 'filename') {
            $filename = uniqid() . '.' . $extension;
            // Generate a filename without any extension
        } else {
            // If outputType is not recognized, return null
            return null;
        }

        return $filename;
    }



    public function updateProducts(int $id, array $data)
    {
        $user = $this->model->findOrFail($id);
        $oldFileName = $user->image;

        if (!empty($data['image'])) {
            // Case 1: If it's base64 image (new image)
            if (str_starts_with($data['image'], 'data:image')) {
                if ($oldFileName) {
                    $this->deleteImage($oldFileName);
                }
                $this->storeImage($user, $data['image']);
                unset($data['image']); // Important! Prevent base64 from being saved directly.
            }
            // Case 2: If it’s already a URL or file path (leave image unchanged)
            else {
                unset($data['image']);
            }
        }

        // Update other product details
        $user->update($data);
    }



    // Function to delete the old image
    public function deleteImage($fileName)
    {
        // Construct the path to the file
        $filePath = 'product/' . $fileName;

        // Delete the file if it exists
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }



    public function getProductFilter($modelClass, $perPage = 15, array $with = [], array $columns = ['*'], array $conditions = [], $sortOrder = 'asc', $sortBy = 'id')
    {
        // Dynamically instantiate the model class
        $query = app($modelClass)->newQuery();

        // Apply selected columns
        $query->select($columns);

        // Eager load the role and specify the fields
        if (!empty($with)) {
            $query->with([
                'category:id,name', // Only select id and name from the roles and building
            ]);
        }

        // Apply search term if provided
        if (!empty($conditions['searchTerm'])) {
            $query->where(function ($q) use ($conditions) {
                // Filter by name, low_alert_qty, or other fields
                $q->where('name', 'like', "%{$conditions['searchTerm']}%")
                    ->orWhere('barcode', 'like', "%{$conditions['searchTerm']}%")
                    ->orWhere('purchase_price', 'like', "%{$conditions['searchTerm']}%")
                    ->orWhere('selling_price', 'like', "%{$conditions['searchTerm']}%")
                    ->orWhere('low_alert_qty', 'like', "%{$conditions['searchTerm']}%")
                    ->orWhereHas('category', function ($q) use ($conditions) {
                        $q->where('name', 'like', "%{$conditions['searchTerm']}%");
                    });
            });
        }


        // Apply sorting if the column exists
        if (Schema::hasColumn(app($modelClass)->getTable(), $sortBy)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Paginate the results
        return $query->paginate($perPage, $columns);
    }


    public function getById($id, array $with = [], array $columns = ['*'])
    {
        // Default relationships to eager load if none specified
        $defaultRelations = ['category:id,name']; // Only select 'id' and 'name' from 'role and building'

        // Merge default relations with any additional ones provided
        $with = array_merge($defaultRelations, $with);

        return parent::find($id, $with, $columns);
    }

    public function getByIds(array $Ids)
    {
        return Product::whereIn('id', $Ids)->get();
    }



    public function deleteProduct(int $id)
    {
        $package = $this->model->findOrFail($id);
        $package->delete();
    }


    public function deleteProducts(array $ids): array
    {
        // Check if the categories exist
        $existingCategories = $this->model->whereIn('id', $ids)->get();

        if ($existingCategories->isEmpty()) {
            return [
                'success' => false,
                'message' => 'No product found to delete.'
            ];
        }

        // Proceed with deletion
        $this->model->whereIn('id', $ids)->delete();

        return [
            'success' => true,
            'message' => 'product deleted successfully.'
        ];
    }

    public function getAllProductsWithCategory()
    {

        return Product::with('category')->get();
    }


    public function findByBarcode(string $barcode)
    {
        return Product::with('category')
            ->where('barcode', $barcode)
            ->first();
    }


}
