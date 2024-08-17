<?php
$host = 'tccappionic-bd.mysql.uhserver.com';
$user = 'ionic_perfil_bd';
$password = '{[UOLluiz2019';
$database = 'tccappionic_bd';

$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_error) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

// Consulta para recuperar PDFs
$query = "SELECT id, titulo FROM artigos";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="card">';
        echo '<h3>' . htmlspecialchars($row['titulo']) . '</h3>';
        echo '<a href="detalhes_pdf.php?id=' . $row['id'] . '">Ver Detalhes</a>';
        echo '</div>';
    }
} else {
    echo "Nenhum PDF encontrado.";
}

$mysqli->close();
?>
