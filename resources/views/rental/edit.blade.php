<x-app title="Edit Rental">
    <div class="pagetitle">
        <h1>Edit Rental</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rental.index') }}">Data Rental</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Form Edit Transaksi Rental</h5>
                        <form action="{{ route('rental.update', $rental->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label for="customer_id" class="col-sm-3 col-form-label">Pelanggan</label>
                                <div class="col-sm-9">
                                    <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                        <option value="">Pilih Pelanggan</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id', $rental->customer_id) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} ({{ $customer->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="vehicle_id" class="col-sm-3 col-form-label">Kendaraan</label>
                                <div class="col-sm-9">
                                    <select name="vehicle_id" id="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>
                                        <option value="">Pilih Kendaraan</option>
                                        @foreach ($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" data-price="{{ $vehicle->price_per_day }}" {{ old('vehicle_id', $rental->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                                                {{ $vehicle->name }} - {{ $vehicle->license_plate }} (Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}/hari)
                                                {{ $vehicle->status != 'available' && $rental->vehicle_id != $vehicle->id ? '[Tidak Tersedia]' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="driver_id" class="col-sm-3 col-form-label">Supir (Opsional)</label>
                                <div class="col-sm-9">
                                    <select name="driver_id" id="driver_id" class="form-select @error('driver_id') is-invalid @enderror">
                                        <option value="">Tanpa Supir</option>
                                        @foreach ($drivers as $driver)
                                            <option value="{{ $driver->id }}" data-price="{{ $driver->cost_per_day }}" {{ old('driver_id', $rental->driver_id) == $driver->id ? 'selected' : '' }}>
                                                {{ $driver->name }} (Rp {{ number_format($driver->cost_per_day, 0, ',', '.') }}/hari)
                                                {{ $driver->status != 'available' && $rental->driver_id != $driver->id ? '[Tidak Tersedia]' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('driver_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="start_date" class="col-sm-3 col-form-label">Tanggal Mulai</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $rental->start_date) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="end_date" class="col-sm-3 col-form-label">Tanggal Selesai</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $rental->end_date) }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="pending" {{ old('status', $rental->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ old('status', $rental->status) == 'paid' ? 'selected' : '' }}>Dibayar</option>
                                        <option value="active" {{ old('status', $rental->status) == 'active' ? 'selected' : '' }}>Berjalan</option>
                                        <option value="completed" {{ old('status', $rental->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                                        <option value="cancelled" {{ old('status', $rental->status) == 'cancelled' ? 'selected' : '' }}>Batal</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <div class="alert alert-info">
                                        <h6 class="alert-heading fw-bold">Estimasi Harga (Otomatis)</h6>
                                        <p class="mb-0">Total Hari: <span id="preview_days" class="fw-bold">{{ $rental->total_days }}</span> Hari</p>
                                        <p class="mb-0">Total Harga: <span id="preview_price" class="fw-bold">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('rental.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const vehicleSelect = document.getElementById('vehicle_id');
            const driverSelect = document.getElementById('driver_id');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            
            const previewDays = document.getElementById('preview_days');
            const previewPrice = document.getElementById('preview_price');

            function calculateEstimate() {
                const vehicleOption = vehicleSelect.options[vehicleSelect.selectedIndex];
                const driverOption = driverSelect.options[driverSelect.selectedIndex];
                
                const vehiclePrice = vehicleOption && vehicleOption.dataset.price ? parseInt(vehicleOption.dataset.price) : 0;
                const driverPrice = driverOption && driverOption.dataset.price ? parseInt(driverOption.dataset.price) : 0;
                
                const start = new Date(startDateInput.value);
                const end = new Date(endDateInput.value);
                
                let days = 0;
                let totalPrice = 0;

                if (startDateInput.value && endDateInput.value && end >= start) {
                    const diffTime = Math.abs(end - start);
                    days = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                    totalPrice = (vehiclePrice + driverPrice) * days;
                }

                previewDays.textContent = days;
                previewPrice.textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(totalPrice);
            }

            vehicleSelect.addEventListener('change', calculateEstimate);
            driverSelect.addEventListener('change', calculateEstimate);
            startDateInput.addEventListener('change', calculateEstimate);
            endDateInput.addEventListener('change', calculateEstimate);
        });
    </script>
    @endpush
</x-app>
