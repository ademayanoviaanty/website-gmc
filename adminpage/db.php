<?php
$host     = "localhost";
$user     = "root";
$password = "";
$dbname   = "adminpage";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
  http_response_code(500);
  die(json_encode(["error" => "Koneksi gagal: " . $conn->connect_error]));
}

$conn->set_charset("utf8mb4");
