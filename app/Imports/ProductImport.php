<?php
// app/Imports/CusImport.php
namespace App\Imports;

use App\Models\Product;
use App\Models\ProductCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class ProductImport implements ToModel, WithHeadingRow
{
    private $rowCount = 0;
    private $duplicateEntries = []; // Store duplicate entries
    private $validationErrors = []; // Store validation errors

    public function model(array $row)
    {
        $this->rowCount++; // Increment row count
        $currentRowIndex = $this->rowCount + 1; // +1 to account for the header row

        // Validate each row
        $validator = Validator::make($row, [
            'name' => 'required|string|max:255',
            'barcode' => 'required|string|max:255',
            'category' => 'required|string|max:255', // Category column as name
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
        ]);


        // If validation fails, store the errors
        if ($validator->fails()) {
            $this->validationErrors[$currentRowIndex] = $validator->errors()->toArray();
            return null; // Skip this row

        }

        try {
            // Check if the category exists, if not, create it
            $category = ProductCategory::firstOrCreate(
                ['name' => $row['category']], // Search by category name
                ['name' => $row['category']]  // Create with category name if not found
            );

            Product::create([
                'name' => $row['name'],
                'barcode' => $row['barcode'],
                'category_id' => $category->id, // Use the ID of the existing or newly created category
                'purchase_price' => $row['purchase_price'],
                'selling_price' => $row['selling_price'],
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Check if error is a duplicate entry
            if ($e->getCode() === '23000') {
                $duplicateMessage = "Duplicate entry found for '{$row['name']}' on row $currentRowIndex";
                $this->duplicateEntries[] = $duplicateMessage;
            }
        }

        return null;
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getDuplicateEntries()
    {
        return $this->duplicateEntries;
    }

    public function getValidationErrors()
    {
        return $this->validationErrors;
    }
}
