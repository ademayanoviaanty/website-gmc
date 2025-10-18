<?php
header('Content-Type: application/json');
require __DIR__ . '/db.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
  echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
  exit;
}

$uploadDir = __DIR__ . '/../landingpage/assets/img/uploaded';
$photo = null;

$stmt = $mysqli->prepare("SELECT photo FROM product WHERE id=?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($photo);
$stmt->fetch();
$stmt->close();

$stmt2 = $mysqli->prepare("DELETE FROM product WHERE id=?");
$stmt2->bind_param('i', $id);
$ok = $stmt2->execute();
$stmt2->close();

if (!$ok) {
  echo json_encode(['success' => false, 'message' => 'Gagal menghapus data.']);
  exit;
}

if ($photo) {
  $path = rtrim($uploadDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $photo;
  if (is_file($path)) {
    @unlink($path);
  }
}

echo json_encode(['success' => true, 'message' => 'Data produk berhasil dihapus.']);
