<?php

namespace App\Http\Controllers;

use App\Models\VehicleCategory;
use Illuminate\Http\Request;

class VehicleCategoryController extends Controller
{
    public function index()
    {
        return view('vehicle_category.index', [
            'title' => 'Kategori Kendaraan',
            'categories' => VehicleCategory::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('vehicle_category.create', [
            'title' => 'Tambah Kategori',
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama kategori wajib diisi',
        ]);

        VehicleCategory::create($validate);
        return to_route('vehicle-category.index')->withSuccess('Kategori berhasil ditambahkan');
    }

    public function edit(VehicleCategory $vehicleCategory)
    {
        return view('vehicle_category.edit', [
            'title' => 'Edit Kategori',
            'category' => $vehicleCategory,
        ]);
    }

    public function update(Request $request, VehicleCategory $vehicleCategory)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama kategori wajib diisi',
        ]);

        $vehicleCategory->update($validate);
        return to_route('vehicle-category.index')->withSuccess('Kategori berhasil diubah');
    }

    public function destroy(VehicleCategory $vehicleCategory)
    {
        $vehicleCategory->delete();
        return to_route('vehicle-category.index')->withSuccess('Kategori berhasil dihapus');
    }
}
