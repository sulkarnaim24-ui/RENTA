<x-app title="Asuransi Kendaraan">
    <div class="pagetitle">
        <h1>Asuransi Kendaraan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Asuransi Kendaraan</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
                            <h5 class="card-title m-0">Data Polis Asuransi</h5>
                            <a href="{{ route('insurance-record.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Asuransi</a>
                        </div>
                        <x-alert />
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kendaraan</th>
                                        <th>Provider</th>
                                        <th>No Polis</th>
                                        <th>Masa Berlaku</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($insurances as $insurance)
                                        @php
                                            $isExpired = \Carbon\Carbon::parse($insurance->end_date)->isPast();
                                        @endphp
                                        <tr class="{{ $isExpired ? 'table-danger' : '' }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $insurance->vehicle->name }} <br> <small class="text-muted">{{ $insurance->vehicle->license_plate }}</small></td>
                                            <td>{{ $insurance->provider }}</td>
                                            <td>{{ $insurance->policy_number }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($insurance->start_date)->format('d/m/Y') }} - 
                                                <strong>{{ \Carbon\Carbon::parse($insurance->end_date)->format('d/m/Y') }}</strong>
                                            </td>
                                            <td>
                                                @if($isExpired)
                                                    <span class="badge bg-danger">Kedaluwarsa</span>
                                                @else
                                                    <span class="badge bg-success">Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    @if($insurance->document_file)
                                                        <a href="{{ asset('storage/' . $insurance->document_file) }}" target="_blank" class="btn btn-sm btn-info" title="Lihat Dokumen">
                                                            <i class="bi bi-file-earmark-text"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('insurance-record.edit', $insurance->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('insurance-record.destroy', $insurance->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data asuransi ini?')">
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
