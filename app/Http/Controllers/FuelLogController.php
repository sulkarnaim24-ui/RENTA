<?php

namespace App\Http\Controllers;

use App\Models\FuelLog;
use Illuminate\Http\Request;

class FuelLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('fuel_log.index', [
            'title' => 'Data Log BBM',
            'fuelLogs' => FuelLog::with(['vehicle', 'rental.customer'])->latest('log_date')->get(),
        ]);
    }

    public function create()
    {
        return view('fuel_log.create', [
            'title' => 'Tambah Log BBM',
            'vehicles' => \App\Models\Vehicle::all(),
            'rentals' => \App\Models\Rental::with(['customer', 'vehicle'])->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'rental_id' => 'nullable|exists:rentals,id',
            'log_date' => 'required|date',
            'liters' => 'required|numeric|min:0.1',
            'cost' => 'required|integer|min:0',
            'odometer' => 'required|integer|min:0',
        ]);

        FuelLog::create($validated);

        return redirect()->route('fuel-log.index')->with('success', 'Data log BBM berhasil ditambahkan');
    }

    public function show(FuelLog $fuelLog)
    {
        // Optional: Not always needed for simple logs
    }

    public function edit(FuelLog $fuelLog)
    {
        return view('fuel_log.edit', [
            'title' => 'Edit Log BBM',
            'fuelLog' => $fuelLog,
            'vehicles' => \App\Models\Vehicle::all(),
            'rentals' => \App\Models\Rental::with(['customer', 'vehicle'])->latest()->get(),
        ]);
    }

    public function update(Request $request, FuelLog $fuelLog)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'rental_id' => 'nullable|exists:rentals,id',
            'log_date' => 'required|date',
            'liters' => 'required|numeric|min:0.1',
            'cost' => 'required|integer|min:0',
            'odometer' => 'required|integer|min:0',
        ]);

        $fuelLog->update($validated);

        return redirect()->route('fuel-log.index')->with('success', 'Data log BBM berhasil diupdate');
    }

    public function destroy(FuelLog $fuelLog)
    {
        $fuelLog->delete();
        return redirect()->route('fuel-log.index')->with('success', 'Data log BBM berhasil dihapus');
    }
}
