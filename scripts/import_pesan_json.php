<?php
// CLI only: php scripts/import_pesan_json.php [path/to/pesan.json]
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require_once __DIR__ . '/../includes/database.php';
$pdo = null;
try {
  $path = $argv[1] ?? __DIR__ . '/../data/pesan.json';
  if (!is_file($path) || !is_readable($path)) { throw new RuntimeException('JSON file not found.'); }
  $rows = json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
  if (!is_array($rows) || array_values($rows) !== $rows) { throw new RuntimeException('Expected an array of messages.'); }
  $pdo = contact_db(); $pdo->beginTransaction();
  $stmt = $pdo->prepare('INSERT INTO pesan_kontak (nama,email,telepon,pesan,tanggal,legacy_key) VALUES (:nama,:email,:telepon,:pesan,:tanggal,:legacy_key) ON DUPLICATE KEY UPDATE legacy_key = VALUES(legacy_key)');
  $inserted = 0;
  foreach ($rows as $index => $row) {
    if (!is_array($row)) { throw new RuntimeException('Invalid legacy row.'); }
    $data = contact_validate($row);
    $text = $row['tanggal'] ?? '';
    if (!is_string($text)) { throw new RuntimeException('Invalid legacy date.'); }
    $format = strlen($text) === 16 ? '!Y-m-d H:i' : '!Y-m-d H:i:s';
    $date = DateTimeImmutable::createFromFormat($format, $text, new DateTimeZone('Asia/Jakarta'));
    $errors = DateTimeImmutable::getLastErrors();
    if (!$date || ($errors && ($errors['warning_count'] || $errors['error_count']))) { throw new RuntimeException('Invalid legacy date.'); }
    $data['tanggal'] = $date->format('Y-m-d H:i:s');
    $data['legacy_key'] = hash('sha256', $index . ':' . json_encode($row, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR));
    $stmt->execute($data); $inserted += $stmt->rowCount() === 1 ? 1 : 0;
  }
  $pdo->commit();
  echo "Import selesai: $inserted pesan baru, " . (count($rows) - $inserted) . " sudah pernah diimpor. File JSON tidak diubah.\n";
} catch (Throwable $ex) {
  if ($pdo instanceof PDO && $pdo->inTransaction()) { $pdo->rollBack(); }
  fwrite(STDERR, "Import dibatalkan. Periksa konfigurasi, tabel, dan format seluruh pesan/tanggal dalam JSON. Tidak ada impor parsial.\n"); exit(1);
}