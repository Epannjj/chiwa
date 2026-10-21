<?php require '_auth.php'; admin_head('Dashboard'); ?>
<div class="cards">
<?php foreach($MODULES as $k=>$m): ?><a class="stat" href="<?= $k ?>.php"><b><?= count(load($k)) ?></b><span><?= $m['label'] ?></span></a><?php endforeach; ?>
<a class="stat" href="kontak.php"><b><?= count(load('pesan')) ?></b><span>Pesan Masuk</span></a></div>
<div class="panel"><h3>Selamat datang 👋</h3><p>Kelola seluruh konten website promosi Anda dari menu di samping.</p></div>
<?php admin_foot(); ?>
