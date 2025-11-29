<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MataKuliahController extends Controller
{
    public function store(Request $request)
    {
        // VALIDASI DASAR
        $request->validate([
            'nama_mata_kuliah' => 'required|string|max:255',
        ]);

        // VALIDASI DUPLIKAT (CASE-INSENSITIVE) - CUMA CEK PUNYA USER INI AJA
        $exists = MataKuliah::where('user_id', Auth::id())
            ->whereRaw('LOWER(nama_mata_kuliah) = ?', [
                strtolower($request->nama_mata_kuliah)
            ])->first();

        if ($exists) {
            return back()->withErrors([
                'nama_mata_kuliah' => 'Mata kuliah sudah ditambahkan sebelumnya.'
            ])->withInput();
        }

        // SIMPAN MATA KULIAH BARU (DENGAN user_id)
        $mk = MataKuliah::create([
            'nama_mata_kuliah' => $request->nama_mata_kuliah,
            'user_id' => Auth::id(),  // TAMBAH INI
        ]);

        // JIKA DARI CREATE TUGAS
        if ($request->from_tugas == 'yes') {
            return redirect()
                ->route('tugas.create')
                ->with('new_mata_kuliah_id', $mk->id)
                ->withInput($request->only([
                    'judul_tugas', 
                    'tanggal', 
                    'status', 
                    'deskripsi', 
                    'catatan'
                ]))
                ->with('success', 'Mata kuliah berhasil ditambahkan!');
        }

        // JIKA DARI EDIT TUGAS
        if ($request->has('from_tugas_edit')) {
            return redirect()
                ->route('tugas.edit', $request->from_tugas_edit)
                ->with('new_mata_kuliah_id', $mk->id)
                ->withInput($request->only([
                    'judul_tugas', 
                    'tanggal', 
                    'status', 
                    'deskripsi', 
                    'catatan'
                ]))
                ->with('success', 'Mata kuliah berhasil ditambahkan!');
        }

        // DEFAULT
        return redirect()
            ->route('mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan!');
    }


    public function index()
    {
        // CUMA AMBIL MATAKULIAH PUNYA USER LOGIN
        $matkul = MataKuliah::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(5);
            
        return view('mata-kuliah.index', compact('matkul'));
    }


    public function edit($id)
    {
        // PASTIKAN CUMA BISA EDIT PUNYA SENDIRI
        $matkul = MataKuliah::where('user_id', Auth::id())
            ->findOrFail($id);
            
        return view('mata-kuliah.edit', compact('matkul'));
    }


    public function update(Request $request, $id)
    {
        // VALIDASI DASAR
        $request->validate([
            'nama_mata_kuliah' => 'required|string|max:255',
        ]);

        // PASTIKAN INI MATAKULIAH PUNYA USER LOGIN
        $matkul = MataKuliah::where('user_id', Auth::id())
            ->findOrFail($id);

        // VALIDASI DUPLIKAT (CASE-INSENSITIVE) - CUMA CEK PUNYA USER INI
        $duplicate = MataKuliah::where('user_id', Auth::id())
            ->whereRaw('LOWER(nama_mata_kuliah) = ?', [
                strtolower($request->nama_mata_kuliah)
            ])->where('id', '!=', $id)->first();

        if ($duplicate) {
            return back()->withErrors([
                'nama_mata_kuliah' => 'Nama mata kuliah sudah digunakan.'
            ])->withInput();
        }

        $matkul->update([
            'nama_mata_kuliah' => $request->nama_mata_kuliah,
        ]);

        return redirect()->route('mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil diperbarui!');
    }


    public function destroy($id)
    {
        // PASTIKAN CUMA BISA HAPUS PUNYA SENDIRI
        $matkul = MataKuliah::where('user_id', Auth::id())
            ->findOrFail($id);
            
        $matkul->delete();

        return redirect()->route('mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil dihapus!');
    }
}