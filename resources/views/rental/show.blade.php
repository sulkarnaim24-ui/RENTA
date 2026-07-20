<table class="table table-bordered">
    <tr>
        <th width="30%">ID Transaksi</th>
        <td>#RNT-{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}</td>
    </tr>
    <tr>
        <th>Pelanggan</th>
        <td>{{ $rental->customer->name }} ({{ $rental->customer->email }})</td>
    </tr>
    <tr>
        <th>Kendaraan</th>
        <td>
            {{ $rental->vehicle->name }} - {{ $rental->vehicle->license_plate }}
            <br>
            <small class="text-muted">Rp {{ number_format($rental->vehicle->price_per_day, 0, ',', '.') }} / hari</small>
        </td>
    </tr>
    <tr>
        <th>Supir</th>
        <td>
            @if($rental->driver)
                {{ $rental->driver->name }} ({{ $rental->driver->license_number }})
                <br>
                <small class="text-muted">Rp {{ number_format($rental->driver->cost_per_day, 0, ',', '.') }} / hari</small>
            @else
                <span class="text-muted">Tanpa Supir</span>
            @endif
        </td>
    </tr>
    <tr>
        <th>Tanggal Sewa</th>
        <td>{{ \Carbon\Carbon::parse($rental->start_date)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($rental->end_date)->format('d F Y') }}</td>
    </tr>
    <tr>
        <th>Total Durasi</th>
        <td>{{ $rental->total_days }} Hari</td>
    </tr>
    <tr>
        <th>Total Biaya</th>
        <td><strong class="fs-5 text-primary">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</strong></td>
    </tr>
    <tr>
        <th>Status Transaksi</th>
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
    </tr>
    <tr>
        <th>Tanggal Dibuat</th>
        <td>{{ $rental->created_at->format('d F Y H:i') }}</td>
    </tr>
</table>
