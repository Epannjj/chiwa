<?php
// Environment variables take priority. No real credentials belong in the ZIP.
function contact_db() {
    static $pdo = null;
    if ($pdo instanceof PDO) { return $pdo; }
    
    $file = __DIR__ . '/database.local.php';
    $local = is_file($file) ? require $file : [];
    if (!is_array($local)) { throw new RuntimeException('Invalid database configuration.'); }
    
    $get = function ($key, $default = '') use ($local) {
        $value = getenv('DB_' . strtoupper($key));
        return $value !== false ? $value : ($local[$key] ?? $default);
    };
    
    $host = $get('host', 'sql310.infinityfree.com');
    $port = $get('port', '3306');
    $name = $get('name', 'if0_43236243_chiwa');
    $user = $get('user', 'if0_43236243');
    $pass = $get('pass', '6TUVgJPhGZA5t'); // Fixed: looking up 'pass' with fallback to your password

    if ($user === '' || !preg_match('/^[0-9]+$/', (string)$port)
        || preg_match('/[;\x00-\x1f]/', $host . $name)) {
        throw new RuntimeException('Configure database.local.php or DB_* environment variables first.');
    }

    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    $pdo->exec("SET time_zone = '+07:00'");
    return $pdo;
}

function contact_validate($input) {
    $data = [];
    foreach (['nama', 'email', 'telepon', 'pesan'] as $key) {
        if (isset($input[$key]) && !is_string($input[$key])) {
            throw new InvalidArgumentException('Data formulir tidak valid.');
        }
        $data[$key] = trim($input[$key] ?? '');
    }
    if ($data['nama'] === '' || $data['pesan'] === ''
        || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException('Isi nama, email yang valid, dan pesan.');
    }
    foreach (['nama' => 150, 'email' => 254, 'telepon' => 40, 'pesan' => 10000] as $key => $limit) {
        if (!mb_check_encoding($data[$key], 'UTF-8') || mb_strlen($data[$key], 'UTF-8') > $limit) {
            throw new InvalidArgumentException('Data terlalu panjang atau mengandung karakter tidak valid.');
        }
    }
    return $data;
}

function contact_insert($input) {
    $data = contact_validate($input);
    $pdo = contact_db();
    $stmt = $pdo->prepare('INSERT INTO pesan_kontak (nama, email, telepon, pesan) VALUES (:nama, :email, :telepon, :pesan)');
    $stmt->execute($data);
    return (int)$pdo->lastInsertId();
}

function contact_all() {
    return contact_db()->query('SELECT id, nama, email, telepon, pesan, tanggal FROM pesan_kontak ORDER BY tanggal DESC, id DESC')->fetchAll();
}

function contact_count() {
    return (int)contact_db()->query('SELECT COUNT(*) FROM pesan_kontak')->fetchColumn();
}

function contact_delete($id) {
    if (!filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
        throw new InvalidArgumentException('ID pesan tidak valid.');
    }
    $stmt = contact_db()->prepare('DELETE FROM pesan_kontak WHERE id = :id');
    $stmt->execute(['id' => $id]);
}

function contact_csrf_token() {
    if (empty($_SESSION['contact_csrf'])) { $_SESSION['contact_csrf'] = bin2hex(random_bytes(32)); }
    return $_SESSION['contact_csrf'];
}

function contact_csrf_valid($token) {
    return is_string($token) && isset($_SESSION['contact_csrf']) && hash_equals($_SESSION['contact_csrf'], $token);
}
?>