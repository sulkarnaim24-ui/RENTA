<x-app title="Data Perawatan Kendaraan">
    <div class="pagetitle">
        <h1>Data Perawatan Kendaraan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Perawatan</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
                            <h5 class="card-title m-0">Riwayat Perawatan Kendaraan</h5>
                            <a href="{{ route('maintenance-record.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Perawatan</a>
                        </div>
                        <x-alert />
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kendaraan</th>
                                        <th>Tanggal Servis</th>
                                        <th>Deskripsi Perbaikan</th>
                                        <th>Biaya</th>
                                        <th>Jadwal Selanjutnya</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($records as $record)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $record->vehicle->name }}<br>
                                                <span class="badge bg-secondary">{{ $record->vehicle->license_plate }}</span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($record->maintenance_date)->format('d M Y') }}</td>
                                            <td>{{ Str::limit($record->description, 50) }}</td>
                                            <td>Rp {{ number_format($record->cost, 0, ',', '.') }}</td>
                                            <td>
                                                @if($record->next_maintenance_date)
                                                    {{ \Carbon\Carbon::parse($record->next_maintenance_date)->format('d M Y') }}
                                                @else
                                                    <span class="text-muted">Belum diatur</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('maintenance-record.edit', $record->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('maintenance-record.destroy', $record->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
