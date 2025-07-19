<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Jualans</title>
    <link rel="icon" href="{{ asset('JuaLans.icon.png') }}" type="image/png" />
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Alpine.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar for zoom modal */
        #zoomImageModal .max-h-\[90vh\]::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        #zoomImageModal .max-h-\[90vh\]::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        #zoomImageModal .max-h-\[90vh\]::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        #zoomImageModal .max-h-\[90vh\]::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-inter antialiased">

<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
        @if (session('success'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition:leave="transition ease-in duration-700"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                class="mb-4 px-4 py-3 bg-green-100 text-green-800 border border-green-300 rounded shadow text-center"
            >
                {{ session('success') }}
            </div>
        @endif

        <!-- Search Form -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <form method="GET" action="{{ route('product.index') }}" class="flex flex-1 items-center gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari produk..."
                    class="w-full sm:w-90 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300"
                >
                <button type="submit"
                    class="bg-gray-700 hover:bg-gray-500 text-white px-4 py-2 rounded-lg transition">
                    Cari
                </button>
            </form>
            <a href="{{ route('dashboard') }}" class="inline-block bg-gradient-to-r bg-blue-800 text-white hover:bg-blue-600 px-4 py-2 rounded-lg shadow-md font-medium transition-transform duration-300">
                Dashboard
            </a>
        </div>

        <!-- Slider Papan Iklan -->
        <div
            x-data="{
                activeSlide: 0,
                slides:
                [
                    { image: '/banner1.jpg', title: 'Diskon Besar!', subtitle: 'Hanya hari ini. Jangan lewatkan.' },
                    { image: '/banner2.jpg', title: 'Produk Terbaru', subtitle: 'Tersedia sekarang dengan harga terbaik.' },
                    { image: '/banner3.jpg', title: 'Beli 2 Gratis 1', subtitle: 'Nikmati penawaran spesial hanya minggu ini.' },
                    { image: '/banner4.jpg', title: 'Flash Sale Spesial', subtitle: 'Diskon hingga 70% untuk produk pilihan.' },
                    { image: '/banner5.jpg', title: 'Voucher Eksklusif', subtitle: 'Dapatkan voucher hanya di aplikasi kami.' }
                ],
                init() {
                    setInterval(() => {
                        this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                    }, 5000);
                }
            }"
            class="relative w-full h-64 sm:h-80 rounded-xl overflow-hidden mb-10 shadow-lg"
        >
            <template x-for="(slide, index) in slides" :key="index">
                <div
                    x-show="activeSlide === index"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 translate-x-full"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-700"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-full"
                    class="absolute inset-0 w-full h-full"
                >
                    <img :src="slide.image" class="w-full h-full object-cover" alt="Slide">
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center text-white text-center px-4">
                        <h2 class="text-2xl sm:text-3xl font-bold" x-text="slide.title"></h2>
                        <p class="mt-1 text-sm sm:text-base" x-text="slide.subtitle"></p>
                    </div>
                </div>
            </template>

            <div class="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex gap-2">
                <template x-for="(slide, index) in slides" :key="index">
                    <!-- <button
                        @click="activeSlide = index"
                        :class="activeSlide === index ? 'bg-white' : 'bg-gray-400'"
                        class="w-3 h-3 rounded-full transition"
                    ></button> -->
                </template>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $item) {{-- Pastikan ini $products (plural) --}}
                <div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col transition transform hover:scale-105 duration-300">
                    <div class="w-full mt-3 h-48 bg-white flex items-center justify-center relative group overflow-hidden">
                        <!-- Gambar Produk -->
                        <img
                            onclick="openModal({{ $item->id }}, 'detail')"
                            src="{{ asset('storage/' . $item->foto) }}" {{-- Gunakan asset() untuk storage --}}
                            alt="Foto Produk"
                            class="max-h-full max-w-full object-contain transition duration-300 ease-in-out group-hover:blur-[1px] cursor-pointer"
                        >

                        <!-- Overlay Blur + Ikon Mata + Tulisan -->
                        <div
                            class="absolute inset-0 rounded-t-lg bg-black bg-opacity-40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer"
                            onclick="openModal({{ $item->id }}, 'detail')"
                        >
                            <!-- Ikon Mata -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white mb-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <!-- Tulisan Lihat Detail -->
                            <p class="text-white text-sm font-semibold">Lihat Detail</p>
                        </div>
                    </div>

                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-lg font-bold text-gray-800 mb-1">{{ $item->nama }}</p>
                        <p class="text-yellow-600 font-semibold mb-1">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        <p class="text-gray-600 text-sm flex-1">{{ $item->deskripsi }}</p>

                        <div class="pt-2">
                            <button onclick="openModal({{ $item->id }}, 'beli')"
                                class="bg-blue-800 hover:bg-blue-600 text-white py-2 px-4 rounded w-full text-center transition">
                                Beli
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500">Produk tidak ditemukan.</div>
            @endforelse
        </div>

        {{-- Tambahkan link paginasi jika menggunakan paginate() di controller --}}
        <div class="mt-8">
            {{ $products->links() }}
        </div>

    </div>

    <!-- Modal Detail & Beli -->
    <div id="buyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl p-6 relative">
            <button onclick="closeModal()" class="absolute top-3 right-4 text-gray-600 hover:text-red-600 text-3xl font-bold">&times;</button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="relative text-center">
                        <p class="text-sm text-gray-500 mb-2">Klik gambar untuk melihat lebih besar</p>
                        <img id="modalImage" src="" alt="Produk"
                            onclick="zoomImage()"
                            class="cursor-zoom-in w-full h-64 object-contain bg-gray-100 rounded transition duration-300 hover:scale-105">
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2" id="modalTitle">Detail Produk</h2>
                    <p class="text-yellow-600 text-xl font-semibold mb-2" id="modalPrice"></p>
                    <p class="text-gray-700 mb-4 text-justify" id="modalDesc"></p>

                    <div id="buyFormSection">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" id="modalProductId">

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Nama Pembeli</label>
                                <input type="text" name="nama_pembeli" required class="mt-1 p-2 w-full border rounded focus:ring focus:border-blue-300">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                <input type="text" name="alamat" required class="mt-1 p-2 w-full border rounded focus:ring focus:border-blue-300">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <input type="number" name="no_hp" required class="mt-1 p-2 w-full border rounded focus:ring focus:border-blue-300">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                                <input type="number" name="jumlah" min="1" value="1" required class="mt-1 p-2 w-full border rounded focus:ring focus:border-blue-300">
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-800 hover:bg-blue-600 text-white py-3 rounded text-lg transition">
                                Masukkan Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="zoomImageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50 p-4">
        <div class="relative max-w-4xl w-full max-h-[90vh] overflow-auto">
            <button onclick="closeZoomImage()" class="absolute top-3 right-4 text-red-700 hover:text-red-600 text-4xl font-bold">&times;</button>
            <img id="zoomedImage" src="" class="w-full h-auto object-contain rounded-lg shadow-lg cursor-zoom-out">
        </div>
    </div>

