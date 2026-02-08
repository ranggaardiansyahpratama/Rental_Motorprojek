# Implementasi Perbaikan Sistem Penyewaan Motor

## 📋 Checklist Implementasi

Berdasarkan spesifikasi, berikut adalah checklist fitur yang perlu diperbaiki:

---

## ✅ FITUR YANG SUDAH ADA DAN BERFUNGSI

### 1. Sistem Registrasi & Login
- ✅ Renter dapat registrasi
- ✅ Owner dapat registrasi
- ✅ Admin login
- ✅ Role-based authentication

### 2. Fitur Penyewa (Renter)
- ✅ Cari motor berdasarkan merk (filter brand)
- ✅ Cari berdasarkan CC (filter 100cc, 125cc, 150cc) - ada di dashboard renter `<select id="cc-filter">`
- ✅ Form pemesanan motor (modal rental)
- ✅ Melihat status penyewaan (section "Penyewaan Terkini")
- ✅ Melihat histori sewa (section "Riwayat Penyewaan")

### 3. Fitur Pemilik (Owner)
- ✅ Dapat mendaftarkan lebih dari 1 motor
- ✅ Melihat status motor (tersedia, disewa, perawatan) - Dashboard owner section "Status Motor Overview"
- ✅ Melihat laporan bagi hasil - Dashboard owner section "Revenue Sharing"

### 4. Fitur Admin
- ✅ Route verify motor: `admin.motors.verify` (line 91 web.php)
- ✅ Method verify sudah ada di MotorController
- ✅ CRUD users
- ✅ CRUD motors
- ✅ CRUD rentals
- ✅ CRUD payments
- ✅ Laporan penyewaan
- ✅ Laporan pendapatan

---

## ⚠️ FITUR YANG PERLU DIPERBAIKI/DITAMBAHKAN

### 1. **Paket Sewa (Harian, Mingguan, Bulanan) dengan Diskon**

**Status:** Struktur database sudah ada, tapi logic belum lengkap

**Apa yang sudah ada:**
- ✅ Field `daily_rate`, `weekly_rate`, `monthly_rate` di tabel motors
- ✅ Dropdown paket di modal rental (daily, weekly, monthly)
- ✅ JavaScript `calculateRentalCost()` di renter dashboard

**Apa yang perlu diperbaiki:**
1. ❌ **Form Admin untuk Set Harga Paket**
   - Saat verifikasi motor, admin WAJIB set 3 harga (harian, mingguan, bulanan)
   - Sudah ada di method verify, tapi perlu UI form

2. ❌ **Logic Perhitungan Otomatis**
   ```
   Rental Controller perlu update:
   - Jika durasi 1-6 hari   → gunakan daily_rate
   - Jika durasi 7-29 hari  → gunakan weekly_rate (biasanya daily_rate × 7 × 0.9)
   - Jika durasi 30+ hari   → gunakan monthly_rate (biasanya daily_rate × 30 × 0.8)
   ```

3. ❌ **Validasi Paket**
   - Penyewa pilih "mingguan" tapi sewa cuma 3 hari → error atau auto-adjust
   - Penyewa pilih "bulanan" tapi sewa cuma 20 hari → error atau auto-adjust

**File yang perlu diedit:**
- `app/Http/Controllers/RentalController.php` - update method `store()`
- `resources/views/admin/motors/show.blade.php` - tambah form verifikasi dengan 3 input harga
- `resources/views/dashboards/renter.blade.php` - update JavaScript calculateRentalCost()

---

### 2. **UI Verifikasi Motor untuk Admin**

**Status:** Backend sudah ada, UI belum lengkap

**Apa yang sudah ada:**
- ✅ Route: POST `/admin/motors/{motor}/verify`
- ✅ Method: `MotorController@verify`
- ✅ Request Validation: `MotorVerificationRequest`
- ✅ Column di database: `verified_at`, `verified_by`, `admin_notes`

**Apa yang perlu ditambahkan:**
1. ❌ **Halaman Admin untuk List Motor Pending Verifikasi**
   - Buat view: `resources/views/admin/motors/index.blade.php`
   - Filter motor dengan status `pending_verification`
   - Button "Verifikasi" untuk setiap motor

2. ❌ **Modal/Halaman Form Verifikasi**
   - Input: Daily Rate (harian)
   - Input: Weekly Rate (mingguan)
   - Input: Monthly Rate (bulanan)
   - Textarea: Admin Notes
   - Button: "Setujui" (action=approve)
   - Button: "Tolak" (action=reject)

3. ❌ **Badge Status di List Motor**
   ```blade
   @if($motor->status == 'pending_verification')
       <span class="badge badge-warning">Menunggu Verifikasi</span>
   @elseif($motor->status == 'verified')
       <span class="badge badge-success">Terverifikasi</span>
   @elseif($motor->status == 'rejected')
       <span class="badge badge-danger">Ditolak</span>
   @endif
   ```

**File yang perlu diedit:**
- `resources/views/admin/motors/index.blade.php` - tambah modal verifikasi
- Atau buat halaman baru: `resources/views/admin/motors/verify.blade.php`

