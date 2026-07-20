<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('rental.index', [
            'title' => 'Data Rental',
            'rentals' => Rental::with(['customer', 'vehicle', 'driver'])->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('rental.create', [
            'title' => 'Tambah Rental',
            'customers' => \App\Models\User::where('role', 'customer')->get(),
            'vehicles' => \App\Models\Vehicle::where('status', 'available')->get(),
            'drivers' => \App\Models\Driver::where('status', 'available')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,paid,active,completed,cancelled',
        ]);

        $start = \Carbon\Carbon::parse($validated['start_date']);
        $end = \Carbon\Carbon::parse($validated['end_date']);
        $totalDays = $start->diffInDays($end) + 1;

        $vehicle = \App\Models\Vehicle::findOrFail($validated['vehicle_id']);
        $totalPrice = $vehicle->price_per_day * $totalDays;

        if (!empty($validated['driver_id'])) {
            $driver = \App\Models\Driver::findOrFail($validated['driver_id']);
            $totalPrice += ($driver->cost_per_day * $totalDays);
        }

        $validated['total_days'] = $totalDays;
        $validated['total_price'] = $totalPrice;

        Rental::create($validated);

        if ($validated['status'] == 'active') {
            $vehicle->update(['status' => 'rented']);
            if (!empty($validated['driver_id'])) {
                \App\Models\Driver::where('id', $validated['driver_id'])->update(['status' => 'assigned']);
            }
        }

        return redirect()->route('rental.index')->with('success', 'Data rental berhasil ditambahkan');
    }

    public function show(Rental $rental)
    {
        return view('rental.show', compact('rental'));
    }

    public function edit(Rental $rental)
    {
        return view('rental.edit', [
            'title' => 'Edit Rental',
            'rental' => $rental,
            'customers' => \App\Models\User::where('role', 'customer')->get(),
            'vehicles' => \App\Models\Vehicle::all(),
            'drivers' => \App\Models\Driver::all(),
        ]);
    }

    public function update(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,paid,active,completed,cancelled',
        ]);

        $start = \Carbon\Carbon::parse($validated['start_date']);
        $end = \Carbon\Carbon::parse($validated['end_date']);
        $totalDays = $start->diffInDays($end) + 1;

        $vehicle = \App\Models\Vehicle::findOrFail($validated['vehicle_id']);
        $totalPrice = $vehicle->price_per_day * $totalDays;

        if (!empty($validated['driver_id'])) {
            $driver = \App\Models\Driver::findOrFail($validated['driver_id']);
            $totalPrice += ($driver->cost_per_day * $totalDays);
        }

        $validated['total_days'] = $totalDays;
        $validated['total_price'] = $totalPrice;

        $oldStatus = $rental->status;
        $rental->update($validated);

        if ($validated['status'] == 'active' && $oldStatus != 'active') {
            $vehicle->update(['status' => 'rented']);
            if ($rental->driver_id) {
                \App\Models\Driver::where('id', $rental->driver_id)->update(['status' => 'assigned']);
            }
        } elseif (in_array($validated['status'], ['completed', 'cancelled']) && in_array($oldStatus, ['active', 'paid', 'pending'])) {
            $vehicle->update(['status' => 'available']);
            if ($rental->driver_id) {
                \App\Models\Driver::where('id', $rental->driver_id)->update(['status' => 'available']);
            }
        }

        return redirect()->route('rental.index')->with('success', 'Data rental berhasil diupdate');
    }

    public function destroy(Rental $rental)
    {
        $rental->delete();
        return redirect()->route('rental.index')->with('success', 'Data rental berhasil dihapus');
    }
}
