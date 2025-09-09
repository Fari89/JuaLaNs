<x-app-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100 p-4">
        <div class="flex flex-col md:flex-row bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-5xl">

            {{-- Bagian Kiri (Responsive Image Slider - Hilang di mode handphone) --}}
            <div 
                x-data="{ 
                    images: ['{{ asset('banner1.jpg') }}', '{{ asset('banner2.jpg') }}', '{{ asset('banner3.jpg') }}'], 
                    current: 0 
                }"
                x-init="setInterval(() => { current = (current + 1) % images.length }, 5000)"
                class="md:w-1/2 p-10 hidden md:flex flex-col justify-center items-center text-center text-white relative overflow-hidden"
            >
                <template x-for="(img, index) in images" :key="index">
                    <div 
                        class="absolute inset-0 bg-center bg-cover transition-all duration-[1500ms] ease-in-out"
                        :style="`background-image: url('${img}')`"
                        x-show="current === index"
                        x-transition:enter="transform transition ease-out duration-[1500ms]"
                        x-transition:enter-start="opacity-0 scale-105"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transform transition ease-in duration-[1500ms]"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-105"
                    ></div>
                </template>

                <div class="absolute inset-0 bg-black bg-opacity-50"></div>

                <div class="relative z-10 p-4 sm:p-6 md:p-0">
                    <a href="/" class="mb-6 inline-block">
                        <img src="{{ url('Jualans.png') }}" alt="Jualans Logo" class="h-16 object-contain filter brightness-0 invert">
                    </a>
                    <h1 class="text-3xl font-bold mb-3">Selamat Datang di Jualans</h1>
                    <p class="text-white max-w-sm leading-relaxed">
                        Daftar sekarang untuk memulai petualangan belanja dan jualan online yang mudah dan menyenangkan.
                    </p>
                </div>
            </div>

            {{-- Bagian Kanan (Form Registrasi) --}}
            <div class="md:w-1/2 p-4 sm:p-8 md:p-10 mt-6 md:mt-0 flex flex-col justify-center">
                {{-- Judul dan Logo untuk Mode Handphone --}}
                <div class="flex flex-col items-center justify-center mb-6 md:hidden mt-14">
                    <a href="/" class="mb-2 inline-block">
                        <img src="{{ url('Jualans.png') }}" alt="Jualans Logo" class="h-10 object-contain">
                    </a>
                    <h2 class="text-xl font-bold text-gray-800">Buat Akun Baru</h2>
                    <p class="text-sm text-gray-500">Daftar sekarang untuk mulai berbelanja.</p>
                </div>

                {{-- Judul untuk Mode Desktop (disembunyikan di mode handphone) --}}
                <div class="text-center mb-6 hidden md:block">
                    <h2 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h2>
                </div>
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Username</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-500">
                        @error('name')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-500">
                        @error('email')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- PASSWORD FIELD --}}
                    <div x-data="{ showPassword: false }">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="relative mt-1">
                            <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-500 pr-10">
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                <span x-show="!showPassword"><i class="fas fa-eye-slash text-gray-500"></i></span>
                                <span x-show="showPassword"><i class="fas fa-eye text-gray-500"></i></span>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    {{-- PASSWORD CONFIRMATION FIELD --}}
                    <div x-data="{ showPasswordConfirm: false }">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <div class="relative mt-1">
                            <input id="password_confirmation" :type="showPasswordConfirm ? 'text' : 'password'" name="password_confirmation" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-500 pr-10">
                            <button type="button" @click="showPasswordConfirm = !showPasswordConfirm" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                <span x-show="!showPasswordConfirm"><i class="fas fa-eye-slash text-gray-500"></i></span>
                                <span x-show="showPasswordConfirm"><i class="fas fa-eye text-gray-500"></i></span>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-center my-6">
                        <div class="border-t border-gray-300 flex-grow"></div>
                        <span class="px-4 text-sm text-gray-500">Atau</span>
                        <div class="border-t border-gray-300 flex-grow"></div>
                    </div>
                    
                    {{-- Tombol Login Sosial Media --}}
                    <div class="flex flex-col gap-3 mb-6">
                        <a href="#" class="flex items-center justify-center gap-3 bg-white border border-gray-300 text-gray-700 rounded-md py-2 shadow-sm hover:shadow-md transition">
                            <i class="fab fa-google text-blue-600"></i> Lanjutkan dengan Google
                        </a>
                        <a href="#" class="flex items-center justify-center gap-3 bg-blue-600 text-white rounded-md py-2 shadow-sm hover:bg-blue-700 transition">
                            <i class="fab fa-facebook-f"></i> Lanjutkan dengan Facebook
                        </a>
                        
                    </div>
                    <div class="flex flex-col md:flex-row items-center justify-between pt-4 gap-4">
                        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-500 transition">
                            Sudah punya akun? <span class="font-semibold">Masuk</span>
                        </a>
                        <button type="submit" class="w-full md:w-auto px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 transition">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</x-app-layout>