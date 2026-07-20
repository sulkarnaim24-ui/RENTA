<?php

namespace App\Http\Controllers;

use App\Models\DamageReport;
use Illuminate\Http\Request;

class DamageReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('damage_report.index', [
            'title' => 'Data Laporan Kerusakan',
            'reports' => DamageReport::with(['vehicle', 'rental.customer'])->latest('reported_date')->get(),
        ]);
    }

    public function create()
    {
        return view('damage_report.create', [
            'title' => 'Tambah Laporan Kerusakan',
            'vehicles' => \App\Models\Vehicle::all(),
            'rentals' => \App\Models\Rental::with(['customer', 'vehicle'])->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'rental_id' => 'nullable|exists:rentals,id',
            'description' => 'required|string',
            'reported_date' => 'required|date',
            'repair_cost' => 'nullable|integer|min:0',
            'status' => 'required|in:reported,in_repair,resolved',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('damage_reports', 'public');
        }

        $validated['repair_cost'] = $validated['repair_cost'] ?? 0;

        DamageReport::create($validated);

        return redirect()->route('damage-report.index')->with('success', 'Laporan kerusakan berhasil ditambahkan');
    }

    public function show(DamageReport $damageReport)
    {
        //
    }

    public function edit(DamageReport $damageReport)
    {
        return view('damage_report.edit', [
            'title' => 'Edit Laporan Kerusakan',
            'report' => $damageReport,
            'vehicles' => \App\Models\Vehicle::all(),
            'rentals' => \App\Models\Rental::with(['customer', 'vehicle'])->latest()->get(),
        ]);
    }

    public function update(Request $request, DamageReport $damageReport)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'rental_id' => 'nullable|exists:rentals,id',
            'description' => 'required|string',
            'reported_date' => 'required|date',
            'repair_cost' => 'nullable|integer|min:0',
            'status' => 'required|in:reported,in_repair,resolved',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($damageReport->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($damageReport->photo);
            }
            $validated['photo'] = $request->file('photo')->store('damage_reports', 'public');
        }

        $validated['repair_cost'] = $validated['repair_cost'] ?? 0;

        $damageReport->update($validated);

        return redirect()->route('damage-report.index')->with('success', 'Laporan kerusakan berhasil diupdate');
    }

    public function destroy(DamageReport $damageReport)
    {
        if ($damageReport->photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($damageReport->photo);
        }
        $damageReport->delete();
        
        return redirect()->route('damage-report.index')->with('success', 'Laporan kerusakan berhasil dihapus');
    }
}
