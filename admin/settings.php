<?php require '_auth.php'; $msg='';
if ($_SERVER['REQUEST_METHOD']==='POST') { foreach($settings as $k=>$v) $settings[$k]=trim($_POST[$k]??$v); save('settings',$settings); $msg='Pengaturan disimpan'; }
admin_head('Site Setting'); ?>
<?php if($msg): ?><div class="ok"><?= $msg ?></div><?php endif; ?>
<form method="post" class="panel grid">
<?php foreach($settings as $k=>$v): ?><label><?= ucwords(str_replace('_',' ',$k)) ?>
 <?php if($k==='warna'): ?><input type="color" name="<?= $k ?>" value="<?= e($v) ?>">
 <?php elseif(in_array($k,['meta_deskripsi','alamat'])): ?><textarea name="<?= $k ?>" rows="3"><?= e($v) ?></textarea>
 <?php else: ?><input name="<?= $k ?>" value="<?= e($v) ?>"><?php endif; ?></label>
<?php endforeach; ?><div><button class="btn">Simpan Pengaturan</button></div></form>
<?php admin_foot(); ?>
