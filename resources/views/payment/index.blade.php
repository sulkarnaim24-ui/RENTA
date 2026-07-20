<x-app title="Data Pembayaran & Tagihan">
    <div class="pagetitle">
        <h1>Data Pembayaran & Tagihan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Pembayaran</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
                            <h5 class="card-title m-0">Riwayat Tagihan & Pembayaran</h5>
                            <a href="{{ route('payment.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Pembayaran</a>
                        </div>
                        <x-alert />
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Rental</th>
                                        <th>Customer</th>
                                        <th>Tgl Pembayaran</th>
                                        <th>Metode</th>
                                        <th>Nominal</th>
                                        <th>Bukti</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>#{{ $payment->rental_id }}</td>
                                            <td>{{ $payment->rental->customer->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                            <td><span class="badge bg-secondary">{{ strtoupper($payment->payment_method) }}</span></td>
                                            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                            <td>
                                                @if($payment->proof_of_payment)
                                                    <a href="{{ asset('storage/' . $payment->proof_of_payment) }}" target="_blank">Lihat Bukti</a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($payment->status == 'pending')
                                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                                @elseif($payment->status == 'verified')
                                                    <span class="badge bg-success">Verified</span>
                                                @else
                                                    <span class="badge bg-danger">Gagal</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('payment.edit', $payment->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('payment.destroy', $payment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data tagihan ini?')">
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
