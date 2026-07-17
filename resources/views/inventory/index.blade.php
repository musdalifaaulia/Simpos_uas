<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    
    @if($lowStocks->count() > 0)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <h4 class="alert-heading"><i class="bi bi-exclamation-triangle-fill"></i> Low Stock Alert!</h4>
        <p>Terdapat {{ $lowStocks->count() }} barang yang stoknya sudah mencapai batas minimum. Harap segera lakukan restock!</p>
        <hr>
        <ul class="mb-0">
            @foreach($lowStocks as $ls)
                <li><strong>{{ $ls->product->name }}</strong> ({{ $ls->branch->name }}) - Sisa Stok: <span class="badge bg-danger">{{ $ls->stock_quantity }}</span></li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-lg p-3">
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('inventory.create') }}" role="button">Tambah Inventaris Baru</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cabang</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Stok Fisik</th>
                        <th scope="col">Stok Minimum</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventories as $inv)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $inv->branch?->name }}</td>
                            <td>{{ $inv->product?->name }}</td>
                            <td>{{ $inv->stock_quantity }}</td>
                            <td>{{ $inv->min_stock_level }}</td>
                            <td>
                                @if($inv->stock_quantity <= $inv->min_stock_level)
                                    <span class="badge bg-danger">Low Stock</span>
                                @else
                                    <span class="badge bg-success">Aman</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('inventory.edit', $inv) }}" class="btn btn-warning btn-sm" title="Stock Opname">
                                    <i class='bx bx-edit-alt'></i> Stock Opname
                                </a>
                                @if(Auth::user()->role === 'Superadmin')
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('inventory.destroy', $inv) }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('modals')
    @endpush

    @push('scripts')
        <script>
            $('#data-table').on('click', '.btn-delete', function() {
                $('#form-delete').attr('action', $(this).data('route'))
            })
        </script>
    @endpush
</x-app>