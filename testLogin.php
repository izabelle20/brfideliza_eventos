<?php
session_start();
if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])){

    include_once('config.php');
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Preparar a consulta SQL para evitar SQL Injection
    $stmt = $conexao->prepare("SELECT * FROM pessoa WHERE email = ? AND senha = ?");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows < 1){
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    } else {
        $_SESSION['email'] = $email;
        $_SESSION['senha'] = $senha;
        header('Location: Sistema.php');
    }

    $stmt->close();
} else {
    header('Location: login.php');
}
?>
