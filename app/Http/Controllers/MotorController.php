<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Http\Requests\MotorVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MotorController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        
        if ($user->isOwner()) {
            $motors = Motor::where('owner_id', $user->id)->latest()->paginate(10);
            return view('motors.owner', compact('motors'));
        } elseif ($user->isAdmin()) {
            // Admin melihat motor berdasarkan status untuk verifikasi
            $status = request('status', 'pending_verification');
            
            $motors = Motor::with('owner')
                ->when($status === 'pending_verification', function($q) {
                    return $q->where('status', 'pending_verification');
                })
                ->when($status === 'verified', function($q) {
                    return $q->where('status', 'available');
                })
                ->when($status === 'rejected', function($q) {
                    return $q->where('status', 'rejected');
                })
                ->latest()
                ->paginate(10);
                
            $pendingCount = Motor::where('status', 'pending_verification')->count();
            
            return view('motors.index', compact('motors', 'pendingCount'));
        } else {
            // Penyewa melihat motor tersedia untuk disewa (Step 3: Pilih motor & durasi)
            $motors = Motor::where('status', 'available')
                ->with('owner')
                ->when(request('brand'), function($q) {
                    return $q->where('brand', request('brand'));
                })
                ->when(request('engine_capacity'), function($q) {
                    return $q->where('engine_capacity', request('engine_capacity'));
                })
                ->when(request('year'), function($q) {
                    return $q->where('year', request('year'));
                })
                ->when(request('price_range'), function($q) {
                    $range = explode('-', request('price_range'));
                    if (count($range) === 2) {
                        return $q->whereBetween('rental_price', [(int)$range[0], (int)$range[1]]);
                    }
                })
                ->latest()
                ->paginate(12);
            return view('motors.browse', compact('motors'));
        }
    }

    public function show(Motor $motor)
    {
        $motor->load('owner', 'rentals.renter');
        
        // Check if user can view this motor
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isRenter() && $motor->owner_id !== $user->id) {
            abort(403);
        }

        return view('motors.show', compact('motor'));
    }

    public function create()
    {
        $this->authorize('create', Motor::class);
        return view('motors.create');
    }

    public function store(Request $request)
    {
        // Pastikan hanya owner yang bisa mendaftarkan motor
        if (!auth()->user()->isOwner()) {
            abort(403, 'Hanya pemilik yang dapat mendaftarkan motor');
        }
        
        $validated = $request->validate([
            'brand' => 'required|string|max:100',
            'type' => 'required|string|max:100', 
            'license_plate' => 'required|string|max:20|unique:motors,license_plate',
            'color' => 'required|string|max:50',
            'year' => 'required|integer|min:2010|max:' . date('Y'),
            'engine_capacity' => 'required|integer|min:50|max:1000',
            'description' => 'nullable|string|max:1000',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:5120', // 5MB
            'documents' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // 10MB
        ], [
            'brand.required' => 'Merk motor wajib diisi',
            'type.required' => 'Jenis motor wajib diisi',
            'license_plate.required' => 'Nomor polisi wajib diisi',
            'license_plate.unique' => 'Nomor polisi sudah terdaftar dalam sistem',
            'color.required' => 'Warna motor wajib diisi',
            'year.required' => 'Tahun pembuatan wajib diisi',
            'engine_capacity.required' => 'Kapasitas mesin wajib diisi',
            'photo.required' => 'Foto motor wajib diupload',
            'photo.image' => 'File foto harus berupa gambar',
            'photo.max' => 'Ukuran foto maksimal 5MB',
            'documents.required' => 'Dokumen STNK/BPKB wajib diupload',
            'documents.max' => 'Ukuran dokumen maksimal 10MB',
        ]);

        // Step 1: Pemilik mendaftarkan motor dengan semua data
        
        // Upload photo motor
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('motors/photos', 'public');
        }

        // Upload dokumen motor (STNK/BPKB)
        if ($request->hasFile('documents')) {
            $validated['documents'] = $request->file('documents')->store('motors/documents', 'public');
        }

        // Set data tambahan
        $validated['owner_id'] = auth()->id();
        $validated['status'] = 'pending_verification'; // Menunggu verifikasi admin
        
        $motor = Motor::create($validated);

        return redirect()->route('owner.dashboard')
            ->with('success', 'Motor berhasil didaftarkan! Menunggu verifikasi admin untuk menentukan harga sewa.');
    }

    public function edit(Motor $motor)
    {
        $this->authorize('update', $motor);
        return view('motors.edit', compact('motor'));
    }

    public function update(Request $request, Motor $motor)
    {
        $this->authorize('update', $motor);
        
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'license_plate' => 'required|string|unique:motors,license_plate,' . $motor->id,
            'color' => 'required|string|max:255',
            'year' => 'required|integer|min:1990|max:' . date('Y'),
            'engine_capacity' => 'nullable|integer|min:50|max:1000',
            'description' => 'nullable|string',
            'status' => 'nullable|in:available,maintenance,rented',
            'daily_rate' => 'nullable|numeric|min:0',
            'weekly_rate' => 'nullable|numeric|min:0',
            'monthly_rate' => 'nullable|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Only admin can change status and pricing
        if (!auth()->user()->isAdmin()) {
            unset($validated['status'], $validated['daily_rate'], $validated['weekly_rate'], $validated['monthly_rate']);
        }

        // Upload new photo if provided
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($motor->photo) {
                Storage::disk('public')->delete($motor->photo);
            }
            $validated['photo'] = $request->file('photo')->store('motors/photos', 'public');
        }

        // Upload new documents if provided
        if ($request->hasFile('documents')) {
            // Delete old documents
            if ($motor->documents) {
                foreach ($motor->documents as $document) {
                    Storage::disk('public')->delete($document);
                }
            }
            $documents = [];
            foreach ($request->file('documents') as $file) {
                $documents[] = $file->store('motors/documents', 'public');
            }
            $validated['documents'] = $documents;
        }

        $motor->update($validated);

        return redirect()->route(auth()->user()->role . '.motors.show', $motor)
            ->with('success', 'Motor berhasil diperbarui.');
    }

    public function export()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $motors = Motor::with('owner')->get();
        
        $csvData = "ID,Pemilik,Merk,Tipe,Plat Nomor,Warna,Tahun,Status,Harga Harian,Harga Mingguan,Harga Bulanan,Tanggal Daftar\n";
        
        foreach ($motors as $motor) {
            $csvData .= sprintf(
                "%d,%s,%s,%s,%s,%s,%d,%s,%s,%s,%s,%s\n",
                $motor->id,
                $motor->owner->name,
                $motor->brand,
                $motor->type,
                $motor->license_plate,
                $motor->color,
                $motor->year,
                $motor->status,
                $motor->daily_rate ?? 0,
                $motor->weekly_rate ?? 0,
                $motor->monthly_rate ?? 0,
                $motor->created_at->format('Y-m-d H:i:s')
            );
        }

        $filename = 'motors_' . date('Y-m-d_H-i-s') . '.csv';
        
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function verify(MotorVerificationRequest $request, Motor $motor)
    {
        $this->authorize('verify', $motor);
        
        $validated = $request->validated();

        if ($validated['action'] === 'approve') {
            // Step 2: Admin verifikasi & tentukan harga sewa motor
            $motor->update([
                'status' => 'available',  // Motor siap disewakan
                'daily_rate' => $validated['daily_rate'],
                'weekly_rate' => $validated['weekly_rate'],
                'monthly_rate' => $validated['monthly_rate'],
                'rental_price' => $validated['daily_rate'], // Default to daily rate
                'admin_notes' => $validated['admin_notes'],
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ]);
            
            $message = sprintf(
                'Motor berhasil diverifikasi dan siap disewakan dengan harga:
                - Harian: Rp %s
                - Mingguan: Rp %s
                - Bulanan: Rp %s',
                number_format($validated['daily_rate'], 0, ',', '.'),
                number_format($validated['weekly_rate'], 0, ',', '.'),
                number_format($validated['monthly_rate'], 0, ',', '.')
            );
        } else {
            $motor->update([
                'status' => 'rejected',
                'admin_notes' => $validated['admin_notes'] ?: 'Motor ditolak oleh admin',
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ]);
            
            $message = 'Motor telah ditolak';
        }

        return redirect()->back()->with('success', $message);
    }

    public function destroy(Motor $motor)
    {
        $this->authorize('delete', $motor);
        
        // Check if motor has active rentals
        if ($motor->rentals()->whereIn('status', ['confirmed', 'active'])->exists()) {
            return redirect()->back()->with('error', 'Motor tidak dapat dihapus karena sedang dalam masa sewa aktif.');
        }

        // Delete associated files
        if ($motor->photo) {
            Storage::disk('public')->delete($motor->photo);
        }
        
        if ($motor->documents) {
            if (is_array($motor->documents)) {
                foreach ($motor->documents as $document) {
                    Storage::disk('public')->delete($document);
                }
            } else {
                Storage::disk('public')->delete($motor->documents);
            }
        }

        $motor->delete();

        return redirect()->route(auth()->user()->role . '.motors.index')->with('success', 'Motor berhasil dihapus dari sistem.');
    }
}
