<x-app title="Edit Asuransi">
    <div class="pagetitle">
        <h1>Edit Asuransi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('insurance-record.index') }}">Asuransi Kendaraan</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Form Edit Asuransi</h5>
                        <form action="{{ route('insurance-record.update', $insurance->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label for="vehicle_id" class="col-sm-3 col-form-label">Kendaraan</label>
                                <div class="col-sm-9">
                                    <select name="vehicle_id" id="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>
                                        <option value="">Pilih Kendaraan</option>
                                        @foreach ($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $insurance->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                                                {{ $vehicle->name }} ({{ $vehicle->license_plate }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="provider" class="col-sm-3 col-form-label">Penyedia / Provider</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('provider') is-invalid @enderror" id="provider" name="provider" value="{{ old('provider', $insurance->provider) }}" required>
                                    @error('provider')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="policy_number" class="col-sm-3 col-form-label">Nomor Polis</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('policy_number') is-invalid @enderror" id="policy_number" name="policy_number" value="{{ old('policy_number', $insurance->policy_number) }}" required>
                                    @error('policy_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="start_date" class="col-sm-3 col-form-label">Tanggal Mulai</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $insurance->start_date) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="end_date" class="col-sm-3 col-form-label">Tanggal Kedaluwarsa</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $insurance->end_date) }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="premium_cost" class="col-sm-3 col-form-label">Biaya Premi (Rp)</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control @error('premium_cost') is-invalid @enderror" id="premium_cost" name="premium_cost" value="{{ old('premium_cost', $insurance->premium_cost) }}" required>
                                    @error('premium_cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="document_file" class="col-sm-3 col-form-label">Dokumen Polis (Opsional)</label>
                                <div class="col-sm-9">
                                    @if($insurance->document_file)
                                        <div class="mb-2">
                                            <a href="{{ asset('storage/' . $insurance->document_file) }}" target="_blank" class="btn btn-sm btn-info">Lihat Dokumen Saat Ini</a>
                                        </div>
                                    @endif
                                    <input class="form-control @error('document_file') is-invalid @enderror" type="file" id="document_file" name="document_file" accept=".pdf,image/*">
                                    <div class="form-text">Biarkan kosong jika tidak ingin mengubah dokumen. Format: pdf, jpg, jpeg, png. Maksimal 2MB.</div>
                                    @error('document_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary">Update Asuransi</button>
                                    <a href="{{ route('insurance-record.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
