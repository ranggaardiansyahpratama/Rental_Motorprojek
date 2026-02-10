<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Penyewa - RentMotor</title>
    
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7fa;
            color: #1a202c;
        }

        .glass-sidebar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(226, 232, 240, 0.8);
        }

        .sidebar-link {
            display: flex;
            items: center;
            padding: 0.875rem 1.25rem;
            margin: 0.25rem 0.5rem;
            border-radius: 12px;
            font-weight: 600;
            color: #718096;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-link i {
            width: 1.5rem;
            font-size: 1.1rem;
            margin-right: 0.75rem;
            text-align: center;
        }

        .sidebar-link:hover, .sidebar-link.active {
            color: #3182ce;
            background: #ebf8ff;
        }

        .sidebar-link.active {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .card-nexus {
            background: white;
            border-radius: 24px;
            border: 1px solid #edf2f7;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-nexus:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.06);
        }

        .motor-image-container {
            height: 180px;
            position: relative;
            overflow: hidden;
            border-top-left-radius: 24px;
            border-top-right-radius: 24px;
        }

        .motor-price-badge {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(49, 130, 206, 0.9);
            color: white;
            padding: 4px 12px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 0.75rem;
            backdrop-filter: blur(4px);
        }

        .btn-action-primary {
            background: linear-gradient(135deg, #3182ce 0%, #2c5282 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.875rem;
            box-shadow: 0 4px 14px 0 rgba(49, 130, 206, 0.3);
            transition: all 0.3s ease;
        }

        .btn-action-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(49, 130, 206, 0.4);
        }

        .status-pill {
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f7fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #a0aec0; }

        .dashboard-main {
            margin-left: 280px;
        }

        @media (max-width: 1024px) {
            .dashboard-main { margin-left: 0; }
            .sidebar-nav { display: none; }
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Desktop Sidebar -->
    <aside class="sidebar-nav fixed top-0 left-0 h-screen w-[280px] glass-sidebar z-50 flex flex-col p-6">
        <div class="flex items-center space-x-3 mb-12 px-4">
            <div class="bg-blue-600 p-2 rounded-xl text-white shadow-lg">
                <i class="fas fa-motorcycle text-xl"></i>
            </div>
            <span class="text-xl font-extrabold tracking-tighter">RENTMOTOR</span>
        </div>

        <div class="flex-1 space-y-2">
            <button onclick="switchTab('overview')" class="sidebar-link active w-full text-left" id="tab-overview">
                <i class="fas fa-th-large"></i> Ringkasan
            </button>
            <button onclick="switchTab('browse')" class="sidebar-link w-full text-left" id="tab-browse">
                <i class="fas fa-search"></i> Cari Motor (Pesan)
            </button>
            <button onclick="switchTab('rentals')" class="sidebar-link w-full text-left" id="tab-rentals">
                <i class="fas fa-clock"></i> Penyewaan Aktif
            </button>
            <button onclick="switchTab('history')" class="sidebar-link w-full text-left" id="tab-history">
                <i class="fas fa-history"></i> Riwayat & Laporan
            </button>
            <button onclick="switchTab('payments')" class="sidebar-link w-full text-left" id="tab-payments">
                <i class="fas fa-credit-card"></i> Pembayaran
            </button>
        </div>

        <div class="pt-8 border-t border-gray-100 mt-auto">
            <div class="bg-white rounded-2xl p-4 border border-gray-50 shadow-sm flex items-center mb-6">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mr-3 font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-gray-400 font-bold uppercase">Penyewa</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('profile.edit') }}" class="text-[10px] font-bold text-gray-500 hover:text-blue-600 text-center py-2 bg-gray-50 rounded-lg transition">PROFIL</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-[10px] font-bold text-red-500 hover:text-red-700 text-center py-2 bg-red-50 rounded-lg transition">LOGOUT</button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Mobile Header -->
    <header class="lg:hidden bg-white border-b border-gray-100 p-4 sticky top-0 z-[60] flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <i class="fas fa-motorcycle text-blue-600 text-lg"></i>
            <span class="font-extrabold text-lg">RENTMOTOR</span>
        </div>
        <button class="text-gray-500"><i class="fas fa-bars"></i></button>
    </header>

    <main class="dashboard-main min-h-screen p-6 lg:p-10">
        
        <!-- SECTION: OVERVIEW -->
        <section id="section-overview" class="tab-content transition-all duration-500">
            <div class="mb-10 flex flex-col md:flex-row justify-between md:items-end gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Halo, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h1>
                    <p class="text-gray-500 font-medium">Selamat datang di pusat kendali penyewaan Anda.</p>
                </div>
                <button onclick="switchTab('browse')" class="btn-action-primary">
                    <i class="fas fa-plus mr-2"></i> Buat Penyewaan Baru
                </button>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="card-nexus p-6 border-l-4 border-blue-500">
                    <p class="text-[10px] font-black font-bold text-gray-400 uppercase tracking-widest mb-1">Total Sewa</p>
                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-black">{{ $totalRentals }}</span>
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center"><i class="fas fa-motorcycle"></i></div>
                    </div>
                </div>
                <div class="card-nexus p-6 border-l-4 border-green-500">
                    <p class="text-[10px] font-black font-bold text-gray-400 uppercase tracking-widest mb-1">Sewa Aktif</p>
                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-black text-green-600">{{ $activeRentals }}</span>
                        <div class="w-10 h-10 bg-green-50 text-green-600 rounded-lg flex items-center justify-center"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
                <div class="card-nexus p-6 border-l-4 border-yellow-500">
                    <p class="text-[10px] font-black font-bold text-gray-400 uppercase tracking-widest mb-1">Butuh Bayar</p>
                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-black text-yellow-600">{{ $pendingPayments }}</span>
                        <div class="w-10 h-10 bg-yellow-50 text-yellow-600 rounded-lg flex items-center justify-center"><i class="fas fa-file-invoice-dollar"></i></div>
                    </div>
                </div>
                <div class="card-nexus p-6 border-l-4 border-indigo-500">
                    <p class="text-[10px] font-black font-bold text-gray-400 uppercase tracking-widest mb-1">Total Pengeluaran</p>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-black">Rp {{ number_format($totalSpent/1000, 0) }}k</span>
                        <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center"><i class="fas fa-wallet"></i></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Recent Activity -->
                <div class="lg:col-span-2">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Aktifitas Terkini</h2>
                        <button onclick="switchTab('history')" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua</button>
                    </div>
                    <div class="space-y-4">
                        @forelse($myRentals->take(3) as $r)
                        <div class="card-nexus p-5 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-400 mr-4">
                                    <i class="fas fa-motorcycle text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $r->motor->brand }} {{ $r->motor->type }}</h4>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $r->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="status-pill {{ $r->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $r->status }}
                            </span>
                        </div>
                        @empty
                        <div class="card-nexus p-10 text-center text-gray-400">Belum ada aktifitas penyewaan.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Tips / Card -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Panduan Aman</h2>
                    <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-3xl p-8 text-white relative overflow-hidden shadow-xl">
                        <div class="relative z-10">
                            <i class="fas fa-shield-alt text-4xl mb-4 opacity-30"></i>
                            <h3 class="text-lg font-bold mb-2 leading-tight">Selalu Gunakan Helm & Patuhi Aturan Lalu Lintas</h3>
                            <p class="text-xs text-blue-100 mb-6">Pastikan unit motor dalam kondisi baik sebelum membawa berkendara jauh.</p>
                            <a href="#" class="text-[10px] font-bold uppercase tracking-widest bg-white text-blue-800 px-4 py-2 rounded-full inline-block">Pelajari Lanjut</a>
                        </div>
                        <i class="fas fa-motorcycle absolute -bottom-4 -right-4 text-7xl opacity-10 transform -rotate-12"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION: BROWSE MOTORS -->
        <section id="section-browse" class="tab-content hidden">
            <div class="mb-10">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Cari Motor</h2>
                <p class="text-gray-500 font-medium">Temukan unit yang sesuai dengan kebutuhan perjalanan Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($availableMotors as $motor)
                <div class="card-nexus group overflow-hidden">
                    <div class="motor-image-container bg-gray-100">
                        @if($motor->photo)
                            <img src="{{ asset('storage/' . $motor->photo) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300"><i class="fas fa-motorcycle text-4xl"></i></div>
                        @endif
                        <div class="motor-price-badge">Rp {{ number_format($motor->rental_price/1000, 0) }}k/hari</div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-1">{{ $motor->brand }} {{ $motor->type }}</h4>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-6">{{ $motor->year }} • {{ $motor->color }}</p>
                        <button onclick="openBooking('{{ $motor->id }}', '{{ $motor->brand }} {{ $motor->type }}', {{ $motor->rental_price }})" class="w-full btn-action-primary text-xs tracking-widest uppercase">
                            PESAN SEKARANG
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- SECTION: RENTALS (ACTIVE) -->
        <section id="section-rentals" class="tab-content hidden">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-10">Penyewaan Aktif</h2>
            <div class="space-y-6">
                @forelse($myRentals->where('status', 'active') as $r)
                <div class="card-minimal p-8 flex flex-col lg:flex-row justify-between lg:items-center gap-8 border-l-8 border-green-500">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-3xl">
                            <i class="fas fa-motorcycle"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900">{{ $r->motor->brand }} {{ $r->motor->type }}</h3>
                            <div class="flex items-center text-sm font-bold text-gray-500 mt-1">
                                <span class="bg-gray-100 px-3 py-1 rounded-lg mr-3">{{ strtoupper($r->motor->license_plate) }}</span>
                                <i class="fas fa-calendar-alt mr-2"></i> {{ $r->start_date->format('d M') }} - {{ $r->end_date->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="flex lg:flex-col items-end gap-3">
                        <p class="text-[10px] font-black font-bold text-gray-400 uppercase tracking-widest">Sisa Waktu</p>
                        <span class="text-xl font-bold text-blue-600">{{ $r->end_date->diffInDays(now()) }} Hari Lagi</span>
                        <a href="{{ route('renter.rentals.show', $r) }}" class="text-sm font-bold text-gray-900 hover:text-blue-600 transition">Detail Kontrak <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                @empty
                <div class="card-nexus p-20 text-center text-gray-400 italic">Tidak ada penyewaan motor yang aktif saat ini.</div>
                @endforelse
            </div>
        </section>

        <!-- SECTION: HISTORY -->
        <section id="section-history" class="tab-content hidden">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Riwayat & Laporan</h2>
                    <p class="text-gray-500 font-medium tracking-tight">Cetak bukti transaksi dan pantau riwayat sewa Anda.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('renter.reports.history') }}" class="px-5 py-3 bg-white border border-gray-200 rounded-xl font-bold text-sm text-gray-700 hover:bg-gray-50 transition shadow-sm">
                        <i class="fas fa-file-pdf mr-2 text-red-500"></i> Generate Riwayat (PDF)
                    </a>
                </div>
            </div>

            <div class="card-nexus overflow-hidden">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Unit Motor</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Periode</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Biaya</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($myRentals as $r)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="px-8 py-6">
                                <div class="font-bold text-gray-900">{{ $r->motor->brand }} {{ $r->motor->type }}</div>
                                <div class="text-[10px] font-bold text-gray-400">{{ strtoupper($r->motor->license_plate) }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-xs font-bold text-gray-700">{{ $r->start_date->format('d/m/y') }} - {{ $r->end_date->format('d/m/y') }}</div>
                                <div class="text-[10px] text-gray-400 font-bold uppercase">{{ $r->duration_days }} HARI</div>
                            </td>
                            <td class="px-8 py-6 font-bold text-gray-900">Rp {{ number_format($r->total_amount, 0, ',', '.') }}</td>
                            <td class="px-8 py-6">
                                <span class="status-pill {{ $r->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ str_replace('_', ' ', $r->status) }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <a href="{{ route('renter.rentals.show', $r) }}" class="text-blue-600 hover:text-blue-800"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION: PAYMENTS -->
        <section id="section-payments" class="tab-content hidden">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-10">Pembayaran</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @forelse($myRentals->where('status', 'pending_payment') as $p)
                <div class="card-nexus p-8 bg-blue-50 border-blue-100 flex flex-col sm:flex-row justify-between items-center gap-6">
                    <div class="flex items-center text-left w-full">
                        <div class="w-16 h-16 bg-white rounded-3xl flex items-center justify-center text-blue-600 text-2xl mr-6 shadow-sm">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-black text-gray-900">{{ $p->motor->brand }} {{ $p->motor->type }}</h4>
                            <div class="text-sm font-bold text-blue-600 mt-1">TOTAL: Rp {{ number_format($p->total_amount, 0, ',', '.') }}</div>
                            <p class="text-[10px] text-gray-400 font-bold mt-2 uppercase">Klik bayar sekarang untuk konfirmasi</p>
                        </div>
                    </div>
                    <a href="{{ route('renter.payments.create', ['rental_id' => $p->id]) }}" class="whitespace-nowrap btn-action-primary text-xs tracking-widest uppercase">
                        BAYAR SEKARANG
                    </a>
                </div>
                @empty
                <div class="col-span-full card-nexus p-20 text-center text-gray-400 bg-white">
                    <div class="w-16 h-16 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-check-double text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Tagihan Lunas</h3>
                    <p class="font-medium">Tidak ada pembayaran yang tertunda saat ini.</p>
                </div>
                @endforelse
            </div>
        </section>

    </main>

    <!-- Booking Modal -->
    <div id="modal-booking" class="fixed inset-0 bg-gray-900/60 backdrop-filter blur-sm hidden flex items-center justify-center z-[100] px-4">
        <div class="bg-white w-full max-w-lg rounded-[32px] p-10 relative shadow-2xl overflow-y-auto max-h-[90vh]">
            <button onclick="closeBooking()" class="absolute top-8 right-8 text-gray-400 hover:text-gray-900 transition"><i class="fas fa-times text-xl"></i></button>
            <div class="mb-8">
                <h3 class="text-2xl font-black text-gray-900 mb-1">Formulir Penyewaan</h3>
                <p class="text-xs font-bold text-blue-600 uppercase tracking-widest" id="modal-motor-title">NAMA MOTOR</p>
            </div>
            
            <form id="form-rental" action="" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Mulai Sewa</label>
                        <input type="date" name="start_date" id="start_date" required onchange="calculate()" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3.5 text-sm font-bold text-gray-700 outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Selesai Sewa</label>
                        <input type="date" name="end_date" id="end_date" required onchange="calculate()" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3.5 text-sm font-bold text-gray-700 outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-gray-400 uppercase">Subtotal</span>
                        <span class="text-sm font-black text-gray-900" id="calc-subtotal">-</span>
                    </div>
                    <div class="pt-3 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-sm font-black text-gray-900 uppercase">Estimasi Total</span>
                        <span class="text-xl font-extrabold text-blue-600" id="calc-total">Rp 0</span>
                    </div>
                </div>

                <button type="submit" class="w-full btn-action-primary uppercase tracking-widest py-5 font-black">
                    KONFIRMASI BOOKING SEKARANG
                </button>
            </form>
        </div>
    </div>

    <script>
        let currentDailyPrice = 0;

        function switchTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            // Remove active classes from all sidebar links
            document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));

            // Show selected tab content
            document.getElementById('section-' + tabId).classList.remove('hidden');
            // Add active class to selected sidebar link
            document.getElementById('tab-' + tabId).classList.add('active');
        }

        function openBooking(id, title, price) {
            currentDailyPrice = price;
            document.getElementById('modal-motor-title').innerText = title;
            document.getElementById('form-rental').action = `/renter/motors/${id}/rent`;
            document.getElementById('modal-booking').classList.remove('hidden');
            
            // Set default dates
            const today = new Date().toISOString().split('T')[0];
            const tomorrow = new Date(new Date().getTime() + 86400000).toISOString().split('T')[0];
            document.getElementById('start_date').value = today;
            document.getElementById('start_date').min = today;
            document.getElementById('end_date').value = tomorrow;
            document.getElementById('end_date').min = tomorrow;
            calculate();
        }

        function closeBooking() {
            document.getElementById('modal-booking').classList.add('hidden');
        }

        function calculate() {
            const start = new Date(document.getElementById('start_date').value);
            const end = new Date(document.getElementById('end_date').value);
            
            if(start && end && end > start) {
                const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                const total = days * currentDailyPrice;
                document.getElementById('calc-subtotal').innerText = days + ' Hari';
                document.getElementById('calc-total').innerText = 'Rp ' + total.toLocaleString();
            } else {
                document.getElementById('calc-total').innerText = 'Rp 0';
            }
        }

        // Close modal on outside click
        window.onclick = function(event) {
            const modal = document.getElementById('modal-booking');
            if (event.target == modal) closeBooking();
        }
    </script>
</body>
</html>
