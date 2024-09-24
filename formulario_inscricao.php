<?php
session_start();
require_once 'config.php'; // Inclui o arquivo com detalhes de conexão ao banco de dados

// Verificação da conexão
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Verificação do ID do evento na URL
if (isset($_GET['id'])) {
    $idEvento = $_GET['id'];

    // Verificar se o que foi digitado na URL é um inteiro
    if (!filter_var($idEvento, FILTER_VALIDATE_INT)) {
        header('Location: index.php');
        exit();
    } else {
        // Utilize prepared statements para evitar SQL injection
        $sqlEvento = "SELECT * FROM evento WHERE idEvento = ?";
        $stmtEvento = $conexao->prepare($sqlEvento);
        $stmtEvento->bind_param("i", $idEvento);
        $stmtEvento->execute();
        $resultEvento = $stmtEvento->get_result();
        $evento = $resultEvento->fetch_assoc();

        if (!$evento) {
            // Redirecionar caso o evento não seja encontrado
            header('Location: index.php');
            exit();
        }
    }
} else {
    // Redirecionar caso o ID da URL não tenha valor
    header('Location: index.php');
    exit();
}

// Query para recuperar os detalhes do usuário (exemplo)
$idUsuario = 1; // Suponha que você tenha o ID do usuário específico
$sqlUsuario = "SELECT nomeCompleto, telefone, email FROM pessoa WHERE idPessoa = ?";
$stmtUsuario = $conexao->prepare($sqlUsuario);
$stmtUsuario->bind_param("i", $idUsuario);
$stmtUsuario->execute();
$resultUsuario = $stmtUsuario->get_result();

if ($resultUsuario->num_rows > 0) {
    $rowUsuario = $resultUsuario->fetch_assoc();
    $nome = $rowUsuario['nomeCompleto'];
    $telefone = $rowUsuario['telefone'];
    $email = $rowUsuario['email'];
} else {
    // Tratamento caso nenhum usuário seja encontrado
    $nome = "Nome do Participante";
    $telefone = "Telefone do Participante";
    $email = "email@exemplo.com";
}

// Fechar conexões e liberar recursos
$stmtEvento->close();
$stmtUsuario->close();
$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Inscrição</title>
    <link rel="stylesheet" href="CSS/formulario_inscricao.css">
</head>
<body>
    <nav class="navbar bg-body-tertiary tab">
        <div class="container-fluid" id="navbar_marca">
            <div id="logo">
                <span class="navbar-brand mb-0" style="color: white;"><img src="img/logo.jpg" alt="BrFideliza"> BrFideliza</span> 
            </div>
            <div id="menu">
                <a href="home.php"><img src="img/home-icon.png" alt="Página Inicial"></a>
                <a href="login.php"><img src="img/user-icon.png" alt="Perfil do Usuário"></a>
                <a href="historico.php"><img src="img/historico-icon.png" alt="Histórico"></a>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-left">
                <div class="event-details">
                    <img src="IMG/evento_imagem.jpeg" alt="">
                    <h2>Detalhes do Evento</h2>
                    <p>
                        <strong>Título:</strong> <?php echo htmlspecialchars($evento['eveTitulo']); ?><br>
                        <strong>Data:</strong> <?php echo date('d/m/Y', strtotime($evento['eveData'])); ?><br>
                        <strong>Local:</strong> <?php echo htmlspecialchars($evento['eveLocal']); ?>
                    </p>
                    <p><?php echo htmlspecialchars($evento['eveDescricao']); ?></p>
                </div>
            </div>
            <div class="col-right">
                <div class="registration-form">
                    <h2>Formulário de Inscrição</h2>
                    <form action="processo_formulario.php" method="post">
                        <label for="nome">Nome Completo:</label><br>
                        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required><br>
                        <label for="telefone">Telefone:</label><br>
                        <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>" required><br>
                        <label for="email">E-mail:</label><br>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>
                        <button type="submit">Enviar Inscrição</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer>
       <p class="rodape">© 2024 BrFideliza. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
