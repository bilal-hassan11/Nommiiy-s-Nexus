<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order Details</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #ffffff; padding: 20px; }
        .container { background: #fff; padding: 20px; max-width: 900px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .title { font-size: 24px; font-weight: bold; color: #3a3541; }
        .details { margin-bottom: 20px; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; }
        .detail-title { font-weight: bold; color: #3a3541; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .summary { margin-top: 20px; text-align: right; }
        .summary div { margin-bottom: 8px; font-weight: bold; color: #3a3541; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title">View Purchase Order Details</div>
        </div>

        <div class="details">
            <div class="detail-row"><span class="detail-title">PURCHASE ORDER NUMBER:</span> {{ $order->order_number ?? '--' }}</div>
            <div class="detail-row"><span class="detail-title">DELIVERY DATE:</span> {{ $order->expected_delivery_date ?? '--' }}</div>
            <div class="detail-row"><span class="detail-title">SUPPLIER:</span> {{ $order->supplier->name ?? '--' }}</div>
            <div class="detail-row"><span class="detail-title">PAYMENT STATUS:</span> {{ $order->payment_status ?? '--' }}</div>
            <div class="detail-row"><span class="detail-title">PURCHASE DATE:</span> {{ $order->purchase_date ?? '--' }}</div>
            <div class="detail-row"><span class="detail-title">PENDING PAYMENT:</span> ${{ number_format($grossAmount - ($order->paid_amount ?? 0), 2) }}</div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderDetails as $item)
                    <tr>
                        <td>{{ $item->product->name ?? '--' }}</td>
                        <td>{{ $item->product->category->name ?? '--' }}</td>
                        <td>{{ $item->quantity ?? '--' }}</td>
                        <td>${{ number_format($item->price ?? 0, 2) }}</td>
                        <td>${{ number_format(($item->quantity ?? 0) * ($item->price ?? 0), 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <div>Gross Total: ${{ number_format($grossAmount, 2) }}</div>
            <div>Paid: ${{ number_format($order->paid_amount ?? 0, 2) }}</div>
            <div>Pending Amount: ${{ number_format($grossAmount - ($order->paid_amount ?? 0), 2) }}</div>
        </div>

    </div>
</body>
</html>
