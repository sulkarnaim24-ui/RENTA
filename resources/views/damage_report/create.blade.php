<x-app title="Tambah Laporan Kerusakan">
    <div class="pagetitle">
        <h1>Tambah Laporan Kerusakan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('damage-report.index') }}">Laporan Kerusakan</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Form Tambah Laporan</h5>
                        <form action="{{ route('damage-report.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="vehicle_id" class="col-sm-3 col-form-label">Kendaraan</label>
                                <div class="col-sm-9">
                                    <select name="vehicle_id" id="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>
                                        <option value="">Pilih Kendaraan</option>
                                        @foreach ($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
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
                                        <option value="">Pilih Transaksi Rental Jika Terkait</option>
                                        @foreach ($rentals as $rental)
                                            <option value="{{ $rental->id }}" {{ old('rental_id') == $rental->id ? 'selected' : '' }}>
                                                #{{ $rental->id }} - {{ $rental->customer->name }} ({{ $rental->vehicle->license_plate }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('rental_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="reported_date" class="col-sm-3 col-form-label">Tanggal Dilaporkan</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control @error('reported_date') is-invalid @enderror" id="reported_date" name="reported_date" value="{{ old('reported_date', date('Y-m-d')) }}" required>
                                    @error('reported_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-sm-3 col-form-label">Deskripsi</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required placeholder="Jelaskan detail kerusakan">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="repair_cost" class="col-sm-3 col-form-label">Estimasi Biaya (Rp)</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control @error('repair_cost') is-invalid @enderror" id="repair_cost" name="repair_cost" value="{{ old('repair_cost', 0) }}" required>
                                    @error('repair_cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="reported" {{ old('status') == 'reported' ? 'selected' : '' }}>Dilaporkan (Menunggu Tindakan)</option>
                                        <option value="in_repair" {{ old('status') == 'in_repair' ? 'selected' : '' }}>Sedang Diperbaiki</option>
                                        <option value="resolved" {{ old('status') == 'resolved' ? 'selected' : '' }}>Selesai Diperbaiki</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="photo" class="col-sm-3 col-form-label">Foto Bukti (Opsional)</label>
                                <div class="col-sm-9">
                                    <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo" name="photo" accept="image/*">
                                    <div class="form-text">Format: jpg, jpeg, png. Maksimal 2MB.</div>
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                                    <a href="{{ route('damage-report.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
