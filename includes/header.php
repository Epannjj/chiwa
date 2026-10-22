<?php require_once __DIR__.'/config.php'; require_once __DIR__.'/seed.php';
$page = basename($_SERVER['PHP_SELF'], '.php');
$nav = ['index'=>'Beranda','produk'=>'Produk','portofolio'=>'Portofolio','testimoni'=>'Testimoni','faq'=>'FAQ','kontak'=>'Kontak']; ?>
<!DOCTYPE html>
<html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e(($title ?? '') ? $title.' | '.$settings['nama_situs'] : $settings['nama_situs'].' - '.$settings['tagline']) ?></title>
<meta name="description" content="<?= e($settings['meta_deskripsi']) ?>">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
<style>:root{--primary:<?= e($settings['warna']) ?>}</style>
</head><body>
<header class="nav"><div class="container nav-in">
  <a href="index.php" class="logo"><?= e($settings['nama_situs']) ?></a>
  <button class="burger" onclick="document.querySelector('.menu').classList.toggle('open')">☰</button>
  <nav class="menu">
    <?php foreach($nav as $k=>$v): ?><a href="<?= $k ?>.php" class="<?= $page==$k?'active':'' ?>"><?= $v ?></a><?php endforeach; ?>
    <a class="btn btn-sm" href="https://wa.me/<?= e($settings['whatsapp']) ?>" target="_blank">Hubungi Kami</a>
  </nav>
</div></header>
<main>
