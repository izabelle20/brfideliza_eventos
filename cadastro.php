<?php
// Incluir o arquivo de configuração
require_once 'config.php';

// Variável para armazenar mensagens de erro
$erro = '';

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se todos os campos obrigatórios estão preenchidos
    if (empty($_POST['nome']) || empty($_POST['cpf']) || empty($_POST['telefone']) || empty($_POST['email']) || empty($_POST['senha'])) {
        $erro = "Todos os campos são obrigatórios!";
    } else {
        // Recuperar os dados do formulário
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Verificar se o e-mail já está cadastrado
        $sql = "SELECT idPessoa FROM pessoa WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $erro = "O e-mail já está cadastrado!";
        } else {
            // Hash da senha
            //$hashSenha = password_hash($senha, PASSWORD_DEFAULT);

            // Inserir os dados no banco de dados
            $sql = "INSERT INTO pessoa (nomeCompleto, CPF, telefone, email, senha, ativo, dataRegistro, dataUltimaAtualizacao) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
            $stmt = $conexao->prepare($sql);     
            $ativo = 1;
            $stmt->bind_param("sssssi", $nome, $cpf, $telefone, $email, $senha, $ativo);

            if ($stmt->execute()) {
                // Redirecionar para uma página de sucesso após o cadastro
                header("Location: cadastro_sucesso.php");
                exit();
            } else {
                $erro = "Erro ao cadastrar. Tente novamente mais tarde!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="cadastro.css">
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

    <div class="row d-flex justify-content-center" id="card_principal_cadastro">

        <div class="col-6" id="card_direita">
            <div class="justify-content-center" id="logo" style="margin-top: 5%;">
                <img src="img/logo.jpg" alt="BrFideliza">
            </div>
            <h1>Cadastre-se</h1>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                <div class="mb-3 form-login">
                    <label for="form-nome" class="form-label" style="color:white">Nome Completo:</label>
                    <input type="text" name="nome" class="form-control" id="form-nome">

                    <label for="form-cpf" class="form-label" style="color:white">CPF:</label>
                    <input type="text" name="cpf" class="form-control" id="form-cpf">

                    <label for="form-telefone" class="form-label" style="color:white">Telefone:</label>
                    <input type="text" name="telefone" class="form-control" id="form-telefone">

                    <label for="form-email" class="form-label" style="color:white">Email:</label>
                    <input type="email" name="email" class="form-control" id="form-email">

                    <label for="form-senha" class="form-label" style="color:white">Senha:</label>
                    <input type="password" name="senha" class="form-control" id="form-senha">

                    <!-- Mostrar mensagem de erro, se houver -->
                    <?php if (!empty($erro)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $erro; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <input type="submit" name="submit" value="Cadastrar" id="botao_cadastro" class="btn btn-cadastrar">
            </form>
        </div>
    </div>

    <footer>
       <p class="rodape">© 2024 BrFideliza. Todos os direitos reservados.</p>
    </footer>
</body>

</html>
