<x-app title="Data Log BBM">
    <div class="pagetitle">
        <h1>Data Log BBM</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Log BBM</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
                            <h5 class="card-title m-0">Riwayat Penggunaan BBM</h5>
                            <a href="{{ route('fuel-log.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Log</a>
                        </div>
                        <x-alert />
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Kendaraan</th>
                                        <th>Odometer</th>
                                        <th>Liter</th>
                                        <th>Total Biaya</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fuelLogs as $log)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($log->log_date)->format('d M Y') }}</td>
                                            <td>
                                                {{ $log->vehicle->name }}<br>
                                                <small class="text-muted">{{ $log->vehicle->license_plate }}</small>
                                                @if($log->rental)
                                                    <br><span class="badge bg-secondary">Rental: {{ $log->rental->customer->name }}</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($log->odometer, 0, ',', '.') }} km</td>
                                            <td>{{ number_format($log->liters, 2, ',', '.') }} L</td>
                                            <td>Rp {{ number_format($log->cost, 0, ',', '.') }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('fuel-log.edit', $log->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('fuel-log.destroy', $log->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus log ini?')">
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
