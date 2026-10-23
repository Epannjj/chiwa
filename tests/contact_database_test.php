<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require_once __DIR__ . '/../includes/database.php';
function check($ok, $message) { if (!$ok) { throw new RuntimeException($message); } }
$ids = [];
try {
  $before = contact_count();
  $input = ['nama'=>"Uji O'Connor", 'email'=>'contact-test@example.com', 'telepon'=>'081234567890', 'pesan'=>"Uji pesan database 😀\n<script>alert('uji')</script>"];
  $ids[] = contact_insert($input); $ids[] = contact_insert($input);
  check($ids[0] !== $ids[1], 'Each submission must get a unique ID.');
  check(contact_count() === $before + 2, 'Dashboard count must read the database.');
  $found = array_values(array_filter(contact_all(), function ($row) use ($ids) { return (int)$row['id'] === $ids[0]; }));
  check(count($found) === 1 && $found[0]['pesan'] === $input['pesan'] && $found[0]['nama'] === $input['nama'], 'Admin must read back exact message contents.');
  $invalid = false;
  try { contact_insert(['nama'=>'Uji','email'=>'invalid','pesan'=>'Hello']); } catch (InvalidArgumentException $ex) { $invalid = true; }
  check($invalid && contact_count() === $before + 2, 'Invalid input must not be persisted.');
  contact_delete($ids[0]);
  check(contact_count() === $before + 1, 'Delete must remove the database row.');
  echo "PASS: database insert/read/count/delete, unique IDs, Unicode, validation.\n";
} finally {
  foreach ($ids as $id) { contact_delete($id); }
}