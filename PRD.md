# Product Requirements Document (PRD): Sistem Rental Kendaraan

## 1. Ringkasan Eksekutif (Executive Summary)
**Sistem Rental Kendaraan** adalah platform aplikasi berbasis web yang membantu perusahaan rental mengelola armada kendaraan, pemesanan, pengemudi, hingga laporan kondisi kendaraan secara terpusat, efisien, dan transparan.

## 2. Masalah (Problem Statement)
Perusahaan rental membutuhkan sistem untuk mengelola armada kendaraan, pemesanan, pengemudi, dan laporan kondisi kendaraan — mulai dari katalog unit, penugasan pengemudi, konsumsi bahan bakar, jadwal perawatan, kerusakan, hingga status asuransi — yang saat ini masih dilakukan secara manual dan terpisah-pisah.

## 3. Tujuan & Sasaran (Goals & Objectives)
- **Bagi Pengelola Rental:** Mengotomatisasi manajemen armada kendaraan, penugasan pengemudi, pelacakan biaya operasional (BBM & perawatan), serta memonitor kondisi dan status legal (asuransi) kendaraan secara *real-time*.
- **Bagi Pengemudi:** Mendapatkan penugasan yang jelas dan mencatat kondisi kendaraan (BBM, kerusakan) selama masa tugas.
- **Bagi Pelanggan:** Memberikan kemudahan mencari kendaraan yang tersedia, melakukan pemesanan, dan membayar secara *online* kapan saja.

## 4. Target Pengguna (User Personas)
1. **Pengelola Rental (Admin):** Mengelola data kendaraan & kategori, menyetujui pemesanan, menugaskan pengemudi, memverifikasi pembayaran, mencatat perawatan/kerusakan/asuransi, dan melihat laporan.
2. **Pengemudi (Driver):** Menerima penugasan rental, mencatat konsumsi bahan bakar, dan melaporkan kerusakan kendaraan.
3. **Pelanggan (Customer):** Mencari kendaraan, membuat pesanan (rental), melakukan pembayaran, dan melihat riwayat pemesanan.

## 5. Fitur Utama (Key Features)

### A. Katalog Kendaraan dan Kategori
- CRUD Kategori Kendaraan (mis. City Car, SUV, MPV, Motor).
- CRUD Data Kendaraan (Nama, Merek, Nomor Polisi, Harga Sewa/Hari, Foto, Kategori).
- Manajemen Status Kendaraan (Tersedia, Disewa, Perawatan).

### B. Pemesanan dan Manajemen Rental
- Pencarian & filter kendaraan berdasarkan kategori dan tanggal ketersediaan.
- Proses pemesanan (pilih tanggal mulai & selesai, kalkulasi harga otomatis).
- Manajemen status rental (Menunggu Pembayaran, Dibayar, Berjalan, Selesai, Dibatalkan).

### C. Data Pengemudi dan Penugasan
- CRUD Data Pengemudi (Nama, No. SIM, Kontak, Status).
- Penugasan pengemudi ke transaksi rental tertentu.

### D. Pencatatan Konsumsi Bahan Bakar
- Input log BBM per kendaraan (tanggal, liter, biaya, odometer), terhubung ke rental terkait.

### E. Jadwal dan Riwayat Perawatan
- Pencatatan riwayat perawatan (servis, biaya, tanggal) per kendaraan.
- Penjadwalan perawatan berikutnya berdasarkan tanggal/jarak tempuh.

### F. Laporan Kerusakan Kendaraan
- Pelaporan kerusakan (deskripsi, foto, tanggal, estimasi/biaya perbaikan) terkait kendaraan & rental tertentu.
- Status penanganan kerusakan (Dilaporkan, Diperbaiki, Selesai).

### G. Manajemen Asuransi Kendaraan
- Pencatatan polis asuransi per kendaraan (penyedia, no. polisi, masa berlaku, premi, cakupan).
- Notifikasi masa berlaku asuransi akan habis.

### H. Pembayaran & Tagihan
- Pencatatan pembayaran per transaksi rental (metode, bukti transfer, status verifikasi).
- Penerbitan invoice otomatis.

### I. Dashboard & Laporan
- Ringkasan rental berjalan, total pendapatan, jumlah kendaraan aktif, dan status armada (tersedia/disewa/perawatan).

## 6. Skema Data & Arsitektur (Data Schema & Architecture)

### 6.1. Penjelasan Naratif
Sistem menggunakan arsitektur *Monolith* berbasis framework **Laravel**, dengan *frontend* menggunakan **Blade Template Engine** dan **Bootstrap (NiceAdmin)**. Database yang digunakan adalah **MySQL/PostgreSQL**.

