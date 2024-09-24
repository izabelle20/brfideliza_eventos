<?php
session_start();
include_once('config.php');

if (isset($_GET['id'])) {
    $idEvento = $_GET['id'];

    // Verificar se o que foi digitado na URL é um inteiro
    if (!filter_var($idEvento, FILTER_VALIDATE_INT)) {
        header('Location: index.php');
        exit();
    } else {
        // Utilize prepared statements para evitar SQL injection
        $sql = "SELECT * FROM evento WHERE idEvento = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $idEvento);
        $stmt->execute();
        $result = $stmt->get_result();
        $linha = $result->fetch_assoc();

        if (!$linha) {
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
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Eventos - BrFideliza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="pagina_evento.css">
</head>
<body>
    <nav class="navbar bg-body-tertiary tab">
        <div class="container-fluid" id="navbar_marca">
            <div id="logo">
                <span class="navbar-brand mb-0" style="color: white;"><img src="img/logo.jpg" alt="BrFideliza">BrFideliza</span>
            </div>
            <div id="menu">
                <a href="home.php"><img src="img/home-icon.png" alt="Página Inicial"></a> <!-- Ícone para página inicial -->
                <a href="login.php"><img src="img/user-icon.png" alt="Perfil do Usuário"></a> <!-- Ícone para perfil do usuário -->
                <a href="historico.php"><img src="img/historico-icon.png" alt="Histórico"></a> <!-- Ícone para histórico -->
            </div>
        </div>
    </nav>
    <div class="container mt-4" id="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card" id="card">
                    <div id="image-container">
                        <img src="IMG/evento_imagem.jpeg" class="card-img-top img-fluid" alt="Imagem do Evento">
                        <h5 class="card-title" id="card-title"><?php echo htmlspecialchars($linha['eveTitulo']); ?></h5>
                    </div>
                    <div class="card-body" id="card-body">
                        <p>Descrição: <?php echo htmlspecialchars($linha['eveDescricao']); ?></p>
                        <br>
                        <hr>
                        <p>Data inicial: <?php echo htmlspecialchars($linha['eveDtIniInscricao']); ?></p>
                        <p>Horário inicial: <?php echo htmlspecialchars($linha['eveHrIniInscricao'] ?? 'N/A'); ?></p>
                        <p>Data final: <?php echo htmlspecialchars($linha['eveDtFimInscricao']); ?></p>
                        <p>Local: <?php echo htmlspecialchars($linha['eveLocal']); ?></p>
                        <p>Total de vagas: <?php echo htmlspecialchars($linha['eveVagas']); ?></p>
                        <p>Valor do ingresso: <?php echo htmlspecialchars($linha['eveVlIngresso']); ?></p>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <a href="formulario_inscricao.php?id=<?php echo $idEvento; ?>" class="btn btn-danger btn-block">Comprar ingresso</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p class="rodape">© 2024 BrFideliza. Todos os direitos reservados.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
