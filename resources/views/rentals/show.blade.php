@extends('layouts.app')

@section('title', 'Detail Penyewaan - RentMotor')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Penyewaan</h1>
            <p class="text-gray-600">ID Pesanan: #{{ $rental->id }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="px-4 py-2 rounded-full text-sm font-bold {{ $rental->status_badge }}">
                {{ ucfirst(str_replace('_', ' ', $rental->status)) }}
            </span>
            <a href="{{ route(auth()->user()->role . '.rentals.index') }}" class="text-gray-500 hover:text-gray-700 bg-white border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm" role="alert">
            <div class="flex">
                <i class="fas fa-check-circle mt-1 mr-3"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Motor Details -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-motorcycle text-green-600 mr-2"></i> Informasi Motor
                    </h2>
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="md:w-1/3">
                            <img src="{{ asset('storage/' . $rental->motor->photo) }}" alt="Motor" class="w-full h-40 object-cover rounded-lg border shadow-sm">
                        </div>
                        <div class="md:w-2/3 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Merk & Tipe</p>
                                <p class="font-bold text-gray-900">{{ $rental->motor->brand }} {{ $rental->motor->type }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Nomor Polisi</p>
                                <p class="font-bold text-gray-900">{{ $rental->motor->license_plate }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Warna</p>
                                <p class="font-bold text-gray-900">{{ $rental->motor->color }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tahun</p>
                                <p class="font-bold text-gray-900">{{ $rental->motor->year }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">Pemilik</p>
                                <p class="font-bold text-gray-900">{{ $rental->motor->owner->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rental Period & Price -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-calendar-alt text-blue-600 mr-2"></i> Detail Penyewaan
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                        <p class="text-xs text-blue-600 font-semibold uppercase tracking-wider mb-1">Tanggal Mulai</p>
                        <p class="text-lg font-bold text-gray-900">{{ $rental->start_date->format('d M Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $rental->start_date->isoFormat('dddd') }}</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                        <p class="text-xs text-blue-600 font-semibold uppercase tracking-wider mb-1">Tanggal Selesai</p>
                        <p class="text-lg font-bold text-gray-900">{{ $rental->end_date->format('d M Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $rental->end_date->isoFormat('dddd') }}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-xl border border-green-100">
                        <p class="text-xs text-green-600 font-semibold uppercase tracking-wider mb-1">Durasi</p>
                        <p class="text-lg font-bold text-gray-900">{{ $rental->duration_days }} Hari</p>
                        <p class="text-xs text-gray-500">Total penyewaan</p>
                    </div>
                </div>

                <div class="mt-8 border-t border-gray-100 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Rincian Biaya</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-600">
                            <span>Harga Sewa ({{ $rental->duration_days }} hari x Rp {{ number_format($rental->daily_price, 0, ',', '.') }})</span>
                            <span class="font-medium">Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Jaminan Keamanan (Security Deposit)</span>
                            <span class="font-medium">Rp {{ number_format($rental->security_deposit, 0, ',', '.') }}</span>
                        </div>
                        @if($rental->penalty_amount > 0)
                        <div class="flex justify-between text-red-600">
                            <span>Denda Kerusakan/Keterlambatan</span>
                            <span class="font-medium">Rp {{ number_format($rental->penalty_amount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-xl font-bold text-gray-900 pt-3 border-t">
                            <span>Total Pembayaran</span>
                            <span class="text-green-600">Rp {{ number_format($rental->total_amount + $rental->security_deposit + $rental->penalty_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Evidence (Step 4: Penyewa bayar) -->
            @if($rental->payments->count() > 0)
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-receipt text-yellow-600 mr-2"></i> Bukti Pembayaran
                    </h2>
                    @foreach($rental->payments as $payment)
                        <div class="flex flex-col md:flex-row gap-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <div class="md:w-1/3">
                                @if($payment->proof_of_payment)
                                    <a href="{{ asset('storage/' . $payment->proof_of_payment) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $payment->proof_of_payment) }}" alt="Bukti Bayar" class="w-full h-48 object-cover rounded-lg border hover:opacity-75 transition">
                                    </a>
                                @else
                                    <div class="w-full h-48 bg-gray-200 rounded-lg flex flex-col items-center justify-center text-gray-500">
                                        <i class="fas fa-image text-3xl mb-2"></i>
                                        <p class="text-xs">Belum upload bukti</p>
                                        @if(auth()->id() === $rental->renter_id && $rental->status === 'pending_payment')
                                            <a href="{{ route('renter.payments.edit', $payment) }}" class="mt-2 text-blue-600 font-semibold text-xs underline">Upload Sekarang</a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="md:w-2/3 space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-semibold text-gray-500">STATUS PEMBAYARAN:</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold 
                                        {{ $payment->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ strtoupper($payment->status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-700"><strong>Metode:</strong> {{ ucfirst($payment->payment_method) }}</p>
                                <p class="text-sm text-gray-700"><strong>Jumlah:</strong> Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-700"><strong>Tanggal:</strong> {{ $payment->created_at->format('d M Y H:i') }}</p>
                                
                                @if($payment->status === 'pending' && auth()->user()->isAdmin())
                                    <div class="pt-4 flex gap-2">
                                        <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="action" value="confirm">
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                                                Konfirmasi Pembayaran
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <!-- Renter Info -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user text-green-600 mr-2"></i> Data Penyewa
                </h3>
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold text-lg">
                        {{ substr($rental->renter->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 capitalize">{{ $rental->renter->name }}</p>
                        <p class="text-xs text-gray-500">{{ $rental->renter->email }}</p>
                    </div>
                </div>
                <div class="text-sm space-y-2 text-gray-600">
                    <p><i class="fas fa-phone mr-2"></i> {{ $rental->renter->phone_number ?? '-' }}</p>
                    <p><i class="fas fa-map-marker-alt mr-2"></i> {{ $rental->renter->address ?? '-' }}</p>
                </div>
            </div>

            <!-- Admin Actions (Step 4 & 5) -->
            @if(auth()->user()->isAdmin())
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl shadow-lg p-6 text-white">
                    <h3 class="text-lg font-bold mb-4 flex items-center">
                        <i class="fas fa-tools mr-2"></i> Admin Panel
                    </h3>
                    
                    <div class="space-y-4">
                        @if($rental->status === 'pending_payment')
                            <div class="p-3 bg-white/10 rounded-lg border border-white/20 text-xs">
                                <p class="font-semibold text-yellow-400 mb-1">Menunggu Pembayaran</p>
                                <p>Silakan konfirmasi pembayaran jika penyewa sudah mengupload bukti bayar.</p>
                            </div>
                        @endif

                        @if($rental->status === 'paid')
                            <form action="{{ route('admin.rentals.update', $rental) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="confirm">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 py-3 rounded-lg font-bold transition flex items-center justify-center">
                                    <i class="fas fa-motorcycle mr-2"></i> Konfirmasi & Serahkan Motor
                                </button>
                            </form>
                        @endif

                        @if($rental->status === 'active')
                            <div class="p-4 bg-green-900/40 rounded-lg border border-green-500/50 mb-4">
                                <p class="text-xs font-semibold text-green-400 mb-1">Masa Sewa Sedang Berjalan</p>
                                <p class="text-sm">Motor telah diserahterimakan kepada penyewa.</p>
                            </div>
                            
                            <!-- Return Motor Form (Step 5: Admin konfirmasi pengembalian) -->
                            <h4 class="text-sm font-bold mb-2">Konfirmasi Pengembalian</h4>
                            <form action="{{ route('admin.rentals.complete', $rental) }}" method="POST" class="space-y-3">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">Denda (Jika ada)</label>
                                    <input type="number" name="penalty_amount" value="0" class="w-full bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-sm text-white focus:ring-2 focus:ring-green-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">Catatan Kondisi</label>
                                    <textarea name="return_notes" rows="2" class="w-full bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-sm text-white focus:ring-2 focus:ring-green-500 outline-none" placeholder="Contoh: Motor kembali dalam kondisi baik..."></textarea>
                                </div>
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 py-3 rounded-lg font-bold transition flex items-center justify-center" onclick="return confirm('Apakah Anda yakin ingin mengkonfirmasi pengembalian motor?')">
                                    <i class="fas fa-check-circle mr-2"></i> Motor Sudah Kembali
                                </button>
                            </form>
                        @endif

                        @if($rental->status === 'completed')
                            <div class="bg-green-100 text-green-800 p-4 rounded-xl flex items-center shadow-lg">
                                <i class="fas fa-check-circle text-2xl mr-3"></i>
                                <div>
                                    <p class="font-extrabold">SELESAI</p>
                                    <p class="text-xs">Motor sudah dikembalikan.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Renter Actions -->
            @if(auth()->id() === $rental->renter_id && $rental->status === 'pending_payment')
                <div class="bg-blue-600 rounded-xl shadow-lg p-6 text-white">
                    <h3 class="text-lg font-bold mb-4">Instruksi Pembayaran</h3>
                    <p class="text-sm mb-4">Silakan transfer sebesar <strong>Rp {{ number_format($rental->total_amount + $rental->security_deposit, 0, ',', '.') }}</strong> ke rekening berikut:</p>
                    <div class="bg-white/20 p-3 rounded-lg mb-4 text-sm">
                        <p><strong>Bank:</strong> BCA</p>
                        <p><strong>No Rek:</strong> 1234567890</p>
                        <p><strong>Atas Nama:</strong> RentMotor Utama</p>
                    </div>
                    <p class="text-xs italic">* Unggah bukti transfer di halaman "Pembayaran Saya" atau detail transaksi ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
