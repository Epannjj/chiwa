# Website Promosi (PHP + HTML + JS)

Pesan kontak menggunakan **MySQL/MariaDB**, tabel `pesan_kontak`.
Banner, produk, portofolio, testimoni, FAQ, dan site setting tetap menggunakan JSON seperti versi sebelumnya. Perubahan ini khusus penyimpanan pesan kontak.

## Cara menjalankan
1. Butuh PHP 7.4+ (disarankan PHP 8.2+) dengan ekstensi `pdo_mysql` dan `mbstring`, serta MySQL 5.7+/8.x atau MariaDB 10.3+.
2. Ekstrak ke `htdocs/webpromo` untuk XAMPP/Laragon, atau folder website pada hosting. Saat memperbarui versi lama, **cadangkan dahulu dan jangan menimpa folder `data/` lama**, karena berisi konten situs Anda.
3. Di phpMyAdmin/cPanel, buat database (misalnya `webpromo`) dan akun database. Tambahkan akun ke database itu dengan hak SELECT, INSERT, DELETE untuk penggunaan website (impor SQL memerlukan akun dengan hak CREATE).
4. Pilih database tersebut di phpMyAdmin → **Import** → pilih `database/webpromo.sql` → **Go/Kirim**. SQL tidak menghapus data yang sudah ada; jalankan sebelum menggunakan formulir.
5. Salin `includes/database.local.example.php` menjadi `includes/database.local.php`. Isi `host`, `port`, `name`, `user`, dan `pass` sesuai hosting. Nama database dan username di cPanel sering memiliki awalan akun, misalnya `akun_webpromo`; gunakan nama lengkapnya. Jangan membagikan file yang sudah berisi password.
6. Alternatif konfigurasi: atur environment `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`; nilainya lebih diutamakan daripada file lokal. Tidak ada akun atau password database aktif dalam ZIP.
7. Dari folder website jalankan `php -S localhost:8000`, lalu buka `http://localhost:8000` dan `/admin`. Untuk hosting, buka domain Anda.
8. Login admin awal masih mengikuti versi sebelumnya; **ubah username/password admin di `includes/config.php` sebelum online**. Jangan memakai password bawaan di produksi. Folder `data/` tetap harus dapat ditulis untuk konten situs lainnya (misalnya chmod 775, jangan 777).

## Kirim dan lihat pesan
- Pengunjung membuka `kontak.php` dan menekan **Kirim Pesan**. Pesan disimpan ke tabel `pesan_kontak`, bukan `data/pesan.json`, dan tidak otomatis dikirim ke email atau WhatsApp.
- Admin masuk → **Pesan Kontak** (`admin/kontak.php`) untuk membaca pesan terbaru dan menghapusnya. **Pesan Masuk** di dashboard dihitung dari database yang sama.
- Data berisi ID unik otomatis, nama, email, telepon, isi pesan, dan tanggal waktu WIB (UTC+7). UTF-8 mendukung karakter Indonesia dan emoji.
- Jika koneksi database gagal, formulir menampilkan kegagalan, bukan konfirmasi sukses. Isi pesan tetap tampil agar dapat dikirim ulang. Pengiriman sukses diarahkan ulang supaya refresh halaman tidak mengirim pesan yang sama lagi.
- Query menggunakan PDO prepared statements; form kirim/hapus menggunakan token sesi. Halaman pesan admin tetap memerlukan login.

## Memindahkan pesan lama (opsional)
1. Simpan cadangan `data/pesan.json` dari website lama. Jangan mengunggahnya ke lokasi publik yang tidak terlindungi.
2. Setelah SQL dan koneksi siap, melalui terminal hosting atau terminal XAMPP/Laragon di folder website jalankan:
   ```sh
   php scripts/import_pesan_json.php data/pesan.json
   ```
   Untuk lokasi lain: `php scripts/import_pesan_json.php /lokasi/cadangan/pesan.json`.
3. Script hanya dapat dijalankan melalui terminal, bukan browser. Seluruh impor menggunakan transaksi: bila ada baris tidak valid, tidak ada pesan dari proses itu yang disimpan. Pesan lama harus memiliki nama, email valid, isi pesan, dan tanggal `YYYY-MM-DD HH:MM` atau `YYYY-MM-DD HH:MM:SS`; perbaiki pada salinan cadangan bila perlu.
4. Mengimpor ulang **file dengan isi dan urutan sama** tidak menggandakan pesan. ID database dibuat ulang otomatis; tanggal dan isi asli dipertahankan. Jangan mengubah/menyusun ulang file setelah impor jika ingin mengulangnya tanpa duplikasi.
5. Periksa hasil di **Pesan Kontak** lalu pindahkan cadangan JSON ke lokasi aman di luar folder publik. Script tidak menghapus file lama.

## Pengamanan hosting
- Apache 2.4 membaca `.htaccess` pada `includes/`, `database/`, `scripts/`, dan `data/`. Pastikan hosting mengizinkan aturan tersebut. Untuk Nginx, konfigurasi server harus menolak akses HTTP ke folder tersebut secara terpisah. Server PHP bawaan hanya untuk pengujian lokal, bukan produksi.
- Pakai HTTPS, cadangkan database secara rutin, dan jangan sertakan `database.local.php` dalam ZIP publik.

## Pengujian ulang
Pada database **khusus pengujian** yang sudah diimpor SQL dan dikonfigurasi dengan environment DB_*, jalankan `php tests/contact_database_test.php`. Tes membuat pesan uji lalu membersihkannya.

## Halaman Website
Beranda (banner slider), Produk, Portofolio (filter kategori), Testimoni, FAQ (accordion), Kontak (form + peta + WhatsApp).

## Halaman Admin
Dashboard, Banner, Portofolio, Produk, Testimoni, FAQ, Pesan Kontak, Site Setting (nama situs, warna tema, kontak, sosmed, SEO).
