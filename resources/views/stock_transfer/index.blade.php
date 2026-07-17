<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('stock-transfer.create') }}" role="button"><i class="bx bx-transfer"></i> Buat Mutasi Baru</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ref. Number</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Dari Cabang</th>
                        <th scope="col">Ke Cabang</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transfers as $tf)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $tf->reference_number }}</strong></td>
                            <td>{{ $tf->created_at->format('d/m/Y') }}</td>
                            <td>{{ $tf->product?->name }}</td>
                            <td><span class="badge bg-secondary">{{ $tf->fromBranch?->name }}</span></td>
                            <td><span class="badge bg-info text-dark">{{ $tf->toBranch?->name }}</span></td>
                            <td><strong>{{ $tf->quantity }}</strong></td>
                            <td>
                                @if($tf->status === 'Completed')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning">{{ $tf->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>