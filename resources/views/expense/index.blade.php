<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <div class="mb-3 d-flex justify-content-between">
            <a class="btn btn-primary" href="{{ route('expense.create') }}" role="button"><i class="bx bx-plus"></i> Catat Pengeluaran</a>
            <button onclick="window.print()" class="btn btn-secondary"><i class="bx bx-printer"></i> Cetak Laporan</button>
        </div>
        <div class="table-responsive" id="print-area">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Jumlah (Rp)</th>
                        <th scope="col">Cabang</th>
                        <th scope="col">Catatan</th>
                        <th scope="col" class="no-print">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $exp)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $exp->date->format('d/m/Y') }}</td>
                            <td>{{ $exp->category }}</td>
                            <td class="text-end fw-bold text-danger">- Rp {{ number_format($exp->amount, 0, ',', '.') }}</td>
                            <td>{{ $exp->branch?->name }}</td>
                            <td>{{ $exp->notes }}</td>
                            <td class="no-print">
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('expense.destroy', $exp) }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    @push('scripts')
        <script>
            $('#data-table').on('click', '.btn-delete', function() {
                $('#form-delete').attr('action', $(this).data('route'))
            })
        </script>
    @endpush

    <style>
        @media print {
            body * { visibility: hidden; }
            #print-area, #print-area * { visibility: visible; }
            #print-area { position: absolute; left: 0; top: 0; width: 100%; }
            .no-print { display: none !important; }
            .card { box-shadow: none !important; border: none !important; }
        }
    </style>
</x-app>