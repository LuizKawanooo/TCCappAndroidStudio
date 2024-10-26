// api/database_connection.php
<?php
$host = 'tccappionic-bd.mysql.uhserver.com'; // Endereço do seu servidor
$user = 'ionic_perfil_bd'; // Usuário do banco de dados
$password = '{[UOLluiz2019'; // Senha do banco de dados
$dbname = 'tccappionic_bd'; // Nome do banco de dados

$connection = new mysqli($host, $user, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
