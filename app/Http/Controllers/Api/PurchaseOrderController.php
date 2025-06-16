<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Http\Requests\Orders\PurchaseOrderPaymentStatusRequest;
use App\Services\PurchaseOrder\PurchaseOrderService;
use App\Http\Requests\Orders\StorePurchaseOrderRequest;
use App\Http\Requests\Orders\PurchaseOrderStatusRequest;

class PurchaseOrderController extends Controller
{
    protected $purchaseOrderService;

    public function __construct(PurchaseOrderService $purchaseOrderService)
    {
        $this->purchaseOrderService = $purchaseOrderService;
    }

    public function latestOrderNumber()
    {
        return response()->json([
            'latest_order_number' => $this->purchaseOrderService->getLatestOrderNumber(),
        ]);
    }

    public function store(StorePurchaseOrderRequest $request)
    {
        $order = $this->purchaseOrderService->createOrder($request->validated());
        return response()->json(['message' => 'Order created successfully', 'data' => $order]);
    }

    public function index(Request $request)
    {
        $orders = $this->purchaseOrderService->getAllOrders($request->all());
        return response()->json($orders);
    }

    public function show($id)
    {
        return response()->json($this->purchaseOrderService->getOrderById($id));
    }

    public function downloadPurchaseOrderViewPDF($id): JsonResponse|Response
    {
        $response = $this->purchaseOrderService->generateProductPriceListPdf($id);

        if ($response['success']) {
            return response($response['pdfContent'], ApiResponseCodeEnum::OK->value)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="purchase_order.pdf"');
        }

        return response()->json([
            'success' => false,
            'message' => $response['message'],
            'error' => $response['error'],
        ], ApiResponseCodeEnum::SERVER_ERROR->value);
    }



    public function update(StorePurchaseOrderRequest $request, $id)
    {
        $order = $this->purchaseOrderService->updateOrder($id, $request->validated());
        return response()->json(['message' => 'Order updated successfully', 'data' => $order]);
    }

    public function updateOrderStatus(PurchaseOrderStatusRequest $request, $id)
    {

        $order = $this->purchaseOrderService->updateOrderStatus($id, $request->order_status);
        return response()->json(['message' => 'Order status updated successfully', 'data' => $order]);
    }
    
    function updateOrderPaymentStatus(PurchaseOrderPaymentStatusRequest $request, $id)
    {
        $order = $this->purchaseOrderService->updateOrderPaymentStatus($id, $request->payment_status);
        return response()->json(['message' => 'Payment status updated successfully', 'data' => $order]);
    }

    public function destroy($id)
    {
        $this->purchaseOrderService->deleteOrder($id);
        return response()->json(['message' => 'Order deleted successfully']);
    }

     public function batchDelete(Request $request): JsonResponse
     {
        try {

            $order_ids = $request->input('ids');
            if (is_string($order_ids)) {
                $order_ids = json_decode(trim($order_ids), true);
            }

            if (empty($order_ids) || !is_array($order_ids)) {
                return response()->json(['message' => 'No Order selected for deletion'],  ApiResponseCodeEnum::BAD_REQUEST->value);
            }
            $this->purchaseOrderService->batchDeleteOrders($order_ids);

            return response()->json(['message' => 'Orders deleted successfully'],  ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }


     }
}
