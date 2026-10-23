<?php require_once __DIR__.'/../includes/config.php'; require_once __DIR__.'/../includes/seed.php';
if (empty($_SESSION['admin'])) { header('Location: login.php'); exit; }
function admin_head($title) { global $MODULES; $cur = basename($_SERVER['PHP_SELF'], '.php'); ?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title) ?> - Admin</title><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="admin.css"></head><body>
<aside class="side"><div class="brand">⚙ Admin Panel</div>
<a href="index.php" class="<?= $cur=='index'?'on':'' ?>">📊 Dashboard</a>
<?php foreach($MODULES as $k=>$m): ?><a href="<?= $k ?>.php" class="<?= $cur==$k?'on':'' ?>">▸ <?= $m['label'] ?></a><?php endforeach; ?>
<a href="kontak.php" class="<?= $cur=='kontak'?'on':'' ?>">✉ Pesan Kontak</a>
<a href="settings.php" class="<?= $cur=='settings'?'on':'' ?>">🛠 Site Setting</a>
<a href="../index.php" target="_blank">🌐 Lihat Website</a><a href="logout.php">⎋ Logout</a></aside>
<div class="main"><h1><?= e($title) ?></h1>
<?php }
function admin_foot() { echo '</div><script src="admin.js"></script></body></html>'; }
