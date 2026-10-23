# Website Promosi (PHP + HTML + JS)

Seluruh konten situs menggunakan **MySQL/MariaDB**: banner, produk, portofolio, testimoni, FAQ, pengaturan situs, dan pesan kontak. Aplikasi tidak memerlukan folder `data/` atau file JSON.

## Cara menjalankan
1. Butuh PHP 7.4+ (disarankan PHP 8.2+) dengan ekstensi `pdo_mysql` dan `mbstring`, serta MySQL 5.7+/8.x atau MariaDB 10.3+.
2. Ekstrak ke `htdocs/chiwa` untuk XAMPP/Laragon, atau folder website pada hosting. Database tidak disimpan di Git; setiap developer memiliki MySQL lokal sendiri dan mengimpor skema yang sama dari file SQL di repository.
3. Di phpMyAdmin, buat database bernama `webpromo`.
4. Pilih database `webpromo` → **Import** → pilih `database/webpromo1.sql` → **Go/Kirim**. File SQL ini membuat tabel dan mengisi data awal; mengimpor ulang tidak menghapus data yang sudah ada.
5. Untuk XAMPP lokal, mulai Apache dan MySQL di Control Panel XAMPP. File lokal `includes/database.local.php` menggunakan host `127.0.0.1`, database `webpromo`, user `root`, dan password kosong (nilai bawaan umum XAMPP). Jika instalasi Anda memakai kredensial berbeda, ubah file lokal tersebut. File ini diabaikan Git; jangan commit atau membagikan kredensial.
6. Untuk hosting, buat `includes/database.local.php` dengan hostname MySQL serta nama database, user, dan password dari penyedia hosting. Host database tidak selalu sama dengan domain website; gunakan hostname yang ditampilkan di panel hosting. File ini diabaikan Git agar kredensial tidak ikut terunggah.
7. Alternatif konfigurasi: atur environment `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`; nilainya lebih diutamakan daripada file lokal.
8. Buka `http://localhost/chiwa/cek_database.php` untuk memastikan koneksi dan tabel database, lalu `http://localhost/chiwa/` untuk situs atau `/admin` untuk panel admin. Halaman pengecekan koneksi hanya dapat dibuka dari komputer lokal.
9. Login admin awal masih mengikuti versi sebelumnya; **ubah username/password admin di `includes/config.php` sebelum online**. Jangan memakai password bawaan di produksi.

## Kirim dan lihat pesan
- Pengunjung membuka `kontak.php` dan menekan **Kirim Pesan**. Pesan disimpan ke tabel `pesan_kontak` dan tidak otomatis dikirim ke email atau WhatsApp.
- Admin masuk → **Pesan Kontak** (`admin/kontak.php`) untuk membaca pesan terbaru dan menghapusnya. **Pesan Masuk** di dashboard dihitung dari database yang sama.
- Data berisi ID unik otomatis, nama, email, telepon, isi pesan, dan tanggal waktu WIB (UTC+7). UTF-8 mendukung karakter Indonesia dan emoji.
- Jika koneksi database gagal, formulir menampilkan kegagalan, bukan konfirmasi sukses. Isi pesan tetap tampil agar dapat dikirim ulang. Pengiriman sukses diarahkan ulang supaya refresh halaman tidak mengirim pesan yang sama lagi.
- Query menggunakan PDO prepared statements; form kirim/hapus menggunakan token sesi. Halaman pesan admin tetap memerlukan login.

## Berbagi perubahan database lewat Git
- Commit perubahan struktur atau data contoh ke `database/webpromo1.sql`, bukan database MySQL atau file `includes/database.local.php`.
- Setelah `git pull`, developer mengimpor SQL yang diperbarui melalui phpMyAdmin. Buat cadangan database lokal sebelum mengimpor perubahan skema.
- Karena file SQL memakai `CREATE TABLE IF NOT EXISTS` dan `INSERT IGNORE`, perubahan definisi tabel yang sudah ada perlu diterapkan sebagai migrasi `ALTER TABLE` yang eksplisit; mengimpor ulang saja tidak mengubah kolom tabel lama.

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
