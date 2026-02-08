# Analisis Alur Sistem Rental Motor

## ✅ ALUR SISTEM YANG SUDAH ADA

### **Step 1: Pemilik Mendaftarkan Motor** ✅ SUDAH ADA
**File:** `MotorController@store` (Line 84-136)

**Proses:**
- Pemilik mengisi form dengan data:
  - ✅ Merk (brand)
  - ✅ Jenis (type)
  - ✅ Nomor Polisi (license_plate)
  - ✅ Foto (photo) - max 5MB
  - ✅ Dokumen STNK/BPKB (documents) - max 10MB
  - ✅ Warna, Tahun, Kapasitas Mesin, Deskripsi
- Motor disimpan dengan status: `pending_verification`
- Menunggu admin untuk verifikasi

**Status:** ✅ **LENGKAP**

---

### **Step 2: Admin Verifikasi & Tentukan Harga Sewa** ✅ SUDAH ADA
**File:** `MotorController@verify` (Line 234-274)

**Proses:**
- Admin melihat motor dengan status `pending_verification`
- Admin bisa:
  - **Approve:** Set harga sewa (daily_rate, weekly_rate, monthly_rate)
  - **Reject:** Tolak motor dengan catatan
- Jika approved:
  - Status motor berubah menjadi `available`
  - Harga sewa tersimpan di database
  - Motor siap untuk disewakan

**Status:** ✅ **LENGKAP**

---

### **Step 3: Penyewa Pilih Motor → Pilih Durasi → Sistem Hitung Biaya** ✅ SUDAH ADA
**File:** `RentalController@store` (Line 53-103)

**Proses:**
- Penyewa browse motor dengan status `available`
- Penyewa pilih motor dan durasi (duration_days)
- Sistem otomatis hitung biaya berdasarkan paket:
  - **Harian (1-6 hari):** Harga normal
  - **Mingguan (7-29 hari):** Gunakan weekly_rate
  - **Bulanan (30+ hari):** Gunakan monthly_rate
- Sistem hitung security deposit (50% dari harga harian)
- Rental dibuat dengan status `pending_payment`
- Payment record otomatis dibuat

**Status:** ✅ **LENGKAP**

---

### **Step 4: Penyewa Bayar → Admin Konfirmasi → Motor Berstatus Disewa** ✅ SUDAH ADA
**File:** `PaymentController@update` (Line 77-111) & `PaymentController@confirm` (Line 113-153)

**Proses:**
1. **Penyewa Upload Bukti Bayar:**
   - Upload payment_proof (gambar)
   - Pilih payment_method (cash/transfer/e_wallet)
   - Payment status: `pending`
   - Rental status: `paid`

2. **Admin Konfirmasi Pembayaran:**
   - Admin review bukti pembayaran
   - Admin bisa:
     - **Confirm:** Payment status → `confirmed`, Rental status → `confirmed`
     - **Reject:** Payment status → `rejected`, Rental status → `pending_payment`
   - Jika confirmed:
     - Motor status berubah menjadi `rented`
     - Sistem otomatis create revenue share record
     - Jika start_date = hari ini, rental status → `active`

**Status:** ✅ **LENGKAP**

---

### **Step 5: Setelah Waktu Habis → Motor Dikembalikan → Admin Konfirmasi Pengembalian** ✅ SUDAH ADA
**File:** `RentalController@returnMotor` (Line 142-175)

**Proses:**
- Admin/Owner konfirmasi pengembalian motor
- Input:
  - return_notes (catatan kondisi motor)
  - penalty_amount (denda jika ada)
- Rental status berubah menjadi `completed`
- Motor status kembali menjadi `available`
- Sistem update revenue share dengan penalty (jika ada)

**Status:** ✅ **LENGKAP**

---

### **Step 6: Sistem Otomatis Catat Pendapatan → Laporan Bagi Hasil** ✅ SUDAH ADA
**File:** `PaymentController@createRevenueShare` (Line 302-317)

**Proses:**
- Sistem otomatis create revenue share saat payment confirmed
- Perhitungan bagi hasil:
  - Default: 80% Pemilik, 20% Platform
  - Custom: Admin bisa set persentase manual
- Data yang dicatat:
  - total_amount
  - owner_percentage
  - platform_percentage
  - owner_amount
  - platform_amount
  - status (pending/paid)
- Laporan tersedia untuk:
  - **Pemilik:** Lihat pendapatan mereka
  - **Admin:** Lihat semua bagi hasil

**Status:** ✅ **LENGKAP**

---

## 🔍 FITUR TAMBAHAN YANG SUDAH ADA

### 1. **Entri Transaksi Manual (Admin)** ✅
**File:** `PaymentController@store` (Line 174-224)
- Admin bisa input pembayaran cash langsung
- Bisa set custom owner percentage
- Generate transaction ID otomatis
- Bisa langsung print receipt

### 2. **Rental Cancellation** ✅
**File:** `RentalController@cancel` (Line 177-188)
- Penyewa bisa cancel sebelum payment confirmed
- Rental status → `cancelled`

### 3. **Export Data Motor** ✅
**File:** `MotorController@export` (Line 199-232)
- Admin bisa export data motor ke CSV
- Include semua informasi motor dan harga

### 4. **Payment Receipt** ✅
**File:** `PaymentController@receipt` (Line 347-360)
- Generate struk pembayaran
- Include revenue share information

### 5. **Mark Revenue as Paid** ✅
**File:** `PaymentController@markRevenuePaid` (Line 362-383)
- Admin tandai bagi hasil sudah dibayar ke owner
- Batch update multiple revenue shares

---

## ✅ KESIMPULAN

**SEMUA ALUR SISTEM YANG DIINGINKAN SUDAH LENGKAP!**

### Checklist Alur:
1. ✅ Pemilik mendaftarkan motor (Merk, Jenis, Nomor Polisi, Foto, Dokumen)
2. ✅ Admin verifikasi & tentukan harga sewa motor
3. ✅ Penyewa pilih motor → pilih durasi → sistem hitung biaya
4. ✅ Penyewa bayar → Admin konfirmasi → motor berstatus Disewa
5. ✅ Setelah waktu habis → motor dikembalikan → Admin konfirmasi pengembalian
6. ✅ Sistem otomatis catat pendapatan → laporan bagi hasil untuk Pemilik → laporan penyewaan untuk Admin

---

## 📊 STATUS DATABASE

### Tables yang Digunakan:
1. **motors** - Data motor dan harga
2. **rentals** - Data penyewaan
3. **payments** - Data pembayaran
4. **revenue_shares** - Data bagi hasil
5. **users** - Data pengguna (admin, owner, renter)

### Status Flow:
```
Motor: pending_verification → available → rented → available
Rental: pending_payment → paid → confirmed → active → completed
Payment: pending → confirmed/rejected
Revenue Share: pending → paid
```

---

## 🎯 TIDAK ADA YANG PERLU DITAMBAHKAN

Sistem sudah **LENGKAP** sesuai dengan alur yang diinginkan. Semua fitur sudah terimplementasi dengan baik:

- ✅ Registrasi motor oleh pemilik
- ✅ Verifikasi dan penetapan harga oleh admin
- ✅ Pemilihan motor dan perhitungan biaya otomatis
- ✅ Proses pembayaran dan konfirmasi
- ✅ Pengembalian motor dan konfirmasi
- ✅ Pencatatan pendapatan otomatis
- ✅ Laporan bagi hasil untuk pemilik
- ✅ Laporan penyewaan untuk admin

**Sistem siap digunakan!** 🚀
