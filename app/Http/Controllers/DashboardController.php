<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Tugas::with('mataKuliah')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Filter by Status
        if ($request->filled('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        // Filter by Time Period
        if ($request->filled('waktu') && $request->waktu != 'Semua') {
            $today = Carbon::today();
            
            switch ($request->waktu) {
                case 'Hari Ini':
                    $query->whereDate('tanggal', $today);
                    break;
                case 'Minggu Ini':
                    $startOfWeek = $today->copy()->startOfWeek();
                    $endOfWeek = $today->copy()->endOfWeek();
                    $query->whereBetween('tanggal', [$startOfWeek, $endOfWeek]);
                    break;
                case 'Bulan Ini':
                    $query->whereMonth('tanggal', $today->month)
                          ->whereYear('tanggal', $today->year);
                    break;
            }
        }

        // Filter by Mata Kuliah
        if ($request->filled('mata_kuliah') && $request->mata_kuliah != 'Semua') {
            $query->where('mata_kuliah_id', $request->mata_kuliah);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul_tugas', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhere('catatan', 'like', '%' . $search . '%');
            });
        }

        // Pagination with per_page
        $perPage = $request->get('per_page', 10);
        $tugas = $query->paginate($perPage)->withQueryString();

        // Get all mata kuliah for filter dropdown
        $mataKuliahs = MataKuliah::where('user_id', Auth::id())->get();

        return view('dashboard.index', compact('tugas', 'mataKuliahs'));
    }

    // Toggle checkbox done/undone
    public function toggleDone(Request $request, $id)
    {
        $tugas = Tugas::where('user_id', Auth::id())->findOrFail($id);
        
        $tugas->is_done = $request->is_done;
        
        // Jika di-check, status jadi Selesai
        if ($request->is_done) {
            $tugas->status = 'Selesai';
        } else {
            // Jika di-uncheck, kembali ke status sebelumnya atau default
            // Bisa disesuaikan logikanya
            $tugas->status = 'Sedang Berlangsung';
        }
        
        $tugas->save();

        return response()->json([
            'success' => true,
            'status' => $tugas->status,
            'is_done' => $tugas->is_done
        ]);
    }
}