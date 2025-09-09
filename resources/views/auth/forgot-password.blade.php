<x-app-layout>
    <div class="flex items-center justify-center min-h-screen p-4 bg-cover bg-center" style="background-image: url('{{ asset('banner1.jpg') }}');">
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="relative w-full max-w-md p-8 bg-white rounded-2xl shadow-2xl border border-gray-100">
            
            <div class="text-center ">
                <a href="{{ route('dashboard') }}" class="inline-block">
                </a>
            </div>

            <div class="text-center mb-8">
                <div class="text-4xl text-gray-800 mb-2">
                    <i class="fas fa-lock text-blue-600"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Lupa Password</h2>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                    Tidak masalah! Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password.
                </p>
            </div>

            @if (session('status'))
                <div class="mb-4 text-sm text-green-700 bg-green-100 border border-green-200 p-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required autofocus
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" />
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" 
                        class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-200">
                        Kirim Tautan Reset Password
                    </button>
                </div>
            </form>

            <div class="text-center mt-8">
                <a href="{{ route('login') }}" 
                   class="inline-block text-sm font-medium text-blue-600 hover:text-blue-800 transition">
                    ← Kembali ke Halaman Login
                </a>
            </div>

        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuQl1gaewi7uFO0lkpi9kfhFhyGjRmESiIO2LWQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</x-app-layout>