<?php

// app/Services/BaseExcelImportService.php
namespace App\Services\Import;

use Maatwebsite\Excel\Facades\Excel;
use App\Enums\Responses\ApiResponseCodeEnum;

class ImportExcelDataService
{
    public function import($importer, $file): array
    {
        try {
            Excel::import($importer, $file);
            $importedCount = $importer->getRowCount();
            $duplicateEntries = $importer->getDuplicateEntries();
            $validationErrors = $importer->getValidationErrors();
    
            // Merge both validation errors and duplicate entries
            $allErrors = [];
    
            // Add validation errors if any
            if (!empty($validationErrors)) {
                foreach ($validationErrors as $rowIndex => $errors) {
                    foreach ($errors as $field => $messages) {
                        // Format the validation error to show row number and field name
                        foreach ($messages as $message) {
                            $allErrors[] = "$field - $message on row $rowIndex"; // Modify the format
                        }
                    }
                }
            }
    
            // Add duplicate entries if any
            if (!empty($duplicateEntries)) {
                foreach ($duplicateEntries as $duplicateMessage) {
                    $allErrors[] = $duplicateMessage;
                }
            }
    
            // If there are any errors, return them all in the response
            if (!empty($allErrors)) {
                return [
                    'success' => false,
                    'message' => 'Import failed with errors.',
                    'status' => 'error',
                    'errors' => $allErrors, // Include all errors here
                ];
            }
    
            return [
                'success' => true,
                'message' => 'Import completed successfully.',
                'count' => $importedCount,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'An unexpected error occurred during import.',
                'status' => ApiResponseCodeEnum::SERVER_ERROR->value,
            ];
        }
    }
    
}
