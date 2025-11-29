<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ganti Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 py-10">

<div class="max-w-lg mx-auto bg-white shadow p-6 rounded-lg">

    <h2 class="text-2xl font-bold mb-4">Ganti Password</h2>

    <!-- Tampilkan error -->
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded">
            <ul class="list-disc ml-5 text-sm">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tampilkan sukses -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold">Password Lama</label>
            <input type="password" name="current_password"
                class="w-full px-4 py-2 border rounded mt-1" required>
        </div>

        <div>
            <label class="block font-semibold">Password Baru</label>
            <input type="password" name="password"
                class="w-full px-4 py-2 border rounded mt-1" required>
        </div>

        <div>
            <label class="block font-semibold">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation"
                class="w-full px-4 py-2 border rounded mt-1" required>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Update Password
        </button>

        <a href="{{ route('dashboard') }}" 
           class="inline-block ml-3 text-gray-600 hover:text-black">
           Kembali
        </a>
    </form>

</div>

</body>
</html>
