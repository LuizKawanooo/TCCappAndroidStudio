<?php
// api.php

// Database connection
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve all time slots and their statuses
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $sql = "SELECT * FROM horarios";
  $result = $conn->query($sql);

  $horarios = array();
  while ($row = $result->fetch_assoc()) {
    $horarios[] = array(
      "id" => $row["id"],
      "horario" => $row["horario"],
      "status" => $row["status_horario"]
    );
  }

  echo json_encode($horarios);
}

// Update status of a time slot
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST["id"];
  $status = $_POST["status"];

  $sql = "UPDATE horarios SET status_horario = '$status' WHERE id = $id";
  $conn->query($sql);

  echo "Status updated successfully";
}

$conn->close();
?>
