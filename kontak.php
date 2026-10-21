<?php $title='Kontak'; require 'includes/header.php'; require 'includes/sections.php';
$ok = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pesan = load('pesan');
  $pesan[] = ['id'=>time(),'nama'=>trim($_POST['nama']??''),'email'=>trim($_POST['email']??''),'telepon'=>trim($_POST['telepon']??''),'pesan'=>trim($_POST['pesan']??''),'tanggal'=>date('Y-m-d H:i')];
  save('pesan', $pesan); $ok = true;
}
page_hero('Hubungi Kami', 'Konsultasi gratis, kami siap membantu Anda.'); ?>
<section class="section"><div class="container grid-2">
 <div class="card info">
  <h3>Informasi Kontak</h3>
  <p>📍 <?= e($settings['alamat']) ?></p><p>📞 <?= e($settings['telepon']) ?></p><p>✉️ <?= e($settings['email']) ?></p>
  <a class="btn" href="https://wa.me/<?= e($settings['whatsapp']) ?>" target="_blank">Chat via WhatsApp</a>
  <iframe src="https://maps.google.com/maps?q=<?= urlencode($settings['alamat']) ?>&output=embed" loading="lazy"></iframe>
 </div>
 <form class="card form" method="post" data-validate>
  <?php if($ok): ?><div class="alert">Terima kasih! Pesan Anda sudah terkirim.</div><?php endif; ?>
  <label>Nama<input name="nama" required></label>
  <label>Email<input type="email" name="email" required></label>
  <label>No. WhatsApp<input name="telepon"></label>
  <label>Pesan<textarea name="pesan" rows="5" required><?= isset($_GET['paket']) ? 'Saya tertarik dengan '.e($_GET['paket']) : '' ?></textarea></label>
  <button class="btn">Kirim Pesan</button>
 </form>
</div></section>
<?php require 'includes/footer.php'; ?>
