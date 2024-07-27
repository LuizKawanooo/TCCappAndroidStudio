<?php
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'];
$password = $data['password'];

$sql = "SELECT password FROM registrar_usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($hashed_password);
$stmt->fetch();

$response = array();
if (password_verify($password, $hashed_password)) {
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
    $response['error'] = 'Invalid email or password';
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
