<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/cadastrosucesso.css">
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

    <div class="container mt-5">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Cadastro Realizado com Sucesso!</h4>
            <p>Seu cadastro foi concluído com sucesso. Agora você pode fazer login para acessar sua conta.</p>
            <hr>
            <p class="mb-0">Clique <a href="login.php">aqui</a> para fazer login.</p>
        </div>
    </div>

    <footer>
       <p class="rodape">© 2024 BrFideliza. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
