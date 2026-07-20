<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Welcome Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="fw-bold mb-3">
                        <i class='bx bx-smile text-primary me-2'></i>
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-muted mb-0">
                        Anda login sebagai <span class="badge bg-primary">{{ Auth::user()->role }}</span>
                    </p>
                    <p class="text-muted mt-2">
                        <i class='bx bx-time-five me-1'></i>
                        {{ now()->isoFormat('dddd, D MMMM YYYY - HH:mm') }}
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('niceadmin/img/noprofil.png') }}"
                        alt="Avatar" class="img-fluid rounded-circle border border-3 border-primary"
                        style="max-width: 150px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Rental Aktif</p>
                            <h2 class="fw-bold mb-0">{{ $activeRentalsCount }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-car fs-2 text-primary'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Kendaraan Tersedia</p>
                            <h2 class="fw-bold mb-0">{{ $activeVehiclesCount }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-check-shield fs-2 text-success'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Total Pendapatan</p>
                            <h4 class="fw-bold mb-0">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-money fs-2 text-info'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Total Pengguna</p>
                            <h2 class="fw-bold mb-0">{{ $totalUsers }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-user fs-2 text-warning'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Chart -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class='bx bx-line-chart text-primary me-2'></i>
                        Grafik Pendapatan (6 Bulan Terakhir)
                    </h5>
                </div>
                <div class="card-body pt-3">
                    <div id="revenueChart"></div>
                </div>
            </div>
        </div>
        
        <!-- Notifications -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class='bx bx-bell text-danger me-2'></i>
                        Peringatan & Notifikasi
                    </h5>
                </div>
                <div class="card-body pt-3" style="max-height: 400px; overflow-y: auto;">
                    @if($pendingMaintenances->count() == 0 && $expiringInsurances->count() == 0)
                        <div class="alert alert-success">
                            Semua kendaraan dalam kondisi optimal. Tidak ada peringatan asuransi atau perawatan.
                        </div>
                    @else
                        @foreach($expiringInsurances as $ins)
                            <div class="alert alert-danger d-flex align-items-center p-2 mb-2">
                                <i class='bx bx-shield-quarter fs-3 me-2'></i>
                                <div>
                                    <small class="d-block fw-bold">Asuransi {{ $ins->vehicle->name }} ({{ $ins->vehicle->license_plate }})</small>
                                    <small>Kedaluwarsa: {{ \Carbon\Carbon::parse($ins->end_date)->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        @endforeach

                        @foreach($pendingMaintenances as $mtn)
                            <div class="alert alert-warning d-flex align-items-center p-2 mb-2">
                                <i class='bx bx-wrench fs-3 me-2'></i>
                                <div>
                                    <small class="d-block fw-bold">Perawatan {{ $mtn->vehicle->name }} ({{ $mtn->vehicle->license_plate }})</small>
                                    <small>Jadwal: {{ \Carbon\Carbon::parse($mtn->scheduled_date)->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-rocket me-2 text-primary'></i>
                Quick Actions
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3 mt-2">
                <div class="col-md-3">
                    <a href="{{ route('user.index') }}" class="text-decoration-none">
                        <div class="card border border-primary border-opacity-25 h-100 hover-shadow">
                            <div class="card-body text-center mt-4">
                                <i class='bx bx-user-plus fs-1 text-primary mb-2'></i>
                                <h6 class="mb-0">Manage Users</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('setting.index') }}" class="text-decoration-none">
                        <div class="card border border-success border-opacity-25 h-100 hover-shadow">
                            <div class="card-body text-center mt-4"">
                                <i class='bx bx-cog fs-1 text-success mb-2'></i>
                                <h6 class=" mb-0">Settings</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('dashboard.show') }}" class="text-decoration-none">
                        <div class="card border border-info border-opacity-25 h-100 hover-shadow">
                            <div class="card-body text-center mt-4"">
                                <i class='bx bx-user-circle fs-1 text-info mb-2'></i>
                                <h6 class=" mb-0">My Profile</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('dashboard.edit') }}" class="text-decoration-none">
                        <div class="card border border-warning border-opacity-25 h-100 hover-shadow">
                            <div class="card-body text-center mt-4"">
                                <i class='bx bx-edit fs-1 text-warning mb-2'></i>
                                <h6 class=" mb-0">Edit Profile</h6>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- System Information -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold">
                        <i class='bx bx-info-circle me-2 text-primary'></i>
                        System Information
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 pt-4">
                        <li class="mb-2">
                            <i class='bx bx-check-circle text-success me-2'></i>
                            <strong>Laravel Version:</strong> {{ app()->version() }}
                        </li>
                        <li class="mb-2">
                            <i class='bx bx-check-circle text-success me-2'></i>
                            <strong>PHP Version:</strong> {{ PHP_VERSION }}
                        </li>
                        <li class="mb-2">
                            <i class='bx bx-check-circle text-success me-2'></i>
                            <strong>Environment:</strong> {{ config('app.env') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 pt-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold">
                        <i class='bx bx-user me-2 text-primary'></i>
                        Your Account
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class='bx bx-envelope text-primary me-2'></i>
                            <strong>Email:</strong> {{ Auth::user()->email }}
                        </li>
                        <li class="mb-2">
                            <i class='bx bx-calendar text-primary me-2'></i>
                            <strong>Member Since:</strong> {{ Auth::user()->created_at->format('d M Y') }}
                        </li>
                        <li class="mb-2">
                            <i class='bx bx-time text-primary me-2'></i>
                            <strong>Last Updated:</strong> {{ Auth::user()->updated_at->diffForHumans() }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    @push('modals')
    @endpush

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            new ApexCharts(document.querySelector("#revenueChart"), {
                series: [{
                    name: 'Pendapatan',
                    data: {!! json_encode($chartRevenues) !!}
                }],
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: { show: false }
                },
                markers: { size: 4 },
                colors: ['#000080'],
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                xaxis: {
                    categories: {!! json_encode($chartMonths) !!}
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return "Rp " + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                        }
                    }
                }
            }).render();
        });
    </script>
    @endpush

</x-app>
