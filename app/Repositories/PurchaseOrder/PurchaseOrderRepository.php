<?php

namespace App\Repositories\PurchaseOrder;

use App\Models\Order;
use Illuminate\Support\Str;

class PurchaseOrderRepository
{
    public function getLatestOrderNumber()
    {
        return Order::where('type', 'Purchase Orders')
            ->orderBy('id', 'desc')
            ->value('order_number');
    }

    public function store(array $data)
    {
        $order = Order::create([
            'order_number' => $this->generateOrderNumber(),
            'supplier_id' => $data['supplier_id'] ?? null,
            'shop_id' => $data['shop_id'] ?? null,
            'payment_method' => $data['payment_method'],
            'purchase_date' => $data['purchase_date'],
            'payment_status' => $data['payment_status'] ?? 'Unpaid',
            'paid_amount' => $data['paid_amount'] ?? 0,
            'total_amount' => $data['total_amount'],
            'order_status' => $data['order_status'] ?? 'Pending',
            'expected_delivery_date' => $data['expected_delivery_date'] ?? null,
            'delivery_status' => $data['delivery_status'] ?? 'Pending',
            'type' => 'Purchase Orders',
            'notes' => $data['notes'] ?? null,
            // 'user_id' => auth()->id(),
        ]);

        foreach ($data['order_details'] as $detail) {
            $order->orderDetails()->create([
                'product_id' => $detail['product_id'],
                'quantity' => $detail['quantity'],
                'price' => $detail['price'],
                'in_out' => 'in',
            ]);
        }

        // Update payment status if paid amount is equal or greater than total amount
        if ($order->paid_amount >= $order->total_amount) {
            $order->update(['payment_status' => 'Paid']);
        }

        return $order;
    }

    public function getAll($filters)
    {
        $query = Order::orderByDesc('id')->with('orderDetails', 'shop', 'supplier')->where('type', 'Purchase Orders');

        // Global search
        if (!empty($filters['name'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('order_number', 'like', '%' . $filters['name'] . '%')
                    ->orWhere('purchase_date', 'like', '%' . $filters['name'] . '%')
                    ->orWhereHas('supplier', function ($supplierQuery) use ($filters) {
                        $supplierQuery->where('name', 'like', '%' . $filters['name'] . '%');
                    })
                    ->orWhereHas('shop', function ($shopQuery) use ($filters) {
                        $shopQuery->where('name', 'like', '%' . $filters['name'] . '%');
                    });
            });
        }


        if (!empty($filters['supplier_id'])) {
            $query->where('supplier_id', $filters['supplier_id']);
        }
        if (!empty($filters['order_number'])) {
            $query->where('order_number', $filters['order_number']);
        }
        if (!empty($filters['purchase_date'])) {
            $query->where('purchase_date', $filters['purchase_date']);
        }

        return $query->paginate(15);
    }

    public function findById($id)
    {
        return Order::with(['orderDetails.product.category', 'shop', 'supplier'])->findOrFail($id);
    }
    public function getPurchaseOrderPdf($id)
    {
        return Order::with(['orderDetails.product.category', 'shop', 'supplier'])->findOrFail($id);
    }

    public function update($id, $data)
    {
        $order = Order::findOrFail($id);

        $order->update($data);

        if (isset($data['order_details'])) {
            $order->orderDetails()->delete();
            foreach ($data['order_details'] as $detail) {
                $order->orderDetails()->create([
                    'product_id' => $detail['product_id'],
                    'quantity' => $detail['quantity'],
                    'price' => $detail['price'],
                    'in_out' => 'in',
                ]);
            }
        }

        // Update payment status if paid amount is equal or greater than total amount
        if ($order->paid_amount >= $order->total_amount) {
            $order->update(['payment_status' => 'Paid']);
        }else{
            $order->update(['payment_status' => 'Unpaid']);
        }

        return $order;
    }

    public function updateOrderStatus($id, $status)
    {
        $order = Order::findOrFail($id);
        $order->update(['order_status' => $status]);
        return $order;
    }

    public function updateOrderPaymentStatus($id, $status)
    {
        $order = Order::findOrFail($id);
        $order->update(['payment_status' => $status]);
        return $order;
    }

    public function delete($id)
    {
        $order = Order::findOrFail($id);
        return $order->delete();
    }

    public function batchDelete($ids)
    {
        return Order::whereIn('id', $ids)->delete();
    }

    private function generateOrderNumber()
    {
        $latestOrder = Order::where('type', 'Purchase Orders')->orderBy('id', 'desc')->first();
        $lastNumber = $latestOrder ? (int) Str::after($latestOrder->order_number, 'PO-') : 0;
        return 'PO-' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
    }
}
