<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRecord;
use Illuminate\Http\Request;

class MaintenanceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('maintenance_record.index', [
            'title' => 'Data Perawatan Kendaraan',
            'records' => MaintenanceRecord::with('vehicle')->latest('maintenance_date')->get(),
        ]);
    }

    public function create()
    {
        return view('maintenance_record.create', [
            'title' => 'Tambah Data Perawatan',
            'vehicles' => \App\Models\Vehicle::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'maintenance_date' => 'required|date',
            'description' => 'required|string',
            'cost' => 'required|integer|min:0',
            'next_maintenance_date' => 'nullable|date|after_or_equal:maintenance_date',
        ]);

        MaintenanceRecord::create($validated);

        return redirect()->route('maintenance-record.index')->with('success', 'Data perawatan berhasil ditambahkan');
    }

    public function show(MaintenanceRecord $maintenanceRecord)
    {
        //
    }

    public function edit(MaintenanceRecord $maintenanceRecord)
    {
        return view('maintenance_record.edit', [
            'title' => 'Edit Data Perawatan',
            'record' => $maintenanceRecord,
            'vehicles' => \App\Models\Vehicle::all(),
        ]);
    }

    public function update(Request $request, MaintenanceRecord $maintenanceRecord)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'maintenance_date' => 'required|date',
            'description' => 'required|string',
            'cost' => 'required|integer|min:0',
            'next_maintenance_date' => 'nullable|date|after_or_equal:maintenance_date',
        ]);

        $maintenanceRecord->update($validated);

        return redirect()->route('maintenance-record.index')->with('success', 'Data perawatan berhasil diupdate');
    }

    public function destroy(MaintenanceRecord $maintenanceRecord)
    {
        $maintenanceRecord->delete();
        return redirect()->route('maintenance-record.index')->with('success', 'Data perawatan berhasil dihapus');
    }
}
