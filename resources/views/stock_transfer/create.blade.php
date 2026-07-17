<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        
        <div class="alert alert-info">
            <i class="bx bx-info-circle"></i> Mutasi stok akan secara **otomatis** memotong stok dari cabang asal dan menambahkannya ke cabang tujuan saat diproses.
        </div>

        <form action="{{ route('stock-transfer.store') }}" method="POST">
            @csrf
            
            <!-- We send the current branch id implicitly in controller, but for validation rules 'different', we can put a hidden field -->
            <input type="hidden" name="from_branch_id" value="{{ $currentBranchId }}">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="product_id" class="form-label">Pilih Produk (Dari Cabang Anda)</label>
                    <select class="form-control select2-default @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($inventories as $inv)
                            <option value="{{ $inv->product->id }}" data-max="{{ $inv->stock_quantity }}" {{ old('product_id') == $inv->product->id ? 'selected' : '' }}>
                                {{ $inv->product->name }} (Sisa Stok: {{ $inv->stock_quantity }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="to_branch_id" class="form-label">Tujuan Cabang Mutasi</label>
                    <select class="form-control @error('to_branch_id') is-invalid @enderror" id="to_branch_id" name="to_branch_id">
                        <option value="">-- Pilih Cabang Tujuan --</option>
                        @foreach($destinationBranches as $branch)
                            <option value="{{ $branch->id }}" {{ old('to_branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    @error('to_branch_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="quantity" class="form-label">Jumlah (Qty) Mutasi</label>
                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1">
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-danger d-none" id="qty-warning">Kuantitas melebihi stok yang tersedia!</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="notes" class="form-label">Catatan / Alasan Mutasi</label>
                    <textarea class="form-control" id="notes" name="notes">{{ old('notes') }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" id="btn-submit"><i class="bx bx-transfer"></i> Proses Mutasi</button>
            <a href="{{ route('stock-transfer.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Validasi QTY Realtime di Frontend
            $('#quantity, #product_id').on('change keyup', function() {
                let selectedOption = $('#product_id').find('option:selected');
                if(!selectedOption.val()) return;

                let maxStock = parseInt(selectedOption.data('max'));
                let inputQty = parseInt($('#quantity').val());

                if (inputQty > maxStock) {
                    $('#qty-warning').removeClass('d-none');
                    $('#quantity').addClass('is-invalid');
                    $('#btn-submit').prop('disabled', true);
                } else {
                    $('#qty-warning').addClass('d-none');
                    $('#quantity').removeClass('is-invalid');
                    $('#btn-submit').prop('disabled', false);
                }
            });
        });
    </script>
    @endpush
</x-app>