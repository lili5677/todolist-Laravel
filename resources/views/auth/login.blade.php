<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - To Do List Task App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f0f7ff] min-h-screen flex items-center justify-center">
    <div class="bg-gray-100 rounded-lg shadow-2xl p-8 w-full max-w-md">
        <div class="bg-white rounded-lg p-8">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h2>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
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
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <!-- Button Masuk -->
                <button 
                    type="submit"
                    class="w-full bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-3 rounded-lg transition duration-200"
                >
                    Masuk
                </button>

                <!-- Link ke Register -->
                <p class="text-center text-sm text-gray-600 mt-4">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-cyan-500 hover:text-cyan-600 font-semibold">
                        Daftar Disini
                    </a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>