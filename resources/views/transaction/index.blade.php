<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('transaction.create') }}" role="button"><i class="bx bx-cart"></i> Ke Halaman Kasir (POS)</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">No. Invoice</th>
                        <th scope="col">Waktu</th>
                        <th scope="col">Kasir</th>
                        <th scope="col">Pelanggan</th>
                        <th scope="col">Total</th>
                        <th scope="col">Metode Bayar</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $tx)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $tx->invoice_number }}</strong></td>
                            <td>{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $tx->user?->name }}</td>
                            <td>{{ $tx->customer?->name ?? 'Umum' }}</td>
                            <td>Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</td>
                            <td>{{ $tx->payment_method }}</td>
                            <td>
                                <a href="{{ route('transaction.show', $tx) }}" class="btn btn-info btn-sm">
                                    <i class='bx bx-receipt'></i> Struk
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>