Struktur data terdiri dari 10 tabel inti:
- **vehicle_categories:** Kategori/jenis kendaraan.
- **vehicles:** Katalog kendaraan, terhubung ke kategori.
- **customers:** Data pelanggan/penyewa.
- **drivers:** Data pengemudi.
- **rentals:** Tabel transaksi utama, menghubungkan `customers`, `vehicles`, dan `drivers` (opsional), mencatat periode & total tagihan.
- **fuel_logs:** Riwayat konsumsi bahan bakar per kendaraan, dapat terhubung ke `rentals`.
- **maintenance_records:** Riwayat & jadwal perawatan kendaraan.
- **damage_reports:** Laporan kerusakan kendaraan, terhubung ke `rentals` yang relevan.
- **payments:** Riwayat pembayaran untuk sebuah `rental`.
- **insurance_records:** Data polis asuransi per kendaraan.

### 6.2. Visualisasi ERD (Entity Relationship Diagram)

```mermaid
erDiagram
    VEHICLE_CATEGORIES {
        bigint id PK
        string name
        text description
    }

    VEHICLES {
        bigint id PK
        bigint category_id FK
        string name
        string brand
        string license_plate
        integer price_per_day
        enum status "available, rented, maintenance"
        string image
        timestamp created_at
    }

    CUSTOMERS {
        bigint id PK
        string name
        string email
        string password
        string phone
        text address
        string driver_license "Foto SIM/KTP"
        timestamp created_at
    }

    DRIVERS {
        bigint id PK
        string name
        string phone
        string license_number
        enum status "available, on_duty, inactive"
        timestamp created_at
    }

    RENTALS {
        bigint id PK
        bigint customer_id FK
        bigint vehicle_id FK
        bigint driver_id FK "nullable"
        date start_date
        date end_date
        integer total_days
        integer total_price
        enum status "pending, paid, active, completed, cancelled"
        timestamp created_at
    }

    FUEL_LOGS {
        bigint id PK
        bigint vehicle_id FK
        bigint rental_id FK "nullable"
        date log_date
        decimal liters
        integer cost
        integer odometer
    }

    MAINTENANCE_RECORDS {
        bigint id PK
        bigint vehicle_id FK
        date maintenance_date
        text description
        integer cost
        date next_maintenance_date
    }

    DAMAGE_REPORTS {
        bigint id PK
        bigint vehicle_id FK
        bigint rental_id FK "nullable"
        text description
        string photo
        date reported_date
        integer repair_cost
        enum status "reported, in_repair, resolved"
    }

    PAYMENTS {
        bigint id PK
        bigint rental_id FK
        integer amount
        string payment_method
        string proof_of_payment
        enum status "pending, verified, failed"
        timestamp payment_date
    }

    INSURANCE_RECORDS {
        bigint id PK
        bigint vehicle_id FK
        string provider
        string policy_number
        date start_date
        date end_date
        integer premium
        text coverage_details
    }

    %% Relationships
    VEHICLE_CATEGORIES ||--o{ VEHICLES : "categorizes"
    CUSTOMERS ||--o{ RENTALS : "makes"
    VEHICLES ||--o{ RENTALS : "is rented in"
    DRIVERS ||--o{ RENTALS : "is assigned to"
    VEHICLES ||--o{ FUEL_LOGS : "has"
    RENTALS ||--o{ FUEL_LOGS : "recorded during"
    VEHICLES ||--o{ MAINTENANCE_RECORDS : "has"
    VEHICLES ||--o{ DAMAGE_REPORTS : "has"
    RENTALS ||--o{ DAMAGE_REPORTS : "reported during"
    RENTALS ||--|| PAYMENTS : "has"
    VEHICLES ||--o{ INSURANCE_RECORDS : "has"
```

## 7. Kebutuhan Non-Fungsional (Non-Functional Requirements)
- **Keamanan:** Enkripsi password menggunakan Bcrypt, proteksi CSRF pada setiap form, dan pembatasan otorisasi level halaman dengan Middleware.
- **Kinerja:** Waktu muat halaman kurang dari 3 detik untuk sisi pelanggan.
- **Responsivitas:** Antarmuka harus beradaptasi dengan baik di perangkat seluler (Mobile-Friendly) menggunakan kaidah CSS framework yang ada.

> **Catatan:** Autentikasi Admin/Pengelola dapat ditangani melalui mekanisme login terpisah (mis. tabel `admins`/`users` internal Laravel) di luar 10 tabel inti di atas, karena fokus skema ini adalah entitas operasional rental.
