<?php
// Verifica se o ID do evento e o novo estado foram enviados via POST
if (isset($_POST['idEvento']) && isset($_POST['acao'])) {
    // Captura os parâmetros
    $idEvento = $_POST['idEvento'];
    $acao = $_POST['acao']; // Deve ser 'ativar' ou 'desativar'

    // Traduz a ação para o novo estado
    $novoEstado = ($acao == 'ativar') ? 1 : 0;

    // Inclui o arquivo de configuração do banco de dados
    require_once '../config.php';

    // Verifica se houve erro na conexão
    if ($conexao->connect_error) {
        die('Erro na conexão: ' . $conexao->connect_error);
    }

    // SQL statement para atualizar o estado do evento
    $sql = "UPDATE evento SET eveAtivo = ? WHERE idEvento = ?";

    // Prepara a declaração SQL
    $stmt = $conexao->prepare($sql);
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conexao->error);
    }

    // Bind dos parâmetros
    $stmt->bind_param("ii", $novoEstado, $idEvento);

    // Executa a consulta SQL
    if ($stmt->execute() === TRUE) {
        echo "Estado do evento atualizado com sucesso para " . ($novoEstado ? 'Ativo' : 'Inativo') . "!<br>";
        echo "<a href='listar_eventos.php'>Voltar para a lista de eventos</a>";
    } else {
        echo "Erro ao atualizar estado do evento: " . $stmt->error;
    }

    // Fecha o statement
    $stmt->close();

    // Fecha a conexão com o banco de dados
    $conexao->close();
} else {
    // Se os parâmetros não foram recebidos corretamente
    echo "Parâmetros incorretos. Certifique-se de fornecer 'idEvento' e 'acao'.";
}
?>
