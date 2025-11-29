<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - To Do List Task App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f0f7ff] min-h-screen flex items-center justify-center">
    <div class="bg-gray-100 rounded-lg shadow-2xl p-8 w-full max-w-md">
        <div class="bg-white rounded-lg p-8">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Daftar</h2>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Nama Lengkap</label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan nama lengkap"
                        required
                    >
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan email"
                        required
                    >
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Konfirmasi Password</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Konfirmasi password"
                        required
                    >
                </div>

                <!-- Button Daftar -->
                <button 
                    type="submit"
                    class="w-full bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-3 rounded-lg transition duration-200"
                >
                    Daftar
                </button>

                <!-- Link ke Login -->
                <p class="text-center text-sm text-gray-600 mt-4">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-cyan-500 hover:text-cyan-600 font-semibold">
                        Masuk
                    </a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>