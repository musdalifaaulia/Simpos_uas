<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow p-4" id="receipt-area">
                <div class="text-center mb-4">
                    <h3 class="fw-bold m-0">{{ $setting->app_name }}</h3>
                    <p class="m-0 text-muted">{{ $transaction->branch->name ?? '' }}</p>
                    <p class="m-0 text-muted">{{ $transaction->branch->address ?? '' }}</p>
                    <hr>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <strong>No. Invoice:</strong><br>
                        {{ $transaction->invoice_number }}
                    </div>
                    <div class="col-6 text-end">
                        <strong>Waktu & Tanggal:</strong><br>
                        {{ $transaction->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <strong>Pelanggan:</strong><br>
                        {{ $transaction->customer?->name ?? 'Umum' }}
                    </div>
                    <div class="col-6 text-end">
                        <strong>Kasir:</strong><br>
                        {{ $transaction->user?->name ?? '-' }}
                    </div>
                </div>

                <table class="table mb-4">
                    <thead>
                        <tr class="table-active">
                            <th>Item</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->details as $detail)
                        <tr>
                            <td>
                                {{ $detail->product->name }}<br>
                                <small class="text-muted">{{ $detail->product->sku }}</small>
                            </td>
                            <td class="text-center">{{ $detail->quantity }}</td>
                            <td class="text-end">Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">GRAND TOTAL</th>
                            <th class="text-end fs-5">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end text-muted">
                                Pembayaran menggunakan: <strong>{{ $transaction->payment_method }}</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                
                <div class="text-center mt-5">
                    <p class="fw-bold">*** TERIMA KASIH ***</p>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <button class="btn btn-success me-2" onclick="window.print()"><i class="bx bx-printer"></i> Cetak Struk</button>
                <a href="{{ route('transaction.create') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Kembali ke Kasir</a>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #receipt-area, #receipt-area * {
                visibility: visible;
            }
            #receipt-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .card {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>
</x-app>