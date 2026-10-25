<?php require_once __DIR__.'/../includes/config.php'; $err='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  if (($_POST['user']??'')===ADMIN_USER && ($_POST['pass']??'')===ADMIN_PASS) { $_SESSION['admin']=1; header('Location: index.php'); exit; }
  $err='Username atau password salah';
} ?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login Admin</title><link rel="stylesheet" href="admin.css"></head>
<body class="login"><form method="post" class="box"><h2>Login Admin</h2><?php if($err): ?><div class="err"><?= $err ?></div><?php endif; ?>
<label>Username<input name="user" required></label><label>Password<input type="password" name="pass" required></label>
<button class="btn">Masuk</button><small>Default: admin / admin123</small></form></body></html>
