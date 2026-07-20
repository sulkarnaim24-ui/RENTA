<div class="row">
    <div class="col-md-4 text-center">
        <img src="{{ $driver->image ? asset('storage/' . $driver->image) : asset('niceadmin/img/noprofil.png') }}"
            alt="Image" class="img-fluid rounded shadow-sm">
    </div>
    <div class="col-md-8">
        <table class="table table-striped table-bordered">
            <tr>
                <th width="30%">Nama</th>
                <td>{{ $driver->name }}</td>
            </tr>
            <tr>
                <th>No HP</th>
                <td>{{ $driver->phone ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nomor SIM</th>
                <td>{{ $driver->license_number }}</td>
            </tr>
            <tr>
                <th>Biaya Jasa / Hari</th>
                <td>Rp {{ number_format($driver->cost_per_day, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($driver->status == 'available')
                        <span class="badge bg-success">Available</span>
                    @elseif($driver->status == 'assigned')
                        <span class="badge bg-primary">Assigned</span>
                    @else
                        <span class="badge bg-warning text-dark">Leave</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>
