<?php
function gerarToken($id) {
    $chave = 'sua_chave_secreta'; // Deve ser uma chave secreta conhecida apenas pelo seu servidor
    return hash_hmac('sha256', $id, $chave);
}
?>
