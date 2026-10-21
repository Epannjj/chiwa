<?php
// Data contoh awal
load('banner', [
 ['id'=>1,'judul'=>'Jasa Pembuatan Website Profesional & Terjangkau','subjudul'=>'Tingkatkan kredibilitas bisnis Anda dengan website modern, cepat, dan SEO friendly.','gambar'=>'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1600','tombol'=>'Lihat Paket','link'=>'produk.php'],
 ['id'=>2,'judul'=>'Website Toko Online Siap Jualan','subjudul'=>'Terima pesanan 24 jam dengan katalog produk dan checkout WhatsApp.','gambar'=>'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1600','tombol'=>'Konsultasi Gratis','link'=>'kontak.php'],
]);
load('portofolio', [
 ['id'=>1,'judul'=>'Klinik Sehat','kategori'=>'Company Profile','gambar'=>'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800','url'=>'#','deskripsi'=>'Website klinik dengan booking online.'],
 ['id'=>2,'judul'=>'Kopi Nusantara','kategori'=>'Toko Online','gambar'=>'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800','url'=>'#','deskripsi'=>'Toko online kopi lokal.'],
 ['id'=>3,'judul'=>'Properti Jaya','kategori'=>'Landing Page','gambar'=>'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800','url'=>'#','deskripsi'=>'Landing page penjualan perumahan.'],
 ['id'=>4,'judul'=>'Sekolah Cerdas','kategori'=>'Company Profile','gambar'=>'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800','url'=>'#','deskripsi'=>'Website sekolah dan PPDB online.'],
 ['id'=>5,'judul'=>'Fashion Kita','kategori'=>'Toko Online','gambar'=>'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800','url'=>'#','deskripsi'=>'Katalog fashion dengan checkout WA.'],
 ['id'=>6,'judul'=>'Travel Bahagia','kategori'=>'Landing Page','gambar'=>'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=800','url'=>'#','deskripsi'=>'Landing page paket wisata.'],
]);
load('produk', [
 ['id'=>1,'nama'=>'Paket Starter','harga'=>'750000','fitur'=>"Landing page 1 halaman\nDomain .com 1 tahun\nHosting 1 GB\nSSL gratis\nTombol WhatsApp",'populer'=>''],
 ['id'=>2,'nama'=>'Paket Bisnis','harga'=>'1500000','fitur'=>"Company profile 5 halaman\nDomain .com 1 tahun\nHosting 3 GB\nEmail bisnis\nSEO dasar\nRevisi 3x",'populer'=>'1'],
 ['id'=>3,'nama'=>'Paket Toko Online','harga'=>'2500000','fitur'=>"Katalog produk unlimited\nKeranjang & checkout WA\nHosting 5 GB\nPanel admin\nSEO lanjutan\nGaransi 1 tahun",'populer'=>''],
]);
load('testimoni', [
 ['id'=>1,'nama'=>'Budi Santoso','jabatan'=>'Owner Kopi Nusantara','foto'=>'https://i.pravatar.cc/150?img=12','isi'=>'Websitenya cepat dan rapi, penjualan online naik drastis!','rating'=>'5'],
 ['id'=>2,'nama'=>'Siti Rahma','jabatan'=>'Manager Klinik Sehat','foto'=>'https://i.pravatar.cc/150?img=47','isi'=>'Pelayanan ramah, revisi cepat. Sangat direkomendasikan.','rating'=>'5'],
 ['id'=>3,'nama'=>'Andi Wijaya','jabatan'=>'CEO Properti Jaya','foto'=>'https://i.pravatar.cc/150?img=33','isi'=>'Landing page-nya menghasilkan banyak leads. Mantap!','rating'=>'4'],
]);
load('faq', [
 ['id'=>1,'pertanyaan'=>'Berapa lama proses pembuatan website?','jawaban'=>'Rata-rata 3–7 hari kerja tergantung paket dan kelengkapan materi.'],
 ['id'=>2,'pertanyaan'=>'Apakah sudah termasuk domain dan hosting?','jawaban'=>'Ya, semua paket sudah termasuk domain dan hosting selama 1 tahun.'],
 ['id'=>3,'pertanyaan'=>'Apakah bisa revisi?','jawaban'=>'Bisa, setiap paket mendapatkan jatah revisi sesuai ketentuan.'],
 ['id'=>4,'pertanyaan'=>'Bagaimana cara pembayarannya?','jawaban'=>'DP 50% di awal dan pelunasan setelah website selesai.'],
]);
load('pesan', []);
