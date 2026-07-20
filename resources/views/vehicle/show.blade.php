<div class="row">
    <div class="col-md-4 text-center">
        <img src="{{ $vehicle->image ? asset('storage/' . $vehicle->image) : asset('niceadmin/img/noprofil.png') }}"
            alt="Image" class="img-fluid rounded shadow-sm">
    </div>
    <div class="col-md-8">
        <table class="table table-striped table-bordered">
            <tr>
                <th width="30%">Kategori</th>
                <td>{{ $vehicle->category->name }}</td>
            </tr>
            <tr>
                <th>Nama Kendaraan</th>
                <td>{{ $vehicle->name }}</td>
            </tr>
            <tr>
                <th>Merek</th>
                <td>{{ $vehicle->brand }}</td>
            </tr>
            <tr>
                <th>Plat Nomor</th>
                <td>{{ $vehicle->license_plate }}</td>
            </tr>
            <tr>
                <th>Harga Sewa / Hari</th>
                <td>Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($vehicle->status == 'available')
                        <span class="badge bg-success">Available</span>
                    @elseif($vehicle->status == 'rented')
                        <span class="badge bg-warning">Rented</span>
                    @else
                        <span class="badge bg-danger">Maintenance</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>
