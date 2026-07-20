<x-app title="Edit Pembayaran">
    <div class="pagetitle">
        <h1>Edit Pembayaran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('payment.index') }}">Pembayaran</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Form Edit Pembayaran</h5>
                        <form action="{{ route('payment.update', $payment->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label for="rental_id" class="col-sm-3 col-form-label">Rental Transaksi</label>
                                <div class="col-sm-9">
                                    <select name="rental_id" id="rental_id" class="form-select @error('rental_id') is-invalid @enderror" required>
                                        <option value="">Pilih Transaksi Rental</option>
                                        @foreach ($rentals as $rental)
                                            <option value="{{ $rental->id }}" {{ old('rental_id', $payment->rental_id) == $rental->id ? 'selected' : '' }}>
                                                #{{ $rental->id }} - {{ $rental->customer->name }} ({{ $rental->vehicle->license_plate }}) - Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('rental_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="amount" class="col-sm-3 col-form-label">Nominal Bayar (Rp)</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount', $payment->amount) }}" required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="payment_method" class="col-sm-3 col-form-label">Metode Pembayaran</label>
                                <div class="col-sm-9">
                                    <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                        <option value="">Pilih Metode</option>
                                        <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="transfer" {{ old('payment_method', $payment->payment_method) == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                        <option value="ewallet" {{ old('payment_method', $payment->payment_method) == 'ewallet' ? 'selected' : '' }}>E-Wallet (OVO/Gopay/Dana)</option>
                                        <option value="credit_card" {{ old('payment_method', $payment->payment_method) == 'credit_card' ? 'selected' : '' }}>Kartu Kredit</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="payment_date" class="col-sm-3 col-form-label">Tanggal Pembayaran</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date" name="payment_date" value="{{ old('payment_date', $payment->payment_date) }}" required>
                                    @error('payment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi (Pending)</option>
                                        <option value="verified" {{ old('status', $payment->status) == 'verified' ? 'selected' : '' }}>Terverifikasi (Verified)</option>
                                        <option value="failed" {{ old('status', $payment->status) == 'failed' ? 'selected' : '' }}>Gagal (Failed)</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="proof_of_payment" class="col-sm-3 col-form-label">Bukti Bayar (Opsional)</label>
                                <div class="col-sm-9">
                                    @if($payment->proof_of_payment)
                                        <div class="mb-2">
                                            <a href="{{ asset('storage/' . $payment->proof_of_payment) }}" target="_blank" class="btn btn-sm btn-info">Lihat Bukti Saat Ini</a>
                                        </div>
                                    @endif
                                    <input class="form-control @error('proof_of_payment') is-invalid @enderror" type="file" id="proof_of_payment" name="proof_of_payment" accept="image/*">
                                    <div class="form-text">Biarkan kosong jika tidak ingin mengubah bukti bayar. Format: jpg, jpeg, png. Maksimal 2MB.</div>
                                    @error('proof_of_payment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary">Update Pembayaran</button>
                                    <a href="{{ route('payment.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
