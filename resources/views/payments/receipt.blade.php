<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Struk Pembayaran - RentMotor</title>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
            .receipt-container { box-shadow: none !important; margin: 0 !important; }
        }
    </style>
</head>

<body class="bg-gray-100 p-4">
    <div class="max-w-md mx-auto">
        <!-- Navigation Buttons -->
        <div class="no-print mb-4 flex gap-2">
            <a href="{{ route('payments.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
            
            <button onclick="window.print()" 
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                <i class="fas fa-print mr-1"></i> Cetak Struk
            </button>
            
            <a href="{{ route('payments.create') }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm">
                <i class="fas fa-plus mr-1"></i> Pembayaran Baru
            </a>
        </div>

        <!-- Receipt Container -->
        <div class="receipt-container bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 text-white text-center py-4 px-6">
                <h1 class="text-xl font-bold">🏍️ RENTMOTOR</h1>
                <p class="text-blue-100 text-sm">Rental Motor Terpercaya</p>
            </div>

            <!-- Receipt Content -->
            <div class="p-6 space-y-4">
                <!-- Title -->
                <div class="text-center border-b-2 border-dashed pb-4">
                    <h2 class="text-lg font-bold text-gray-800">STRUK PEMBAYARAN</h2>
                    <p class="text-sm text-gray-600">{{ date('d F Y H:i:s', strtotime($payment->created_at)) }}</p>
                </div>

                <!-- Transaction Info -->
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">No. Struk:</span>
                        <span class="font-mono font-bold">{{ $payment->transaction_id ?: 'CASH-' . date('Ymd', strtotime($payment->created_at)) . '-' . str_pad($payment->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-semibold text-green-600">
                            @if($payment->status === 'confirmed')
                                ✅ TERBAYAR
                            @elseif($payment->status === 'pending')
                                ⏳ PENDING
                            @else
                                ❌ GAGAL
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Metode:</span>
                        <span class="font-semibold">💵 TUNAI</span>
                    </div>
                </div>

                <!-- Rental Details -->
                <div class="border-t border-dashed pt-4">
                    <h3 class="font-bold text-gray-800 mb-2">DETAIL PENYEWAAN</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Motor:</span>
                            <span class="font-semibold">{{ $payment->rental->motor->brand }} {{ $payment->rental->motor->type }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">No. Polisi:</span>
                            <span class="font-mono">{{ $payment->rental->motor->license_plate }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Penyewa:</span>
                            <span>{{ $payment->rental->renter->name }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Periode:</span>
                            <span>{{ date('d/m/Y', strtotime($payment->rental->start_date)) }} - {{ date('d/m/Y', strtotime($payment->rental->end_date)) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Durasi:</span>
                            <span>{{ \Carbon\Carbon::parse($payment->rental->start_date)->diffInDays(\Carbon\Carbon::parse($payment->rental->end_date)) + 1 }} hari</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Amount -->
                <div class="border-t border-dashed pt-4">
                    <div class="flex justify-between items-center text-lg">
                        <span class="font-bold text-gray-800">TOTAL BAYAR:</span>
                        <span class="font-bold text-blue-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Revenue Share -->
                @if($revenueShare)
                <div class="border-t border-dashed pt-4">
                    <h3 class="font-bold text-gray-800 mb-2 text-sm">BAGI HASIL</h3>
                    <div class="space-y-1 text-xs">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Pemilik Motor ({{ $revenueShare->owner_percentage }}%):</span>
                            <span>Rp {{ number_format($revenueShare->owner_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Platform ({{ $revenueShare->platform_percentage }}%):</span>
                            <span>Rp {{ number_format($revenueShare->platform_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Notes -->
                @if($payment->payment_notes)
                <div class="border-t border-dashed pt-4">
                    <h3 class="font-bold text-gray-800 mb-2 text-sm">CATATAN</h3>
                    <p class="text-xs text-gray-600">{{ $payment->payment_notes }}</p>
                </div>
                @endif

                <!-- Footer -->
                <div class="border-t border-dashed pt-4 text-center text-xs text-gray-500 space-y-1">
                    <p>Terima kasih telah menggunakan layanan kami</p>
                    <p>Simpan struk ini sebagai bukti pembayaran</p>
                    <p class="font-mono">ID Payment: #{{ $payment->id }}</p>
                </div>

                <!-- QR Code Area (placeholder) -->
                <div class="text-center pt-2">
                    <div class="inline-block border-2 border-dashed border-gray-300 p-4">
                        <div class="w-16 h-16 bg-gray-100 mx-auto flex items-center justify-center">
                            <i class="fas fa-qrcode text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">QR Verification</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Actions -->
        <div class="no-print mt-4 text-center">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center justify-center text-green-800 mb-2">
                    <i class="fas fa-check-circle text-green-600 mr-2"></i>
                    <span class="font-semibold">Pembayaran Berhasil Diproses!</span>
                </div>
                <p class="text-sm text-green-700">
                    Transaksi tunai telah berhasil dicatat dalam sistem.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Auto print after 2 seconds (optional)
        // setTimeout(() => {
        //     window.print();
        // }, 2000);
        
        // Print shortcut
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
    </script>
</body>
</html>