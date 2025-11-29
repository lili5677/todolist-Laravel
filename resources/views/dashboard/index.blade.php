<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - To Do List Task App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>


    <style>
    .sort-icon {
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        display: block;
        opacity: 0.4;
        transition: 0.2s;
    }
    .sort-up {
        border-bottom: 6px solid #4b5563; /* gray-600 */
    }
    .sort-down {
        border-top: 6px solid #d1d5db; /* gray-300 */
    }
    th:hover .sort-icon {
        opacity: 1;
    }

    [x-cloak] { 
        display: none !important; 
    }

    ::-webkit-scrollbar {
        width: 0px;
        background: transparent;
    }
    </style>


</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h1 class="text-xl sm:text-2xl font-bold text-blue-600">To Do List Task App</h1>
            <div class="flex items-center gap-4">
                    <div x-data="{ open: false }" x-cloak class="relative flex items-center gap-2">
                        <!-- Tombol Avatar + Nama -->
                        <button @click="open = !open" class="flex items-center gap-2 px-2 py-1 rounded-lg hover:bg-gray-100 transition">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" 
                                class="w-10 h-10 rounded-full shadow-sm border" alt="Avatar">

                            <div class="hidden sm:block text-left">
                                <p class="text-sm font-semibold text-gray-800 leading-none">Hai, {{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>

                            <!-- Icon panah -->
                            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 text-gray-500 transition-transform" 
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- DROPDOWN -->
                        <div 
                            x-show="open"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-2"
                            @click.outside="open = false"

                            class="absolute right-0 top-14 w-52 bg-white border border-gray-200 shadow-xl 
                                rounded-xl overflow-hidden z-50"
                        >

                            <!-- Header kecil di dropdown -->
                            <div class="px-4 py-3 bg-gray-50 border-b">
                                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('profile') }}"
                            class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M5.121 17.804A4 4 0 017 17h10a4 4 0 011.879.804L19 19H5l.121-1.196z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a5 5 0 100-10 5 5 0 000 10z"/>
                                </svg>
                                Profil
                            </a>

                            <a href="{{ route('password.change') }}"
                            class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 11v2m0 4h.01M5 20h14a2 2 0 002-2v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7a2 2 0 002 2z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7a3 3 0 016 0v4H9V7z"/>
                                </svg>
                                Ganti Password
                            </a>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button 
                                    class="flex items-center gap-2 w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
                                    
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" 
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>

                                    Keluar
                                </button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
        <!-- Search & Add Button -->
        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mb-6">
            <form method="GET" action="{{ route('dashboard') }}" class="flex-1 max-w-full sm:max-w-md">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Search for tasks..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </form>
           <div class="flex items-center gap-2">
            <a href="{{ route('tugas.create') }}" 
                class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition text-sm font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Tugas
            </a>

            <a href="{{ route('mata-kuliah.index') }}"
                class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition text-sm font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Matkul
            </a>
            
            </div>
        </div>

        <!-- Filters & Per Page -->
        <form method="GET" action="{{ route('dashboard') }}" class="mb-6">
            <!-- Items Per Page (Mobile: Full Width, Desktop: Left) -->
            <div class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <label class="text-sm text-gray-600 whitespace-nowrap">Tampilkan</label>
                    <select name="per_page" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span class="text-sm text-gray-600 whitespace-nowrap">data per halaman</span>
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="hidden" name="waktu" value="{{ request('waktu') }}">
                    <input type="hidden" name="mata_kuliah" value="{{ request('mata_kuliah') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                </div>

                <!-- Filter Dropdowns (Mobile: Stack, Desktop: Row) -->
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <!-- Filter Status -->
                    <select name="status" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="Semua" {{ request('status') == 'Semua' ? 'selected' : '' }}>Semua Status</option>
                        <option value="Belum Mulai" {{ request('status') == 'Belum Mulai' ? 'selected' : '' }}>Belum Mulai</option>
                        <option value="Sedang Berlangsung" {{ request('status') == 'Sedang Berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>

                    <!-- Filter Waktu -->
                    <select name="waktu" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="Semua" {{ request('waktu') == 'Semua' ? 'selected' : '' }}>Semua Waktu</option>
                        <option value="Hari Ini" {{ request('waktu') == 'Hari Ini' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="Minggu Ini" {{ request('waktu') == 'Minggu Ini' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="Bulan Ini" {{ request('waktu') == 'Bulan Ini' ? 'selected' : '' }}>Bulan Ini</option>
                    </select>

                    <!-- Filter Mata Kuliah -->
                    <select name="mata_kuliah" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="Semua" {{ request('mata_kuliah') == 'Semua' ? 'selected' : '' }}>Semua Mata Kuliah</option>
                        @foreach($mataKuliahs as $mk)
                            <option value="{{ $mk->id }}" {{ request('mata_kuliah') == $mk->id ? 'selected' : '' }}>
                                {{ $mk->nama_mata_kuliah }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Reset Button -->
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-center text-sm">
                        Reset Kategori
                    </a>
                </div>
            </div>
        </form>

        <!-- Table (Desktop) & Cards (Mobile) -->
        
        <!-- Desktop Table View -->
        <div class="hidden lg:block bg-white rounded-lg shadow overflow-x-auto overflow-y-visible">
            <table class="w-full table-fixed">
                <colgroup>
                    <col style="width: 23%;">
                    <col style="width: 11%;">
                    <col style="width: 14%;">
                    <col style="width: 17%;">
                    <col style="width: 17%;">
                    <col style="width: 18%;">
                </colgroup>
                <thead class="bg-blue-100 border-b">
                    <tr>

                        <!-- Daftar Tugas -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            <div class="flex items-center gap-1">
                                Daftar Tugas
                                <div class="flex flex-col ml-1 leading-none">
                                    <span class="sort-icon sort-up"></span>
                                    <span class="sort-icon sort-down"></span>
                                </div>
                            </div>
                        </th>

                        <!-- Tenggat -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            <div class="flex items-center gap-1">
                                Tenggat
                                <div class="flex flex-col ml-1 leading-none">
                                    <span class="sort-icon sort-up"></span>
                                    <span class="sort-icon sort-down"></span>
                                </div>
                            </div>
                        </th>

                        <!-- Status -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            <div class="flex items-center gap-1">
                                Status
                                <div class="flex flex-col ml-1 leading-none">
                                    <span class="sort-icon sort-up"></span>
                                    <span class="sort-icon sort-down"></span>
                                </div>
                            </div>
                        </th>

                        <!-- Deskripsi -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            <div class="flex items-center gap-1">
                                Deskripsi
                                <div class="flex flex-col ml-1 leading-none">
                                    <span class="sort-icon sort-up"></span>
                                    <span class="sort-icon sort-down"></span>
                                </div>
                            </div>
                        </th>

                        <!-- Catatan -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            <div class="flex items-center gap-1">
                                Catatan
                                <div class="flex flex-col ml-1 leading-none">
                                    <span class="sort-icon sort-up"></span>
                                    <span class="sort-icon sort-down"></span>
                                </div>
                            </div>
                        </th>

                        <!-- Aksi -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            <div class="flex items-center gap-1">
                                Aksi
                                <div class="flex flex-col ml-1 leading-none">
                                    <span class="sort-icon sort-up"></span>
                                    <span class="sort-icon sort-down"></span>
                                </div>
                            </div>
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse($tugas as $item)
                    <tr class="hover:bg-gray-50">
                        <!-- Checkbox & Judul -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <input 
                                    type="checkbox" 
                                    class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 toggle-done"
                                    data-id="{{ $item->id }}"
                                    {{ $item->is_done ? 'checked' : '' }}
                                >
                                <div>
                                    <p class="font-semibold text-gray-800 {{ $item->is_done ? 'line-through text-gray-400' : '' }}">
                                        {{ $item->judul_tugas }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $item->mataKuliah->nama_mata_kuliah }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Tanggal - DENGAN LOGIC MERAH -->
                        <td class="px-6 py-4">
                            <p class="text-sm {{ $item->getDateColorClass() }}">
                                {{ $item->tanggal->format('d M Y') }}
                            </p>
                        </td>

                        <!-- Status Badge -->
                        <td class="px-6 py-4">
                            <div x-data="{ open: false }" class="relative inline-block">
                                <!-- Badge yang bisa diklik -->
                                <button 
                                    @click="open = !open"
                                    class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full text-white whitespace-nowrap {{ $item->getStatusBadgeClass() }} hover:opacity-90 transition cursor-pointer"
                                >
                                    {{ $item->status }}
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Dropdown Pilihan Status -->
                                <div 
                                    x-show="open"
                                    @click.outside="open = false"
                                    x-transition
                                    class="absolute z-50 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden"
                                >
                                    <!-- Belum Mulai -->
                                    <button 
                                        onclick="updateStatus({{ $item->id }}, 'Belum Mulai')"
                                        class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-2"
                                    >
                                        <span class="w-3 h-3 rounded-full bg-gray-500"></span>
                                        Belum Mulai
                                    </button>

                                    <!-- Sedang Berlangsung -->
                                    <button 
                                        onclick="updateStatus({{ $item->id }}, 'Sedang Berlangsung')"
                                        class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-2"
                                    >
                                        <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                                        Sedang Berlangsung
                                    </button>

                                    <!-- Selesai -->
                                    <button 
                                        onclick="updateStatus({{ $item->id }}, 'Selesai')"
                                        class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-2"
                                    >
                                        <span class="w-3 h-3 rounded-full bg-green-500"></span>
                                        Selesai
                                    </button>
                                </div>
                            </div>
                        </td> 

                        <!-- Deskripsi -->
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600 truncate" title="{{ $item->deskripsi }}">
                                {{ Str::limit($item->deskripsi, 40) }}
                            </p>
                        </td>

                        <!-- Catatan -->
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600 truncate" title="{{ $item->catatan }}">
                                {{ Str::limit($item->catatan, 40) }}
                            </p>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <!-- Edit Button -->
                                <a href="{{ route('tugas.edit', $item->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <!-- Delete Button -->
                                <button onclick="confirmDelete({{ $item->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>

                                <!-- Detail Button (Text Only) -->
                                <a href="{{ route('tugas.show', $item->id) }}" class="px-2 py-1 text-green-600 hover:bg-green-50 rounded-lg transition font-medium text-sm whitespace-nowrap" title="Detail">
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <p class="text-lg">Tidak ada tugas ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="lg:hidden space-y-4">
            @forelse($tugas as $item)
            <div class="bg-white rounded-lg shadow p-4">
                <!-- Header: Checkbox + Judul + Status -->
                <div class="flex items-start gap-3 mb-3">
                    <input 
                        type="checkbox" 
                        class="w-5 h-5 mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500 toggle-done"
                        data-id="{{ $item->id }}"
                        {{ $item->is_done ? 'checked' : '' }}
                    >
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800 mb-1 {{ $item->is_done ? 'line-through text-gray-400' : '' }}">
                            {{ $item->judul_tugas }}
                        </h3>
                        <p class="text-sm text-gray-500 mb-2">{{ $item->mataKuliah->nama_mata_kuliah }}</p>
                        <div x-data="{ open: false }" class="relative inline-block">
                            <!-- Badge yang bisa diklik -->
                            <button 
                                @click="open = !open"
                                class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full text-white {{ $item->getStatusBadgeClass() }} hover:opacity-90 transition"
                            >
                                {{ $item->status }}
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Pilihan Status -->
                            <div 
                                x-show="open"
                                @click.outside="open = false"
                                x-transition
                                class="absolute z-50 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden left-0"
                            >
                                <!-- Belum Mulai -->
                                <button 
                                    onclick="updateStatus({{ $item->id }}, 'Belum Mulai')"
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-2"
                                >
                                    <span class="w-3 h-3 rounded-full bg-gray-500"></span>
                                    Belum Mulai
                                </button>

                                <!-- Sedang Berlangsung -->
                                <button 
                                    onclick="updateStatus({{ $item->id }}, 'Sedang Berlangsung')"
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-2"
                                >
                                    <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                                    Sedang Berlangsung
                                </button>

                                <!-- Selesai -->
                                <button 
                                    onclick="updateStatus({{ $item->id }}, 'Selesai')"
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-2"
                                >
                                    <span class="w-3 h-3 rounded-full bg-green-500"></span>
                                    Selesai
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tanggal - DENGAN LOGIC MERAH -->
                <div class="flex items-center gap-2 text-sm mb-2 {{ $item->getDateColorClass() }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{ $item->tanggal->format('d M Y') }}</span>
                </div>

                <!-- Deskripsi -->
                @if($item->deskripsi)
                <div class="text-sm text-gray-600 mb-2">
                    <span class="font-medium">Deskripsi:</span> {{ Str::limit($item->deskripsi, 60) }}
                </div>
                @endif

                <!-- Catatan -->
                @if($item->catatan)
                <div class="text-sm text-gray-600 mb-3">
                    <span class="font-medium">Catatan:</span> {{ Str::limit($item->catatan, 60) }}
                </div>
                @endif

                <!-- Actions -->
                <div class="flex gap-2 pt-3 border-t">
                    <a href="{{ route('tugas.edit', $item->id) }}" class="flex items-center justify-center gap-2 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                    <button onclick="confirmDelete({{ $item->id }})" class="flex items-center justify-center gap-2 px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                    <a href="{{ route('tugas.show', $item->id) }}" class="flex-1 flex items-center justify-center gap-2 px-3 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition text-sm font-medium">
                        Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
                <p class="text-lg">Tidak ada tugas ditemukan</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <!-- Info Jumlah Data -->
                <div class="text-sm text-gray-600 text-center sm:text-left">
                    Menampilkan {{ $tugas->firstItem() ?? 0 }} sampai {{ $tugas->lastItem() ?? 0 }} dari {{ $tugas->total() }} data
                </div>

                <!-- Pagination Buttons -->
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <!-- First Page -->
                    @if ($tugas->onFirstPage())
                        <span class="px-2 sm:px-3 py-2 bg-gray-100 text-gray-400 rounded cursor-not-allowed text-xs sm:text-sm">Pertama</span>
                    @else
                        <a href="{{ $tugas->url(1) }}" class="px-2 sm:px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50 text-xs sm:text-sm">Pertama</a>
                    @endif

                    <!-- Previous Page -->
                    @if ($tugas->onFirstPage())
                        <span class="px-2 sm:px-3 py-2 bg-gray-100 text-gray-400 rounded cursor-not-allowed text-xs sm:text-sm">« Sebelumnya</span>
                    @else
                        <a href="{{ $tugas->previousPageUrl() }}" class="px-2 sm:px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50 text-xs sm:text-sm">« Sebelumnya</a>
                    @endif

                    <!-- Page Numbers -->
                    @foreach ($tugas->getUrlRange(max(1, $tugas->currentPage() - 1), min($tugas->lastPage(), $tugas->currentPage() + 1)) as $page => $url)
                        @if ($page == $tugas->currentPage())
                            <span class="px-3 sm:px-4 py-2 bg-blue-600 text-white rounded font-semibold text-xs sm:text-sm">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 sm:px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50 text-xs sm:text-sm">{{ $page }}</a>
                        @endif
                    @endforeach

                    <!-- Next Page -->
                    @if ($tugas->hasMorePages())
                        <a href="{{ $tugas->nextPageUrl() }}" class="px-2 sm:px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50 text-xs sm:text-sm">Selanjutnya »</a>
                    @else
                        <span class="px-2 sm:px-3 py-2 bg-gray-100 text-gray-400 rounded cursor-not-allowed text-xs sm:text-sm">Selanjutnya »</span>
                    @endif

                    <!-- Last Page -->
                    @if ($tugas->hasMorePages())
                        <a href="{{ $tugas->url($tugas->lastPage()) }}" class="px-2 sm:px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50 text-xs sm:text-sm">Terakhir</a>
                    @else
                        <span class="px-2 sm:px-3 py-2 bg-gray-100 text-gray-400 rounded cursor-not-allowed text-xs sm:text-sm">Terakhir</span>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modalHapus" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-xl font-bold text-blue-600 mb-4">Apakah anda yakin mau menghapus tugas?</h3>
            
            <form id="formHapus" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="flex gap-3">
                    <button 
                        type="submit"
                        class="flex-1 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-2 rounded-lg transition"
                    >
                        Hapus
                    </button>
                    <button 
                        type="button"
                        onclick="closeModalHapus()"
                        class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 rounded-lg transition"
                    >
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

   <script>
        let deleteId = null;

        // ====== MODAL DELETE ======
        function confirmDelete(id) {
            deleteId = id;
            document.getElementById('formHapus').action = `/tugas/${id}`;
            document.getElementById('modalHapus').classList.remove('hidden');
        }

        function closeModalHapus() {
            document.getElementById('modalHapus').classList.add('hidden');
        }

        // ====== UPDATE STATUS (VERSI BARU) ======
        function updateStatus(tugasId, newStatus) {
            fetch(`/tugas/${tugasId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal update status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }

        // ====== TOGGLE DONE CHECKBOX ======
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.toggle-done').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const tugasId = this.dataset.id;
                    const isDone = this.checked;

                    fetch(`/tugas/${tugasId}/toggle-done`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ is_done: isDone })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>

</body>
</html>