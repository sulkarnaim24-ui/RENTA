<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <form action="{{ route('vehicle.update', $vehicle) }}" method="post" enctype="multipart/form-data" class="form">
            @csrf
            @method('put')
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label for="image" class="form-label">Foto Kendaraan</label>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="upload" name="image">
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <img src="{{ $vehicle->image ? asset('storage/' . $vehicle->image) : asset('niceadmin/img/noprofil.png') }}" alt="Image" class="w-100 rounded mt-2" id="preview">
                </div>
                <div class="col-md-9">
                    <div class="mb-3">
                        <label for="category_id" class="form-label required">Kategori</label>
                        <select class="form-select select2-default @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $vehicle->category_id) == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label required">Nama Kendaraan</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" required value="{{ old('name', $vehicle->name) }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label required">Merek</label>
                        <input class="form-control @error('brand') is-invalid @enderror" type="text" id="brand" name="brand" required value="{{ old('brand', $vehicle->brand) }}">
                        @error('brand') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="license_plate" class="form-label required">Plat Nomor</label>
                        <input class="form-control @error('license_plate') is-invalid @enderror" type="text" id="license_plate" name="license_plate" required value="{{ old('license_plate', $vehicle->license_plate) }}">
                        @error('license_plate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price_per_day" class="form-label required">Harga per Hari (Rp)</label>
                        <input class="form-control @error('price_per_day') is-invalid @enderror" type="number" id="price_per_day" name="price_per_day" required value="{{ old('price_per_day', $vehicle->price_per_day) }}">
                        @error('price_per_day') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label required">Status</label>
                        <select class="form-select select2-default @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="available" @selected(old('status', $vehicle->status) == 'available')>Available</option>
                            <option value="rented" @selected(old('status', $vehicle->status) == 'rented')>Rented</option>
                            <option value="maintenance" @selected(old('status', $vehicle->status) == 'maintenance')>Maintenance</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="text-end">
                <a href="{{ route('vehicle.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app>
