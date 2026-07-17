<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <form action="{{ route('inventory.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="branch_id" class="form-label">Cabang</label>
                    <select class="form-control @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id">
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id', Auth::user()->branch_id) == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="product_id" class="form-label">Produk</label>
                    <select class="form-control select2-default @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->sku }} - {{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="stock_quantity" class="form-label">Jumlah Stok (Awal)</label>
                    <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0">
                    @error('stock_quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="min_stock_level" class="form-label">Level Stok Minimum (Alert)</label>
                    <input type="number" class="form-control @error('min_stock_level') is-invalid @enderror" id="min_stock_level" name="min_stock_level" value="{{ old('min_stock_level', 10) }}" min="0">
                    @error('min_stock_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</x-app>