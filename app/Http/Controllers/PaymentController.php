<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('payment.index', [
            'title' => 'Data Pembayaran & Tagihan',
            'payments' => Payment::with(['rental.customer'])->latest('payment_date')->get(),
        ]);
    }

    public function create()
    {
        return view('payment.create', [
            'title' => 'Tambah Pembayaran',
            'rentals' => \App\Models\Rental::with(['customer', 'vehicle'])->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'amount' => 'required|integer|min:0',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
            'status' => 'required|in:pending,verified,failed',
            'proof_of_payment' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('proof_of_payment')) {
            $validated['proof_of_payment'] = $request->file('proof_of_payment')->store('payments', 'public');
        }

        Payment::create($validated);

        return redirect()->route('payment.index')->with('success', 'Data pembayaran berhasil ditambahkan');
    }

    public function show(Payment $payment)
    {
        //
    }

    public function edit(Payment $payment)
    {
        return view('payment.edit', [
            'title' => 'Edit Pembayaran',
            'payment' => $payment,
            'rentals' => \App\Models\Rental::with(['customer', 'vehicle'])->latest()->get(),
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'amount' => 'required|integer|min:0',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
            'status' => 'required|in:pending,verified,failed',
            'proof_of_payment' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('proof_of_payment')) {
            if ($payment->proof_of_payment) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($payment->proof_of_payment);
            }
            $validated['proof_of_payment'] = $request->file('proof_of_payment')->store('payments', 'public');
        }

        $payment->update($validated);

        return redirect()->route('payment.index')->with('success', 'Data pembayaran berhasil diupdate');
    }

    public function destroy(Payment $payment)
    {
        if ($payment->proof_of_payment) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($payment->proof_of_payment);
        }
        $payment->delete();
        
        return redirect()->route('payment.index')->with('success', 'Data pembayaran berhasil dihapus');
    }
}
