<?php
header('Content-Type: application/json');
require __DIR__ . '/db.php';

$uploadDir = __DIR__ . '/../landingpage/assets/img/uploaded';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0775, true);
$id        = isset($_POST['index']) ? (int)$_POST['index'] : 0;
$name      = trim($_POST['name'] ?? '');
$harga     = trim($_POST['harga'] ?? '');
$kategori  = trim($_POST['kategori'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');
$oldPhoto  = trim($_POST['oldPhoto'] ?? '');

if ($name === '' || $harga === '' || $kategori === '' || $deskripsi === '') {
  echo json_encode(['success' => false, 'message' => 'Field wajib tidak lengkap.']);
  exit;
}

function randomFilename($ext)
{
  return date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
}

$photoFilename = $oldPhoto;
if (!empty($_FILES['photo']['name'])) {
  $file = $_FILES['photo'];
  if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Upload error: ' . $file['error']]);
    exit;
  }

  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $mime = finfo_file($finfo, $file['tmp_name']);
  finfo_close($finfo);

  $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'];
  if (!isset($allowed[$mime])) {
    echo json_encode(['success' => false, 'message' => 'Tipe file tidak didukung.']);
    exit;
  }

  $ext = $allowed[$mime];
  $newName = randomFilename($ext);
  $dest = $uploadDir . DIRECTORY_SEPARATOR . $newName;

  if (!move_uploaded_file($file['tmp_name'], $dest)) {
    echo json_encode(['success' => false, 'message' => 'Gagal memindahkan file upload.']);
    exit;
  }

  if ($oldPhoto && is_file($uploadDir . DIRECTORY_SEPARATOR . $oldPhoto)) {
    @unlink($uploadDir . DIRECTORY_SEPARATOR . $oldPhoto);
  }

  $photoFilename = $newName;
}

if ($id > 0) {
  if ($kategori !== '') {
    $stmt = $conn->prepare("INSERT IGNORE INTO kategori (nama) VALUES (?)");
    $stmt->bind_param("s", $kategori);
    $stmt->execute();
    $stmt->close();
  }

  $stmt = $conn->prepare("UPDATE product SET name=?, harga=?, kategori=?, deskripsi=?, photo=? WHERE id=?");
  if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit;
  }
  $stmt->bind_param('sssssi', $name, $harga, $kategori, $deskripsi, $photoFilename, $id);
  $ok = $stmt->execute();
  $stmt->close();
  echo json_encode(['success' => $ok, 'message' => $ok ? 'Data diperbarui.' : 'Gagal update data.']);
  exit;
} else {
  if ($kategori !== '') {
    $stmt = $conn->prepare("INSERT IGNORE INTO kategori (nama) VALUES (?)");
    $stmt->bind_param("s", $kategori);
    $stmt->execute();
    $stmt->close();
  }

  $stmt = $conn->prepare("INSERT INTO product (name, harga, kategori, deskripsi, photo, added_date) VALUES (?,?,?,?,?, NOW())");
  if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit;
  }
  $stmt->bind_param('sssss', $name, $harga, $kategori, $deskripsi, $photoFilename);
  $ok = $stmt->execute();
  $stmt->close();
  echo json_encode(['success' => $ok, 'message' => $ok ? 'Data ditambahkan.' : 'Gagal tambah data.']);
  exit;
}
