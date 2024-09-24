<!-- http://localhost:82/brfidelizafinal/ADM/admin_inscricoes.php?evento_id=27 -->

<?php
require_once '../config.php';

function escape($value) {
    global $conexao;
    return mysqli_real_escape_string($conexao, $value);
}

$pag_status = '';
if (isset($_GET['status_pagamento']) && !empty($_GET['status_pagamento'])) {
    $pag_status = escape($_GET['status_pagamento']);
}

$sql = "SELECT inscricao.idInscricao, inscricao.insDataRegistro, evento.eveTitulo, pessoa.nomeCompleto, pessoa.telefone, pessoa.email, pagamento.pag_status
        FROM inscricao
        INNER JOIN pedido ON inscricao.pedido_idPedido = pedido.idPedido
        INNER JOIN pessoa ON pedido.Pessoa_idPessoa_registrou = pessoa.idPessoa
        INNER JOIN evento ON inscricao.evento_idEvento = evento.idEvento
        LEFT JOIN pagamento ON pedido.idPedido = pagamento.pedido_idPedido";

if (!empty($pag_status)) {
    $sql .= " WHERE pagamento.pag_status = ?";
}

$sql .= " AND inscricao.evento_idEvento = ? ORDER BY inscricao.idInscricao DESC";

$stmt = $conexao->prepare($sql);

if (isset($_GET['evento_id']) && !empty($_GET['evento_id'])) {
    $evento_id = $_GET['evento_id'];
} else {
    die('ID do evento não especificado.');
}

if (!empty($pag_status)) {
    $stmt->bind_param("si", $pag_status, $evento_id);
} else {
    $stmt->bind_param("i", $evento_id);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Administração de Inscrições</title>
    <link rel="stylesheet" href="../CSS/admin.css">
</head>
<body>
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

<h1>Administração de Inscrições</h1>

<form method="GET" action="">
    <label for="status_pagamento">Filtrar por Status de Pagamento:</label>
    <select name="status_pagamento" id="status_pagamento">
        <option value="">Todos</option>
        <option value="inscrito" <?php echo ($pag_status == 'inscrito') ? 'selected' : ''; ?>>Inscrito</option>
        <option value="pago" <?php echo ($pag_status == 'pago') ? 'selected' : ''; ?>>Pago</option>
        <option value="presente" <?php echo ($pag_status == 'presente') ? 'selected' : ''; ?>>Presente</option>
    </select>
    <input type="hidden" name="evento_id" value="<?php echo isset($_GET['evento_id']) ? $_GET['evento_id'] : ''; ?>">
    <button type="submit">Filtrar</button>
</form>

<table>
    <thead>
    <tr>
        <th>ID Inscrição</th>
        <th>Data de Registro</th>
        <th>Nome Completo</th>
        <th>Telefone</th>
        <th>Email</th>
        <th>Status Pagamento</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['idInscricao'] . "</td>";
        echo "<td>" . $row['insDataRegistro'] . "</td>";
        echo "<td>" . $row['nomeCompleto'] . "</td>";
        echo "<td>" . $row['telefone'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['pag_status'] . "</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<form id="formExportCSV" method="POST" action="exportar_inscricao.php?type=csv&status=inscrito">
    <input type="hidden" name="sql_query" value="<?php echo base64_encode($sql); ?>">
    <input type="hidden" name="evento_id" value="<?php echo isset($_GET['evento_id']) ? $_GET['evento_id'] : ''; ?>">
    <button type="submit" id="btnExportCSV">Exportar para CSV</button>
</form>

<form id="formExportCSV" method="POST" action="exportar_inscricao.php?type=pdf&status=inscrito">
    <input type="hidden" name="sql_query" value="<?php echo base64_encode($sql); ?>">
    <input type="hidden" name="evento_id" value="<?php echo isset($_GET['evento_id']) ? $_GET['evento_id'] : ''; ?>">
    <button type="submit" id="btnExportCSV">Exportar para PDF</button>
</form>

<form id="formExportCSV" method="POST" action="exportar_inscricao.php?type=excel&status=inscrito">
    <input type="hidden" name="sql_query" value="<?php echo base64_encode($sql); ?>">
    <input type="hidden" name="evento_id" value="<?php echo isset($_GET['evento_id']) ? $_GET['evento_id'] : ''; ?>">
    <button type="submit" id="btnExportCSV">Exportar para Excel</button>
</form>

<footer>
    <p class="rodape">© 2024 BrFideliza. Todos os direitos reservados.</p>
</footer>

</body>
</html>

<?php
$stmt->close();
$conexao->close();
?>
