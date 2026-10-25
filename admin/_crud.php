<?php // Halaman CRUD generik. Set $type sebelum include.
require_once '_auth.php';
$mod = $MODULES[$type]; $items = load($type); $msg = '';
function portfolio_upload_index($file) {
  if (!is_array($file) || !isset($file['error']) || !is_int($file['error'])) { throw new RuntimeException('Data upload file index.html tidak valid.'); }
  if ($file['error'] === UPLOAD_ERR_NO_FILE) { return null; }
  if ($file['error'] !== UPLOAD_ERR_OK) { throw new RuntimeException('File index.html gagal diunggah. Silakan coba lagi.'); }
  if (!isset($file['name']) || !is_string($file['name']) || strtolower(basename($file['name'])) !== 'index.html') { throw new InvalidArgumentException('File yang diunggah harus bernama index.html.'); }
  if (!isset($file['size']) || !is_int($file['size']) || $file['size'] < 0 || $file['size'] > 3 * 1024 * 1024) { throw new InvalidArgumentException('Ukuran file index.html maksimal 3 MB.'); }
  if (!isset($file['tmp_name']) || !is_string($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) { throw new RuntimeException('File upload tidak valid.'); }

  $directoryName = bin2hex(random_bytes(16));
  $directory = __DIR__ . '/../uploads/portofolio/' . $directoryName;
  if (!mkdir($directory, 0755, true) && !is_dir($directory)) { throw new RuntimeException('Folder upload portofolio tidak dapat dibuat.'); }
  if (!move_uploaded_file($file['tmp_name'], $directory . '/index.html')) {
    rmdir($directory);
    throw new RuntimeException('File index.html tidak dapat disimpan.');
  }
  return 'uploads/portofolio/' . $directoryName . '/index.html';
}
function portfolio_delete_uploaded_index($url) {
  if (!preg_match('~^uploads/portofolio/([a-f0-9]{32})/index\.html$~', (string)$url, $matches)) { return; }
  $directory = __DIR__ . '/../uploads/portofolio/' . $matches[1];
  $file = $directory . '/index.html';
  if (is_file($file) && !unlink($file)) { throw new RuntimeException('File index.html lama tidak dapat dihapus.'); }
  if (is_dir($directory) && !rmdir($directory)) { throw new RuntimeException('Folder portofolio lama tidak dapat dihapus.'); }
}
function portfolio_upload_image($file) {
  if (!is_array($file) || !isset($file['error']) || !is_int($file['error'])) { throw new RuntimeException('Data upload gambar tidak valid.'); }
  if ($file['error'] === UPLOAD_ERR_NO_FILE) { return null; }
  if ($file['error'] !== UPLOAD_ERR_OK) { throw new RuntimeException('Gambar gagal diunggah. Silakan coba lagi.'); }
  if (!isset($file['name']) || !is_string($file['name'])) { throw new InvalidArgumentException('Nama file gambar tidak valid.'); }
  $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
  $allowedTypes = [
    'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png',
    'gif' => 'image/gif', 'webp' => 'image/webp',
  ];
  if (!isset($allowedTypes[$extension])) { throw new InvalidArgumentException('Format gambar harus JPG, PNG, GIF, atau WebP.'); }
  if (!isset($file['size']) || !is_int($file['size']) || $file['size'] < 0 || $file['size'] > 5 * 1024 * 1024) { throw new InvalidArgumentException('Ukuran gambar maksimal 5 MB.'); }
  if (!isset($file['tmp_name']) || !is_string($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) { throw new RuntimeException('File gambar upload tidak valid.'); }

  $imageInfo = @getimagesize($file['tmp_name']);
  $fileInfo = new finfo(FILEINFO_MIME_TYPE);
  if ($imageInfo === false || $imageInfo['mime'] !== $allowedTypes[$extension] || $fileInfo->file($file['tmp_name']) !== $allowedTypes[$extension]) {
    throw new InvalidArgumentException('Isi file tidak sesuai dengan format gambar yang dipilih.');
  }

  $fileName = bin2hex(random_bytes(16)) . '.' . $extension;
  $directory = __DIR__ . '/../uploads/portofolio/gambar';
  if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) { throw new RuntimeException('Folder upload gambar tidak dapat dibuat.'); }
  if (!move_uploaded_file($file['tmp_name'], $directory . '/' . $fileName)) { throw new RuntimeException('Gambar tidak dapat disimpan.'); }
  return 'uploads/portofolio/gambar/' . $fileName;
}
function portfolio_delete_uploaded_image($path) {
  if (!preg_match('~^uploads/portofolio/gambar/[a-f0-9]{32}\.(jpg|jpeg|png|gif|webp)$~', (string)$path)) { return; }
  $file = __DIR__ . '/../' . $path;
  if (is_file($file) && !unlink($file)) { throw new RuntimeException('Gambar portofolio lama tidak dapat dihapus.'); }
}
if ($_SERVER['REQUEST_METHOD']==='POST') {
  if (isset($_POST['hapus'])) {
    $deleted = null;
    foreach ($items as $item) { if ((string)$item['id'] === (string)$_POST['hapus']) { $deleted = $item; break; } }
    delete_item($type, $_POST['hapus']);
    if ($type === 'portofolio' && $deleted) {
      portfolio_delete_uploaded_index($deleted['url']);
      portfolio_delete_uploaded_image($deleted['gambar']);
    }
    $msg='Data dihapus';
  }
  else {
    $row = ['id' => $_POST['id'] ?: null];
    foreach ($mod['fields'] as $f=>$t) $row[$f] = $t==='checkbox' ? (isset($_POST[$f])?'1':'') : trim($_POST[$f]??'');
    if ($type === 'portofolio' && (isset($_FILES['index_file']) || isset($_FILES['gambar_file']))) {
      $oldUrl = '';
      $oldImage = '';
      foreach ($items as $item) {
        if ((string)$item['id'] === (string)$row['id']) {
          $oldUrl = $item['url'];
          $oldImage = $item['gambar'];
          break;
        }
      }
      $uploadedUrl = null;
      $uploadedImage = null;
      try {
        if (isset($_FILES['index_file'])) { $uploadedUrl = portfolio_upload_index($_FILES['index_file']); }
        if (isset($_FILES['gambar_file'])) { $uploadedImage = portfolio_upload_image($_FILES['gambar_file']); }
        if ($uploadedUrl !== null) { $row['url'] = $uploadedUrl; }
        if ($uploadedImage !== null) { $row['gambar'] = $uploadedImage; }
        save_item($type, $row);
      } catch (Throwable $error) {
        if ($uploadedUrl !== null) { portfolio_delete_uploaded_index($uploadedUrl); }
        if ($uploadedImage !== null) { portfolio_delete_uploaded_image($uploadedImage); }
        throw $error;
      }
      if ($oldUrl !== '' && $oldUrl !== $row['url']) { portfolio_delete_uploaded_index($oldUrl); }
      if ($oldImage !== '' && $oldImage !== $row['gambar']) { portfolio_delete_uploaded_image($oldImage); }
    } else {
      save_item($type, $row);
    }
    $msg='Data disimpan';
  }
  $items = load($type);
}
$edit = null; if (isset($_GET['edit'])) foreach ($items as $i) if ($i['id']==$_GET['edit']) $edit=$i;
admin_head('Kelola '.$mod['label']); $keys = array_keys($mod['fields']); ?>
<?php if($msg): ?><div class="ok"><?= $msg ?></div><?php endif; ?>
<div class="layout">
<form method="post" class="panel" <?= $type === 'portofolio' ? 'enctype="multipart/form-data"' : '' ?>>
 <h3><?= $edit?'Edit':'Tambah' ?> <?= $mod['label'] ?></h3><input type="hidden" name="id" value="<?= e($edit['id']??'') ?>">
 <?php foreach($mod['fields'] as $f=>$t): $v=$edit[$f]??''; ?>
  <label><?= ucfirst($f) ?>
  <?php if($t==='textarea'): ?><textarea name="<?= $f ?>" rows="4"><?= e($v) ?></textarea>
  <?php elseif($t==='checkbox'): ?><input type="checkbox" name="<?= $f ?>" <?= $v?'checked':'' ?>>
  <?php else: ?><input type="<?= $t ?>" name="<?= $f ?>" value="<?= e($v) ?>" <?= in_array($f,['gambar','foto'])?'data-preview':'' ?>><?php endif; ?>
  <?php if($type === 'portofolio' && $f === 'gambar'): ?><small>Isi URL gambar atau unggah gambar. Upload menggantikan URL gambar.</small>
  <input type="file" name="gambar_file" accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp">
  <?php endif; ?>
  <?php if($type === 'portofolio' && $f === 'url'): ?><small>URL website eksternal atau unggah file index.html di bawah ini. Jika keduanya diisi, file index.html yang digunakan.</small>
  <input type="file" name="index_file" accept=".html,text/html">
  <?php endif; ?>
  </label>
 <?php endforeach; ?>
 <button class="btn">Simpan</button> <?php if($edit): ?><a href="<?= $type ?>.php" class="btn gray">Batal</a><?php endif; ?>
</form>
<div class="panel"><input class="search" placeholder="Cari..." data-search>
<table><thead><tr><?php foreach(array_slice($keys,0,3) as $k): ?><th><?= ucfirst($k) ?></th><?php endforeach; ?><th>Aksi</th></tr></thead><tbody>
<?php foreach($items as $i): ?><tr><?php foreach(array_slice($keys,0,3) as $k): $v=$i[$k]??''; ?>
 <td><?= preg_match('/^(https?:.*\.(jpg|jpeg|png|gif|webp)|uploads\/portofolio\/gambar\/[a-f0-9]{32}\.(jpg|jpeg|png|gif|webp))|unsplash|pravatar/i',$v) ? '<img src="'.e($v).'">' : e(mb_strimwidth($v,0,60,'…')) ?></td><?php endforeach; ?>
 <td class="act"><a href="?edit=<?= $i['id'] ?>" class="btn sm">Edit</a>
 <form method="post" onsubmit="return confirm('Hapus data ini?')"><button name="hapus" value="<?= $i['id'] ?>" class="btn sm red">Hapus</button></form></td></tr>
<?php endforeach; ?></tbody></table></div></div>
<?php admin_foot(); ?>
