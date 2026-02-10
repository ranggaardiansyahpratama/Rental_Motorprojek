@extends('layouts.admin')

@section('title', 'Manajemen Motor')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="page-title mb-0">Manajemen Data Motor</h1>
    <div class="flex space-x-2">
        <a href="{{ route('admin.motors.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-bold shadow transition">
            <i class="fas fa-plus mr-2"></i> Tambah Motor
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-container">
    <div class="stat-card blue">
        <div class="stat-info">
            <div class="stat-label">Total Motor</div>
            <div class="stat-value">{{ \App\Models\Motor::count() }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-motorcycle"></i></div>
    </div>

    <div class="stat-card yellow">
        <div class="stat-info">
            <div class="stat-label">Pending Verifikasi</div>
            <div class="stat-value">{{ $pendingCount }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
    </div>

    <div class="stat-card green">
        <div class="stat-info">
            <div class="stat-label">Tersedia</div>
            <div class="stat-value">{{ \App\Models\Motor::where('status', 'available')->count() }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
    </div>

    <div class="stat-card indigo">
        <div class="stat-info">
            <div class="stat-label">Disewa</div>
            <div class="stat-value">{{ \App\Models\Motor::where('status', 'rented')->count() }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-flag-checkered"></i></div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="card-table p-4 mb-6">
    <div class="flex space-x-6">
        <a href="{{ request()->fullUrlWithQuery(['status' => 'pending_verification']) }}" 
           class="px-2 py-2 text-xs font-bold uppercase transition-all {{ request('status') !== 'verified' && request('status') !== 'rejected' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-400 hover:text-gray-600' }}">
            Menunggu Verifikasi ({{ $pendingCount }})
        </a>
        <a href="{{ request()->fullUrlWithQuery(['status' => 'verified']) }}" 
           class="px-2 py-2 text-xs font-bold uppercase transition-all {{ request('status') === 'verified' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-400 hover:text-gray-600' }}">
            Terverifikasi
        </a>
        <a href="{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}" 
           class="px-2 py-2 text-xs font-bold uppercase transition-all {{ request('status') === 'rejected' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-400 hover:text-gray-600' }}">
            Ditolak
        </a>
    </div>
</div>

<!-- Motors Grid -->
@if($motors->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($motors as $motor)
        <div class="card-table">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-gray-800">{{ $motor->brand }} {{ $motor->type }}</h3>
                        <p class="text-[10px] text-gray-500 uppercase">{{ $motor->license_plate }} • {{ $motor->color }}</p>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $motor->status_badge }}">
                         {{ $motor->status }}
                    </span>
                </div>

                <div class="flex space-x-4 mb-4">
                    <img src="{{ $motor->photo ? asset('storage/' . $motor->photo) : 'https://via.placeholder.com/100?text=No+Photo' }}" class="w-20 h-20 object-cover rounded border">
                    <div class="flex-1 text-xs text-gray-600 space-y-1">
                        <div><span class="font-bold">Pemilik:</span> {{ $motor->owner->name }}</div>
                        <div><span class="font-bold">Tahun:</span> {{ $motor->year }}</div>
                        @if($motor->daily_rate)
                        <div class="text-blue-600 font-bold">Rp {{ number_format($motor->daily_rate, 0, ',', '.') }}/hari</div>
                        @endif
                    </div>
                </div>

                <div class="flex justify-end space-x-2 border-t pt-4">
                    <a href="{{ route('admin.motors.show', $motor) }}" class="text-xs text-blue-500 hover:underline">Detail</a>
                    <a href="{{ route('admin.motors.edit', $motor) }}" class="text-xs text-green-500 hover:underline">Edit</a>
                    <button onclick="deleteMotor({{ $motor->id }})" class="text-xs text-red-500 hover:underline">Hapus</button>
                </div>

                @if($motor->status === 'pending_verification')
                <div class="mt-4 bg-gray-50 p-4 rounded border">
                    <form method="POST" action="{{ route('admin.motors.verify', $motor) }}">
                        @csrf
                        <div class="grid grid-cols-1 gap-3">
                            <input type="number" name="daily_rate" placeholder="Harga Harian (Rp)" required class="text-xs p-2 border rounded">
                            <select name="action" required class="text-xs p-2 border rounded">
                                <option value="approve">Setujui</option>
                                <option value="reject">Tolak</option>
                            </select>
                            <button type="submit" class="bg-blue-600 text-white py-2 rounded text-xs font-bold">Simpan Verifikasi</button>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-6">
        {{ $motors->links() }}
    </div>
@else
    <div class="card-table p-12 text-center">
        <div class="text-gray-300 text-4xl mb-4"><i class="fas fa-motorcycle"></i></div>
        <div class="text-gray-500 font-bold">Tidak ada data motor ditemukan</div>
    </div>
@endif

<script>
function deleteMotor(id) {
    if(confirm('Hapus motor ini?')) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/motors/${id}`;
        form.innerHTML = `@csrf @method('DELETE')`;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection