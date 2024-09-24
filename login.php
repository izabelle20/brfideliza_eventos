<?php 
session_start();

if (isset($_SESSION['email']) && isset($_SESSION['senha'])) {
    header('Location: Sistema.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/login.css">
</head>
<body>
    <!-- NavBar -->
    <nav class="navbar bg-body-tertiary tab">
        <div class="container-fluid" id="navbar_marca">
            <div id="logo">
                <span class="navbar-brand mb-0" style="color: white;"><img src="img/logo.jpg" alt="BrFideliza">BrFideliza</span> <!-- Logotipo da marca -->
            </div>
            <div id="menu">
                <a href="home.php"><img src="img/home-icon.png" alt="Página Inicial"></a> <!-- Ícone para página inicial -->
                <a href="login.php"><img src="img/user-icon.png" alt="Perfil do Usuário"></a> <!-- Ícone para perfil do usuário -->
                <a href="historico.php"><img src="img/historico-icon.png" alt="Histórico"></a> <!-- Ícone para histórico -->
            </div>
        </div>
    </nav>

    <div class="row" id="Card_principal">
        <div class="col-6" id="card_esquerda">
            <div>
                <h1>Seja bem-vindo a BrFideliza</h1>
            </div>
            <div class="logo_grande">
                <img src="IMG/logo.jpg" alt="" width='100%'>
            </div>
        </div>

        <div class="col-6" id="card_direita">
            <h1>Login</h1>
            <form action="testLogin.php" method="POST">
                <div class="mb-3 form-login">
                    <label for="form-email" class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" id="form-email" required>
                </div>
                <div class="mb-3 form-login">
                    <label for="form-senha" class="form-label">Senha:</label>
                    <input type="password" name="senha" class="form-control" id="form-senha" required><br>
                    <a href="#">Esqueci minha senha</a> <br>
                    <a href="cadastro.php">Não possui cadastro?</a>
                </div>
                <input type="submit" name="submit" value="Entrar" id="botao_login" class="btn btn-entrar">
            </form>
        </div>
    </div>
    
    <footer>
       <p class="rodape">© 2024 BrFideliza. Todos os direitos reservados.</p>
    </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="JS/login.js"></script>
</html>
