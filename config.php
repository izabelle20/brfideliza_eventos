<?php
$servername = "199.193.117.238";
$username = "brfpix_user_eventos01";
$password = "3ZmMlnD1iqTQ";
$dbname = "brfpix_eventos01";

// Cria a conexão
$conexao = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conexao->connect_error) {
    die("Connection failed: " . $conexao->connect_error);
}
?>
