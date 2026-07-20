<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('vehicle.create') }}" role="button">Tambah</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Nama Kendaraan</th>
                        <th scope="col">Merek</th>
                        <th scope="col">Plat Nomor</th>
                        <th scope="col">Harga/Hari</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicles as $vehicle)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $vehicle->category->name }}</td>
                            <td>{{ $vehicle->name }}</td>
                            <td>{{ $vehicle->brand }}</td>
                            <td>{{ $vehicle->license_plate }}</td>
                            <td>Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}</td>
                            <td>
                                @if($vehicle->status == 'available')
                                    <span class="badge bg-success">Available</span>
                                @elseif($vehicle->status == 'rented')
                                    <span class="badge bg-warning">Rented</span>
                                @else
                                    <span class="badge bg-danger">Maintenance</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm btn-detail"
                                    data-route="{{ route('vehicle.show', $vehicle) }}">
                                    <i class='bx bx-show'></i>
                                </button>
                                <a href="{{ route('vehicle.edit', $vehicle) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('vehicle.destroy', $vehicle) }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('modals')
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Kendaraan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-detail">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endpush

    @push('scripts')
        <script>
            $('#data-table').on('click', '.btn-delete', function() {
                $('#form-delete').attr('action', $(this).data('route'))
            })

            $('#data-table').on('click', '.btn-detail', function() {
                Swal.fire({
                    title: 'Memuat...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $('#modal-detail').load($(this).data('route'), function(response, status, xhr) {
                    if (status == "success") {
                        setTimeout(() => {
                            Swal.close();
                            $('#detailModal').modal('show');
                        }, 1000);
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Gagal memuat data",
                            icon: "error"
                        });
                    }
                });
            })
        </script>
    @endpush
</x-app>
