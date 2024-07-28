<?php
// Configuração do e-mail para teste
$to = 'juviscreudo2@gmail.com'; // Substitua pelo seu endereço de e-mail real
$subject = 'Teste de Envio de E-mail';
$message = 'Se este e-mail chegar, o envio de e-mail está funcionando.';
$headers = 'From: no-reply@seusite.com' . "\r\n" .
           'Reply-To: no-reply@seusite.com' . "\r\n";

if (mail($to, $subject, $message, $headers)) {
    echo 'E-mail enviado com sucesso!';
} else {
    echo 'Falha ao enviar o e-mail.';
}
?>
