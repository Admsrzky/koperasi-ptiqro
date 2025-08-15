<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Kasbon PT. IQRO LAUTAN PENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Header -->
    <header class="bg-blue-600 text-white">
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold">Sistem Informasi Pengelolaan Kasbon ILP</div>
            <ul class="flex space-x-6">
                <li><a href="#home" class="hover:text-blue-200">Beranda</a></li>
                <li><a href="#about" class="hover:text-blue-200">Tentang</a></li>
                <li><a href="#services" class="hover:text-blue-200">Layanan</a></li>
                <li><a href="#contact" class="hover:text-blue-200">Kontak</a></li>
                <li><a href="{{ route('login') }}" class="hover:text-white bg-gradient-to-r from-pink-500 to-yellow-400 text-white p-2 rounded-lg px-5">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="bg-blue-500 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Selamat Datang di Sistem Informasi Pengelolaan Kasbon PT. IQRO LAUTAN PENA</h1>
            <p class="text-xl mb-8">Membangun kesejahteraan bersama melalui pelayanan koperasi yang terpercaya</p>
            <a href="#contact" class="bg-gradient-to-r from-blue-400 to-green-400 text-white px-6 py-3 rounded-full font-semibold hover:from-blue-500 hover:to-green-500">Gabung Sekarang</a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">Tentang Kami</h2>
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="md:w-1/2">
                    <img src="{{ asset('assets/img/koperasi.jpg') }}" alt="Koperasi ILP" class="rounded-lg shadow-lg">
                </div>
                <div class="md:w-1/2">
                    <p class="text-lg mb-4">Sistem Informasi Pengelolaan Kasbon PT. IQRO LAUTAN PENA adalah lembaga keuangan yang berdedikasi untuk meningkatkan kesejahteraan anggota melalui berbagai layanan simpan pinjam dan investasi yang aman serta menguntungkan.</p>
                    <p class="text-lg">Berdiri sejak 2013, kami telah melayani ribuan anggota dengan prinsip kebersamaan, transparansi, dan profesionalisme.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="bg-gray-200 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">Layanan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-xl font-semibold mb-4">Simpanan</h3>
                    <p>Berbagai jenis simpanan dengan bunga kompetitif untuk keamanan dan pertumbuhan dana Anda.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-xl font-semibold mb-4">Pinjaman</h3>
                    <p>Pinjaman dengan proses cepat dan bunga rendah untuk kebutuhan pribadi atau usaha.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-xl font-semibold mb-4">Investasi</h3>
                    <p>Peluang investasi yang menguntungkan dengan risiko terkelola untuk masa depan Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">Hubungi Kami</h2>
            <div class="flex flex-col md:flex-row gap-8">
                <div class="md:w-1/2">
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-semibold mb-4">Informasi Kontak</h3>
                        <p class="mb-2"><strong>Alamat:</strong> Jl. Raya Anyer No. 59, Ds. Gunung Sugih Cilegon-Banten</p>
                        <p class="mb-2"><strong>Telepon:</strong> (0254) 7960937</p>
                        <p class="mb-2"><strong>Email:</strong> iqrolautanpenapt@yahoo.com</p>
                        <p><strong>Jam Operasional:</strong> Senin-Sabtu, 08.00-18.00 WIB</p>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-semibold mb-4">Kirim Pesan</h3>
                        <div class="space-y-4">
                            <input type="text" placeholder="Nama" class="w-full p-3 border rounded-lg">
                            <input type="email" placeholder="Email" class="w-full p-3 border rounded-lg">
                            <textarea placeholder="Pesan" class="w-full p-3 border rounded-lg h-32"></textarea>
                            <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-500">Kirim</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 PT. IQRO LAUTAN PENA. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>