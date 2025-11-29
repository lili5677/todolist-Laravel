<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 py-10">

<div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6">

    <!-- TOMBOL KEMBALI -->
    <a href="{{ route('dashboard') }}" 
       class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali
    </a>

    <h2 class="text-2xl font-bold text-gray-800 mb-4">Profil Saya</h2>

    <!-- Avatar -->
    <div class="flex items-center gap-4 mb-6">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random"
            class="w-16 h-16 rounded-full shadow">
        <div>
            <p class="text-lg font-semibold">{{ Auth::user()->name }}</p>
            <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
        </div>
    </div>

    <hr class="my-4">

    <!-- FORM EDIT PROFIL -->
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold text-gray-700">Nama</label>
            <input type="text" name="name" value="{{ Auth::user()->name }}"
                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">
        </div>

        <div class="mb-4">
            <label class="block font-semibold text-gray-700">Email</label>
            <input type="email" name="email" value="{{ Auth::user()->email }}"
                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Update Profil
        </button>
    </form>

    <hr class="my-6">

    <!-- CARD GANTI PASSWORD -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-center justify-between">
        <div>
            <p class="font-semibold text-blue-800">Ingin mengganti password?</p>
            <p class="text-sm text-blue-600">Jaga keamanan akun Anda.</p>
        </div>

        <a href="{{ route('password.change') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
            Ganti Password
        </a>
    </div>

</div>

</body>
</html>
