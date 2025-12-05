<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

require_once "db.php";

$res = $conn->query("
    SELECT
      id,
      title,
      description,
      category,
      thumbnail_url,
      video_url,
      created_at
    FROM courses
    ORDER BY created_at DESC
");

$courses = [];
while ($row = $res->fetch_assoc()) {
    $courses[] = $row;
}

echo json_encode([
    "success" => true,
    "courses" => $courses
]);
?>
