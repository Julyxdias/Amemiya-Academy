<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$title        = trim($data["title"] ?? "");
$description  = trim($data["description"] ?? "");
$category     = trim($data["category"] ?? "");
$thumbnail_url= trim($data["thumbnail_url"] ?? "");
$video_url    = trim($data["video_url"] ?? "");

if (!$title) {
    echo json_encode(["success" => false, "message" => "Título é obrigatório."]);
    exit;
}

/*
   Ajuste aqui conforme está sua tabela COURSES.
   Vou assumir algo perto disso:

   CREATE TABLE courses (
     id CHAR(36) PRIMARY KEY,
     title TEXT NOT NULL,
     description TEXT,
     category TEXT,
     thumbnail_url TEXT,
     video_url TEXT,
     created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   );
*/

$id = uuid_create(UUID_TYPE_RANDOM); // se tiver ext/uuid habilitada

$stmt = $conn->prepare("
    INSERT INTO courses (id, title, description, category, thumbnail_url, video_url)
    VALUES (?, ?, ?, ?, ?, ?)
");
$stmt->bind_param("ssssss", $id, $title, $description, $category, $thumbnail_url, $video_url);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Curso criado com sucesso."]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao inserir curso: " . $stmt->error
    ]);
}
?>
