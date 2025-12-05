<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once "db.php";

$raw  = file_get_contents("php://input");
$data = json_decode($raw, true);

$user_id          = $data["user_id"] ?? null;
$registro         = $data["registro"] ?? null;
$course_id        = $data["course_id"] ?? null;
$status           = $data["status"] ?? null;
$progress_percent = $data["progress_percent"] ?? null;

if (!$course_id || !$status) {
    echo json_encode([
        "success" => false,
        "message" => "course_id ou status faltando",
        "debug"   => $data
    ]);
    exit;
}

// se veio user_id, usamos ele diretamente
if ($user_id) {
    $user_id = trim($user_id);
} 
else {
    // buscar user_id pelo registro
    if (!$registro) {
        echo json_encode([
            "success" => false,
            "message" => "Nenhum user_id ou registro foi enviado",
            "debug"   => $data
        ]);
        exit;
    }

    $stmtUser = $conn->prepare("SELECT id FROM users WHERE registro = ? LIMIT 1");
    $stmtUser->bind_param("s", $registro);
    $stmtUser->execute();
    $resUser = $stmtUser->get_result();

    if ($row = $resUser->fetch_assoc()) {
        $user_id = $row["id"];
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Registro não encontrado: $registro"
        ]);
        exit;
    }
}

// status válido?
$valid = ["nao_iniciado", "em_andamento", "concluido"];
if (!in_array($status, $valid)) {
    echo json_encode([
        "success" => false,
        "message" => "Status inválido"
    ]);
    exit;
}

if ($progress_percent === null) {
    $progress_percent = $status === "concluido" ? 100 : ($status === "em_andamento" ? 50 : 0);
}

$now = date("Y-m-d H:i:s");

// verifica se já existe progresso
$stmtCheck = $conn->prepare("
    SELECT id FROM user_course_progress
    WHERE user_id = ? AND course_id = ?
");
$stmtCheck->bind_param("si", $user_id, $course_id);
$stmtCheck->execute();
$resCheck = $stmtCheck->get_result();

if ($row = $resCheck->fetch_assoc()) {

    $stmt = $conn->prepare("
        UPDATE user_course_progress
        SET status = ?, progress_percent = ?
        WHERE id = ?
    ");
    $stmt->bind_param("sii", $status, $progress_percent, $row["id"]);
    $stmt->execute();

    echo json_encode([
        "success" => true,
        "message" => "Progresso atualizado (UPDATE)",
        "data" => $data
    ]);
    exit;

} else {

    $stmt = $conn->prepare("
        INSERT INTO user_course_progress (user_id, course_id, status, progress_percent)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("sisi", $user_id, $course_id, $status, $progress_percent);
    $stmt->execute();

    echo json_encode([
        "success" => true,
        "message" => "Progresso criado (INSERT)",
        "data" => $data
    ]);
    exit;
}
?>
