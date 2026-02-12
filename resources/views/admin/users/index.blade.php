@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="page-title mb-0">Manajemen User</h1>
    <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-bold shadow transition">
        <i class="fas fa-user-plus mr-2"></i> Tambah User
    </a>
</div>

<!-- Stats Cards (Quick count) -->
<div class="stats-container">
    <div class="stat-card blue">
        <div class="stat-info">
            <div class="stat-label">Total Pengguna</div>
            <div class="stat-value">{{ $users->total() }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-users"></i></div>
    </div>
    <div class="stat-card purple">
        <div class="stat-info">
            <div class="stat-label">Admin</div>
            <div class="stat-value">{{ \App\Models\User::where('role', 'admin')->count() }}</div>
        </div>
        <div class="stat-icon" style="color: #a855f7;"><i class="fas fa-user-shield"></i></div>
    </div>
    <div class="stat-card indigo">
        <div class="stat-info">
            <div class="stat-label">Owner</div>
            <div class="stat-value">{{ \App\Models\User::where('role', 'owner')->count() }}</div>
        </div>
        <div class="stat-icon" style="color: #6366f1;"><i class="fas fa-store"></i></div>
    </div>
    <div class="stat-card green">
        <div class="stat-info">
            <div class="stat-label">Renter</div>
            <div class="stat-value">{{ \App\Models\User::where('role', 'renter')->count() }}</div>
        </div>
        <div class="stat-icon" style="color: #22c55e;"><i class="fas fa-user-tag"></i></div>
    </div>
</div>

<!-- User Table Section -->
<div class="card-table">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
        <div class="relative w-64 text-xs">
            <input type="text" placeholder="Cari nama atau email..." class="w-full pl-8 pr-4 py-2 border rounded focus:outline-none focus:border-blue-500">
            <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-white text-left">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">User</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Role</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kontak</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Bergabung</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 bg-white">
                @foreach($users as $user)
                <tr class="hover:bg-blue-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-xs uppercase">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-800">{{ $user->name }}</div>
                                <div class="text-[10px] text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                            @if($user->role === 'admin') bg-purple-100 text-purple-700
                            @elseif($user->role === 'owner') bg-blue-100 text-blue-700
                            @else bg-green-100 text-green-700 @endif">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-600">
                        @if($user->phone)
                            <div class="flex items-center"><i class="fas fa-phone mr-1 opacity-50"></i> {{ $user->phone }}</div>
                        @else
                            <span class="text-gray-300 italic">No phone</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-500">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="relative inline-block text-left">
                            <button onclick="toggleDropdown('dropdown-{{ $user->id }}', event)" class="p-2 text-gray-500 hover:text-blue-600 focus:outline-none rounded-full hover:bg-gray-100 transition">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="dropdown-{{ $user->id }}" class="hidden absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-lg z-50 border border-gray-100 overflow-hidden transform origin-top-right transition-all">
                                <div class="py-1">
                                    <a href="{{ route('admin.users.show', $user) }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                        <i class="fas fa-eye w-5"></i> Detail
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition">
                                        <i class="fas fa-edit w-5"></i> Edit
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <button onclick="deleteUser({{ $user->id }})" class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition text-left">
                                        <i class="fas fa-trash w-5"></i> Hapus
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-6 py-4">
        {{ $users->links() }}
    </div>
    @endif
</div>

<script>
function toggleDropdown(id, event) {
    event.stopPropagation();
    const dropdown = document.getElementById(id);
    const isHidden = dropdown.classList.contains('hidden');
    
    // Close all other dropdowns
    document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
        el.classList.add('hidden');
    });

    // Toggle current
    if (isHidden) {
        dropdown.classList.remove('hidden');
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.relative')) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
            el.classList.add('hidden');
        });
    }
});

function deleteUser(id) {
    if(confirm('Hapus pengguna ini?')) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${id}`;
        form.innerHTML = `@csrf @method('DELETE')`;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection