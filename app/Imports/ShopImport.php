<?php
// app/Imports/CustomerImport.php
namespace App\Imports;
use App\Models\Shop;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class ShopImport implements ToModel, WithHeadingRow
{
    private $rowCount = 0;
    private $duplicateEntries = []; // Store duplicate entries
    private $validationErrors = []; // Store validation errors

    public function model(array $row)
    {
        $this->rowCount++; // Increment row count
        $currentRowIndex = $this->rowCount + 1; // +1 to account for the header row

        $validator = Validator::make($row, [
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'contact_number' => 'nullable',
        ]);

        // If validation fails, store the errors
        if ($validator->fails()) {
            $this->validationErrors[$currentRowIndex] = $validator->errors()->toArray();
            return null; // Skip this row

        }
        try {
            Shop::create([
                'name' => $row['name'],
                'location' => $row['location'],
                'contact_number' => $row['contact_number'],
            ]);
        } catch (\Illuminate\Database\QueryException $e) {


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
