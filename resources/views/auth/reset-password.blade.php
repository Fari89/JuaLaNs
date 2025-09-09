<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-white to-blue-200 p-4">
        <div class="w-full max-w-md bg-white/70 backdrop-blur-md rounded-2xl shadow-xl p-8 space-y-6">
            {{-- Logo --}}
            <div class="text-center">
                <a href="{{ route('dashboard') }}" class="inline-block">
                    <img src="{{ url('Jualans.png') }}" alt="Jualans Logo" class="h-14 mx-auto drop-shadow-md filter brightness-0 invert">
                </a>
            </div>

            {{-- Form Title and Description --}}
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-800">Reset Kata Sandi</h2>
                <p class="text-sm text-gray-500 mt-1">Masukkan kata sandi baru untuk akun Anda.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div x-data="{ showPassword: false }">
                    <x-input-label for="password" :value="__('Password')" />
                    <div class="relative mt-1">
                        <x-text-input id="password" class="block w-full pr-10" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password" />
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                            <span x-show="!showPassword"><i class="fas fa-eye-slash text-gray-500"></i></span>
                            <span x-show="showPassword"><i class="fas fa-eye text-gray-500"></i></span>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div x-data="{ showPasswordConfirm: false }">
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                    <div class="relative mt-1">
                        <x-text-input id="password_confirmation" class="block w-full pr-10" :type="showPasswordConfirm ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" />
                        <button type="button" @click="showPasswordConfirm = !showPasswordConfirm" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                            <span x-show="!showPasswordConfirm"><i class="fas fa-eye-slash text-gray-500"></i></span>
                            <span x-show="showPasswordConfirm"><i class="fas fa-eye text-gray-500"></i></span>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 transition">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-guest-layout>