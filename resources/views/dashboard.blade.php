    <x-app-layout>
      <!-- Hero Carousel -->
      <section x-data="carousel()" x-init="start()" class="relative h-screen w-full overflow-hidden bg-gray-900 flex flex-col justify-between">
        <div class="absolute inset-0 z-0 flex transition-transform duration-[1000ms] ease-in-out" :style="`transform: translateX(-${currentIndex * 100}%);`">
          <template x-for="(image, index) in images" :key="index">
            <div class="min-w-full h-screen"><img :src="image" alt="Slide" class="w-full h-full object-cover" /></div>
          </template>
        </div>
        <div class="relative z-10 flex-1 flex flex-col justify-center items-center text-center px-4">
          <div class="max-w-4xl text-white animate__animated animate__fadeInDown">
            <img src="{{ url('FaRs_logo.png') }}" alt="Logo" class="h-12 md:h-24 mb-4 mx-auto" />
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">Selamat Datang</h1>
            <p class="text-lg md:text-2xl mb-6 max-w-2xl mx-auto">Temukan produk terbaik pilihan dengan harga bersahabat!</p>
    <form action="{{ route('dashboard') }}" method="GET" class="flex gap-2 w-full">
          <form action="{{ route('dashboard') }}" method="GET" class="flex gap-2 w-full">
<input
    type="text"
    name="search"
    id="search"
    class="flex-auto px-4 py-2 border border-white border-opacity-60
           bg-white bg-opacity-10 text-white
           rounded-xl shadow-md
           placeholder-white
           focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-80 focus:border-transparent
           transition-all duration-300 ease-in-out w-full"
    placeholder="Cari produk elegan..."
/>
        <button type="submit"
        aria-label="Cari"
        class="inline-flex items-center justify-center px-4 py-2
               bg-white bg-opacity-10 hover:bg-opacity-20 {{-- Increased hover opacity for better feedback --}}
               text-white border border-white border-opacity-50 {{-- Added explicit border opacity --}}
               rounded-lg shadow-sm
               transition duration-300 ease-in-out
               focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
    </svg>
    <span class="sr-only">Cari</span> {{-- For accessibility --}}
