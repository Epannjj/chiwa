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
   <a class="btn" href="order.php?paket=<?= urlencode($p['nama']) ?>">Pesan Sekarang</a>
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
  <?php
  $hasPreview = preg_match('~^uploads/portofolio/[a-f0-9]{32}/index\.html$~', $p['url']);
  $hasUploadedImage = preg_match('~^uploads/portofolio/gambar/[a-f0-9]{32}\.(jpg|jpeg|png|gif|webp)$~', $p['gambar']);
  ?>
  <a class="card porto reveal" data-cat="<?= e($p['kategori']) ?>" href="<?= e($p['url']) ?>" <?= strpos($p['url'], 'uploads/portofolio/') === 0 ? '' : 'target="_blank" rel="noopener noreferrer"' ?>>
   <div class="thumb"><?php if($hasUploadedImage): ?><img src="<?= e($p['gambar']) ?>" alt="<?= e($p['judul']) ?>" loading="lazy"><?php elseif($hasPreview): ?><iframe src="<?= e($p['url']) ?>" title="Pratinjau <?= e($p['judul']) ?>" loading="lazy" sandbox="allow-scripts"></iframe><?php elseif(!empty($p['gambar'])): ?><img src="<?= e($p['gambar']) ?>" alt="<?= e($p['judul']) ?>" loading="lazy"><?php endif; ?></div>
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
function section_form_order() { global $settings;
  $paketDariProduk = is_string($_GET['paket'] ?? null) ? $_GET['paket'] : '';

  // Ambil daftar portofolio untuk pilihan template
  $daftarTemplate = [];
  try {
    $daftarTemplate = load('portofolio');
  } catch (Throwable $ex) {
    $daftarTemplate = [];
  }

  // Helper: ambil URL gambar thumbnail untuk kartu template
  $previewUrl = function($p) {
    if (!empty($p['gambar'])) return $p['gambar'];
    // Kalau tidak ada gambar tapi punya iframe preview, tetap tidak bisa jadi <img>
    return '';
  };

  $ekstensi = ['.com', '.id', '.co.id', '.net', '.org', '.biz.id', '.web.id', '.my.id', '.online', '.site'];
?>
<section class="section"><div class="container narrow">
 <div class="head">
  <span class="eyebrow">Pesan Sekarang</span>
  <h2>Form Detail Order</h2>
  <p>Isi data di bawah, lalu kirim langsung ke WhatsApp kami.</p>
 </div>
 <form class="card form" id="orderForm" data-wa="<?= e($settings['whatsapp']) ?>">
  <div class="grid-2">
   <label>Nama Pemesan<input name="nama" required></label>
   <label>Nama Bisnis<input name="bisnis" required></label>

   <label style="grid-column:1/-1">Domain
     <div class="domain-row">
       <input name="domain_nama" required style="flex:1">
       <select name="domain_ekstensi" required style="width:auto;margin-top:.4rem">
         <?php foreach($ekstensi as $ext): ?>
           <option value="<?= e($ext) ?>" <?= $ext==='.com'?'selected':'' ?>><?= e($ext) ?></option>
         <?php endforeach; ?>
       </select>
     </div>
     <small class="domain-hint">Hasil: <b id="domainPreview">namadomain.com</b></small>
   </label>

   <label style="grid-column:1/-1">Pilih Template
     <input type="hidden" name="template" id="templateValue" required value="<?= e($paketDariProduk) ?>">
     <div class="template-grid" id="templateGrid">
       <?php if(empty($daftarTemplate)): ?>
         <div class="template-empty">Belum ada template portofolio. Hubungi kami untuk info template.</div>
       <?php else: ?>
         <?php foreach($daftarTemplate as $tpl):
           $img = $previewUrl($tpl);
           $judul = $tpl['judul'];
           $kategori = $tpl['kategori'];
           $selected = ($judul === $paketDariProduk);
         ?>
           <button type="button" class="template-card <?= $selected?'selected':'' ?>" data-judul="<?= e($judul) ?>">
             <div class="template-thumb">
               <?php if($img): ?>
                 <img src="<?= e($img) ?>" alt="<?= e($judul) ?>" loading="lazy">
               <?php else: ?>
                 <div class="template-noimg">No Image</div>
               <?php endif; ?>
             </div>
             <div class="template-name"><?= e($judul) ?></div>
             <div class="template-cat"><?= e($kategori) ?></div>
           </button>
         <?php endforeach; ?>
       <?php endif; ?>
     </div>
     <div class="template-selected-info" id="templateSelectedInfo">
       <?= $paketDariProduk ? 'Dipilih: <b>'.e($paketDariProduk).'</b>' : 'Belum ada template dipilih' ?>
     </div>
   </label>

   <label>Slogan<input name="slogan"></label>
   <label>Logo<input name="logo"></label>
   <label>WhatsApp<input name="wa" required></label>
   <label style="grid-column:1/-1">Deskripsi<textarea name="deskripsi" rows="3" required></textarea></label>
  </div>
  <button class="btn" type="submit">Kirim ke WhatsApp</button>
 </form>
</div></section>

<style>
/* Grid kartu template */
.template-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:.8rem;margin-top:.6rem}
.template-card{border:2px solid #e4e7f2;border-radius:12px;background:#fff;padding:0;cursor:pointer;overflow:hidden;text-align:left;transition:.2s;display:flex;flex-direction:column}
.template-card:hover{border-color:var(--primary);transform:translateY(-2px);box-shadow:0 8px 20px -10px rgba(51,65,255,.4)}
.template-card.selected{border-color:var(--primary);box-shadow:0 0 0 3px rgba(51,65,255,.15)}
.template-thumb{aspect-ratio:4/3;background:#f3f4f9;overflow:hidden;display:flex;align-items:center;justify-content:center}
.template-thumb img{width:100%;height:100%;object-fit:cover;display:block}
.template-noimg{color:#9aa0b8;font-size:.75rem;text-align:center;padding:.5rem}
.template-name{font-weight:600;font-size:.85rem;color:#2b3050;padding:.5rem .6rem 0;line-height:1.3}
.template-cat{font-size:.72rem;color:#7a809a;padding:0 .6rem .6rem}
.template-empty{padding:1rem;color:#7a809a;font-size:.85rem;text-align:center;grid-column:1/-1;border:1px dashed #dde0ec;border-radius:10px}
.template-selected-info{margin-top:.6rem;font-size:.85rem;color:#555}
.template-selected-info b{color:var(--primary)}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var grid = document.getElementById('templateGrid');
  var valueInput = document.getElementById('templateValue');
  var info = document.getElementById('templateSelectedInfo');
  if (!grid || !valueInput) return;

  grid.addEventListener('click', function (e) {
    var card = e.target.closest('.template-card');
    if (!card) return;
    e.preventDefault();

    // Hapus selected dari semua
    grid.querySelectorAll('.template-card').forEach(function (c) { c.classList.remove('selected'); });
    card.classList.add('selected');

    var judul = card.getAttribute('data-judul') || '';
    valueInput.value = judul;
    if (info) info.innerHTML = 'Dipilih: <b>' + judul + '</b>';
  });
});
</script>
<?php }