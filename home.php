<?php
include 'config.php';
session_start(); // Verifica se o usuário está conectado
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres do documento como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Define a escala inicial para dispositivos móveis -->
    <title>Página Inicial - BrFideliza</title> <!-- Título da página -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> <!-- Importa o CSS do Bootstrap -->
    <link rel="stylesheet" href="CSS/home.css"> <!-- Importa o arquivo CSS personalizado -->
</head>
<body>
    <nav class="navbar bg-body-tertiary tab">
        <div class="container-fluid" id="navbar_marca">
            <div id="logo">
                <span class="navbar-brand mb-0" style="color: white;"><img src="img/logo.jpg" alt="BrFideliza">BrFideliza</span> 
            </div>
            <div id="menu">
                <a href="./ADM/sistema_adm.php"><img src="img/home-icon.png" alt="Página Inicial"></a> <!-- Ícone para página inicial -->
                <a href="login.php"><img src="img/user-icon.png" alt="Perfil do Usuário"></a> <!-- Ícone para perfil do usuário -->
                <a href="historico.php"><img src="img/historico-icon.png" alt="Histórico"></a> <!-- Ícone para histórico -->
            </div>
        </div>
    </nav>

    <div class="container mt-4" id="barra_pesquisa">
        <form method="GET" action="home.php">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Digite o nome do evento..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-danger" type="submit" id="button-addon2">Buscar</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="card-container">
            <?php
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            if ($search) {
                // Prepara a consulta usando Prepared Statements
                $stmt = $conexao->prepare("SELECT * FROM evento WHERE eveTitulo LIKE ?");
                $search = "%" . $search . "%";
                $stmt->bind_param("s", $search);
            } else {
                $stmt = $conexao->prepare("SELECT * FROM evento");
            }

            $stmt->execute();
            $result = $stmt->get_result(); // Executa a consulta e obtém o resultado

            if ($result && $result->num_rows > 0) { 
                while ($linha = $result->fetch_assoc()) { 
            ?>
                    <div class="card" id="card">
                        <img src="img/evento_imagem.jpeg" class="card-img-top" alt="Imagem do Evento"> 
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($linha["eveTitulo"]); ?></h5> 
                            <p>Dias do Evento: <?php echo htmlspecialchars($linha["eveData"]); ?></p>
                            <p>Local: <?php echo htmlspecialchars($linha["eveLocal"]); ?></p> 
                            <a href="pagina_evento.php?id=<?php echo htmlspecialchars($linha["idEvento"]); ?>" class="btn btn-danger">Ver detalhes</a>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "0 resultados encontrados."; 
            }
            $stmt->close();
            ?>
        </div>
    </div>

    <footer>
       <p class="rodape">© 2024 BrFideliza. Todos os direitos reservados.</p> <!-- modificar para a cor branca -->
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> <!-- Importa o JavaScript do Bootstrap -->
</body>
</html>
