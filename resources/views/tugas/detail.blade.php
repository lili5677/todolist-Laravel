<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tugas - To Do List Task App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-6">
        
        <!-- Header with Back Button -->
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-gray-700 hover:text-gray-900 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="font-semibold">Kembali</span>
            </a>

            <!-- Judul Tengah -->
            <h1 class="text-2xl font-bold text-gray-800">Detail Tugas</h1>
            
            <!-- Spacer untuk balance layout -->
            <div class="w-24"></div>
        </div>

        <!-- Detail Card -->
        <div class="bg-white rounded-lg shadow-2xl p-8">
            <div class="bg-white rounded-lg p-8">
                <h2 class="text-2xl font-bold text-blue-600 mb-2">{{ $tugas->judul_tugas }}</h2>
                <p class="text-lg text-gray-600 mb-4">{{ $tugas->mataKuliah->nama_mata_kuliah }}</p>
                
                <!-- Tanggal -->
                <div class="flex items-center gap-2 text-blue-600 mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-semibold">{{ $tugas->tanggal->format('d F Y') }}</span>
                </div>

                <!-- Status Badge -->
                <div class="mb-6">
                    <span class="px-4 py-2 text-sm font-semibold rounded-full text-white {{ $tugas->getStatusBadgeClass() }}">
                        {{ $tugas->status }}
                    </span>
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-blue-600 mb-2">Deskripsi</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $tugas->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                </div>

                <!-- Catatan -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-blue-600 mb-2">Catatan</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $tugas->catatan ?? 'Tidak ada catatan' }}</p>
                </div>

                <!-- Action Button - CUMA EDIT TUGAS -->
                <div class="flex justify-center">
                    <a 
                        href="{{ route('tugas.edit', $tugas->id) }}"
                        class="w-full max-w-md flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Tugas
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>