<?php
// Permitir qualquer origem
header("Access-Control-Allow-Origin: *");

// Opcional: Permitir métodos específicos (GET, POST, etc.)
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Opcional: Permitir cabeçalhos específicos
header("Access-Control-Allow-Headers: Content-Type, Authorization");



$servername = "tccappionic-bd.mysql.uhserver.com"; // Nome do servidor
$username = "ionic_perfil_bd"; // Usuário do MySQL
$password = "{[UOLluiz2019"; // Senha do MySQL
$dbname = "tccappionic_bd"; // Nome do banco de dados

// Crie a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Função para atualizar os pontos do usuário
function atualizarPontosUsuario($rmUsuario) {
    global $conn;

    // Verifique se o RM do usuário foi fornecido
    if (!$rmUsuario) {
        return "RM do usuário não foi fornecido.";
    }

    // Consultar o valor atual de pontos do usuário
    $sqlGetPontos = "SELECT pontos FROM registrar_usuarios WHERE rm = ?";
    $stmtGet = $conn->prepare($sqlGetPontos);
    $stmtGet->bind_param("s", $rmUsuario); // Vincula o parâmetro RM
    $stmtGet->execute();
    $result = $stmtGet->get_result();

    // Verificar se o usuário existe no banco de dados
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pontosAtuais = $row['pontos'];

        // Adicionar 100 pontos aos pontos atuais
        $novosPontos = $pontosAtuais + 100;

        // Atualizar o valor dos pontos no banco de dados
        $sqlUpdatePontos = "UPDATE registrar_usuarios SET pontos = ? WHERE rm = ?";
        $stmtUpdate = $conn->prepare($sqlUpdatePontos);
        $stmtUpdate->bind_param("is", $novosPontos, $rmUsuario); // Vincula novos pontos e RM
        if ($stmtUpdate->execute()) {
            return "Pontos atualizados com sucesso! Novo total: $novosPontos pontos.";
        } else {
            return "Erro ao atualizar pontos: " . $stmtUpdate->error;
        }
    } else {
        return "Usuário com RM $rmUsuario não encontrado.";
    }
}

// Exemplo de uso da função, substitua "12345" pelo RM real do usuário
$rmUsuario = $_POST['rm']; // Ou de onde você está recebendo o RM do usuário
$resultado = atualizarPontosUsuario($rmUsuario);
echo $resultado;

// Fechar a conexão
$conn->close();
?>