---

### 3. **Sistem Pembayaran Lengkap**

**Status:** Tabel sudah ada, controller belum lengkap

**Apa yang sudah ada:**
- ✅ Tabel `payments`
- ✅ Model `Payment`
- ✅ Route `admin.payments` resource

**Apa yang perlu ditambahkan:**
1. ❌ **Form Upload Bukti Bayar (Renter)**
   - Route: `renter.payments.upload`
   - Upload foto bukti transfer
   - Simpan di storage/payments/
   - Update payment.status = 'pending'
   - Update payment.proof_path

2. ❌ **Konfirmasi Pembayaran (Admin)**
   - Route: `admin.payments.confirm`
   - Button "Konfirmasi" di list payments
   - Update payment.status = 'paid'
   - Update rental.status = 'confirmed'

3. ❌ **Integrasi dengan Rental Flow**
   ```
   Flow yang benar:
   1. Renter buat rental → status: pending_payment
   2. Renter upload bukti bayar → payment.status: pending
   3. Admin konfirmasi payment → payment.status: paid, rental.status: confirmed
   4. Motor ready untuk dipakai → rental.status: active
   5. Setelah selesai → rental.status: completed
   ```

**File yang perlu diedit:**
- `app/Http/Controllers/PaymentController.php` - tambah method upload & confirm
- `resources/views/renter/payments/create.blade.php` - form upload
- `resources/views/admin/payments/index.blade.php` - button konfirmasi

---

### 4. **Konfirmasi Sewa oleh Admin**

**Status:** Field sudah ada di database, action belum ada

**Apa yang sudah ada:**
- ✅ Field `confirmed_at`, `confirmed_by` di tabel rentals

**Apa yang perlu ditambahkan:**
1. ❌ **Button Konfirmasi di Admin**
   - Di halaman `admin.rentals.index`
   - Button hanya muncul jika rental.status = 'paid'
   - Action: update status menjadi 'confirmed'

2. ❌ **Auto Update Status Motor**
   ```php
   Ketika rental dikonfirmasi:
   - Motor.status → 'rented'
   - Rental.status → 'confirmed'
   - Rental.confirmed_at → now()
   - Rental.confirmed_by → auth()->id()
   ```

**File yang perlu diedit:**
- `app/Http/Controllers/RentalController.php` - tambah method `confirm()`
- `routes/web.php` - tambah route: `POST /admin/rentals/{rental}/confirm`
- `resources/views/admin/rentals/index.blade.php` - tambah button

---

### 5. **Automation Bagi Hasil (Revenue Sharing)**

**Status:** Tabel sudah ada, automation belum ada

**Apa yang sudah ada:**
- ✅ Tabel `revenue_shares`
- ✅ Model `RevenueShare`
- ✅ Field: `owner_share`, `platform_commission`

**Apa yang perlu ditambahkan:**
1. ❌ **Trigger Otomatis Saat Rental Completed**
   ```php
   Event: rental.completed
   
   Action:
   - Hitung total_amount dari rental
   - Owner share = total_amount × 0.80 (80%)
   - Platform commission = total_amount × 0.20 (20%)
   - Create RevenueShare record
   - Status: 'pending'
   ```

2. ❌ **Admin Mark Revenue as Paid**
   - Button di halaman revenue_shares
   - Update status menjadi 'paid'
   - Update paid_at timestamp

3. ❌ **Laporan Bagi Hasil per Owner**
   - Owner bisa lihat revenue shares mereka
   - Filter by status (pending/paid)
   - Total pending vs total paid

**File yang perlu diedit:**
- `app/Http/Controllers/RentalController.php` - update method `complete()`
- `app/Http/Controllers/RevenueShareController.php` - buat baru
- `routes/web.php` - tambah route revenue_shares

---

## 🚀 PRIORITAS IMPLEMENTASI

### **Priority 1: Core Rental Flow** ⭐⭐⭐
1. Fix paket sewa dengan diskon otomatis
2. UI verifikasi motor
3. Form & konfirmasi pembayaran
4. Konfirmasi sewa oleh admin

### **Priority 2: Business Logic** ⭐⭐
5. Automation bagi hasil
6. Laporan lengkap per role

### **Priority 3: Enhancement** ⭐
7. Email notifications
8. Export Excel/PDF
9. Dashboard improvements

---

## 📝 KESIMPULAN

**Yang sudah bagus:**
- Database schema SUDAH LENGKAP ✅
- Routing SUDAH SESUAI ✅
- Controllers sudah ada method-method penting ✅
- View dashboard sudah modern dan responsif ✅

**Yang perlu dilengkapi:**
- **UI untuk verifikasi motor** - Backend sudah siap, tinggal buat form
- **Logic paket sewa & diskon** - Tinggal update RentalController
- **Upload & konfirmasi pembayaran** - Tinggal tambah 2 method
- **Auto bagi hasil** - Tinggal trigger saat rental completed

Sistem ini **HAMPIR SELESAI**, hanya perlu melengkapi UI dan beberapa logic business!
