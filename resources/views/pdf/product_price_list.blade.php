<!DOCTYPE html>
<html>
<head>
    <title>Products Price List</title>
    <style>
        body { font-family: sans-serif; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

<h1>Products Price List</h1>

<table>
    <thead>
        <tr>
            <th>Sr. No</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Barcode</th>
            <th>Purchase Price</th>
            <th>Selling Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? 'N/A' }}</td>
                <td>{{ $product->barcode ?? 'N/A' }}</td>
                <td>{{ $product->purchase_price ?? 'N\A' }}</td>
                <td>{{ $product->selling_price ?? 'N\A' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
