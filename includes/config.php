<?php
session_start();
define('DATA_DIR', __DIR__ . '/../data/');
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'admin123'); // ganti password ini

function load($name, $default = []) {
  $f = DATA_DIR . $name . '.json';
  if (!file_exists($f)) { save($name, $default); return $default; }
  return json_decode(file_get_contents($f), true) ?: $default;
}
function save($name, $data) {
  file_put_contents(DATA_DIR . $name . '.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function rupiah($n) { return 'Rp ' . number_format((float)$n, 0, ',', '.'); }

// Definisi modul (dipakai halaman admin)
$MODULES = [
  'banner' => ['label' => 'Banner', 'fields' => ['judul' => 'text', 'subjudul' => 'textarea', 'gambar' => 'text', 'tombol' => 'text', 'link' => 'text']],
  'portofolio' => ['label' => 'Portofolio', 'fields' => ['judul' => 'text', 'kategori' => 'text', 'gambar' => 'text', 'url' => 'text', 'deskripsi' => 'textarea']],
  'produk' => ['label' => 'Produk', 'fields' => ['nama' => 'text', 'harga' => 'number', 'fitur' => 'textarea', 'populer' => 'checkbox']],
  'testimoni' => ['label' => 'Testimoni', 'fields' => ['nama' => 'text', 'jabatan' => 'text', 'foto' => 'text', 'isi' => 'textarea', 'rating' => 'number']],
  'faq' => ['label' => 'FAQ', 'fields' => ['pertanyaan' => 'text', 'jawaban' => 'textarea']],
];

$settings = load('settings', [
  'nama_situs' => 'WebPromo.id', 'tagline' => 'Jasa Pembuatan Website Profesional',
  'whatsapp' => '6281234567890', 'email' => 'halo@webpromo.id', 'telepon' => '0812-3456-7890',
  'alamat' => 'Jl. Merdeka No. 10, Jakarta', 'warna' => '#ff5a1f',
  'instagram' => 'https://instagram.com/', 'facebook' => 'https://facebook.com/',
  'meta_deskripsi' => 'Jasa pembuatan website company profile, toko online, dan landing page.',
  'footer' => '© ' . date('Y') . ' WebPromo.id. All rights reserved.'
]);
