<?php require '_auth.php'; $messageCount = null;
try { $messageCount = contact_count(); } catch (Throwable $ex) { /* Shown below, without leaking credentials. */ }
admin_head('Dashboard'); ?>
<div class="cards">
<?php foreach($MODULES as $k=>$m): ?><a class="stat" href="<?= $k ?>.php"><b><?= count(load($k)) ?></b><span><?= $m['label'] ?></span></a><?php endforeach; ?>
<a class="stat" href="kontak.php"><b><?= $messageCount === null ? '—' : $messageCount ?></b><span>Pesan Masuk</span></a></div>
<?php if($messageCount === null): ?><div class="panel">Database pesan belum terhubung. Periksa konfigurasi database dan impor SQL.</div><?php endif; ?>
<div class="panel"><h3>Selamat datang 👋</h3><p>Kelola seluruh konten website promosi Anda dari menu di samping.</p></div>
<?php admin_foot(); ?>
