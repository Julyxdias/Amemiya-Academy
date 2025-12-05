<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$registro = $data["registro"] ?? "";
$password = $data["password"] ?? "";

if (!$registro || !$password) {
    echo json_encode(["success" => false, "message" => "Registro ou senha vazios."]);
    exit;
}

$stmt = $conn->prepare("SELECT id, registro, name, password_hash, role FROM users WHERE registro = ? LIMIT 1");
$stmt->bind_param("s", $registro);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Usuário não encontrado."]);
    exit;
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user["password_hash"])) {
    echo json_encode(["success" => false, "message" => "Senha incorreta."]);
    exit;
}

echo json_encode([
    "success"   => true,
    "user_id"   => $user["id"],
    "registro"  => $user["registro"],
    "name"      => $user["name"],
    "role"      => $user["role"]
]);
?>
