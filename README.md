# Website Promosi (PHP + HTML + JS)

Tanpa database — data disimpan di folder `data/` (JSON).

## Cara menjalankan
1. Butuh PHP 7.4+ (XAMPP/Laragon atau hosting biasa).
2. Ekstrak ke `htdocs/webpromo`, atau jalankan: `php -S localhost:8000`
3. Buka `http://localhost:8000` (website) dan `/admin` (panel admin).
4. Login admin: **admin / admin123** (ubah di `includes/config.php`).
5. Pastikan folder `data/` bisa ditulis (chmod 775).

## Halaman Website
Beranda (banner slider), Produk, Portofolio (filter kategori), Testimoni, FAQ (accordion), Kontak (form + peta + WhatsApp).

## Halaman Admin
Dashboard, Banner, Portofolio, Produk, Testimoni, FAQ, Pesan Kontak, Site Setting (nama situs, warna tema, kontak, sosmed, SEO).
