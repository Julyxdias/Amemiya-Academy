<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id           = trim($data["id"] ?? "");
$title        = trim($data["title"] ?? "");
$description  = trim($data["description"] ?? "");
$category     = trim($data["category"] ?? "");
$thumbnail_url= trim($data["thumbnail_url"] ?? "");
$video_url    = trim($data["video_url"] ?? "");

if (!$id) {
    echo json_encode(["success" => false, "message" => "ID do curso não informado."]);
    exit;
}
if (!$title) {
    echo json_encode(["success" => false, "message" => "Título é obrigatório."]);
    exit;
}

$stmt = $conn->prepare("
    UPDATE courses
    SET title = ?, description = ?, category = ?, thumbnail_url = ?, video_url = ?
    WHERE id = ?
");
$stmt->bind_param("ssssss", $title, $description, $category, $thumbnail_url, $video_url, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Curso atualizado com sucesso."]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao atualizar curso: " . $stmt->error
    ]);
}
?>
