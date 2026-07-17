<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <form action="{{ route('inventory.update', $inventory) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="alert alert-info">
                Anda sedang melakukan Stock Opname untuk Produk <strong>{{ $inventory->product->name }}</strong> di Cabang <strong>{{ $inventory->branch->name }}</strong>.
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="stock_quantity" class="form-label">Stok Fisik Tersedia</label>
                    <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $inventory->stock_quantity) }}" min="0">
                    @error('stock_quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="min_stock_level" class="form-label">Batas Stok Minimum</label>
                    <input type="number" class="form-control @error('min_stock_level') is-invalid @enderror" id="min_stock_level" name="min_stock_level" value="{{ old('min_stock_level', $inventory->min_stock_level) }}" min="0">
                    @error('min_stock_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Stok</button>
            <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</x-app>