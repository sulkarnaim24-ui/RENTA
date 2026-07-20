<x-app title="Edit Log BBM">
    <div class="pagetitle">
        <h1>Edit Log BBM</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('fuel-log.index') }}">Log BBM</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Form Edit Log BBM</h5>
                        <form action="{{ route('fuel-log.update', $fuelLog->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label for="vehicle_id" class="col-sm-3 col-form-label">Kendaraan</label>
                                <div class="col-sm-9">
                                    <select name="vehicle_id" id="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>
                                        <option value="">Pilih Kendaraan</option>
                                        @foreach ($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $fuelLog->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                                                {{ $vehicle->name }} - {{ $vehicle->license_plate }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="rental_id" class="col-sm-3 col-form-label">Terkait Rental (Opsional)</label>
                                <div class="col-sm-9">
                                    <select name="rental_id" id="rental_id" class="form-select @error('rental_id') is-invalid @enderror">
                                        <option value="">Tidak Terkait Transaksi Apapun</option>
                                        @foreach ($rentals as $rental)
                                            <option value="{{ $rental->id }}" {{ old('rental_id', $fuelLog->rental_id) == $rental->id ? 'selected' : '' }}>
                                                #RNT-{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }} - {{ $rental->customer->name }} ({{ $rental->vehicle->name }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('rental_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="log_date" class="col-sm-3 col-form-label">Tanggal Pengisian</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control @error('log_date') is-invalid @enderror" id="log_date" name="log_date" value="{{ old('log_date', $fuelLog->log_date) }}" required>
                                    @error('log_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="liters" class="col-sm-3 col-form-label">Jumlah (Liter)</label>
                                <div class="col-sm-9">
                                    <input type="number" step="0.01" class="form-control @error('liters') is-invalid @enderror" id="liters" name="liters" value="{{ old('liters', $fuelLog->liters) }}" required placeholder="Misal: 10.5">
                                    @error('liters')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="cost" class="col-sm-3 col-form-label">Total Biaya (Rp)</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control @error('cost') is-invalid @enderror" id="cost" name="cost" value="{{ old('cost', $fuelLog->cost) }}" required placeholder="Misal: 150000">
                                    @error('cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="odometer" class="col-sm-3 col-form-label">Odometer (km)</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control @error('odometer') is-invalid @enderror" id="odometer" name="odometer" value="{{ old('odometer', $fuelLog->odometer) }}" required placeholder="Misal: 12500">
                                    @error('odometer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('fuel-log.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
