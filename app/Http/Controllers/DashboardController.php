<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Agregasi Data Utama
        $activeRentalsCount = \App\Models\Rental::whereIn('status', ['active', 'paid', 'pending'])->count();
        $totalRevenue = \App\Models\Payment::where('status', 'verified')->sum('amount');
        $activeVehiclesCount = \App\Models\Vehicle::where('status', 'available')->count();
        
        // Data User Stats
        $totalUsers = \App\Models\User::count();
        $superadminCount = \App\Models\User::where('role', 'Superadmin')->count();
        $adminCount = \App\Models\User::where('role', 'Admin')->count();

        // 2. Notifikasi (Perawatan & Asuransi)
        $pendingMaintenances = \App\Models\MaintenanceRecord::with('vehicle')
            ->whereNotNull('next_maintenance_date')
            ->where('next_maintenance_date', '<=', \Carbon\Carbon::now()->addDays(14))
            ->orderBy('next_maintenance_date', 'asc')
            ->get();
        $expiringInsurances = \App\Models\InsuranceRecord::with('vehicle')
            ->where('end_date', '<=', \Carbon\Carbon::now()->addDays(30))
            ->orderBy('end_date', 'asc')
            ->get();

        // 3. Data Grafik (Pendapatan per Bulan - 6 bulan terakhir)
        $sixMonthsAgo = \Carbon\Carbon::now()->subMonths(5)->startOfMonth();
        $payments = \App\Models\Payment::where('status', 'verified')
            ->where('payment_date', '>=', $sixMonthsAgo)
            ->get()
            ->groupBy(function($date) {
                return \Carbon\Carbon::parse($date->payment_date)->format('Y-m');
            });
        
        $months = [];
        $revenues = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $monthString = \Carbon\Carbon::now()->subMonths($i)->format('Y-m');
            $months[] = \Carbon\Carbon::now()->subMonths($i)->translatedFormat('M Y');
            
            if(isset($payments[$monthString])) {
                $revenues[] = $payments[$monthString]->sum('amount');
            } else {
                $revenues[] = 0;
            }
        }

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'activeRentalsCount' => $activeRentalsCount,
            'totalRevenue' => $totalRevenue,
            'activeVehiclesCount' => $activeVehiclesCount,
            'totalUsers' => $totalUsers,
            'superadminCount' => $superadminCount,
            'adminCount' => $adminCount,
            'pendingMaintenances' => $pendingMaintenances,
            'expiringInsurances' => $expiringInsurances,
            'chartMonths' => $months,
            'chartRevenues' => $revenues,
        ]);
    }

    public function show()
    {
        return view('dashboard.show', [
            'title' => 'My Profile',
            'user' => Auth::user()
        ]);
    }

    public function edit()
    {
        return view('dashboard.edit', [
            'title' => 'Edit Profile',
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $validate = $request->validate([
                'name' => 'required',
                'password' => 'nullable|min:8',
                'passwordconfirm' => 'nullable|same:password',
                'email' => 'required|email|lowercase|unique:users,email,' . $user->id,
                'avatar' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:512'
            ], [
                'name.required' => 'Nama wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'passwordconfirm.same' => 'Konfirmasi password tidak cocok',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'avatar.image' => 'File avatar harus berupa gambar',
                'avatar.mimes' => 'Format avatar harus png, jpg, jpeg, atau svg',
                'avatar.max' => 'Ukuran avatar tidak boleh lebih dari 512 KB',
            ]);

            if ($request->file('avatar')) {
                $validate['avatar'] = $request->file('avatar')->store('img', 'public');
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }

            if ($request->password) {
                $validate['password'] = bcrypt($request->password);
            } else {
                unset($validate['password']);
            }
            $user->update($validate);

            DB::commit();
            return to_route('dashboard.show')->withSuccess('Data berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('dashboard.edit')->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }
}
