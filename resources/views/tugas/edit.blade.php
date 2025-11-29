<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas - To Do List Task App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-8">
    <div class="bg-white rounded-lg shadow-2xl p-8 w-full max-w-md">
        <div class="bg-white rounded-lg p-8">
            <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Edit Tugas</h2>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('tugas.update', $tugas->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Judul Tugas -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Judul Tugas</label>
                    <input 
                        type="text" 
                        name="judul_tugas" 
                        value="{{ old('judul_tugas', $tugas->judul_tugas) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500"
                        placeholder="Masukan judul tugas"
                        required
                    >
                </div>

                <!-- Mata Kuliah -->
                <!-- Mata Kuliah -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Mata Kuliah</label>

                    <div class="flex gap-2">
                        <select 
                            name="mata_kuliah_id" 
                            id="mata_kuliah_select"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                            <option value="">Pilih Mata Kuliah</option>
                            @foreach($mataKuliahs as $mk)
                                <option value="{{ $mk->id }}" 
                                    {{ old('mata_kuliah_id', $tugas->mata_kuliah_id) == $mk->id ? 'selected' : '' }}>
                                    {{ $mk->nama_mata_kuliah }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Tombol + sama persis seperti halaman create -->
                        <button
                            type="button"
                            onclick="openModalMataKuliahEdit()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                        >
                            +
                        </button>
                    </div>
                </div>



                <!-- Tanggal -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Tenggat</label>
                    <input 
                        type="date" 
                        name="tanggal" 
                        value="{{ old('tanggal', $tugas->tanggal->format('Y-m-d')) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500"
                        required
                    >
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Status</label>
                    <select 
                        name="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500"
                        required
                    >
                        <option value="">Pilih Status</option>
                        <option value="Belum Mulai" {{ old('status', $tugas->status) == 'Belum Mulai' ? 'selected' : '' }}>Belum Mulai</option>
                        <option value="Sedang Berlangsung" {{ old('status', $tugas->status) == 'Sedang Berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="Selesai" {{ old('status', $tugas->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Deskripsi</label>
                    <textarea 
                        name="deskripsi" 
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500"
                        placeholder="Masukan deskripsi tugas"
                    >{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
                </div>

                <!-- Catatan -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Catatan</label>
                    <textarea 
                        name="catatan" 
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500"
                        placeholder="Masukan catatan tugas"
                    >{{ old('catatan', $tugas->catatan) }}</textarea>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button 
                        type="submit"
                        class="flex-1 bg-sky-400 hover:bg-sky-500 text-white font-semibold py-3 rounded-lg transition duration-200"
                    >
                        Update
                    </button>
                    <a 
                        href="{{ route('dashboard') }}"
                        class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-semibold py-3 rounded-lg transition duration-200 text-center"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Mata Kuliah -->
<div id="modalMataKuliahEdit" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-xl font-bold text-blue-600 mb-4">Tambah Mata Kuliah Baru</h3>

        <form action="{{ route('mata-kuliah.store') }}" method="POST">
            @csrf

            <!-- Agar redirect balik ke halaman EDIT -->
            <input type="hidden" name="from_tugas_edit" value="{{ $tugas->id }}">

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Nama Mata Kuliah</label>
                <input
                    type="text"
                    name="nama_mata_kuliah"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: Algoritma, Pemrograman Web"
                    required
                >
            </div>

            <div class="flex gap-3">
                <button
                    type="submit"
                    class="flex-1 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-2 rounded-lg transition"
                >
                    Simpan
                </button>

                <button
                    type="button"
                    onclick="closeModalMataKuliahEdit()"
                    class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 rounded-lg transition"
                >
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    function openModalMataKuliahEdit() {
        document.getElementById('modalMataKuliahEdit').classList.remove('hidden');
    }

    function closeModalMataKuliahEdit() {
        document.getElementById('modalMataKuliahEdit').classList.add('hidden');
    }
</script>


</body>
</html>
