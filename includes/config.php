<?php
session_start();
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'admin123'); // ganti password ini
require_once __DIR__ . '/database.php';

function load($name, $default = []) {
  if ($name === 'pesan') { throw new LogicException('Contact messages must use the database repository.'); }
  $pdo = contact_db();
  if ($name === 'settings') {
    $rows = $pdo->query('SELECT kunci, nilai FROM settings')->fetchAll();
    $stored = [];
    foreach ($rows as $row) { $stored[$row['kunci']] = $row['nilai']; }
    return array_merge($default, $stored);
  }
  if (!isset($GLOBALS['MODULES'][$name])) { throw new InvalidArgumentException('Modul tidak dikenal.'); }
  return $pdo->query("SELECT * FROM `$name` ORDER BY urutan ASC, id ASC")->fetchAll();
}
function save($name, $data) {
  if ($name !== 'settings' || !is_array($data)) { throw new InvalidArgumentException('Penyimpanan hanya menerima pengaturan situs.'); }
  $stmt = contact_db()->prepare('INSERT INTO settings (kunci, nilai) VALUES (:kunci, :nilai) ON DUPLICATE KEY UPDATE nilai = VALUES(nilai)');
  foreach ($data as $key => $value) { $stmt->execute(['kunci' => $key, 'nilai' => (string)$value]); }
}
function save_item($name, $row) {
  if (!isset($GLOBALS['MODULES'][$name]) || !is_array($row)) { throw new InvalidArgumentException('Data modul tidak valid.'); }
  $fields = array_keys($GLOBALS['MODULES'][$name]['fields']);
  $values = [];
  foreach ($fields as $field) {
    $value = $row[$field] ?? '';
    $values[$field] = $field === 'populer' ? (int)(bool)$value : $value;
  }
  $pdo = contact_db();
  if (isset($row['id']) && filter_var($row['id'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
    $assignments = array_map(fn($field) => "`$field` = :$field", $fields);
    $values['id'] = (int)$row['id'];
    $stmt = $pdo->prepare("UPDATE `$name` SET " . implode(', ', $assignments) . ' WHERE id = :id');
    $stmt->execute($values);
    return;
  }
  $values['urutan'] = (int)$pdo->query("SELECT COALESCE(MAX(urutan), 0) + 1 FROM `$name`")->fetchColumn();
  $columns = array_merge($fields, ['urutan']);
  $quoted = array_map(fn($field) => "`$field`", $columns);
  $placeholders = array_map(fn($field) => ":$field", $columns);
  $stmt = $pdo->prepare("INSERT INTO `$name` (" . implode(', ', $quoted) . ') VALUES (' . implode(', ', $placeholders) . ')');
  $stmt->execute($values);
}
function delete_item($name, $id) {
  if (!isset($GLOBALS['MODULES'][$name]) || !filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
    throw new InvalidArgumentException('Data yang akan dihapus tidak valid.');
  }
  $stmt = contact_db()->prepare("DELETE FROM `$name` WHERE id = :id");
  $stmt->execute(['id' => (int)$id]);
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
