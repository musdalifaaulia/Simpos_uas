<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <!-- Produk List -->
        <div class="col-md-7">
            <div class="card shadow p-3">
                <h5 class="fw-bold mb-3">Pilih Produk</h5>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="product-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>SKU</th>
                                <th>Stok</th>
                                <th>Harga Jual</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inventories as $inv)
                            <tr>
                                <td>{{ $inv->product->name }}</td>
                                <td>{{ $inv->product->sku }}</td>
                                <td>{{ $inv->stock_quantity }}</td>
                                <td>Rp {{ number_format($inv->product->selling_price, 0, ',', '.') }}</td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm btn-add-cart" 
                                        data-id="{{ $inv->product->id }}"
                                        data-name="{{ $inv->product->name }}"
                                        data-price="{{ $inv->product->selling_price }}"
                                        data-max="{{ $inv->stock_quantity }}">
                                        <i class="bx bx-plus"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Keranjang (Cart) -->
        <div class="col-md-5">
            <div class="card shadow p-3" style="background: #f8f9fa;">
                <h5 class="fw-bold mb-3">Keranjang Belanja</h5>
                
                <form id="pos-form">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Pelanggan</label>
                        <select name="customer_id" class="form-control select2-default" id="customer_id">
                            <option value="">-- Pelanggan Umum --</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->phone }})</option>
                            @endforeach
                        </select>
                    </div>

                    <hr>
                    
                    <div class="table-responsive mb-3" style="min-height: 200px;">
                        <table class="table table-sm" id="cart-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th style="width: 80px;">Qty</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="cart-body">
                                <tr id="empty-cart"><td colspan="4" class="text-center text-muted">Keranjang masih kosong</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fs-5 fw-bold">TOTAL</span>
                        <span class="fs-4 fw-bold text-primary" id="total-text">Rp 0</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" class="form-control" id="payment_method">
                            <option value="Cash">Cash / Tunai</option>
                            <option value="Debit Card">Kartu Debit</option>
                            <option value="Credit Card">Kartu Kredit</option>
                            <option value="E-Wallet">QRIS / E-Wallet</option>
                        </select>
                    </div>

                    <button type="button" class="btn btn-primary w-100 py-2 fs-5 fw-bold" id="btn-process">
                        <i class="bx bx-check-circle"></i> Proses Transaksi
                    </button>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            let cart = [];
            
            // Format Rupiah
            const formatRupiah = (angka) => {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
            };

            // Render Cart
            const renderCart = () => {
                let html = '';
                let grandTotal = 0;
                
                if (cart.length === 0) {
                    html = '<tr id="empty-cart"><td colspan="4" class="text-center text-muted">Keranjang masih kosong</td></tr>';
                } else {
                    cart.forEach((item, index) => {
                        let subtotal = item.qty * item.price;
                        grandTotal += subtotal;
                        html += `
                            <tr>
                                <td>${item.name}<br><small class="text-muted">${formatRupiah(item.price)}</small></td>
                                <td>
                                    <input type="number" class="form-control form-control-sm qty-input" data-index="${index}" value="${item.qty}" min="1" max="${item.max}">
                                </td>
                                <td class="text-end align-middle">${formatRupiah(subtotal)}</td>
                                <td class="text-center align-middle">
                                    <button type="button" class="btn btn-danger btn-sm btn-remove" data-index="${index}"><i class="bx bx-x"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                }
                
                $('#cart-body').html(html);
                $('#total-text').text(formatRupiah(grandTotal));
            };

            // Add to Cart
            $('.btn-add-cart').click(function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let price = parseFloat($(this).data('price'));
                let max = parseInt($(this).data('max'));

                let existing = cart.find(c => c.id == id);
                if (existing) {
                    if(existing.qty < max) {
                        existing.qty++;
                    } else {
                        Swal.fire('Stok Terbatas', 'Stok produk ini tidak mencukupi lagi.', 'warning');
                    }
                } else {
                    cart.push({ id, name, price, max, qty: 1 });
                }
                renderCart();
            });

            // Change Qty
            $(document).on('change', '.qty-input', function() {
                let index = $(this).data('index');
                let newQty = parseInt($(this).val());
                if(newQty > cart[index].max) {
                    Swal.fire('Stok Terbatas', 'Stok maksimum: ' + cart[index].max, 'warning');
                    newQty = cart[index].max;
                }
                if(newQty < 1) newQty = 1;
                cart[index].qty = newQty;
                renderCart();
            });

            // Remove Item
            $(document).on('click', '.btn-remove', function() {
                let index = $(this).data('index');
                cart.splice(index, 1);
                renderCart();
            });

            // Submit Transaction
            $('#btn-process').click(function() {
                if(cart.length === 0) {
                    return Swal.fire('Error', 'Keranjang masih kosong!', 'error');
                }

                Swal.fire({
                    title: 'Proses Transaksi?',
                    text: 'Pastikan pesanan sudah sesuai',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Proses!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        
                        // Prepare data
                        let data = {
                            _token: $('input[name=_token]').val(),
                            customer_id: $('#customer_id').val(),
                            payment_method: $('#payment_method').val(),
                            products: cart.map(c => ({ id: c.id, quantity: c.qty, price: c.price }))
                        };

                        Swal.fire({ title: 'Memproses...', didOpen: () => { Swal.showLoading(); } });

                        $.post('{{ route("transaction.store") }}', data)
                        .done(function(res) {
                            if(res.success) {
                                Swal.fire('Berhasil!', res.message, 'success').then(() => {
                                    window.location.href = res.redirect;
                                });
                            }
                        })
                        .fail(function(err) {
                            Swal.fire('Gagal', err.responseJSON?.message || 'Terjadi kesalahan sistem', 'error');
                        });
                    }
                });
            });

        });
    </script>
    @endpush
</x-app>