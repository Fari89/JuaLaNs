<x-app-layout>
    <div class="min-h-screen flex flex-col bg-gradient-to-br from-blue-100 via-white to-blue-200">

        <div class="flex items-center justify-center flex-grow p-4 relative">
            <div class="absolute inset-0 overflow-hidden z-0" x-data="{
                images: [
                    '{{ asset('banner1.jpg') }}',
                    '{{ asset('banner2.jpg') }}',
                    '{{ asset('banner3.jpg') }}'
                ],
                currentIndex: 0,
                init() {
                    setInterval(() => {
                        this.currentIndex = (this.currentIndex + 1) % this.images.length;
                    }, 5000);
                }
            }">
                <template x-for="(image, index) in images" :key="index">
                    <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000"
                        :style="`background-image: url('${image}'); opacity: ${currentIndex === index ? 1 : 0};`">
                    </div>
                </template>

                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            </div>

            <div class="relative z-10 w-full max-w-md bg-white backdrop-blur-sm rounded-2xl shadow-xl p-8 mt-24 mb-5">
                <div class="text-center mb-2">
                    
                    <h1 class="text-4xl font-bold text-gray-800 mt-4 mb-3">Login</h1>
                </div>

                @error('email') <p class="text-sm text-red-500 mb-2">{{ $message }}</p> @enderror
                @error('password') <p class="text-sm text-red-500 mb-2">{{ $message }}</p> @enderror

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-500">
                    </div>

                    <div x-data="{ showPassword: false }">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="relative mt-1">
                            <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-500 pr-10">
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                <span x-show="!showPassword"><i class="fas fa-eye-slash text-gray-500"></i></span>
                                <span x-show="showPassword"><i class="fas fa-eye text-gray-500"></i></span>
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-between items-center text-sm text-gray-600">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember" />
                            <span class="ml-2">Ingat Saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-500 transition">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    
                    <div class="flex items-center justify-center my-6">
                        <div class="border-t border-gray-300 flex-grow"></div>
                        <span class="px-4 text-sm text-gray-500">Atau</span>
                        <div class="border-t border-gray-300 flex-grow"></div>
                    </div>
                    
                    <div class="flex flex-col gap-3 mb-6">
                        <a href="#" class="flex items-center justify-center gap-3 bg-white border border-gray-300 text-gray-700 rounded-md py-2 shadow-sm hover:shadow-md transition">
                            <i class="fab fa-google text-blue-600"></i> Lanjutkan dengan Google
                        </a>
                        <a href="#" class="flex items-center justify-center gap-3 bg-blue-600 text-white rounded-md py-2 shadow-sm hover:bg-blue-700 transition">
                            <i class="fab fa-facebook-f"></i> Lanjutkan dengan Facebook
                        </a>
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:text-blue-500 transition">
                            Belum punya akun? <span class="font-semibold">Daftar</span>
                        </a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 transition">
                            Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>