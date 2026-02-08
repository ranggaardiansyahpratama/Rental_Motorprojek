# Analisis Sistem Penyewaan Motor

## Status Fitur Berdasarkan Spesifikasi

### PENYEWA (Renter) 🏍️

| No | Fitur | Status | Keterangan |
|----|-------|--------|------------|
| 1 | Registrasi akun | ✅ SUDAH ADA | Route register tersedia |
| 2 | Cari motor berdasarkan merk | ✅ SUDAH ADA | Filter brand di dashboard renter |
| 3 | Cari berdasarkan jenis (100cc, 125cc, 150cc) | ✅ SUDAH ADA | Filter CC tersedia |
| 4 | Pilih paket sewa (harian, mingguan, bulanan) | ⚠️ PERLU PERBAIKAN | Ada di modal tapi perlu validasi & implementasi diskon |
| 5 | Pemesanan | ✅ SUDAH ADA | Form rental di modal |
| 6 | Pembayaran | ⚠️ PERLU PERBAIKAN | Perlu route & controller untuk payment |
| 7 | Melihat status penyewaan | ✅ SUDAH ADA | Ada di dashboard renter |
| 8 | Melihat histori sewa | ✅ SUDAH ADA | Section history di dashboard |

### PEMILIK KENDARAAN (Owner) 🚗

| No | Fitur | Status | Keterangan |
|----|-------|--------|------------|
| 1 | Registrasi akun | ✅ SUDAH ADA | Route register tersedia |
| 2 | Menyewakan lebih dari 1 kendaraan | ✅ SUDAH ADA | Relasi hasMany di model |
| 3 | Lihat status motor (disewa, tersedia, perawatan) | ✅ SUDAH ADA | Dashboard owner section status |
| 4 | Lihat laporan bagi hasil | ✅ SUDAH ADA | Dashboard owner section revenue |

### ADMIN 👨‍💼

| No | Fitur | Status | Keterangan |
|----|-------|--------|------------|
| 1 | Verifikasi motor | ⚠️ PERLU PERBAIKAN | Schema sudah ada tapi perlu UI & controller |
| 2 | Tetapkan harga sewa (harian, mingguan, bulanan) | ⚠️ PERLU PERBAIKAN | Field sudah ada, perlu form di motor edit |
| 3 | Kelola pesanan | ✅ SUDAH ADA | CRUD rentals ada |
| 4 | Konfirmasi sewa | ⚠️ PERLU PERBAIKAN | Field confirmed_at ada, perlu action button |
| 5 | Kelola pembayaran | ⚠️ PERLU PERBAIKAN | Tabel payments ada, perlu controller lengkap |
| 6 | Bagi hasil ke pemilik | ⚠️ PERLU PERBAIKAN | Tabel revenue_shares ada, perlu automation |
| 7 | Laporan penyewaan | ✅ SUDAH ADA | Reports controller ada |
| 8 | Laporan pendapatan | ✅ SUDAH ADA | Reports controller ada |

---

## Fitur yang Perlu Diperbaiki/Ditambahkan

### 1. Rental Package System (Harian, Mingguan, Bulanan)

**Yang perlu dilakukan:**
- ✅ Migration sudah ada (daily_rate, weekly_rate, monthly_rate di motors table)
- ❌ Perlu update form motor untuk set harga per paket
- ❌ Perlu logic perhitungan diskon otomatis:
  - Harian: 1-6 hari (harga normal)
  - Mingguan: 7-29 hari (diskon 10%)
  - Bulanan: 30+ hari (diskon 20%)

### 2. Motor Verification System

**Yang perlu dilakukan:**
- ✅ Migration sudah ada (status: pending_verification, verified_at, verified_by)
- ❌ Perlu halaman admin untuk verifikasi motor
- ❌ Perlu button "Verifikasi" dan "Tolak"
- ❌ Perlu form catatan admin

### 3. Rental Confirmation System

**Yang perlu dilakukan:**
- ✅ Migration sudah ada (confirmed_at, confirmed_by)
- ❌ Perlu button konfirmasi sewa di admin
- ❌ Perlu update status dari paid → confirmed → active

### 4. Payment Management

**Yang perlu dilakukan:**
- ✅ Tabel payments sudah ada
- ❌ Perlu payment controller lengkap
- ❌ Perlu form upload bukti pembayaran
- ❌ Perlu konfirmasi pembayaran oleh admin

### 5. Revenue Sharing Automation

**Yang perlu dilakukan:**
- ✅ Tabel revenue_shares sudah ada
- ❌ Perlu automation setelah rental completed
- ❌ Bagi hasil 80% owner, 20% admin
- ❌ Perlu laporan bagi hasil per owner

---

## Rencana Implementasi

### Priority 1: Critical Features
1. Motor verification workflow
2. Rental package pricing system
3. Payment upload & confirmation
4. Rental confirmation workflow

### Priority 2: Important Features
5. Revenue sharing automation
6. Enhanced reporting

### Priority 3: Nice to Have
7. Email notifications
8. Dashboard improvements
9. Export to Excel/PDF
