<?php

namespace App\Http\Controllers;

use App\Models\InsuranceRecord;
use Illuminate\Http\Request;

class InsuranceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('insurance_record.index', [
            'title' => 'Asuransi Kendaraan',
            'insurances' => InsuranceRecord::with('vehicle')->orderBy('end_date', 'asc')->get(),
        ]);
    }

    public function create()
    {
        return view('insurance_record.create', [
            'title' => 'Tambah Asuransi',
            'vehicles' => \App\Models\Vehicle::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'policy_number' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'premium_cost' => 'required|integer|min:0',
            'document_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('document_file')) {
            $validated['document_file'] = $request->file('document_file')->store('insurances', 'public');
        }

        InsuranceRecord::create($validated);

        return redirect()->route('insurance-record.index')->with('success', 'Data asuransi berhasil ditambahkan');
    }

    public function show(InsuranceRecord $insuranceRecord)
    {
        //
    }

    public function edit(InsuranceRecord $insuranceRecord)
    {
        return view('insurance_record.edit', [
            'title' => 'Edit Asuransi',
            'insurance' => $insuranceRecord,
            'vehicles' => \App\Models\Vehicle::all(),
        ]);
    }

    public function update(Request $request, InsuranceRecord $insuranceRecord)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'policy_number' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'premium_cost' => 'required|integer|min:0',
            'document_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('document_file')) {
            if ($insuranceRecord->document_file) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($insuranceRecord->document_file);
            }
            $validated['document_file'] = $request->file('document_file')->store('insurances', 'public');
        }

        $insuranceRecord->update($validated);

        return redirect()->route('insurance-record.index')->with('success', 'Data asuransi berhasil diupdate');
    }

    public function destroy(InsuranceRecord $insuranceRecord)
    {
        if ($insuranceRecord->document_file) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($insuranceRecord->document_file);
        }
        $insuranceRecord->delete();
        
        return redirect()->route('insurance-record.index')->with('success', 'Data asuransi berhasil dihapus');
    }
}
