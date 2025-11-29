<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Mata Kuliah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 py-10">

<div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-lg">

    <h1 class="text-2xl font-bold text-blue-600 mb-4">Edit Mata Kuliah</h1>

    <form action="{{ route('mata-kuliah.update', $matkul->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="text-sm font-medium">Nama Mata Kuliah</label>
            <input type="text" name="nama_mata_kuliah"
                   value="{{ $matkul->nama_mata_kuliah }}"
                   class="w-full border p-2 rounded-lg mt-1"
                   required>
        </div>

        <div class="flex gap-3 mt-4">
            <button class="bg-sky-500 text-white px-4 py-2 rounded-lg hover:bg-sky-600">
                Update
            </button>

            <a href="{{ route('mata-kuliah.index') }}"
               class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">
               Kembali
            </a>
        </div>
    </form>

</div>

</body>
</html>
