<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Mata Kuliah</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Style buat cursor not allowed */
        .cursor-not-allowed {
            cursor: not-allowed;
        }
    </style>
</head>

<body class="bg-gray-100 py-10">

<div class="max-w-2xl mx-auto">

    <!-- Tombol Kembali -->
    <a href="/" class="flex items-center text-gray-600 hover:text-black mb-4">
        <span class="text-xl mr-2">←</span>
        Kembali
    </a>

    <div class="bg-white p-6 rounded-xl shadow-lg">

        <h1 class="text-2xl font-bold text-blue-600 mb-4">Tambah Mata Kuliah</h1>

        <!-- PESAN ERROR -->
        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-3 text-sm">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- PESAN BERHASIL -->
        @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-3 text-sm">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('mata-kuliah.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm font-medium">Nama Mata Kuliah</label>
                <input type="text" name="nama_mata_kuliah"
                    class="w-full border p-2 rounded-lg mt-1"
                    placeholder="Contoh: Pemrograman Web" required>
            </div>

            <button class="bg-sky-500 text-white px-4 py-2 rounded-lg hover:bg-sky-600">
                Simpan
            </button>
        </form>

        <hr class="my-6">

        <h1 class="text-2xl font-bold text-blue-600 mb-4">Daftar Mata Kuliah</h1>

        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2 text-center relative">
                        Nama Mata Kuliah
                    </th>
                    <th class="border p-2 w-24 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matkul as $mk)
                <tr>
                    <td class="border p-2">{{ $mk->nama_mata_kuliah }}</td>

                    <td class="border p-2 text-center">
                        <div class="flex justify-center items-center gap-4">

                            <!-- Edit Icon - ADA KOTAKNYA + PENSIL -->
                            <a href="{{ route('mata-kuliah.edit', $mk->id) }}"
                               class="text-blue-500 hover:text-blue-700 inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                     viewBox="0 0 24 24" 
                                     fill="none" 
                                     stroke="currentColor" 
                                     stroke-width="2" 
                                     stroke-linecap="round" 
                                     stroke-linejoin="round" 
                                     class="w-5 h-5">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>

                            <!-- Hapus - PERSIS GAMBAR -->
                            <button onclick="openDeleteModal('{{ $mk->id }}')"
                                    class="text-red-500 hover:text-red-700 inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                     viewBox="0 0 24 24" 
                                     fill="none" 
                                     stroke="currentColor" 
                                     stroke-width="2" 
                                     stroke-linecap="round" 
                                     stroke-linejoin="round" 
                                     class="w-5 h-5">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Custom - RAPI & SIMPLE -->
        <div class="flex justify-between items-center mt-6 text-sm">
            <!-- Kiri: Info -->
            <div class="text-gray-600">
                Menampilkan {{ $matkul->firstItem() ?? 0 }} sampai {{ $matkul->lastItem() ?? 0 }} dari {{ $matkul->total() }} data
            </div>

            <!-- Kanan: Tombol Pagination -->
            <div class="flex items-center gap-1">
                <!-- << Previous -->
                @if ($matkul->onFirstPage())
                    <span class="px-3 py-1.5 bg-gray-100 border border-gray-300 rounded text-gray-400 cursor-not-allowed">
                        &laquo;
                    </span>
                @else
                    <a href="{{ $matkul->previousPageUrl() }}" class="px-3 py-1.5 bg-white border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                        &laquo;
                    </a>
                @endif

                <!-- Nomor Halaman -->
                @foreach ($matkul->getUrlRange(1, $matkul->lastPage()) as $page => $url)
                    @if ($page == $matkul->currentPage())
                        <span class="px-3 py-1.5 bg-blue-600 border border-blue-600 rounded text-white font-medium">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 bg-white border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                <!-- >> Next -->
                @if ($matkul->hasMorePages())
                    <a href="{{ $matkul->nextPageUrl() }}" class="px-3 py-1.5 bg-white border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                        &raquo;
                    </a>
                @else
                    <span class="px-3 py-1.5 bg-gray-100 border border-gray-300 rounded text-gray-400 cursor-not-allowed">
                        &raquo;
                    </span>
                @endif
            </div>
        </div>

    </div>

</div>


<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal"
     class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

    <div class="bg-white w-80 p-6 rounded-2xl shadow-xl text-center animate-scale">

        <h2 class="text-xl font-bold text-red-600 mb-3">Hapus Data?</h2>
        <p class="text-gray-600 text-sm mb-5">
            Perhatian! Menghapus mata kuliah akan menghapus semua tugasnya
        </p>

        <form id="deleteForm" method="POST" class="flex gap-3 justify-center">
            @csrf
            @method('DELETE')

            <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg w-24">
                Hapus
            </button>

            <button type="button"
                onclick="closeDeleteModal()"
                class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg w-24">
                Batal
            </button>
        </form>
    </div>
</div>

<style>
    .animate-scale {
        animation: scaleIn .2s ease-out;
    }
    @keyframes scaleIn {
        from { transform: scale(0.8); opacity: 0; }
        to   { transform: scale(1); opacity: 1; }
    }
</style>

<script>
    function openDeleteModal(id) {
        const form = document.getElementById("deleteForm");
        form.action = "/mata-kuliah/" + id;
        document.getElementById("deleteModal").classList.remove("hidden");
    }

    function closeDeleteModal() {
        document.getElementById("deleteModal").classList.add("hidden");
    }
</script>

</body>
</html>