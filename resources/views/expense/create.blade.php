<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <form action="{{ route('expense.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="date" class="form-label">Tanggal</label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}">
                    @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">Kategori Pengeluaran</label>
                    <select class="form-control @error('category') is-invalid @enderror" id="category" name="category">
                        <option value="Operasional" {{ old('category') == 'Operasional' ? 'selected' : '' }}>Operasional (Listrik, Air, Internet)</option>
                        <option value="Gaji Karyawan" {{ old('category') == 'Gaji Karyawan' ? 'selected' : '' }}>Gaji Karyawan</option>
                        <option value="Inventaris/Alat" {{ old('category') == 'Inventaris/Alat' ? 'selected' : '' }}>Inventaris/Alat</option>
                        <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="amount" class="form-label">Jumlah (Rp)</label>
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" min="0">
                    @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="notes" class="form-label">Catatan</label>
                    <textarea class="form-control" id="notes" name="notes">{{ old('notes') }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan Pengeluaran</button>
            <a href="{{ route('expense.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</x-app>