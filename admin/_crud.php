<?php // Halaman CRUD generik. Set $type sebelum include.
require_once '_auth.php';
$mod = $MODULES[$type]; $items = load($type); $msg = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  if (isset($_POST['hapus'])) { $items = array_values(array_filter($items, fn($i)=>$i['id']!=$_POST['hapus'])); $msg='Data dihapus'; }
  else {
    $row = ['id' => $_POST['id'] ?: time()];
    foreach ($mod['fields'] as $f=>$t) $row[$f] = $t==='checkbox' ? (isset($_POST[$f])?'1':'') : trim($_POST[$f]??'');
    $found=false; foreach ($items as &$i) if ($i['id']==$row['id']) { $i=$row; $found=true; } unset($i);
    if (!$found) $items[] = $row; $msg='Data disimpan';
  }
  save($type, $items);
}
$edit = null; if (isset($_GET['edit'])) foreach ($items as $i) if ($i['id']==$_GET['edit']) $edit=$i;
admin_head('Kelola '.$mod['label']); $keys = array_keys($mod['fields']); ?>
<?php if($msg): ?><div class="ok"><?= $msg ?></div><?php endif; ?>
<div class="layout">
<form method="post" class="panel">
 <h3><?= $edit?'Edit':'Tambah' ?> <?= $mod['label'] ?></h3><input type="hidden" name="id" value="<?= e($edit['id']??'') ?>">
 <?php foreach($mod['fields'] as $f=>$t): $v=$edit[$f]??''; ?>
  <label><?= ucfirst($f) ?>
  <?php if($t==='textarea'): ?><textarea name="<?= $f ?>" rows="4"><?= e($v) ?></textarea>
  <?php elseif($t==='checkbox'): ?><input type="checkbox" name="<?= $f ?>" <?= $v?'checked':'' ?>>
  <?php else: ?><input type="<?= $t ?>" name="<?= $f ?>" value="<?= e($v) ?>" <?= in_array($f,['gambar','foto'])?'data-preview':'' ?>><?php endif; ?>
  </label>
 <?php endforeach; ?>
 <button class="btn">Simpan</button> <?php if($edit): ?><a href="<?= $type ?>.php" class="btn gray">Batal</a><?php endif; ?>
</form>
<div class="panel"><input class="search" placeholder="Cari..." data-search>
<table><thead><tr><?php foreach(array_slice($keys,0,3) as $k): ?><th><?= ucfirst($k) ?></th><?php endforeach; ?><th>Aksi</th></tr></thead><tbody>
<?php foreach($items as $i): ?><tr><?php foreach(array_slice($keys,0,3) as $k): $v=$i[$k]??''; ?>
 <td><?= preg_match('/^https?:.*\.(jpg|png|webp)|unsplash|pravatar/i',$v) ? '<img src="'.e($v).'">' : e(mb_strimwidth($v,0,60,'…')) ?></td><?php endforeach; ?>
 <td class="act"><a href="?edit=<?= $i['id'] ?>" class="btn sm">Edit</a>
 <form method="post" onsubmit="return confirm('Hapus data ini?')"><button name="hapus" value="<?= $i['id'] ?>" class="btn sm red">Hapus</button></form></td></tr>
<?php endforeach; ?></tbody></table></div></div>
<?php admin_foot(); ?>
