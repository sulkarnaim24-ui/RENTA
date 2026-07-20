<x-app title="Data Rental">
    <div class="pagetitle">
        <h1>Data Rental</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Rental</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
                            <h5 class="card-title m-0">Daftar Transaksi Rental</h5>
                            <a href="{{ route('rental.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i>
                                Tambah Rental</a>
                        </div>
                        <x-alert />
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pelanggan</th>
                                        <th>Kendaraan</th>
                                        <th>Tanggal</th>
                                        <th>Total Biaya</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rentals as $rental)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $rental->customer->name }}</td>
                                            <td>{{ $rental->vehicle->name }}<br><small>{{ $rental->vehicle->license_plate }}</small></td>
                                            <td>
                                                <small>Mulai: {{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }}</small><br>
                                                <small>Selesai: {{ \Carbon\Carbon::parse($rental->end_date)->format('d M Y') }}</small><br>
                                                <span class="badge bg-secondary">{{ $rental->total_days }} Hari</span>
                                            </td>
                                            <td>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                                            <td>
                                                @if($rental->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($rental->status == 'paid')
                                                    <span class="badge bg-info">Dibayar</span>
                                                @elseif($rental->status == 'active')
                                                    <span class="badge bg-primary">Berjalan</span>
                                                @elseif($rental->status == 'completed')
                                                    <span class="badge bg-success">Selesai</span>
                                                @else
                                                    <span class="badge bg-danger">Batal</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="btn btn-sm btn-info text-white btn-show"
                                                        data-bs-toggle="modal" data-bs-target="#showModal"
                                                        data-url="{{ route('rental.show', $rental->id) }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <a href="{{ route('rental.edit', $rental->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('rental.destroy', $rental->id) }}" method="POST"
                                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Show -->
    <div class="modal fade" id="showModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rincian Transaksi Rental</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center my-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="modal-content-container"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const showButtons = document.querySelectorAll('.btn-show');
                const modalContent = document.getElementById('modal-content-container');
                const spinner = document.querySelector('.spinner-border');

                showButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const url = this.getAttribute('data-url');
                        modalContent.innerHTML = '';
                        spinner.classList.remove('d-none');

                        fetch(url)
                            .then(response => response.text())
                            .then(html => {
                                spinner.classList.add('d-none');
                                modalContent.innerHTML = html;
                            })
                            .catch(error => {
                                spinner.classList.add('d-none');
                                modalContent.innerHTML = '<div class="alert alert-danger">Gagal memuat data.</div>';
                            });
                    });
                });
            });
        </script>
    @endpush
</x-app>
