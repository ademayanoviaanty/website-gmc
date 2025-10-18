<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/db.php';

$sql = "SELECT nama FROM kategori ORDER BY nama ASC";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
  $data[] = $row['nama'];
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

$conn->close();