</button>
    </form>
          </div>
        </div>
      </section id="produk">
      <!-- Category & Search -->
      <section class="py-10 bg-gray-100">
        <div class="max-w-6xl mx-auto px-4">
          <h2 class="text-3xl font-bold text-center ">Produk andalan kami.</h2>
          <p class="text-center mb-5">kebutuhan rumah tangga hingga perkantoran.</p>
          <!-- <div class="flex flex-wrap justify-center gap-4 mb-5">
            @foreach(['Ruang Tamu','Ruang kerja','Kamar tidur'] as $cat)
              <button class="bg-white border border-gray-300 px-6 py-2 rounded-full shadow hover:bg-blue-100 transition">{{ $cat }}</button>
            @endforeach
          </div>  -->


      <!-- Product Grid -->
      <!-- <h2 class="text-3xl font-bold text-center ">Produk Unggulan</h2>
      <p class="text-center">Berikut adalah produk unggulan kami.</p> -->
      <div class="max-w-6xl mx-auto px-4 py-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          @forelse($product as $item)
            <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col hover:scale-105 transition">
              <div class="relative group h-48 flex items-center justify-center bg-white">
                <img onclick="openModal({{ $item->id }}, 'detail')" src="{{ url('storage/'.$item->foto) }}" alt="{{ $item->nama }}" class="object-contain max-h-full max-w-full transition-group duration-300 group-hover:blur-sm cursor-pointer" />
                <div onclick="openModal({{ $item->id }}, 'detail')" class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <!-- Ikon Mata -->
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
                <p class="text-yellow-600 font-semibold mb-1">Rp {{ number_format($item->harga,0,',','.') }}</p>
                <p class="text-gray-600 text-sm flex-1">{{ Str::limit($item->deskripsi, 100) }}</p>
                <!-- <button onclick="openModal({{ $item->id }}, 'beli')" class="mt-3 bg-blue-600 hover:bg-blue-500 text-white py-2 rounded w-full transition">Beli</button> -->
              </div>
            </div>
          @empty
            <h1 class="col-span-3 text-lg text-center text-gray-500 font-bold">Ups..</h1>
            <p class="col-span-3 text-center text-gray-500">Maaf produk yang kamu cari belum tersedia.</p>
          @endforelse
        </div>
      </div>
      <!-- Modal Detail / Beli -->
      <div id="buyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl p-6 relative overflow-auto max-h-full">
          <button onclick="closeModal()" class="absolute top-3 right-4 text-gray-600 hover:text-red-600 text-3xl font-bold">&times;</button>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <div class="text-center mb-2"><p class="text-sm text-gray-500">Klik gambar untuk zoom</p></div>
              <img id="modalImage" src="" alt="" class="cursor-zoom-in w-full h-64 object-contain bg-gray-100 rounded transition duration-300 hover:scale-105" onclick="zoomImage()" />
            </div>
            <div>
              <h2 id="modalTitle" class="text-2xl font-bold text-gray-800 mb-2"></h2>
              <p id="modalPrice" class="text-yellow-600 text-xl font-semibold mb-4"></p>
              <p id="modalDesc" class="text-gray-700 mb-6 text-justify"></p>
              <div id="buyFormSection">
                <form action="{{ route('cart.add') }}" method="POST">
                  @csrf
                  <input type="hidden" name="product_id" id="modalProductId" />
                  @foreach([['Nama Pembeli','nama_pembeli'],['Alamat','alamat'],['Nomor Telepon','no_hp'],['Jumlah','jumlah']] as $field)
                    <div class="mb-4">
                      <label class="block text-sm font-medium text-gray-700">{{ $field[0] }}</label>
                      <input type="{{ $field[1]=='no_hp'?'number':'text' }}" name="{{ $field[1] }}" required class="mt-1 p-2 w-full border rounded focus:ring focus:border-blue-300" value="{{ $field[1]=='jumlah'?'1':'' }}">
                    </div>
                  @endforeach
                  <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded text-lg transition">Masukkan Keranjang</button>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
      <!-- Zoom Modal -->
      <div id="zoomImageModal" class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50 p-4" onclick="closeZoomImage()">
        <img id="zoomedImage" src="" alt="Zoomed" class="max-w-full max-h-full" />
      </div>
      <div class="text-center ">
    <a href="/product" class=" mt-10 mb-10 left-4 bg-blue-800 border-2 border-white text-white hover:bg-blue-700 px-4 py-2 rounded-lg shadow-md font-medium transition-transform duration-300 z-50 cursor-pointer active:scale-95">
        Lihat semua produk.
    </a>
    </div>
        <!-- Slider Papan Iklan -->
      <section class=" rounded-xl mt-10">
        <div class="max-w-6xl mx-auto px-4">
          
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
                        }, 3000);
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
        </div>
      </section>
        </div>
      </section>
    <!-- Testimonials -->
    <section class="py-16  bg-gray-100" x-data="testimonialSlider()" x-init="start()">
      <div class="max-w-6xl mx-auto text-center px-4">
        <h2 class="text-4xl font-bold mb-10 text-gray-800">Apa Kata Pelanggan?</h2>

        <div class="grid md:grid-cols-2 gap-6 min-h-[240px] ">
          <template x-for="(testimonial, index) in visibleTestimonials" :key="index">
            <div
              x-transition:enter="transition ease-out duration-500"
              x-transition:enter-start="opacity-0 scale-95"
              x-transition:enter-end="opacity-100 scale-100"
              class="bg-white p-6 rounded-xl shadow-md border text-left flex flex-col gap-4"
            >
              <p class="text-gray-600 italic leading-relaxed" x-text="testimonial.text"></p>
              <div class="flex items-center gap-4 mt-auto">
                <img :src="testimonial.avatar" alt="avatar" class="w-12 h-12 rounded-full border" />
                <div>
                  <p class="text-blue-600 font-semibold" x-text="testimonial.author"></p>
                  <div class="flex text-yellow-400 text-sm">
                    <template x-for="n in 5">
                      <span x-html="n <= testimonial.rating ? '&#9733;' : '&#9734;'"></span>
                    </template>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </div>

        <!-- Bullet navigation -->
        <div class="flex justify-center mt-8 space-x-2">
          <template x-for="(group, index) in Math.ceil(testimonials.length / 2)" :key="index">
            <button
              class="w-3 h-3 rounded-full transition"
              :class="{
                'bg-blue-600': currentGroup === index,
                'bg-gray-300': currentGroup !== index
              }"
              @click="currentGroup = index"
            ></button>
          </template>
        </div>
      </div>
    </section>


              <!-- Ai bot -->
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

    </style>
      <!-- Scripts -->
      <script>
        function carousel(){
          return {
            currentIndex:0,
            images:["/slide1.png","/slide2.png","/slide3.png"],
            start(){setInterval(()=>this.currentIndex=(this.currentIndex+1)%this.images.length,4000)}
          }
        }
        const products=@json($product);
        function openModal(id,mode){
          const p=products.find(x=>x.id===id);
          if(!p)return alert('Produk tidak ditemukan');
          document.getElementById('modalTitle').textContent=p.nama;
          document.getElementById('modalPrice').textContent='Rp '+Number(p.harga).toLocaleString('id-ID');
          document.getElementById('modalDesc').textContent=p.deskripsi;
          document.getElementById('modalImage').src='/storage/'+p.foto;
          document.getElementById('modalProductId').value=p.id;
          document.getElementById('buyFormSection').style.display = mode==='beli'?'block':'none';
          document.getElementById('buyModal').classList.remove('hidden');document.getElementById('buyModal').classList.add('flex');
        }
        function closeModal(){document.getElementById('buyModal').classList.add('hidden');document.getElementById('buyModal').classList.remove('flex'); closeZoomImage();}
        function zoomImage(){const src=document.getElementById('modalImage').src;document.getElementById('zoomedImage').src=src; const m=document.getElementById('zoomImageModal');m.classList.remove('hidden');m.classList.add('flex');}
        function closeZoomImage(){document.getElementById('zoomImageModal').classList.add('hidden');document.getElementById('zoomImageModal').classList.remove('flex');

        }
    function testimonialSlider() {
        return {
          testimonials: [
            {
              text: "Pelayanan sangat ramah dan pengiriman cepat. Sangat puas!",
              author: "Dina Rahma",
              avatar: "https://i.pravatar.cc/60?img=1",
              rating: 5,
            },
            {
              text: "Produk sesuai deskripsi dan kualitasnya sangat bagus.",
              author: "Ardi Wijaya",
              avatar: "https://i.pravatar.cc/60?img=2",
              rating: 4,
            },
            {
              text: "Harga terjangkau dengan kualitas premium. Recommended!",
              author: "Ambas nino",
              avatar: "https://i.pravatar.cc/60?img=3",
              rating: 5,
            },
            {
              text: "Respon admin cepat dan sangat membantu. Mantap!",
              author: "Raka Nugroho",
              avatar: "https://i.pravatar.cc/60?img=4",
              rating: 4,
            },
            {
              text: "Website ini sangat mudah digunakan. Proses checkout cepat!",
              author: "Yuni Marlina",
              avatar: "https://i.pravatar.cc/60?img=5",
              rating: 5,
            },
            {
              text: "Sasya berbelanja di sini karna bagus bede.",
              author: "Bayu Firmansyah",
              avatar: "https://i.pravatar.cc/60?img=6",
              rating: 5,
            },
            {
              text: "Pengiriman cepat dan barang dikemas dengan sangat baik.",
              author: "Intan Wulandari",
              avatar: "https://i.pravatar.cc/60?img=7",
              rating: 4,
            },
            {
              text: "Dari awal order hingga produk diterima, semuanya lancar!",
              author: "Rio Saputra",
              avatar: "https://i.pravatar.cc/60?img=8",
              rating: 5,
            },
            {
              text: "Harga terjangkau dengan kualitas premium. Recommended!",
              author: "Ambas nino",
              avatar: "https://i.pravatar.cc/60?img=3",
              rating: 5,
            },
            {
              text: "Respon admin cepat dan sangat membantu. Mantap!",
              author: "Raka Nugroho",
              avatar: "https://i.pravatar.cc/60?img=4",
              rating: 4,
            },
            {
              text: "Website ini sangat mudah digunakan. Proses checkout cepat!",
              author: "Yuni Marlina",
              avatar: "https://i.pravatar.cc/60?img=5",
              rating: 5,
            },
            {
              text: "Sasya berbelanja di sini karna bagus bede.",
              author: "Bayu Firmansyah",
              avatar: "https://i.pravatar.cc/60?img=6",
              rating: 5,
            },
          ],
          currentGroup: 0,
          get visibleTestimonials() {
            const start = this.currentGroup * 2;
            return this.testimonials.slice(start, start + 2);
          },
          start() {
            setInterval(() => {
              this.currentGroup = (this.currentGroup + 1) % Math.ceil(this.testimonials.length / 2);
            }, 3000);
          }
        }
      }
      
      function searchForm() {
      return {
        keyword: '{{ request('search') }}',
        search() {
          fetch(`{{ route('dashboard') }}?search=${this.keyword}`, {
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(res => res.text())
          .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const productList = doc.querySelector('#product-list');
            document.querySelector('#product-list').innerHTML = productList.innerHTML;
          });
        }
      }
    }
    document.addEventListener("DOMContentLoaded", function() {
          const searchInput = document.getElementById('search');
          const placeholders = ["Kursi kerja...", "Kasur minimalist...", "Lampu hias...", "Lampu gantung...", "Tanaman hias..."];
          let placeholderIndex = 0;
          let charIndex = 0;
          let isDeleting = false;
          let typingSpeed = 100;
          let deletingSpeed = 50;
          let pauseBeforeNext = 1500;

          function typePlaceholder() {
              const currentPlaceholder = placeholders[placeholderIndex];

              if (isDeleting) {
                  // Deleting characters
                  searchInput.setAttribute("placeholder", currentPlaceholder.substring(0, charIndex - 1));
                  charIndex--;
                  if (charIndex === 0) {
                      isDeleting = false;
                      placeholderIndex = (placeholderIndex + 1) % placeholders.length;
                      setTimeout(typePlaceholder, 500); // Short pause before typing next
                  } else {
                      setTimeout(typePlaceholder, deletingSpeed);
                  }
              } else {
                  // Typing characters
                  searchInput.setAttribute("placeholder", currentPlaceholder.substring(0, charIndex + 1));
                  charIndex++;
                  if (charIndex === currentPlaceholder.length) {
                      isDeleting = true;
                      setTimeout(typePlaceholder, pauseBeforeNext); // Pause after typing
                  } else {
                      setTimeout(typePlaceholder, typingSpeed);
                  }
              }
          }

          typePlaceholder();
      });

      </script>

      <!-- Font Awesome -->
      <script src="https://kit.fontawesome.com/YOUR_KIT_ID.js" crossorigin="anonymous"></script>
            </div>
        </div>
        <div id="zoomImageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50 p-4">
        <div class="relative max-w-4xl w-full max-h-[90vh] overflow-auto">
            <button onclick="closeZoomImage()" class="absolute top-3 right-4 text-black hover:text-red-600 text-4xl font-bold">&times;</button>
            <img id="zoomedImage" src="" class="w-full h-auto object-contain rounded-lg shadow-lg cursor-zoom-out">
        </div>
    </div>
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
    </x-app-layout>
