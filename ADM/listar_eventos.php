<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Eventos</title>
    <link rel="stylesheet" href="../CSS/listar_eventos.css">
</head>
<body>
    <nav class="navbar bg-body-tertiary tab">
        <div class="container-fluid" id="navbar_marca">
            <div id="logo">
                <span class="navbar-brand mb-0" style="color: white;"><img src="../IMG/logo.jpg" alt="BrFideliza">BrFideliza</span>
            </div>
            <div id="menu">
                <a href="home.php"><img src="../IMG/home-icon.png" alt="Página Inicial"></a>
                <a href="login.php"><img src="../IMG/user-icon.png" alt="Perfil do Usuário"></a>
                <a href="historico.php"><img src="../IMG/historico-icon.png" alt="Histórico"></a>
            </div>
        </div>
    </nav>
    <h1>Listar Eventos</h1>

    <?php
    // Conexão com o banco de dados
    require_once '../config.php';

    // Consulta SQL para obter eventos
    $sql = "SELECT * FROM evento";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Local</th>
                <th>Data</th>
                <th>Início Inscrição</th>
                <th>Fim Inscrição</th>
                <th>Valor Ingresso</th>
                <th>Valor com Desconto</th>
                <th>Empresa ID</th>
                <th>Status</th>
                <th>Vagas Disponíveis</th>
                <th>Ações</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            $status = $row['eveAtivo'] ? "Ativo" : "Inativo";
            $statusClass = $row['eveAtivo'] ? "status-ativo" : "status-inativo";
            $vagasDisponiveis = 100; // Supondo um número fixo para vagas disponíveis

            echo "<tr>
                    <td>{$row['idEvento']}</td>
                    <td>{$row['eveTitulo']}</td>
                    <td>{$row['eveDescricao']}</td>
                    <td>{$row['eveLocal']}</td>
                    <td>{$row['eveData']}</td>
                    <td>{$row['eveDtIniInscricao']}</td>
                    <td>{$row['eveDtFimInscricao']}</td>
                    <td>{$row['eveVlIngresso']}</td>
                    <td>{$row['eveVlComDesconto']}</td>
                    <td>{$row['empresa_idEmpresa']}</td>
                    <td class='$statusClass'>$status</td>
                    <td>$vagasDisponiveis</td>
                    <td>
                        <form action='ativar_desativar_evento.php' method='POST'>
                            <input type='hidden' name='idEvento' value='{$row['idEvento']}'>
                            <select name='acao'>
                                <option value='ativar'>Ativar</option>
                                <option value='desativar'>Desativar</option>
                            </select>
                            <button type='submit'>Salvar</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhum evento encontrado.</p>";
    }

    // Fecha a conexão com o banco de dados
    $conexao->close();
    ?>

    <br><br><br>
    <footer>
        <p class="rodape">© 2024 BrFideliza. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
