<?php
header('Content-Type: application/json');
require __DIR__ . '/db.php';

$sql = "SELECT id, name, harga, kategori, deskripsi, photo, status, created_at
        FROM product
        ORDER BY id DESC";

$res = $conn->query($sql);

if (!$res) {
  echo json_encode(['success' => false, 'message' => $conn->error]);
  exit;
}

$data = [];
while ($row = $res->fetch_assoc()) {
  $data[] = [
    'id'         => (int)$row['id'],
    'name'       => $row['name'],
    'harga'      => $row['harga'],
    'kategori'   => $row['kategori'],
    'deskripsi'  => $row['deskripsi'],
    'photo'      => $row['photo'],
    'status'     => $row['status'],
    'created_at' => $row['created_at'],
  ];
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
