<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tugas - To Do List Task App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-8">
    <div class="bg-white rounded-lg shadow-2xl p-8 w-full max-w-md">
        <div class="bg-white rounded-lg p-8">
            <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Tambah Tugas Baru</h2>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('tugas.store') }}" method="POST">
                @csrf

                <!-- Judul Tugas -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Judul Tugas</label>
                    <input 
                        type="text" 
                        name="judul_tugas" 
                        value="{{ old('judul_tugas') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500"
                        placeholder="Masukan judul tugas"
                        required
                    >
                </div>

                <!-- Mata Kuliah -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Mata Kuliah</label>
                    <div class="flex gap-2">
                        <select
                            name="mata_kuliah_id"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                            <option value="">Pilih Mata Kuliah</option>
                            @foreach($mataKuliahs as $mk)
                                <option value="{{ $mk->id }}"
                                    {{ session('new_mata_kuliah_id') == $mk->id ? 'selected' : '' }}>
                                    {{ $mk->nama_mata_kuliah }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Tombol tambah MK -->
                        <button
                            type="button"
                            onclick="openModalMataKuliah()"
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
                        value="{{ old('tanggal') }}"
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
                        <option value="Belum Mulai" {{ old('status') == 'Belum Mulai' ? 'selected' : '' }}>Belum Mulai</option>
                        <option value="Sedang Berlangsung" {{ old('status') == 'Sedang Berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
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
                    >{{ old('deskripsi') }}</textarea>
                </div>

                <!-- Catatan -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Catatan</label>
                    <textarea 
                        name="catatan" 
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500"
                        placeholder="Masukan catatan tugas"
                    >{{ old('catatan') }}</textarea>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button 
                        type="submit"
                        class="flex-1 bg-sky-400 hover:bg-sky-500 text-white font-semibold py-3 rounded-lg transition duration-200"
                    >
                        Simpan
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
    <div id="modalMataKuliah" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-xl font-bold text-blue-600 mb-4">Tambah Mata Kuliah Baru</h3>
           
            <form id="formMataKuliah" action="{{ route('mata-kuliah.store') }}" method="POST">
                @csrf

                <!-- WAJIB! supaya redirect balik ke halaman Tambah Tugas -->
                <input type="hidden" name="from_tugas" value="yes">

                <!-- Hidden inputs untuk menyimpan data form -->
                <input type="hidden" name="judul_tugas" id="hidden_judul_tugas">
                <input type="hidden" name="tanggal" id="hidden_tanggal">
                <input type="hidden" name="status" id="hidden_status">
                <input type="hidden" name="deskripsi" id="hidden_deskripsi">
                <input type="hidden" name="catatan" id="hidden_catatan">
               
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Nama Mata Kuliah</label>
                    <input
                        type="text"
                        name="nama_mata_kuliah"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh : Kalkulus, Multimedia Dasar"
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
                        onclick="closeModalMataKuliah()"
                        class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 rounded-lg transition"
                    >
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function openModalMataKuliah() {
            // Simpan data sementara dari form utama
            document.getElementById('hidden_judul_tugas').value = document.querySelector('input[name="judul_tugas"]').value;
            document.getElementById('hidden_tanggal').value = document.querySelector('input[name="tanggal"]').value;
            document.getElementById('hidden_status').value = document.querySelector('select[name="status"]').value;
            document.getElementById('hidden_deskripsi').value = document.querySelector('textarea[name="deskripsi"]').value;
            document.getElementById('hidden_catatan').value = document.querySelector('textarea[name="catatan"]').value;
           
            document.getElementById('modalMataKuliah').classList.remove('hidden');
        }

        function closeModalMataKuliah() {
            document.getElementById('modalMataKuliah').classList.add('hidden');
        }
    </script>

</body>
</html>
