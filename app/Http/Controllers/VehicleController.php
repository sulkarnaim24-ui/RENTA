<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        return view('vehicle.index', [
            'title' => 'Data Kendaraan',
            'vehicles' => Vehicle::with('category')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('vehicle.create', [
            'title' => 'Tambah Kendaraan',
            'categories' => VehicleCategory::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'category_id' => 'required|exists:vehicle_categories,id',
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'license_plate' => 'required|string|unique:vehicles,license_plate',
            'price_per_day' => 'required|integer|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ], [
            'category_id.required' => 'Kategori wajib dipilih',
            'name.required' => 'Nama kendaraan wajib diisi',
            'brand.required' => 'Merek wajib diisi',
            'license_plate.required' => 'Plat nomor wajib diisi',
            'license_plate.unique' => 'Plat nomor sudah terdaftar',
            'price_per_day.required' => 'Harga per hari wajib diisi',
            'status.required' => 'Status wajib diisi',
            'image.image' => 'File harus berupa gambar',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($request->file('image')) {
            $validate['image'] = $request->file('image')->store('img/vehicle', 'public');
        }

        Vehicle::create($validate);
        return to_route('vehicle.index')->withSuccess('Kendaraan berhasil ditambahkan');
    }

    public function show(Vehicle $vehicle)
    {
        return view('vehicle.show', [
            'title' => 'Detail Kendaraan',
            'vehicle' => $vehicle,
        ]);
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicle.edit', [
            'title' => 'Edit Kendaraan',
            'vehicle' => $vehicle,
            'categories' => VehicleCategory::all(),
        ]);
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validate = $request->validate([
            'category_id' => 'required|exists:vehicle_categories,id',
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'license_plate' => 'required|string|unique:vehicles,license_plate,' . $vehicle->id,
            'price_per_day' => 'required|integer|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        if ($request->file('image')) {
            $validate['image'] = $request->file('image')->store('img/vehicle', 'public');
            if ($vehicle->image && Storage::disk('public')->exists($vehicle->image)) {
                Storage::disk('public')->delete($vehicle->image);
            }
        }

        $vehicle->update($validate);
        return to_route('vehicle.index')->withSuccess('Kendaraan berhasil diubah');
    }

    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->image && Storage::disk('public')->exists($vehicle->image)) {
            Storage::disk('public')->delete($vehicle->image);
        }
        $vehicle->delete();
        return to_route('vehicle.index')->withSuccess('Kendaraan berhasil dihapus');
    }
}
