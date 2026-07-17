<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row mb-4">
        <!-- Sales Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2" style="border-left: 5px solid #4e73df;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Penjualan</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bx bx-cart-alt fs-1 text-primary text-opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expenses Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2" style="border-left: 5px solid #e74a3b;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Pengeluaran</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bx bx-wallet fs-1 text-danger text-opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profit Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2" style="border-left: 5px solid {{ $profit >= 0 ? '#1cc88a' : '#e74a3b' }};">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold {{ $profit >= 0 ? 'text-success' : 'text-danger' }} text-uppercase mb-1">Profit Bersih</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($profit, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bx bx-line-chart fs-1 {{ $profit >= 0 ? 'text-success' : 'text-danger' }} text-opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Transactions -->
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">5 Transaksi Penjualan Terakhir</h6>
                    <a href="{{ route('transaction.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>Total Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions as $rt)
                                <tr>
                                    <td>{{ $rt->invoice_number }}</td>
                                    <td>{{ $rt->created_at->format('d M Y, H:i') }}</td>
                                    <td>{{ $rt->customer?->name ?? 'Umum' }}</td>
                                    <td>Rp {{ number_format($rt->total_amount, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada transaksi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>