<?php
// app/Imports/CustomerImport.php
namespace App\Imports;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class CustomerImport implements ToModel, WithHeadingRow
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
            'email' => 'nullable|email',
            'address' => 'nullable|string|max:255',
            'nin_bvn' => 'nullable|string|max:255',
            'phone_number' => 'nullable',
        ]);

        // If validation fails, store the errors
        if ($validator->fails()) {
            $this->validationErrors[$currentRowIndex] = $validator->errors()->toArray();
            return null; // Skip this row

        }
        try {
            Customer::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'address' => $row['address'],
                'nin_bvn' => $row['nin_bvn'],
                'phone_number' => $row['phone_number'],
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Check if error is a duplicate entry
            if ($e->getCode() === '23000') {
                $duplicateFields = [];

                  // Check for duplicate 'name'
                  if (Customer::where('name', $row['name'])->exists()) {
                    $duplicateFields[] = "Name '{$row['name']}'";
                }

                // Check for duplicate 'nin_bvn'
                if (Customer::where('nin_bvn', $row['nin_bvn'])->exists()) {
                    $duplicateFields[] = "NIN/BVN '{$row['nin_bvn']}'";
                }

                // Create a combined duplicate message
                if (!empty($duplicateFields)) {
                    $duplicateMessage = 'Duplicate entry found for ' . implode(' and ', $duplicateFields) . " on row $currentRowIndex";
                    $this->duplicateEntries[] = $duplicateMessage;
                }
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