</x-app-layout>

{{-- Footer utama aplikasi, diletakkan di luar x-app-layout jika x-app-layout tidak menyertakannya --}}
<footer class=" bg-blue-800 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <div>
            <a href="{{ route('dashboard') }}" class="inline-block">
                <img src="{{ url('FaRs_logo.png') }}" alt="FaRs Logo" class="h-10 md:h-14 object-contain mb-3 mx-auto" />
            </a>
            <p class="text-sm text-gray-300">
                Platform jual beli produk pilihan terbaik dengan layanan terpercaya dan responsif.
            </p>
        </div>
        <div>
            <h4 class="text-lg font-semibold mb-2">Navigasi</h4>
            <ul class="space-y-1 text-sm text-gray-300">
                <li><a href="{{ route('dashboard') }}" class="hover:underline">Beranda</a></li>
                <li><a href="{{ route('product.index') }}" class="hover:underline">Produk</a></li>
                <li><a href="#" class="hover:underline">Kontak</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-lg font-semibold mb-2">Komponen</h4>
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

<script>
    // Data produk dari backend ke frontend (pastikan ini ada di view)
    // PENTING: Akses data produk melalui properti 'data' dari objek paginator
    const productsData = @json($products->items()); // Mengambil hanya item dari paginator

    function openModal(id, mode) {
        const modal = document.getElementById('buyModal');
        const buyFormSection = document.getElementById('buyFormSection');

        // PERBAIKAN DI SINI: Cari produk di dalam productsData (yang sudah berupa array)
        const product = productsData.find(p => p.id === id);
        if (!product) {
            console.error('Produk dengan ID ' + id + ' tidak ditemukan di data JavaScript.');
            alert('Produk tidak ditemukan. Mungkin ada masalah dalam memuat data.'); // Ganti alert dengan UI yang lebih baik
            return;
        }

        document.getElementById('modalTitle').textContent = product.nama;
        document.getElementById('modalPrice').textContent = 'Rp ' + Number(product.harga).toLocaleString('id-ID');
        document.getElementById('modalDesc').textContent = product.deskripsi;
        document.getElementById('modalImage').src = `/storage/${product.foto}`; // Pastikan path benar
        document.getElementById('modalProductId').value = product.id;

        if (mode === 'beli') {
            buyFormSection.style.display = 'block';
        } else {
            buyFormSection.style.display = 'none';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('buyModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        closeZoomImage(); // Pastikan modal zoom juga tertutup
    }

    function zoomImage() {
        const src = document.getElementById('modalImage').src;
        const zoomModal = document.getElementById('zoomImageModal');
        const zoomedImage = document.getElementById('zoomedImage');

        zoomedImage.src = src;
        zoomModal.classList.remove('hidden');
        zoomModal.classList.add('flex');
    }

    function closeZoomImage() {
        const zoomModal = document.getElementById('zoomImageModal');
        zoomModal.classList.add('hidden');
        zoomModal.classList.remove('flex');
    }
</script>

<a id="openChatbotButton"
   class="fixed bottom-6 right-6 z-50 bg-blue-800 hover:bg-blue-600 text-white p-3 rounded-full shadow-lg transition duration-300 hover:scale-110 cursor-pointer animate-bounce-custom border-2 border-white"
   title="Buka Chatbot AI">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
    </svg>
</a>

<div id="chatbotContainer"
     class="fixed bottom-24 right-6 w-80 bg-white rounded-xl shadow-2xl z-50 flex flex-col transform scale-0 opacity-0 transition-all duration-300 ease-out-back origin-bottom-right"
     style="display: none;">
    <div class="bg-gradient-to-r from-blue-800 to-blue-600 text-white p-4 rounded-t-xl flex justify-between items-center shadow-md hover:from-blue-700 hover:to-blue-500 transition-colors duration-200 cursor-pointer">
        <h4 class="font-bold text-xl flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            Asisten JuaLaNs
        </h4>
        <button id="closeChatbotButton" class="text-white hover:text-gray-200 text-3xl leading-none font-light opacity-80 hover:opacity-100 transition-opacity">&times;</button>
    </div>
    <div id="chatbotMessages" class="flex-grow p-4 overflow-y-auto h-64 bg-gray-50 border-b border-gray-200 custom-scrollbar">
        </div>
    <div id="quickRepliesContainer" class="p-3 bg-gray-100 border-t border-gray-200 flex flex-wrap gap-2 justify-center hidden">
        </div>
    <div class="p-3 flex items-center bg-white border-t border-gray-100">
        <input type="text" id="chatbotInput" placeholder="Ketik pesan Anda..." class="flex-grow border border-gray-300 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 mr-2">
        <button id="chatbotSendButton" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md transform hover:scale-105 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l.684-.282m3.541-1.353L9.04 15.532A1.5 1.5 0 0010.166 17h1.472a1.5 1.5 0 001.38-2.228l-.348-.711m-9.697 1.411A1 1 0 006 17h1.472a1.5 1.5 0 001.38-2.228l-.348-.711m9.697 1.411A1 1 0 0014 17h1.472a1.5 1.5 0 001.38-2.228l-.348-.711" />
            </svg>
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const openChatbotButton = document.getElementById('openChatbotButton');
        const closeChatbotButton = document.getElementById('closeChatbotButton');
        const chatbotContainer = document.getElementById('chatbotContainer');
        const chatbotMessages = document.getElementById('chatbotMessages');
        const chatbotInput = document.getElementById('chatbotInput');
        const chatbotSendButton = document.getElementById('chatbotSendButton');
        const quickRepliesContainer = document.getElementById('quickRepliesContainer');

        // Fungsi untuk menampilkan pesan bot
        function displayBotMessage(message, replies = []) {
            const botMessageDiv = document.createElement('div');
            botMessageDiv.className = 'bg-gray-200 text-gray-800 p-3 rounded-xl rounded-bl-none shadow-sm mb-3 max-w-[85%] self-start animate-fade-in-up';
            botMessageDiv.textContent = message;
            chatbotMessages.appendChild(botMessageDiv);

            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;

            // Clear previous quick replies
            quickRepliesContainer.innerHTML = '';
            if (replies.length > 0) {
                quickRepliesContainer.classList.remove('hidden');
                replies.forEach(reply => {
                    const button = document.createElement('button');
                    button.className = 'bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded-full text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500';
                    button.textContent = reply;
                    button.onclick = () => handleQuickReply(reply);
                    quickRepliesContainer.appendChild(button);
                });
            } else {
                quickRepliesContainer.classList.add('hidden');
            }
        }

        // Fungsi untuk menampilkan pesan pengguna
        function displayUserMessage(message) {
            const userMessageDiv = document.createElement('div');
            userMessageDiv.className = 'bg-blue-600 text-white p-3 rounded-xl rounded-br-none shadow-sm mb-3 max-w-[85%] self-end animate-fade-in-up';
            userMessageDiv.textContent = message;
            chatbotMessages.appendChild(userMessageDiv);
            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        }

        // Fungsi untuk menangani balasan bot yang lebih kompleks
        function getBotResponse(message) {
            const lowerCaseMessage = message.toLowerCase();
            let response = { text: "Maaf, saya belum mengerti. Bisakah Anda lebih spesifik atau pilih opsi di bawah? 🤔", replies: [] };

            if (lowerCaseMessage.includes("halo") || lowerCaseMessage.includes("hai")) {
                response.text = "Halo! Senang bisa membantu. Ada yang bisa saya bantu hari ini? ✨";
                response.replies = ["Lihat Produk", "Status Pesanan", "Bantuan Umum", "Kontak Admin"];
            } else if (lowerCaseMessage.includes("produk") || lowerCaseMessage.includes("barang")) {
                response.text = "Tentu! Anda bisa melihat semua produk kami di halaman 'Lihat Produk'. Kami punya banyak pilihan menarik! 🛍️";
                response.replies = ["Cara Beli", "Produk Terbaru", "Promosi"];
            } else if (lowerCaseMessage.includes("harga")) {
                response.text = "Harga setiap produk tertera jelas di halaman produk masing-masing. Harga di keranjang belanja juga akan otomatis terupdate. 💰";
                response.replies = ["Ada Diskon?", "Metode Pembayaran"];
            } else if (lowerCaseMessage.includes("servis") || lowerCaseMessage.includes("layanan purna jual") || lowerCaseMessage.includes("garansi")) {
                response.text = "Untuk pertanyaan layanan purna jual, garansi, atau perbaikan, silakan hubungi tim dukungan kami. Mereka siap membantu! 🛠️";
                response.replies = ["Nomor Kontak", "Jam Operasional Servis"];
            } else if (lowerCaseMessage.includes("beli") || lowerCaseMessage.includes("cara order")) {
                response.text = "Mudah sekali! Anda bisa menambahkan produk ke keranjang dari halaman produk, lalu ikuti langkah-langkah di halaman checkout. 🛒";
                response.replies = ["Metode Pembayaran", "Biaya Kirim"];
            } else if (lowerCaseMessage.includes("lokasi") || lowerCaseMessage.includes("alamat")) {
                response.text = "JuaLaNs adalah toko online, jadi kami tidak punya lokasi fisik. Kami melayani pengiriman ke seluruh Indonesia! Di mana pun Anda berada, kami siap kirim. 📦";
                response.replies = ["Jangkauan Pengiriman"];
            } else if (lowerCaseMessage.includes("pembayaran") || lowerCaseMessage.includes("bayar")) {
                response.text = "Kami menerima berbagai metode pembayaran seperti transfer bank (BCA, Mandiri), e-wallet (OVO, GoPay), dan kartu kredit. Pilih yang paling nyaman untuk Anda! 💳";
                response.replies = ["Konfirmasi Pembayaran", "Masalah Pembayaran"];
            } else if (lowerCaseMessage.includes("diskon") || lowerCaseMessage.includes("promo")) {
                response.text = "Ya, kami sering ada promo menarik! Cek halaman 'Promosi' atau bagian banner di halaman utama kami untuk penawaran terbaru. Jangan sampai ketinggalan! 🎉";
                response.replies = ["Syarat & Ketentuan Promo"];
            } else if (lowerCaseMessage.includes("status pesanan") || lowerCaseMessage.includes("kiriman")) {
                response.text = "Untuk cek status pesanan, mohon masukkan nomor pesanan Anda. Jika belum ada nomor pesanan, Anda bisa lihat riwayat pembelian di akun Anda. 🚚";
                response.replies = ["Lacak Pesanan", "Pengiriman Lama"];
            } else if (lowerCaseMessage.includes("kontak") || lowerCaseMessage.includes("admin")) {
                response.text = "Anda bisa menghubungi admin kami melalui email di support@jualans.com atau via telepon di +6281234567890 selama jam kerja. Kami siap membantu! 🧑‍💻";
                response.replies = ["Jam Operasional", "Tulis Email"];
            }
            // Add more complex responses as needed
            // Example for specific product query (requires more sophisticated parsing or a real AI)
            else if (lowerCaseMessage.includes("xiaomi") && lowerCaseMessage.includes("redmi note")) {
                response.text = "Ah, Xiaomi Redmi Note! Seri ini sangat populer. Model spesifik mana yang Anda cari? Kami punya beberapa varian. 📱";
                response.replies = ["Redmi Note 12", "Redmi Note 13"];
            } else if (lowerCaseMessage.includes("redmi note 13")) {
                response.text = "Xiaomi Redmi Note 13 adalah pilihan tepat! Harganya mulai dari Rp 2.500.000. Fitur utamanya: Kamera 108MP, layar AMOLED 120Hz, dan baterai 5000mAh. Tertarik? ✨";
                response.replies = ["Lihat Detail Redmi Note 13", "Beli Sekarang Redmi Note 13"];
            }
            return response;
        }

        // Fungsi untuk mengirim pesan (saat tombol Kirim atau Enter ditekan)
        function sendMessage() {
            const messageText = chatbotInput.value.trim();
            if (messageText === '') return;

            displayUserMessage(messageText);
            chatbotInput.value = ''; // Kosongkan input
            chatbotInput.focus();

            // Simulate bot typing
            setTimeout(() => {
                const botResponse = getBotResponse(messageText);
                displayBotMessage(botResponse.text, botResponse.replies);
            }, 700);
        }

        // Fungsi untuk menangani klik tombol quick reply
        function handleQuickReply(replyText) {
            displayUserMessage(replyText);
            // Simulate bot typing
            setTimeout(() => {
                const botResponse = getBotResponse(replyText);
                displayBotMessage(botResponse.text, botResponse.replies);
            }, 700);
        }

        // --- Event Listeners ---
        openChatbotButton.addEventListener('click', function() {
            chatbotContainer.style.display = 'flex'; // Ubah dari none ke flex agar transisi bisa berjalan
            setTimeout(() => {
                chatbotContainer.classList.remove('scale-0', 'opacity-0');
                chatbotContainer.classList.add('scale-100', 'opacity-100');
                chatbotInput.focus();
                // Display initial welcome message with quick replies when chatbot opens
                if (chatbotMessages.children.length === 0) { // Only show initial message if chat is empty
                    displayBotMessage("Halo! Saya Asisten JuaLaNs. Ada yang bisa saya bantu hari ini? 💬", ["Lihat Produk", "Status Pesanan", "Bantuan Umum"]);
                }
            }, 10);
        });

        closeChatbotButton.addEventListener('click', function() {
            chatbotContainer.classList.remove('scale-100', 'opacity-100');
            chatbotContainer.classList.add('scale-0', 'opacity-0');
            setTimeout(() => {
                chatbotContainer.style.display = 'none';
            }, 300);
        });

        chatbotSendButton.addEventListener('click', sendMessage);
        chatbotInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    });
</script>

<style>
    /* Custom Scrollbar for Chatbot Messages */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Custom Animation for Bounce on the Button */
    @keyframes bounce-custom {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-8px);
        }
    }
    .animate-bounce-custom {
        animation: bounce-custom 1.5s infinite ease-in-out;
    }

    /* Ease-out-back timing function for more dynamic pop-up */
    .ease-out-back {
        transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    /* New: Fade In Up Animation for chat messages */
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.3s ease-out forwards;
    }

    /* Adjust container border-radius for full modern look */
    #chatbotContainer {
        border-radius: 1rem; /* rounded-xl in Tailwind */
    }
    /* Ensure header also has rounded corners only at top */
    #chatbotContainer .bg-gradient-to-r {
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }
</style>

</body>
</html>
