<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    @vite('resources/css/app.css') {{-- pastikan Vite dan Tailwind sudah dikonfigurasi --}}
</head>
<body class="bg-gradient-to-br from-blue-50 via-purple-100 to-pink-50 min-h-screen flex items-center justify-center">

    <div class="max-w-xl w-full mx-auto bg-white shadow-2xl rounded-3xl p-10 text-center">
        
        {{-- Gambar roket --}}
        <div class="flex justify-center mb-6">
            <img src="{{ url('FaRs2.png') }}" alt="Logo" class="w-30 h-20">
        </div>

        <h1 class="text-4xl font-bold text-indigo-700 mb-4 animate-fade-in-down">
            Selamat Datang
        </h1>

        <p class="text-gray-600 mb-6">
           Aplikas ini dirancang untuk pengalaman berbelanja yang lebih menyenangkan.
        </p>

        <div class="flex justify-center gap-4">
            <a href="{{ route('product.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-full font-medium shadow transition duration-300">
                Dashboard
            </a>
        </div>
    </div>

    <!-- Animasi -->
    <style>
        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-down {
            animation: fade-in-down 1s ease-out;
        }
    </style>

</body>
</html>
