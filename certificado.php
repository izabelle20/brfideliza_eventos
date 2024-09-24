<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovante de Inscrição</title>
    <link rel="stylesheet" href="./CSS/certificado.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        <h1>Certificado de Inscrição</h1>

        <?php
        require_once 'config.php';
        require_once './vendor/tecnickcom/tcpdf/tcpdf.php';

        // Verifica se o ID da inscrição foi fornecido via GET
        $idInscricao = $_GET['idInscricao'] ?? null;

        if (!$idInscricao) {
            echo "<div class='alert alert-danger'>ID da inscrição não especificado.</div>";
        } else {
            // Sanitiza a entrada para evitar injeção de SQL
            $idInscricao = mysqli_real_escape_string($conexao, $idInscricao);

            // Consulta para buscar os detalhes da inscrição
            $sql = "SELECT * FROM inscricao WHERE idInscricao = $idInscricao";
            $result = $conexao->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Exemplo de geração de certificado usando TCPDF
                $pdf = new TCPDF();
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Cell(0, 10, 'Certificado de Inscrição', 0, 1, 'C');

                // Adiciona detalhes da inscrição
                $pdf->Ln(10);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(0, 10, 'Nome: ' . utf8_decode($row['user_nome_utilizado']), 0, 1);
                $pdf->Cell(0, 10, 'Evento: ' . utf8_decode($row['evento_idEvento']), 0, 1);

                // Saída do PDF para download no navegador
                $pdf->Output('D', 'certificado.pdf');
            } else {
                echo "<div class='alert alert-warning'>Inscrição não encontrada para o ID: $idInscricao</div>";
            }
        }

        $conexao->close();
        ?>
    </div>
    <footer>
       <p class="rodape">© 2024 BrFideliza. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
