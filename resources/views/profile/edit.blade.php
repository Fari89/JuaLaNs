<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-user-circle text-blue-600"></i> {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Update Profile Information --}}
            <div class="p-6 bg-white shadow-lg hover:shadow-xl transition-all duration-300 rounded-xl border border-gray-100">
                <div class="max-w-xl">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                     
                    </h3>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="p-6 bg-white shadow-lg hover:shadow-xl transition-all duration-300 rounded-xl border border-gray-100">
                <div class="max-w-xl">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        
                    </h3>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="p-6 bg-white shadow-lg hover:shadow-xl transition-all duration-300 rounded-xl border border-gray-100">
                <div class="max-w-xl">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    </h3>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            {{-- Logout Section --}}
            <div class="p-6 bg-white shadow-lg hover:shadow-xl transition-all duration-300 rounded-xl border border-gray-100">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                {{-- <i class="fas fa-sign-out-alt text-blue-700">Log Out</i>  --}}
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Klik tombol di bawah untuk keluar dari akun Anda.
                            </p>
                        </header>

                        <form method="POST" action="{{ route('logout') }}" class="mt-6">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-md hover:bg-red-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-300">
                                <i class="fas fa-power-off"></i> Log Out
                            </button>
                        </form>
                    </section>
                </div>
            </div>

        </div>
    </div>

    {{-- Font Awesome untuk ikon --}}
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</x-app-layout>
