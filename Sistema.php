<?php
session_start();
if ((!isset($_SESSION['email']) == true) && (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: login.php');
}
$logado = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo</title>
    <link rel="stylesheet" href="sistema.css">
</head>
<body>

    <nav class="navbar bg-body-tertiary tab">
        <div class="container-fluid" id="navbar_marca">
            <div id="logo">
                <span class="navbar-brand mb-0" style="color: white;"><img src="img/logo.jpg" alt="BrFideliza">BrFideliza</span>
            </div>
            <div id="menu">
                <a href="home.php"><img src="img/home-icon.png" alt="Página Inicial"></a>
                <a href="login.php"><img src="img/user-icon.png" alt="Perfil do Usuário"></a>
                <a href="historico.php"><img src="img/historico-icon.png" alt="Histórico"></a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div>
            <a href="sair.php">Sair</a>
            <a href="home.php">Home</a>
        </div>
        <?php
            echo "<h1>Bem-vindo <u>$logado</u></h1>";
        ?>
    </div>
    <footer>
        <p class="rodape">© 2024 BrFideliza. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
