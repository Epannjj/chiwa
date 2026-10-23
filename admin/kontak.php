<?php require '_auth.php'; $p = []; $error = '';
try {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!contact_csrf_valid($_POST['csrf'] ?? null)) { throw new InvalidArgumentException('Sesi formulir berakhir. Muat ulang halaman.'); }
    contact_delete($_POST['hapus'] ?? null);
    header('Location: kontak.php', true, 303); exit;
  }
  $p = contact_all();
} catch (InvalidArgumentException $ex) {
  http_response_code(422); $error = $ex->getMessage();
} catch (Throwable $ex) {
  http_response_code(503); $error = 'Database pesan tidak dapat diakses. Periksa konfigurasi dan impor SQL terlebih dahulu.';
}
$csrf = contact_csrf_token();
admin_head('Pesan Kontak'); ?>
<?php if($error): ?><div class="panel" role="alert"><?= e($error) ?></div><?php endif; ?>
<div class="panel"><input class="search" placeholder="Cari..." data-search><table><thead><tr><th>Tanggal</th><th>Nama</th><th>Email / WA</th><th>Pesan</th><th></th></tr></thead><tbody>
<?php foreach($p as $m): ?><tr><td><?= e($m['tanggal']) ?></td><td><?= e($m['nama']) ?></td><td><?= e($m['email']) ?><br><?= e($m['telepon']) ?></td><td><?= nl2br(e($m['pesan'])) ?></td>
<td><form method="post" onsubmit="return confirm('Hapus?')"><input type="hidden" name="csrf" value="<?= e($csrf) ?>"><button name="hapus" value="<?= e($m['id']) ?>" class="btn sm red">Hapus</button></form></td></tr><?php endforeach; ?>
<?php if(!$p && !$error): ?><tr><td colspan="5">Belum ada pesan.</td></tr><?php endif; ?></tbody></table></div>
<?php admin_foot(); ?>
