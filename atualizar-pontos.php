<?php
// Permitir qualquer origem
header("Access-Control-Allow-Origin: *");

// Opcional: Permitir métodos específicos (GET, POST, etc.)
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Opcional: Permitir cabeçalhos específicos
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Defina o tipo de conteúdo como JSON
header('Content-Type: application/json');

// Configurações de conexão ao banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com"; // Nome do servidor
$username = "ionic_perfil_bd"; // Usuário do MySQL
$password = "{[UOLluiz2019"; // Senha do MySQL
$dbname = "tccappionic_bd"; // Nome do banco de dados

// Crie a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Conexão falhou: ' . $conn->connect_error]);
    exit;
}

// Função para atualizar os pontos do usuário
function atualizarPontosUsuario($rmUsuario) {
    global $conn;

    // Verifique se o RM do usuário foi fornecido
    if (!$rmUsuario) {
        return ['success' => false, 'message' => 'RM do usuário não foi fornecido.'];
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
            return ['success' => true, 'message' => "Pontos atualizados com sucesso! Novo total: $novosPontos pontos."];
        } else {
            return ['success' => false, 'message' => 'Erro ao atualizar pontos: ' . $stmtUpdate->error];
        }
    } else {
        return ['success' => false, 'message' => "Usuário com RM $rmUsuario não encontrado."];
    }
}

// Captura dados da requisição
$data = json_decode(file_get_contents("php://input"), true);
$rmUsuario = isset($data['rm']) ? $data['rm'] : null; // Alteração para versões mais antigas do PHP
$resultado = atualizarPontosUsuario($rmUsuario);

// Retorna o resultado como JSON
echo json_encode($resultado);

// Fechar a conexão
$conn->close();
?>
