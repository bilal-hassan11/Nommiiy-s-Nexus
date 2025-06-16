<?php

namespace App\Services\PurchaseOrder;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;

use App\Repositories\PurchaseOrder\PurchaseOrderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PurchaseOrderService
{
    protected $purchaseOrderRepository;

    public function __construct(PurchaseOrderRepository $purchaseOrderRepository)
    {
        $this->purchaseOrderRepository = $purchaseOrderRepository;
    }

    public function getLatestOrderNumber()
    {
        return $this->purchaseOrderRepository->getLatestOrderNumber();
    }

    public function createOrder($data)
    {
        return DB::transaction(function () use ($data) {
            return $this->purchaseOrderRepository->store($data);
        });
    }

    public function getAllOrders($filters)
    {
        return $this->purchaseOrderRepository->getAll($filters);
    }

    public function getOrderById($id)
    {
        return $this->purchaseOrderRepository->findById($id);
    }

    public function generateProductPriceListPdf($id): array
    {
        try {
            $order  = $this->purchaseOrderRepository->getPurchaseOrderPdf($id);

            if (!$order ) {
                return [
                    'success' => false,
                    'message' => 'Purchase Order not found.',
                ];
            }
            $grossAmount = $order ->orderDetails->sum(function ($detail) {
                return $detail->quantity * $detail->price;
            });
            
            $html = View::make('pdf.purchaseorder_pdf', compact('order', 'grossAmount'))->render();
            

            // Initialize mPDF
            $mpdf = new Mpdf();
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



    

    public function updateOrder($id, $data)
    {
        return DB::transaction(function () use ($id, $data) {
            return $this->purchaseOrderRepository->update($id, $data);
        });
    }

    public function updateOrderStatus($id, $status)
    {
        return $this->purchaseOrderRepository->updateOrderStatus($id, $status);
    }

    public function updateOrderPaymentStatus($id, $status)
    {
        return $this->purchaseOrderRepository->updateOrderPaymentStatus($id, $status);
    }

    public function deleteOrder($id)
    {
        return $this->purchaseOrderRepository->delete($id);
    }

    public function batchDeleteOrders($ids)
    {
        return DB::transaction(function () use ($ids) {
            return $this->purchaseOrderRepository->batchDelete($ids);
        });
    }
}
