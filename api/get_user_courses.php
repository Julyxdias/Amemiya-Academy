<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

require_once "db.php";

/*
  Esperado:
  - opcionalmente receber ?user_id=UUID
  - retornar todos os cursos com status e progresso daquele usuário
  - se não tiver registro em user_course_progress, assume:
      status = 'nao_iniciado'
      progress_percent = 0
*/

$user_id = isset($_GET["user_id"]) ? trim($_GET["user_id"]) : null;

if ($user_id) {
    $stmt = $conn->prepare("
        SELECT
            c.id,
            c.title,
            c.description,
            c.category,
            c.thumbnail_url,
            c.video_url,
            IFNULL(p.status, 'nao_iniciado') AS status,
            IFNULL(p.progress_percent, 0) AS progress_percent
        FROM courses c
        LEFT JOIN user_course_progress p
            ON p.course_id = c.id AND p.user_id = ?
        ORDER BY c.created_at DESC
    ");
    $stmt->bind_param("s", $user_id);
} else {
    $stmt = $conn->prepare("
        SELECT
            c.id,
            c.title,
            c.description,
            c.category,
            c.thumbnail_url,
            c.video_url,
            'nao_iniciado' AS status,
            0 AS progress_percent
        FROM courses c
        ORDER BY c.created_at DESC
    ");
}

$stmt->execute();
$result = $stmt->get_result();

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

echo json_encode([
    "success" => true,
    "courses" => $courses
]);
?>
