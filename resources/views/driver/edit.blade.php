<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <form action="{{ route('driver.update', $driver) }}" method="post" enctype="multipart/form-data" class="form">
            @csrf
            @method('put')
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label for="image" class="form-label">Foto / SIM</label>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="upload" name="image">
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <img src="{{ $driver->image ? asset('storage/' . $driver->image) : asset('niceadmin/img/noprofil.png') }}" alt="Image" class="w-100 rounded mt-2" id="preview">
                </div>
                <div class="col-md-9">
                    <div class="mb-3">
                        <label for="name" class="form-label required">Nama</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" required value="{{ old('name', $driver->name) }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor HP</label>
                        <input class="form-control @error('phone') is-invalid @enderror" type="text" id="phone" name="phone" value="{{ old('phone', $driver->phone) }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="license_number" class="form-label required">Nomor SIM</label>
                        <input class="form-control @error('license_number') is-invalid @enderror" type="text" id="license_number" name="license_number" required value="{{ old('license_number', $driver->license_number) }}">
                        @error('license_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="cost_per_day" class="form-label required">Biaya Jasa per Hari (Rp)</label>
                        <input class="form-control @error('cost_per_day') is-invalid @enderror" type="number" id="cost_per_day" name="cost_per_day" required value="{{ old('cost_per_day', $driver->cost_per_day) }}">
                        @error('cost_per_day') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label required">Status</label>
                        <select class="form-select select2-default @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="available" @selected(old('status', $driver->status) == 'available')>Available</option>
                            <option value="assigned" @selected(old('status', $driver->status) == 'assigned')>Assigned</option>
                            <option value="leave" @selected(old('status', $driver->status) == 'leave')>Leave</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="text-end">
                <a href="{{ route('driver.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app>
