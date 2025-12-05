<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once "db.php";

$data = json_decode(file_get_contents("php://input"), true);
$id   = trim($data["id"] ?? "");

if (!$id) {
    echo json_encode(["success" => false, "message" => "ID do curso não informado."]);
    exit;
}

// Se houver FK em user_course_progress, primeiro apaga o progresso
$conn->query("DELETE FROM user_course_progress WHERE course_id = (SELECT id FROM courses WHERE id = '$id')");

$stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
$stmt->bind_param("s", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Curso excluído com sucesso."]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao excluir curso: " . $stmt->error
    ]);
}
?>
