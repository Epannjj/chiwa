<?php require 'includes/header.php'; require 'includes/sections.php'; $banners = load('banner'); ?>
<section class="slider">
 <?php foreach($banners as $i=>$b): ?>
 <div class="slide <?= $i==0?'active':'' ?>" style="background-image:linear-gradient(90deg,rgba(10,15,40,.85),rgba(10,15,40,.3)),url('<?= e($b['gambar']) ?>')">
  <div class="container"><h1><?= e($b['judul']) ?></h1><p><?= e($b['subjudul']) ?></p>
  <a class="btn" href="<?= e($b['link']) ?>"><?= e($b['tombol']) ?></a>
  <a class="btn btn-ghost" href="portofolio.php">Lihat Portofolio</a></div>
 </div>
 <?php endforeach; ?>
 <div class="dots"><?php foreach($banners as $i=>$b): ?><span class="<?= $i==0?'active':'' ?>"></span><?php endforeach; ?></div>
</section>
<section class="stats"><div class="container grid-4">
 <div><b data-count="500">0</b>+<small>Website Dibuat</small></div>
 <div><b data-count="350">0</b>+<small>Klien Puas</small></div>
 <div><b data-count="8">0</b>+<small>Tahun Pengalaman</small></div>
 <div><b data-count="24">0</b>/7<small>Support</small></div>
</div></section>
<section class="section"><div class="container">
 <div class="head"><span class="eyebrow">Kenapa Kami</span><h2>Keunggulan Layanan Kami</h2></div>
 <div class="grid-4">
  <div class="card feat reveal"><i>⚡</i><h3>Cepat</h3><p>Website ringan dan loading cepat.</p></div>
  <div class="card feat reveal"><i>📱</i><h3>Mobile Friendly</h3><p>Tampil sempurna di semua perangkat.</p></div>
  <div class="card feat reveal"><i>🔍</i><h3>SEO Friendly</h3><p>Mudah ditemukan di Google.</p></div>
  <div class="card feat reveal"><i>🛡️</i><h3>Aman</h3><p>SSL gratis dan backup rutin.</p></div>
 </div></div></section>
<?php section_produk(); section_portofolio(6); section_testimoni(); section_faq(); require 'includes/footer.php'; ?>
