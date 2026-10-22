<?php
function section_produk() { $items = load('produk'); ?>
<section class="section"><div class="container">
 <div class="head"><span class="eyebrow">Paket Harga</span><h2>Pilih Paket Website Anda</h2></div>
 <div class="grid-3">
 <?php foreach($items as $p): ?>
  <div class="card price <?= $p['populer']?'popular':'' ?> reveal">
   <?php if($p['populer']): ?><span class="badge">Terpopuler</span><?php endif; ?>
   <h3><?= e($p['nama']) ?></h3><div class="amount"><?= rupiah($p['harga']) ?></div>
   <ul><?php foreach(array_filter(explode("\n",$p['fitur'])) as $f): ?><li>✔ <?= e(trim($f)) ?></li><?php endforeach; ?></ul>
   <a class="btn" href="kontak.php?paket=<?= urlencode($p['nama']) ?>">Pesan Sekarang</a>
  </div>
 <?php endforeach; ?></div></div></section>
<?php }
function section_portofolio($limit = 0) { $items = load('portofolio'); if($limit) $items = array_slice($items,0,$limit);
 $cats = array_unique(array_column($items,'kategori')); ?>
<section class="section alt"><div class="container">
 <div class="head"><span class="eyebrow">Portofolio</span><h2>Hasil Karya Kami</h2></div>
 <div class="filters"><button class="active" data-filter="all">Semua</button>
 <?php foreach($cats as $c): ?><button data-filter="<?= e($c) ?>"><?= e($c) ?></button><?php endforeach; ?></div>
 <div class="grid-3">
 <?php foreach($items as $p): ?>
  <a class="card porto reveal" data-cat="<?= e($p['kategori']) ?>" href="<?= e($p['url']) ?>" target="_blank">
   <div class="thumb"><img src="<?= e($p['gambar']) ?>" alt="<?= e($p['judul']) ?>" loading="lazy"></div>
   <div class="body"><small><?= e($p['kategori']) ?></small><h3><?= e($p['judul']) ?></h3><p><?= e($p['deskripsi']) ?></p></div>
  </a>
 <?php endforeach; ?></div></div></section>
<?php }
function section_testimoni() { $items = load('testimoni'); ?>
<section class="section"><div class="container">
 <div class="head"><span class="eyebrow">Testimoni</span><h2>Apa Kata Klien Kami</h2></div>
 <div class="grid-3">
 <?php foreach($items as $t): ?>
  <div class="card testi reveal"><div class="stars"><?= str_repeat('★',(int)$t['rating']).str_repeat('☆',5-(int)$t['rating']) ?></div>
   <p>"<?= e($t['isi']) ?>"</p>
   <div class="person"><img src="<?= e($t['foto']) ?>" alt=""><div><b><?= e($t['nama']) ?></b><small><?= e($t['jabatan']) ?></small></div></div></div>
 <?php endforeach; ?></div></div></section>
<?php }
function section_faq() { $items = load('faq'); ?>
<section class="section alt"><div class="container narrow">
 <div class="head"><span class="eyebrow">FAQ</span><h2>Pertanyaan yang Sering Diajukan</h2></div>
 <?php foreach($items as $f): ?>
  <div class="faq-item"><button class="faq-q"><?= e($f['pertanyaan']) ?><span>+</span></button><div class="faq-a"><p><?= e($f['jawaban']) ?></p></div></div>
 <?php endforeach; ?></div></section>
<?php }
function page_hero($judul, $sub) { ?>
<section class="page-hero"><div class="container"><h1><?= e($judul) ?></h1><p><?= e($sub) ?></p></div></section>
<?php }
