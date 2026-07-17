<table class="table table-bordered">
    <tr>
        <th style="width:30%;">SKU</th>
        <td>{{ $product->sku }}</td>
    </tr>
    <tr>
        <th>Nama Produk</th>
        <td>{{ $product->name }}</td>
    </tr>
    <tr>
        <th>Kategori</th>
        <td>{{ $product->category?->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Pemasok</th>
        <td>{{ $product->supplier?->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Harga Beli</th>
        <td>Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Harga Jual</th>
        <td>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
    </tr>
</table>