<?php
require_once __DIR__ . '/includes/config.php';
$ok = !empty($_SESSION['contact_sent']);
unset($_SESSION['contact_sent']);
$error = ''; $values = ['nama'=>'', 'email'=>'', 'telepon'=>'', 'pesan'=>''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $ok = false;
  foreach ($values as $key => $unused) { $values[$key] = is_string($_POST[$key] ?? null) ? $_POST[$key] : ''; }
  try {
    if (!contact_csrf_valid($_POST['csrf'] ?? null)) { throw new InvalidArgumentException('Sesi formulir berakhir. Silakan kirim ulang.'); }
    contact_insert($_POST);
    $_SESSION['contact_sent'] = true;
    header('Location: kontak.php', true, 303); exit;
  } catch (InvalidArgumentException $ex) {
    http_response_code(422); $error = $ex->getMessage();
  } catch (Throwable $ex) {
    http_response_code(503); $error = 'Pesan belum tersimpan. Silakan coba lagi atau hubungi kami melalui WhatsApp.';
  }
}
$csrf = contact_csrf_token();
$title='Kontak'; require 'includes/header.php'; require 'includes/sections.php';
page_hero('Hubungi Kami', 'Konsultasi gratis, kami siap membantu Anda.'); ?>
<section class="section"><div class="container grid-2">
 <div class="card info">
  <h3>Informasi Kontak</h3>
  <p>📍 <?= e($settings['alamat']) ?></p><p>📞 <?= e($settings['telepon']) ?></p><p>✉️ <?= e($settings['email']) ?></p>
  <a class="btn" href="https://wa.me/<?= e($settings['whatsapp']) ?>" target="_blank">Chat via WhatsApp</a>
  <iframe src="https://maps.google.com/maps?q=<?= urlencode($settings['alamat']) ?>&output=embed" loading="lazy"></iframe>
 </div>
 <form class="card form" method="post" data-validate>
  <input type="hidden" name="csrf" value="<?= e($csrf) ?>">
  <?php if($ok): ?><div class="alert">Terima kasih! Pesan Anda sudah terkirim.</div><?php endif; ?>
  <?php if($error): ?><div class="alert" role="alert"><?= e($error) ?></div><?php endif; ?>
  <label>Nama<input name="nama" maxlength="150" value="<?= e($values['nama']) ?>" required></label>
  <label>Email<input type="email" name="email" maxlength="254" value="<?= e($values['email']) ?>" required></label>
  <label>No. WhatsApp<input name="telepon" maxlength="40" value="<?= e($values['telepon']) ?>"></label>
  <label>Pesan<textarea name="pesan" rows="5" maxlength="10000" required><?= e($values['pesan'] !== '' ? $values['pesan'] : (is_string($_GET['paket'] ?? null) ? 'Saya tertarik dengan '.$_GET['paket'] : '')) ?></textarea></label>
  <button class="btn">Kirim Pesan</button>
 </form>
</div></section>
<?php require 'includes/footer.php'; ?>
