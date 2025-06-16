<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Import the Log class
use Exception;

class WalletController extends Controller
{
    /**
     * Store a newly created deposit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Wallet Transfer Request Added successfully',
        ], 201);
        try {
            // Define validation rules
            $rules = [
                'member' => 'required|string',
                'currency' => 'required|string|in:BDT,NPR',
                'bankAccount' => 'required|string',
                'amount' => 'required|numeric|min:0.01',
                'date' => 'required|date',
                'memberBank' => 'required|string',
                'referenceNumber' => 'required|string',
                'receipt' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
            ];

            // Run validation
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Handle file upload
            $receiptPath = null; // Initialize to null
            if ($request->hasFile('receipt')) {
                try{
                    $receiptFile = $request->file('receipt');
                    $receiptName = time() . '_' . $receiptFile->getClientOriginalName();
                    $receiptPath = 'uploads/' . $receiptName; // Store in 'uploads' directory
                    Storage::disk('public')->put($receiptPath, file_get_contents($receiptFile)); //save to storage
                } catch (\Exception $e) {
                    Log::error('File upload failed: ' . $e->getMessage()); // Log the error
                    return response()->json(['message' => 'Failed to upload receipt. Please try again.'], 500);
                }

            }

            // Create the deposit record in the database
            try {
                $deposit = \App\Models\Deposit::create([ // Use your Deposit model here
                    'member' => $request->member,
                    'currency' => $request->currency,
                    'bank_account' => $request->bankAccount, // Use the correct database column name
                    'amount' => $request->amount,
                    'date' => $request->date,
                    'member_bank' => $request->memberBank, // Use the correct database column name
                    'reference_number' => $request->referenceNumber, // Use the correct database column name
                    'receipt_path' => $receiptPath, // Store the file path
                ]);
            } catch (\Exception $e) {
                Log::error('Database error: ' . $e->getMessage()); // Log the error
                return response()->json(['message' => 'Failed to save deposit data. Please try again.'], 500);
            }


            // Return a success response
            return response()->json([
                'message' => 'Deposit added successfully!',
                'deposit' => $deposit,
            ], 201);
        } catch (\Exception $e) {
             // Handle any unexpected exceptions
             Log::critical('Unexpected error: ' . $e->getMessage());
             return response()->json(['message' => 'An unexpected error occurred. Please try again.'], 500);
        }
    }

    //Bonus Rebeat adjustment store
    public function bonus_rebeat_adjustment_store(Request $request)
    {
        return response()->json([
            'message' => 'Bonus Rebeat Adjustment  successfully',
        ], 201);
        try {
            // Define validation rules
            $rules = [
                'member' => 'required|string',
                'currency' => 'required|string|in:BDT,NPR',
                'bankAccount' => 'required|string',
                'amount' => 'required|numeric|min:0.01',
                'date' => 'required|date',
                'memberBank' => 'required|string',
                'referenceNumber' => 'required|string',
                'receipt' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
            ];

            // Run validation
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Handle file upload
            $receiptPath = null; // Initialize to null
            if ($request->hasFile('receipt')) {
                try{
                    $receiptFile = $request->file('receipt');
                    $receiptName = time() . '_' . $receiptFile->getClientOriginalName();
                    $receiptPath = 'uploads/' . $receiptName; // Store in 'uploads' directory
                    Storage::disk('public')->put($receiptPath, file_get_contents($receiptFile)); //save to storage
                } catch (\Exception $e) {
                    Log::error('File upload failed: ' . $e->getMessage()); // Log the error
                    return response()->json(['message' => 'Failed to upload receipt. Please try again.'], 500);
                }

            }

            // Create the deposit record in the database
            try {
                $deposit = \App\Models\Deposit::create([ // Use your Deposit model here
                    'member' => $request->member,
                    'currency' => $request->currency,
                    'bank_account' => $request->bankAccount, // Use the correct database column name
                    'amount' => $request->amount,
                    'date' => $request->date,
                    'member_bank' => $request->memberBank, // Use the correct database column name
                    'reference_number' => $request->referenceNumber, // Use the correct database column name
                    'receipt_path' => $receiptPath, // Store the file path
                ]);
            } catch (\Exception $e) {
                Log::error('Database error: ' . $e->getMessage()); // Log the error
                return response()->json(['message' => 'Failed to save deposit data. Please try again.'], 500);
            }


            // Return a success response
            return response()->json([
                'message' => 'Deposit added successfully!',
                'deposit' => $deposit,
            ], 201);
        } catch (\Exception $e) {
             // Handle any unexpected exceptions
             Log::critical('Unexpected error: ' . $e->getMessage());
             return response()->json(['message' => 'An unexpected error occurred. Please try again.'], 500);
        }
    }


    //Bonus Rebeat adjustment store
    public function walletadjustments(Request $request)
    {
        return response()->json([
            'message' => 'Wallet Adjustment  successfully',
        ], 201);
        try {
            // Define validation rules
            $rules = [
                'member' => 'required|string',
                'currency' => 'required|string|in:BDT,NPR',
                'bankAccount' => 'required|string',
                'amount' => 'required|numeric|min:0.01',
                'date' => 'required|date',
                'memberBank' => 'required|string',
                'referenceNumber' => 'required|string',
                'receipt' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
            ];

            // Run validation
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Handle file upload
            $receiptPath = null; // Initialize to null
            if ($request->hasFile('receipt')) {
                try{
                    $receiptFile = $request->file('receipt');
                    $receiptName = time() . '_' . $receiptFile->getClientOriginalName();
                    $receiptPath = 'uploads/' . $receiptName; // Store in 'uploads' directory
                    Storage::disk('public')->put($receiptPath, file_get_contents($receiptFile)); //save to storage
                } catch (\Exception $e) {
                    Log::error('File upload failed: ' . $e->getMessage()); // Log the error
                    return response()->json(['message' => 'Failed to upload receipt. Please try again.'], 500);
                }

            }

            // Create the deposit record in the database
            try {
                $deposit = \App\Models\Deposit::create([ // Use your Deposit model here
                    'member' => $request->member,
                    'currency' => $request->currency,
                    'bank_account' => $request->bankAccount, // Use the correct database column name
                    'amount' => $request->amount,
                    'date' => $request->date,
                    'member_bank' => $request->memberBank, // Use the correct database column name
                    'reference_number' => $request->referenceNumber, // Use the correct database column name
                    'receipt_path' => $receiptPath, // Store the file path
                ]);
            } catch (\Exception $e) {
                Log::error('Database error: ' . $e->getMessage()); // Log the error
                return response()->json(['message' => 'Failed to save deposit data. Please try again.'], 500);
            }


            // Return a success response
            return response()->json([
                'message' => 'Deposit added successfully!',
                'deposit' => $deposit,
            ], 201);
        } catch (\Exception $e) {
             // Handle any unexpected exceptions
             Log::critical('Unexpected error: ' . $e->getMessage());
             return response()->json(['message' => 'An unexpected error occurred. Please try again.'], 500);
        }
    }
}
?>
