<?php
// Verifica se a requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configurações do banco de dados
    require_once '../config.php';

    // Verifica qual ação está sendo executada
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

       // Ação: Adicionar Evento
        if ($action == 'add_event') {
            // Verifica se todos os campos foram recebidos
            $campos = ['titulo', 'descricao', 'local', 'data', 'inicio_inscricao', 'fim_inscricao', 'vl_ingresso', 'vl_com_desconto', 'empresa_id'];
            foreach ($campos as $campo) {
                if (!isset($_POST[$campo])) {
                    die("Campo '$campo' não foi especificado.");
                }
            }

            // Prepara os dados para inserção
            $titulo = sanitize($conexao, $_POST['titulo']);
            $descricao = sanitize($conexao, $_POST['descricao']);
            $local = sanitize($conexao, $_POST['local']);
            $data = formatDateTime($_POST['data']);
            $inicio_inscricao = formatDateTime($_POST['inicio_inscricao']);
            $fim_inscricao = formatDateTime($_POST['fim_inscricao']);
            $vl_ingresso = (float)$_POST['vl_ingresso'];
            $vl_com_desconto = (float)$_POST['vl_com_desconto'];
            $empresa_id = (int)$_POST['empresa_id'];

            // Verifica se as datas de inscrição são válidas
            if ($inicio_inscricao >= $fim_inscricao) {
                die("A data de início de inscrição deve ser anterior à data de fim de inscrição.");
            }

            // Verifica se a empresa existe
            $sql_empresa = "SELECT COUNT(*) AS count FROM empresa WHERE idEmpresa = ?";
            $stmt_empresa = $conexao->prepare($sql_empresa);
            if ($stmt_empresa === false) {
                die('Erro na preparação da consulta: ' . $conexao->error);
            }
            $stmt_empresa->bind_param("i", $empresa_id);
            $stmt_empresa->execute();
            $result_empresa = $stmt_empresa->get_result();
            $row_empresa = $result_empresa->fetch_assoc();
            if ($row_empresa['count'] == 0) {
                die("A empresa com id $empresa_id não existe.");
            }
            $stmt_empresa->close();

            // SQL statement para inserir evento na tabela 'evento'
            $sql = "INSERT INTO evento (eveTitulo, eveTituloHash, eveDescricao, eveLocal, eveData, eveDtIniInscricao, eveDtFimInscricao, eveVlIngresso, eveVlComDesconto, empresa_idEmpresa, eveAtivo)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";

            // Prepare a declaração SQL
            $stmt = $conexao->prepare($sql);
            if ($stmt === false) {
                die('Erro na preparação da consulta: ' . $conexao->error);
            }

            // Calcular hash do título
            $tituloHash = md5($titulo);

            // Bind dos parâmetros
            $stmt->bind_param("ssssssddii", $titulo, $tituloHash, $descricao, $local, $data, $inicio_inscricao, $fim_inscricao, $vl_ingresso, $vl_com_desconto, $empresa_id);

            // Executa a consulta SQL
            if ($stmt->execute() === TRUE) {
                echo "Evento adicionado com sucesso!";
                echo '<a href="listar_eventos.php" class="btn btn-primary">Ir para a lista de eventos</a>';
            } else {
                echo "Erro ao adicionar evento: " . $stmt->error;
            }

            // Fecha o statement
            $stmt->close();
    }

           // Ação: Editar Evento
           elseif ($action == 'edit_event') {
            $campos = ['idEvento', 'titulo', 'descricao', 'local', 'data', 'inicio_inscricao', 'fim_inscricao', 'vl_ingresso', 'vl_com_desconto'];
            foreach ($campos as $campo) {
                if (!isset($_POST[$campo])) {
                    die("Campo '$campo' não foi especificado.");
                }
            }

            $idEvento = (int)$_POST['idEvento'];
            $titulo = sanitize($conexao, $_POST['titulo']);
            $descricao = sanitize($conexao, $_POST['descricao']);
            $local = sanitize($conexao, $_POST['local']);
            $data = formatDateTime($_POST['data']);
            $inicio_inscricao = formatDateTime($_POST['inicio_inscricao']);
            $fim_inscricao = formatDateTime($_POST['fim_inscricao']);
            $vl_ingresso = (float)$_POST['vl_ingresso'];
            $vl_com_desconto = (float)$_POST['vl_com_desconto'];

            $tituloHash = md5($titulo);

            $sql = "UPDATE evento 
                    SET eveTitulo = ?, eveTituloHash = ?, eveDescricao = ?, eveLocal = ?, eveData = ?, eveDtIniInscricao = ?, eveDtFimInscricao = ?, eveVlIngresso = ?, eveVlComDesconto = ?
                    WHERE idEvento = ?";

            $stmt = $conexao->prepare($sql);
            if ($stmt === false) {
                die('Erro na preparação da consulta: ' . $conexao->error);
            }

            $stmt->bind_param("ssssssddii", $titulo, $tituloHash, $descricao, $local, $data, $inicio_inscricao, $fim_inscricao, $vl_ingresso, $vl_com_desconto, $idEvento);

           // Executa a consulta SQL
           if ($stmt->execute() === TRUE) {
            echo "Evento adicionado com sucesso!";
            echo '<a href="listar_eventos.php" class="btn btn-primary">Ir para a lista de eventos</a>';
        } else {
            echo "Erro ao adicionar evento: " . $stmt->error;
        }

            $stmt->close();
        }

        // Ação: Excluir Evento
        elseif ($action == 'delete_event') {
            // Verifica se o campo 'idEvento' foi recebido
            if (!isset($_POST['idEvento'])) {
                die("ID do evento não foi especificado.");
            }

            // Prepara o ID do evento para exclusão
            $idEvento = (int)$_POST['idEvento'];

            // SQL statement para excluir evento da tabela 'evento'
            $sql = "DELETE FROM evento WHERE idEvento = ?";

            // Prepare a declaração SQL
            $stmt = $conexao->prepare($sql);
            if ($stmt === false) {
                die('Erro na preparação da consulta: ' . $conexao->error);
            }

            // Bind dos parâmetros
            $stmt->bind_param("i", $idEvento);

            // Executa a consulta SQL
            if ($stmt->execute() === TRUE) {
                echo "Evento adicionado com sucesso!";
                echo '<a href="listar_eventos.php" class="btn btn-primary">Ir para a lista de eventos</a>';
            } else {
                echo "Erro ao adicionar evento: " . $stmt->error;
            }
            // Redireciona para a página de lista de eventos
            header('Location: listar_eventos.php');

            // Fecha o statement
            $stmt->close();
        }
    }

    // Fecha a conexão com o banco de dados
    $conexao->close();
} else {
    die("Acesso não permitido.");
}

// Função para formatar data e hora
function formatDateTime($datetime) {
    $date = new DateTime($datetime);
    return $date->format('Y-m-d H:i:s');
}

// Função para sanitizar dados
function sanitize($conexao, $input) {
    return $conexao->real_escape_string($input);
}
?>
