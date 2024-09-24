<?php
require_once '../config.php'; // Inclui o arquivo com detalhes de conexão ao banco de dados

// Query para recuperar as inscrições pendentes
$sql = "SELECT inscricao.idInscricao, inscricao.insDataRegistro, evento.eveTitulo, pessoa.nomeCompleto, pessoa.email
        FROM inscricao 
        INNER JOIN evento  ON inscricao.evento_idEvento =  evento.idEvento
        INNER JOIN pedido  ON inscricao.pedido_idPedido = pedido.idPedido
        INNER JOIN pessoa  ON pedido.Pessoa_idPessoa_registrou = Pessoa_idPessoa_registrou
        WHERE inscricao.ins_confirmada = 0
        ORDER BY inscricao.insDataRegistro DESC";
$result = $conexao->query($sql);

// Array para armazenar as inscrições do banco de dados
$inscricoes = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $inscricoes[] = $row; // Adiciona cada inscrição ao array $inscricoes
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisão de Inscrições</title>
    <link rel="stylesheet" href="../CSS/revisao_inscricao.css"> <!-- Estilo CSS personalizado -->
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar bg-body-tertiary tab">
        <div class="container-fluid" id="navbar_marca">
            <div id="logo">
                <span class="navbar-brand mb-0" style="color: white;"><img src="../img/logo.jpg" alt="BrFideliza">BrFideliza</span>
            </div>
            <div id="menu">
                <a href="../home.php"><img src="../img/home-icon.png" alt="Página Inicial"></a>
                <a href="../login.php"><img src="../img/user-icon.png" alt="Perfil do Usuário"></a>
                <a href="../historico.php"><img src="../img/historico-icon.png" alt="Histórico"></a>
            </div>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <div class="container">
        <h2>Revisão de Inscrições Pendentes</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data de Inscrição</th>
                    <th>Evento</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inscricoes as $inscricao) : ?>
                    <tr>
                        <td><?php echo $inscricao["idInscricao"]; ?></td>
                        <td><?php echo date('d/m/Y H:i:s', strtotime($inscricao["insDataRegistro"])); ?></td>
                        <td><?php echo $inscricao["eveTitulo"]; ?></td>
                        <td><?php echo $inscricao["nomeCompleto"]; ?></td>
                        <td><?php echo $inscricao["email"]; ?></td>
                        <td>
                            <?php if (!$inscricao['insConfirmada']) : ?>
                                <a href="?action=confirm&id=<?php echo $inscricao['idInscricao']; ?>">Confirmar</a>
                            <?php else : ?>
                                Confirmada
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($inscricoes)) : ?>
                    <tr><td colspan="6">Nenhuma inscrição pendente encontrada.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Rodapé -->
    <footer>
       <p class="rodape">© 2024 BrFideliza. Todos os direitos reservados.</p>
    </footer>
</body>
</html>

<?php
// Fecha a conexão com o banco de dados
$conexao->close();
?>
