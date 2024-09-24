<!-- Exemplo de url (http://localhost:82/brfidelizafinal/capacidade_maxima?idEvento=33) -->

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Capacidade Maxima</title>
</head>
<body>
    <h2>Capacidade Maxima</h2>
    <?php
    // Conectar ao banco de dados (substitua pelos seus detalhes de conexão)
    require_once 'config.php';

    // ID do evento a ser verificado (suponha que seja passado via GET ou POST)
    $idEvento = $_GET['idEvento'] ?? null; // Exemplo: passado via GET ou POST

    if (!$idEvento) {
        echo "<p>ID do evento não especificado.</p>";
    } else {
        // Consulta para obter a capacidade máxima do evento
        $sqlCapacidade = "SELECT eveCapacidadeMaxima FROM evento WHERE idEvento = $idEvento";
        $resultCapacidade = $conn->query($sqlCapacidade);

        if ($resultCapacidade->num_rows > 0) {
            $rowCapacidade = $resultCapacidade->fetch_assoc();
            $capacidadeMaxima = $rowCapacidade['eveCapacidadeMaxima'];

            // Consulta para contar o número de inscrições para o evento
            $sqlContagem = "SELECT COUNT(*) AS totalInscricoes FROM inscricao WHERE evento_idEvento = $idEvento";
            $resultContagem = $conn->query($sqlContagem);

            if ($resultContagem->num_rows > 0) {
                $rowContagem = $resultContagem->fetch_assoc();
                $totalInscricoes = $rowContagem['totalInscricoes'];

                // Verificar se a capacidade máxima foi atingida
                if ($totalInscricoes >= $capacidadeMaxima) {
                    // Capacidade máxima atingida, exibir mensagem de aviso
                    echo "<p>A capacidade máxima deste evento foi atingida. Inscrições estão fechadas no momento.</p>";
                } else {
                    // Ainda há vagas disponíveis, exibir formulário de inscrição
                    echo "<form method='post' action='processar_inscricao.php'>";
                    echo "<input type='hidden' name='idEvento' value='$idEvento'>";
                    echo "<label for='nome'>Seu Nome:</label><br>";
                    echo "<input type='text' id='nome' name='nome' required><br>";
                    echo "<label for='email'>Seu Email:</label><br>";
                    echo "<input type='email' id='email' name='email' required><br>";
                    echo "<input type='submit' name='submit' value='Inscrever-se'>";
                    echo "</form>";
                }
            } else {
                echo "<p>Erro ao contar inscrições.</p>";
            }
        } else {
            echo "<p>Evento não encontrado.</p>";
        }
    }

    $conexao->close();
    ?>
</body>
</html>
