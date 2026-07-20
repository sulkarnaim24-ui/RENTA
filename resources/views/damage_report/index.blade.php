<x-app title="Data Laporan Kerusakan">
    <div class="pagetitle">
        <h1>Data Laporan Kerusakan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Kerusakan</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
                            <h5 class="card-title m-0">Riwayat Laporan Kerusakan</h5>
                            <a href="{{ route('damage-report.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Laporan</a>
                        </div>
                        <x-alert />
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Kendaraan</th>
                                        <th>Tgl Dilaporkan</th>
                                        <th>Deskripsi</th>
                                        <th>Estimasi Biaya</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reports as $report)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($report->photo)
                                                    <img src="{{ asset('storage/' . $report->photo) }}" alt="Foto" width="50" class="img-thumbnail">
                                                @else
                                                    <span class="text-muted">Tidak ada</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $report->vehicle->name }}<br>
                                                <span class="badge bg-secondary">{{ $report->vehicle->license_plate }}</span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($report->reported_date)->format('d M Y') }}</td>
                                            <td>{{ Str::limit($report->description, 30) }}</td>
                                            <td>Rp {{ number_format($report->repair_cost, 0, ',', '.') }}</td>
                                            <td>
                                                @if($report->status == 'reported')
                                                    <span class="badge bg-danger">Dilaporkan</span>
                                                @elseif($report->status == 'in_repair')
                                                    <span class="badge bg-warning text-dark">Diperbaiki</span>
                                                @else
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('damage-report.edit', $report->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('damage-report.destroy', $report->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
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
</x-app>
