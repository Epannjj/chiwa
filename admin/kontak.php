<?php require '_auth.php'; $p = load('pesan');
if (isset($_POST['hapus'])) { $p = array_values(array_filter($p, fn($i)=>$i['id']!=$_POST['hapus'])); save('pesan',$p); }
admin_head('Pesan Kontak'); ?>
<div class="panel"><input class="search" placeholder="Cari..." data-search><table><thead><tr><th>Tanggal</th><th>Nama</th><th>Email / WA</th><th>Pesan</th><th></th></tr></thead><tbody>
<?php foreach(array_reverse($p) as $m): ?><tr><td><?= e($m['tanggal']) ?></td><td><?= e($m['nama']) ?></td><td><?= e($m['email']) ?><br><?= e($m['telepon']) ?></td><td><?= nl2br(e($m['pesan'])) ?></td>
<td><form method="post" onsubmit="return confirm('Hapus?')"><button name="hapus" value="<?= $m['id'] ?>" class="btn sm red">Hapus</button></form></td></tr><?php endforeach; ?>
<?php if(!$p): ?><tr><td colspan="5">Belum ada pesan.</td></tr><?php endif; ?></tbody></table></div>
<?php admin_foot(); ?>
