<footer class=" bg-blue-800 text-white py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <a href="/dashboard" class="inline-block">
        <img src="{{ url('FaRs_logo.png') }}" alt="FaRs Logo" class="h-10 md:h-14 object-contain mb-3 mx-auto" />
    </a>
                    <p class="text-sm text-gray-300">
                        Platform jual beli produk pilihan terbaik dengan layanan terpercaya dan responsif.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-2">Navigasi</h4>
                    <ul class="space-y-1 text-sm text-gray-300">
                        <li><a href="/dashboard" class="hover:underline">Beranda</a></li>
                        <li><a href="{{ route('product.index') }}" class="hover:underline">Produk</a></li>
                        <li><a href="#" class="hover:underline">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-2">Komponen & Tools</h4>
                    <ul class="space-y-1 text-sm text-gray-300">
                        <li>Gemini Ai</li>
                        <li>Laravel 10</li>
                        <li>Tailwind CSS</li>
                        <li>Alpine.js</li>
                        <li>Font Awesome</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-2">Developer</h4>
                    <p class="text-sm text-gray-300">
                        <strong>Muhammad Farihin Mushawwir</strong><br>
                        Email: <a href="mailto:support@jualans.com" class="hover:underline">support@jualans.com</a><br>
                        &copy; {{ date('Y') }} All rights reserved.
                    </p>
                    <div class="flex space-x-4 mt-3 text-xl">
                        <a href="#" class="hover:text-blue-400"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="hover:text-sky-400"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-pink-400"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="hover:text-gray-400"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
            <div class="mt-10 pt-4 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} <strong>JuaLaNs</strong>. All rights reserved. <br>
                All Images &copy; IKEA.
            </div>

        </footer>