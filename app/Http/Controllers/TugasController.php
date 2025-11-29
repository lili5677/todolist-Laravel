<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    // Tampilkan form create
    public function create()
    {
        $mataKuliahs = MataKuliah::where('user_id', Auth::id())
            ->orderBy('nama_mata_kuliah')
            ->get();
        return view('tugas.create', compact('mataKuliahs'));
    }

    // Status Dropdown
    public function updateStatus(Request $request, $id)
    {
        $tugas = Tugas::findOrFail($id);
        $tugas->status = $request->status;
        $tugas->save();

        return response()->json(['success' => true]);
    }

    // Proses store tugas baru
    public function store(Request $request)
    {
        $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Belum Mulai,Sedang Berlangsung,Selesai',
            'deskripsi' => 'nullable|string',
            'catatan' => 'nullable|string',
        ], [
            'judul_tugas.required' => 'Judul tugas wajib diisi',
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih',
            'tanggal.required' => 'Tanggal wajib diisi',
            'status.required' => 'Status wajib dipilih',
        ]);

        Tugas::create([
            'user_id' => Auth::id(),
            'judul_tugas' => $request->judul_tugas,
            'mata_kuliah_id' => $request->mata_kuliah_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'catatan' => $request->catatan,
            'is_done' => false,
        ]);

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil ditambahkan!');
    }

    // Tampilkan detail tugas
    public function show($id)
    {
        $tugas = Tugas::with('mataKuliah')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

       return view('tugas.detail', compact('tugas'));
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $tugas = Tugas::where('user_id', Auth::id())->findOrFail($id);
        $mataKuliahs = MataKuliah::where('user_id', Auth::id())
            ->orderBy('nama_mata_kuliah')
            ->get();
        return view('tugas.edit', compact('tugas', 'mataKuliahs'));
    }

    // Proses update tugas
    public function update(Request $request, $id)
    {
        $tugas = Tugas::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Belum Mulai,Sedang Berlangsung,Selesai',
            'deskripsi' => 'nullable|string',
            'catatan' => 'nullable|string',
        ], [
            'judul_tugas.required' => 'Judul tugas wajib diisi',
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih',
            'tanggal.required' => 'Tanggal wajib diisi',
            'status.required' => 'Status wajib dipilih',
        ]);

        $tugas->update([
            'judul_tugas' => $request->judul_tugas,
            'mata_kuliah_id' => $request->mata_kuliah_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil diupdate!');
    }

    // Proses delete tugas
    public function destroy($id)
    {
        $tugas = Tugas::where('user_id', Auth::id())->findOrFail($id);
        $tugas->delete();

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil dihapus!');
    }
}