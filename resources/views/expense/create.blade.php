<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <form action="{{ route('expense.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="expense_date" class="form-label">Tanggal</label>
                    <input type="date" class="form-control @error('expense_date') is-invalid @enderror" id="expense_date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}">
                    @error('expense_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div> @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="description" class="form-label">Deskripsi Pengeluaran (Kategori/Catatan)</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="amount" class="form-label">Jumlah (Rp)</label>
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" min="0">
                    @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                
            </div>

            <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan Pengeluaran</button>
            <a href="{{ route('expense.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</x-app>