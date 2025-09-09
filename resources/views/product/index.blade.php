<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Jualans</title>
    <link rel="icon" href="{{ asset('JuaLans.icon.png') }}" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

        /* --- CSS untuk Animasi Fade In On Scroll --- */
        .fade-in-section {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        
        .fade-in-section.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-inter antialiased">

<x-app-layout>
    <div class="mt-24 max-w-7xl mx-auto sm:px-6 lg:px-8 ">
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

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 f">
            <form method="GET" action="{{ route('product.index') }}" class="flex flex-1 items-center gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    id="search-input"
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
            class="relative w-full h-64 sm:h-80 rounded-xl overflow-hidden mb-10 shadow-lg fade-in-section"
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
                    </template>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 fade-in-section">
            @forelse($products as $item)
                <div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col transition transform hover:scale-105 duration-300">
                    <div class="w-full mt-3 h-48 bg-white flex items-center justify-center relative group overflow-hidden">
                        <img
                            onclick="openModal({{ $item->id }}, 'detail')"
                            src="{{ asset('storage/' . $item->foto) }}"
                            alt="Foto Produk"
                            class="max-h-full max-w-full object-contain transition duration-300 ease-in-out group-hover:blur-[1px] cursor-pointer"
                        >
                        <div
                            class="absolute inset-0 rounded-t-lg bg-black bg-opacity-40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer"
                            onclick="openModal({{ $item->id }}, 'detail')"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white mb-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <p class="text-white text-sm font-semibold">Lihat Detail</p>
                        </div>
                    </div>

                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-lg font-bold text-gray-800 mb-1">{{ $item->nama }}</p>
                        <p class="text-blue-600 font-semibold mb-1">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        <p class="text-gray-600 text-sm flex-1">{{ $item->deskripsi }}</p>

                        <div class="pt-2">
                            <button onclick="openModal({{ $item->id }}, 'beli')"
                                class="bg-blue-800 hover:bg-blue-600 text-white py-2 px-4 rounded w-full text-center transition">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500">Produk tidak ditemukan.</div>
            @endforelse
        </div>

        {{-- Tambahkan link paginasi jika menggunakan paginate() di controller --}}
        <div class="mt-8 fade-in-section">
            {{ $products->links() }}
        </div>
    </div>

    <div id="buyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl p-6 relative">
            <button onclick="closeModal()" class="absolute top-3 right-4 text-gray-600 hover:text-red-600 text-3xl font-bold">&times;</button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="relative text-center">
                        <p class="text-sm text-gray-500 mb-2">Klik gambar untuk melihat lebih besar</p>
                        <img id="modalImage" src="" alt="Produk"
                            onclick="zoomImage()"
                            class="cursor-zoom-in w-full h-64 object-contain bg-white rounded transition duration-300 hover:scale-105">
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
            let response = { text: "Maaf, saya belum mengerti. Bisakah Anda lebih spesifik atau pilih opsi di bawah ini? 🤔", replies: [] };

            // --- Sapaan dan Pembuka ---
            if (lowerCaseMessage.includes("halo") || lowerCaseMessage.includes("hai") || lowerCaseMessage.includes("selamat") || lowerCaseMessage.includes("pagi") || lowerCaseMessage.includes("siang") || lowerCaseMessage.includes("sore") || lowerCaseMessage.includes("malam")) {
                response.text = "Halo! 👋 Senang bisa membantu Anda. Ada yang bisa saya bantu hari ini? ✨";
                response.replies = ["Lihat Produk", "Status Pesanan", "Bantuan Umum", "Kontak Admin"];
            } else if (lowerCaseMessage.includes("terima kasih") || lowerCaseMessage.includes("makasih")) {
                response.text = "Sama-sama! 😊 Ada hal lain yang bisa saya bantu?";
                response.replies = ["Kembali ke Menu Utama", "Tutup Chat"];
            } else if (lowerCaseMessage.includes("apa kabar")) {
                response.text = "Saya bot yang baik-baik saja, siap melayani Anda! Bagaimana dengan Anda? 😊";
                response.replies = ["Lihat Produk", "Bantuan Umum"];
            }

            // --- Informasi Produk ---
            else if (lowerCaseMessage.includes("produk") || lowerCaseMessage.includes("barang") || lowerCaseMessage.includes("katalog")) {
                response.text = "Tentu! Anda bisa melihat semua produk kami di halaman 'Lihat Produk'. Kami punya banyak pilihan menarik dari berbagai kategori! 🛍️";
                response.replies = ["Cara Beli Produk", "Produk Terbaru", "Kategori Produk", "Promosi"];
            } else if (lowerCaseMessage.includes("harga")) {
                response.text = "Harga setiap produk tertera jelas di halaman produk masing-masing. Harga di keranjang belanja juga akan otomatis terupdate. Apakah Anda mencari informasi harga untuk produk tertentu? 💰";
                response.replies = ["Ada Diskon?", "Metode Pembayaran"];
            } else if (lowerCaseMessage.includes("spesifikasi") || lowerCaseMessage.includes("detail produk")) {
                response.text = "Untuk detail dan spesifikasi lengkap produk, silakan kunjungi halaman produk yang bersangkutan. Biasanya kami menyertakan semua informasi teknis di sana. 🔍";
                response.replies = ["Cari Produk", "Cara Cek Spesifikasi"];
            } else if (lowerCaseMessage.includes("stok") || lowerCaseMessage.includes("ketersediaan")) {
                response.text = "Ketersediaan stok produk tertera di halaman produk masing-masing. Jika tertulis 'Stok Habis' atau 'Pre-order', artinya produk tersebut sedang tidak tersedia atau dalam proses restock. 📦";
                response.replies = ["Notifikasi Stok", "Produk Rekomendasi"];
            } else if (lowerCaseMessage.includes("ulasan") || lowerCaseMessage.includes("review")) {
                response.text = "Anda bisa melihat ulasan produk dari pembeli lain di bagian bawah halaman setiap produk. Ulasan membantu Anda membuat keputusan yang lebih baik! ⭐";
                response.replies = ["Cara Memberi Ulasan", "Ulasan Terbaik"];
            }

            // --- Proses Pembelian ---
            else if (lowerCaseMessage.includes("beli") || lowerCaseMessage.includes("cara order") || lowerCaseMessage.includes("pesan")) {
                response.text = "Mudah sekali! 🛒 Cukup tambahkan produk yang Anda inginkan ke keranjang, lalu klik 'Checkout' dan ikuti langkah-langkah pembayaran hingga selesai. Prosesnya cepat dan aman.";
                response.replies = ["Metode Pembayaran", "Biaya Kirim", "Registrasi Akun"];
            } else if (lowerCaseMessage.includes("keranjang") || lowerCaseMessage.includes("masuk keranjang")) {
                response.text = "Produk yang sudah Anda tambahkan bisa dilihat di ikon keranjang belanja Anda di pojok kanan atas. Dari sana, Anda bisa mengatur jumlah atau melanjutkan ke pembayaran. 🛒";
                response.replies = ["Checkout", "Hapus Produk dari Keranjang"];
            } else if (lowerCaseMessage.includes("pembayaran") || lowerCaseMessage.includes("bayar") || lowerCaseMessage.includes("transfer")) {
                response.text = "Kami menerima berbagai metode pembayaran yang nyaman untuk Anda: Transfer Bank (BCA, Mandiri), E-wallet (OVO, GoPay, Dana), dan Kartu Kredit/Debit (Visa, Mastercard). 💳";
                response.replies = ["Konfirmasi Pembayaran", "Masalah Pembayaran", "Cicilan"];
            } else if (lowerCaseMessage.includes("konfirmasi pembayaran")) {
                response.text = "Setelah melakukan pembayaran, biasanya sistem kami akan otomatis mendeteksinya. Jika dalam 1x24 jam pesanan belum terupdate, Anda bisa konfirmasi manual di halaman 'Status Pesanan' dengan menyertakan bukti transfer. ✅";
                response.replies = ["Cek Status Pembayaran", "Hubungi Dukungan Pembayaran"];
            } else if (lowerCaseMessage.includes("cicilan") || lowerCaseMessage.includes("kredit")) {
                response.text = "Kami menyediakan opsi cicilan melalui mitra penyedia layanan finansial tertentu. Informasi lebih lanjut dan syarat & ketentuan bisa Anda lihat di halaman metode pembayaran. 📑";
                response.replies = ["Mitra Cicilan", "Simulasi Cicilan"];
            }

            // --- Pengiriman dan Status Pesanan ---
            else if (lowerCaseMessage.includes("status pesanan") || lowerCaseMessage.includes("kirim") || lowerCaseMessage.includes("dikirim")) {
                response.text = "Untuk cek status pesanan Anda, mohon masukkan **nomor pesanan** Anda. Jika Anda sudah login, Anda juga bisa melihat riwayat pembelian di dashboard akun Anda. 🚚";
                response.replies = ["Lacak Pesanan", "Kapan Dikirim?", "Pengiriman Lama"];
            } else if (lowerCaseMessage.includes("lacak pesanan") || lowerCaseMessage.includes("tracking")) {
                response.text = "Silakan masukkan nomor resi atau nomor pesanan Anda untuk melacak posisi paket Anda secara real-time. Tracking bisa dilihat di halaman Status Pesanan. 📍";
                response.replies = ["Nomor Resi Hilang", "Estimasi Waktu Tiba"];
            } else if (lowerCaseMessage.includes("biaya kirim") || lowerCaseMessage.includes("ongkir")) {
                response.text = "Biaya pengiriman dihitung berdasarkan lokasi tujuan dan berat/volume produk. Anda bisa melihat estimasi biaya kirim saat proses checkout sebelum pembayaran. 💲";
                response.replies = ["Jangkauan Pengiriman", "Kurir yang Digunakan"];
            } else if (lowerCaseMessage.includes("kurir") || lowerCaseMessage.includes("ekspedisi")) {
                response.text = "Kami bekerja sama dengan berbagai jasa pengiriman terpercaya seperti JNE, J&T, SiCepat, dan Pos Indonesia untuk memastikan pesanan Anda sampai dengan aman dan cepat. 🚚💨";
                response.replies = ["Ganti Kurir", "Pengiriman Instan"];
            } else if (lowerCaseMessage.includes("pengiriman lama") || lowerCaseMessage.includes("belum sampai")) {
                response.text = "Mohon maaf atas ketidaknyamanan ini. 🙏 Terkadang ada kendala di luar dugaan. Silakan cek status pesanan Anda dengan nomor resi. Jika masih terkendala, hubungi customer service kami. ";
                response.replies = ["Hubungi CS Pengiriman", "Ajukan Komplain"];
            } else if (lowerCaseMessage.includes("jangkauan pengiriman") || lowerCaseMessage.includes("kirim ke mana")) {
                response.text = "Kami melayani pengiriman ke seluruh wilayah Indonesia! Dari Sabang sampai Merauke, kami siap kirim pesanan Anda. 🇮🇩";
                response.replies = ["Estimasi Waktu Pengiriman", "Pengiriman Internasional"];
            }

            // --- Pengembalian & Penukaran ---
            else if (lowerCaseMessage.includes("retur") || lowerCaseMessage.includes("kembali barang") || lowerCaseMessage.includes("pengembalian")) {
                response.text = "Untuk proses pengembalian barang, pastikan produk masih dalam kondisi baik dan sesuai Syarat & Ketentuan retur kami. Anda bisa mengajukan permohonan retur di halaman Riwayat Pesanan Anda. ↩️";
                response.replies = ["Syarat Retur", "Status Retur"];
            } else if (lowerCaseMessage.includes("tukar barang") || lowerCaseMessage.includes("penukaran")) {
                response.text = "Penukaran barang bisa dilakukan jika ada kesalahan pengiriman dari pihak kami atau cacat produk. Silakan ajukan permohonan penukaran melalui halaman Riwayat Pesanan Anda. 🔄";
                response.replies = ["Syarat Penukaran", "Produk Tidak Sesuai"];
            } else if (lowerCaseMessage.includes("refund") || lowerCaseMessage.includes("dana kembali")) {
                response.text = "Proses refund akan dilakukan setelah barang retur kami terima dan diverifikasi. Dana akan dikembalikan sesuai metode pembayaran awal atau ke rekening Anda. Waktu proses bisa bervariasi. 💸";
                response.replies = ["Berapa Lama Refund?", "Metode Refund"];
            }

            // --- Akun & Keamanan ---
            else if (lowerCaseMessage.includes("akun") || lowerCaseMessage.includes("registrasi") || lowerCaseMessage.includes("daftar")) {
                response.text = "Membuat akun sangat mudah! Cukup klik 'Daftar' di pojok kanan atas, lalu isi data diri Anda. Dengan akun, Anda bisa melacak pesanan dan mendapatkan promo eksklusif. 👤";
                response.replies = ["Lupa Password", "Manfaat Akun"];
            } else if (lowerCaseMessage.includes("lupa password") || lowerCaseMessage.includes("reset password")) {
                response.text = "Jangan khawatir! Klik 'Lupa Password' di halaman login, masukkan email Anda, dan kami akan kirim link untuk reset password Anda. 🔑";
                response.replies = ["Ganti Email Akun", "Masalah Login"];
            } else if (lowerCaseMessage.includes("keamanan akun") || lowerCaseMessage.includes("data pribadi")) {
                response.text = "Keamanan data Anda adalah prioritas kami. JuaLaNs menggunakan enkripsi dan sistem keamanan terkini untuk melindungi informasi pribadi dan transaksi Anda.🔒";
                response.replies = ["Kebijakan Privasi", "Verifikasi 2 Langkah"];
            }

            // --- Promosi & Diskon ---
            else if (lowerCaseMessage.includes("diskon") || lowerCaseMessage.includes("promo") || lowerCaseMessage.includes("voucher")) {
                response.text = "Ya, kami sering ada promo menarik! Cek halaman 'Promosi' atau bagian banner di halaman utama kami untuk penawaran terbaru. Jangan sampai ketinggalan kesempatan! 🎉";
                response.replies = ["Syarat & Ketentuan Promo", "Cara Pakai Voucher"];
            } else if (lowerCaseMessage.includes("kode promo") || lowerCaseMessage.includes("masukkan voucher")) {
                response.text = "Kode promo atau voucher bisa dimasukkan di halaman keranjang belanja atau halaman checkout sebelum Anda melakukan pembayaran. Pastikan kode sudah benar ya! 🎁";
                response.replies = ["Voucher Tidak Berlaku", "Promo Hari Ini"];
            }

            // --- Bantuan Umum & Kontak ---
            else if (lowerCaseMessage.includes("bantuan umum") || lowerCaseMessage.includes("tanya")) {
                response.text = "Silakan sampaikan pertanyaan Anda atau pilih dari topik bantuan umum yang sering ditanyakan. Kami siap membantu! 🙋‍♀️";
                response.replies = ["FAQ", "Hubungi Customer Service", "Tentang JuaLaNs"];
            } else if (lowerCaseMessage.includes("kontak") || lowerCaseMessage.includes("admin") || lowerCaseMessage.includes("customer service") || lowerCaseMessage.includes("cs")) {
                response.text = "Anda bisa menghubungi tim dukungan kami melalui: \n\n📧 Email: **support@jualans.com** \n📞 Telepon: **+6281234567890** (Jam Kerja: Senin-Jumat, 09.00-17.00 WITA) \n\nKami siap membantu Anda dengan senang hati! 🧑‍💻";
                response.replies = ["Jam Operasional", "Kirim Pesan Sekarang"];
            } else if (lowerCaseMessage.includes("jam operasional")) {
                response.text = "Tim Customer Service kami beroperasi dari hari **Senin hingga Jumat, pukul 09.00 - 17.00 WITA**. Kami akan berusaha membalas secepat mungkin di luar jam tersebut. ⏰";
                response.replies = ["Kontak Cepat", "Tulis Email"];
            } else if (lowerCaseMessage.includes("tentang jualans") || lowerCaseMessage.includes("siapa jualans")) {
                response.text = "JuaLaNs adalah platform e-commerce yang berdedikasi menyediakan berbagai produk berkualitas dengan harga kompetitif dan pengalaman belanja yang nyaman serta aman bagi Anda. Kami berkomitmen untuk kepuasan pelanggan! 🌟";
                response.replies = ["Visi & Misi", "Kebijakan Privasi"];
            } else if (lowerCaseMessage.includes("kebijakan privasi") || lowerCaseMessage.includes("privasi data")) {
                response.text = "Kebijakan privasi kami menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi data pribadi Anda. Anda bisa membacanya lengkap di halaman Kebijakan Privasi kami. 📄";
                response.replies = ["Keamanan Akun", "Syarat & Ketentuan"];
            } else if (lowerCaseMessage.includes("syarat dan ketentuan") || lowerCaseMessage.includes("ketentuan layanan")) {
                response.text = "Syarat dan Ketentuan layanan kami mengatur penggunaan platform JuaLaNs. Pastikan Anda membacanya untuk memahami hak dan kewajiban Anda sebagai pengguna. 📜";
                response.replies = ["Kebijakan Pengembalian", "Kebijakan Pengiriman"];
            }

            // --- Contoh Pertanyaan Spesifik Produk (Furniture) ---
            else if (lowerCaseMessage.includes("lemari") || lowerCaseMessage.includes("meja") || lowerCaseMessage.includes("kursi") || lowerCaseMessage.includes("furniture")) {
                response.text = "Anda mencari produk **furniture**? Kami punya berbagai pilihan lemari, meja, kursi, dan set ruang tamu. Furniture jenis apa yang menarik perhatian Anda? 🛋️";
                response.replies = ["Meja Makan", "Sofa Minimalis", "Lemari Pakaian", "Katalog Furniture"];
            } else if (lowerCaseMessage.includes("sofa minimalis")) {
                response.text = "**Sofa minimalis** adalah pilihan tepat untuk ruang keluarga Anda! Harganya mulai dari Rp 3.000.000. Fitur utamanya: Desain modern, bahan berkualitas, dan nyaman. Tertarik? ✨";
                response.replies = ["Lihat Detail Sofa Minimalis", "Beli Sekarang Sofa Minimalis", "Pilihan Warna Sofa"];
            } else if (lowerCaseMessage.includes("desain interior") || lowerCaseMessage.includes("dekorasi rumah")) {
                response.text = "Kami bisa bantu Anda menemukan **furniture** yang cocok dengan gaya desain interior atau dekorasi rumah Anda. Ceritakan lebih banyak tentang preferensi Anda! 🏡";
                response.replies = ["Furniture Modern", "Furniture Klasik", "Tips Dekorasi"];
            }

            // --- Default / Fallback Response ---
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

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const placeholders = [
            "Cari furnitur impianmu...",
            "Temukan sofa nyaman...",
            "Meja makan minimalis...",
            "Kursi kerja ergonomis...",
            "Lemari pakaian estetik..."
        ];
        let placeholderIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        let typingSpeed = 100; // Kecepatan ketik (ms per karakter)
        let deletingSpeed = 50; // Kecepatan hapus (ms per karakter)
        let delayBeforeTyping = 1500; // Jeda sebelum mulai mengetik placeholder baru (ms)
        let delayBeforeDeleting = 1000; // Jeda sebelum mulai menghapus (ms)

        function typePlaceholder() {
            const currentPlaceholder = placeholders[placeholderIndex];
            if (isDeleting) {
                // Menghapus karakter
                searchInput.setAttribute('placeholder', currentPlaceholder.substring(0, charIndex - 1));
                charIndex--;
                if (charIndex === 0) {
                    isDeleting = false;
                    placeholderIndex = (placeholderIndex + 1) % placeholders.length;
                    setTimeout(typePlaceholder, delayBeforeTyping);
                } else {
                    setTimeout(typePlaceholder, deletingSpeed);
                }
            } else {
                // Mengetik karakter
                searchInput.setAttribute('placeholder', currentPlaceholder.substring(0, charIndex + 1));
                charIndex++;
                if (charIndex === currentPlaceholder.length) {
                    isDeleting = true;
                    setTimeout(typePlaceholder, delayBeforeDeleting);
                } else {
                    setTimeout(typePlaceholder, typingSpeed);
                }
            }
        }

        // Mulai animasi saat halaman dimuat
        typePlaceholder();
    });
    function filterProductsByDropdown(categoryValue) {
        let currentUrl = new URL(window.location.href);

        // Hapus parameter 'page' agar filter selalu dimulai dari halaman pertama
        currentUrl.searchParams.delete('page');

        if (categoryValue === 'null' || categoryValue === '') {
            // Jika memilih "Semua Produk" atau nilai kosong, hapus parameter 'category'
            currentUrl.searchParams.delete('category');
        } else {
            // Atur parameter 'category' dengan nilai yang dipilih
            currentUrl.searchParams.set('category', categoryValue);
        }

        // Pertahankan parameter pencarian yang sudah ada (jika ada)
        let searchParam = currentUrl.searchParams.get('search');
        if (searchParam) {
            currentUrl.searchParams.set('search', searchParam);
        } else {
            currentUrl.searchParams.delete('search');
        }

        // Redirect ke URL yang baru
        window.location.href = currentUrl.toString();
    }

    // --- JavaScript untuk Animasi Fade In On Scroll (DITAMBAHKAN KEMBALI) ---
    const observerOptions = {
        root: null, // Menggunakan viewport sebagai root
        rootMargin: '0px',
        threshold: 0.1 // Memicu ketika 10% elemen terlihat
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Saat elemen masuk viewport, tambahkan kelas visible
                entry.target.classList.add('is-visible');
            } else {
                // Saat elemen keluar viewport, hapus kelas visible
                // Ini memungkinkan animasi untuk terpicu lagi saat di-scroll kembali
                entry.target.classList.remove('is-visible');
            }
        });
    }, observerOptions);

    const sections = document.querySelectorAll('.fade-in-section');
    sections.forEach(section => {
        observer.observe(section);
    });
</script>

<script src="https://kit.fontawesome.com/YOUR_KIT_ID.js" crossorigin="anonymous"></script>

</body>
</html> 