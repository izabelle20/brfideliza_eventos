<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="historico.css">
    <title>Histórico de Eventos</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar bg-body-tertiary tab">
        <div class="container-fluid" id="navbar_marca">
            <div id="logo">
                <span class="navbar-brand mb-0" style="color: white;"><img src="img/logo.jpg" alt="BrFideliza">BrFideliza</span>
            </div>
            <div id="menu">
                <!-- Check if user is logged in -->
                <?php if(isset($_SESSION['usuario'])): ?>
                    <p class="navbar-text" style="color: white;">Seja bem-vindo, <?php echo $_SESSION['usuario']; ?></p>
                <?php endif; ?>
                <!-- Navigation links -->
                <a href="home.php"><img src="img/home-icon.png" alt="Página Inicial"></a>
                <a href="login.php"><img src="img/user-icon.png" alt="Perfil do Usuário"></a>
                <a href="historico.php"><img src="img/historico-icon.png" alt="Histórico"></a>
            </div>
        </div>
    </nav>

    <!-- Event History Section -->
    <div class="row secao_historico">
        <div class="col-10">
            <?php
            // Include database connection
            include 'config.php';

            // SQL query to retrieve events
            $sql = "SELECT * FROM evento";
            $result = $conexao->query($sql);

            // Display events if found
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card_historico">';
                    echo '<img class="" src="IMG/evento_imagem.jpeg" alt="">';
                    echo '<div class="info_card_historico">';
                    echo '<p class="historico_nome_produto">' . $row["eveTitulo"] . '</p>';
                    echo '<p>Organizador: ' . $row["empresa_idEmpresa"] . '</p>';
                    echo '<p>Pago no cartão de crédito</p>'; // Example details
                    echo '<p class="mt-4 mb-2">Valor: R$' . $row["eveVlIngresso"] . '</p>';
                    echo '<p class="btn-card-historico">';
                    echo '<a href="pagina_evento.php"><i class="fa fa-refresh" aria-hidden="true"></i> Ver informações</a>'; // Example action links
                    echo '<a href="#"><i class="fa fa-trash" aria-hidden="true"></i> Entrar em contato com o organizador</a>';
                    echo '<a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Pedir Reembolso?</a>';
                    echo '<a href="certificado.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Meu certificado</a>';
                    echo '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p>Nenhum evento encontrado</p>";
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
       <p class="rodape">© 2024 BrFideliza. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
