<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('driver.index', [
            'title' => 'Data Pengemudi',
            'drivers' => Driver::all(),
        ]);
    }

    public function create()
    {
        return view('driver.create', [
            'title' => 'Tambah Pengemudi',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'license_number' => 'required|string|max:255|unique:drivers,license_number',
            'status' => 'required|in:available,assigned,leave',
            'cost_per_day' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('driver', 'public');
        }

        Driver::create($validated);

        return redirect()->route('driver.index')->with('success', 'Data pengemudi berhasil ditambahkan');
    }

    public function show(Driver $driver)
    {
        return view('driver.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        return view('driver.edit', [
            'title' => 'Edit Pengemudi',
            'driver' => $driver,
        ]);
    }

    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'license_number' => 'required|string|max:255|unique:drivers,license_number,' . $driver->id,
            'status' => 'required|in:available,assigned,leave',
            'cost_per_day' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($driver->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($driver->image);
            }
            $validated['image'] = $request->file('image')->store('driver', 'public');
        }

        $driver->update($validated);

        return redirect()->route('driver.index')->with('success', 'Data pengemudi berhasil diupdate');
    }

    public function destroy(Driver $driver)
    {
        if ($driver->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($driver->image);
        }
        $driver->delete();

        return redirect()->route('driver.index')->with('success', 'Data pengemudi berhasil dihapus');
    }
}
