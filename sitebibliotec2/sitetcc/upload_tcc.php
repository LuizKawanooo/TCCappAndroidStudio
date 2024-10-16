// <?php
// // Conexão com o banco de dados
// $servername = "tccappionic-bd.mysql.uhserver.com";
// $username = "ionic_perfil_bd";
// $password = "{[UOLluiz2019";
// $dbname = "tccappionic_bd";

// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Verifica se o formulário foi enviado para inserir um artigo
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $titulo = $_POST['titulo'];
//     $autor = $_POST['autor'];
//     $ano = $_POST['ano'];

//     // Processa o upload do arquivo, se um novo arquivo foi enviado
//     $arquivo = NULL;
//     if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == UPLOAD_ERR_OK) {
//         if (pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION) !== 'pdf') {
//             echo "Apenas arquivos PDF são permitidos.";
//             exit();
//         }
//         // Lê o conteúdo do arquivo
//         $arquivo = file_get_contents($_FILES['arquivo']['tmp_name']);
//     }

//     // Insere os dados no banco
//     if ($arquivo !== NULL) {
//         // Insere também o arquivo
//         $stmt = $conn->prepare("INSERT INTO artigos (titulo, autor, ano, arquivo) VALUES (?, ?, ?, ?)");
//         $stmt->bind_param("sssb", $titulo, $autor, $ano, $arquivo);
//     } else {
//         // Se não há novo arquivo, insere apenas os outros campos
//         $stmt = $conn->prepare("INSERT INTO artigos (titulo, autor, ano) VALUES (?, ?, ?)");
//         $stmt->bind_param("sss", $titulo, $autor, $ano);
//     }

//     // Executa a inserção e verifica se ocorreu um erro
//     if ($stmt->execute()) {
//         header("Location: tcc.php");
//         exit();
//     } else {
//         echo "Erro ao inserir registro: " . $stmt->error;
//     }
//     $stmt->close();
// }

// $conn->close();
// ?>














<?php
// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se a ação é adicionar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano = $_POST['ano'];

    // Verifica se o arquivo foi enviado
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
        // Obtém o arquivo
        $arquivo = $_FILES['arquivo']['tmp_name'];
        $blob = file_get_contents($arquivo);

        // Prepara a consulta SQL para inserir
        $stmt = $conn->prepare("INSERT INTO artigos (titulo, autor, ano, arquivo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssb", $titulo, $autor, $ano, $blob);

        // Executa a consulta
        if ($stmt->execute()) {
            echo "TCC adicionado com sucesso!";
        } else {
            echo "Erro ao adicionar TCC: " . $stmt->error;
        }

        // Fecha a declaração
        $stmt->close();
    } else {
        echo "Erro ao enviar o arquivo.";
        if (isset($_FILES['arquivo'])) {
            echo " Código de erro: " . $_FILES['arquivo']['error'];
        }
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
