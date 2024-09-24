<?php
// Inclui o arquivo de configuração e o TCPDF
require_once '../config.php';
require_once '../vendor/tecnickcom/tcpdf/tcpdf.php';

// Verifica se os parâmetros type e status foram fornecidos via GET
if (isset($_GET['type']) && isset($_GET['status'])) {
    $type = $_GET['type'];
    $statusFilter = $_GET['status'];

    // Verifica se o valor do filtro é válido (inscrito, pago, presente)
    if (!in_array($statusFilter, ['inscrito', 'pago', 'presente'])) {
        echo "Filtro de status inválido.";
        exit;
    }

    // Consulta SQL para buscar as inscrições filtradas pelo status
    $sql = "SELECT inscricao.idInscricao, inscricao.insDataRegistro, evento.eveTitulo, pessoa.nomeCompleto, pessoa.telefone, pessoa.email, pagamento.pag_status
            FROM inscricao
            INNER JOIN pedido ON inscricao.pedido_idPedido = pedido.idPedido
            INNER JOIN pessoa ON pedido.Pessoa_idPessoa_registrou = pessoa.idPessoa
            INNER JOIN evento ON inscricao.evento_idEvento = evento.idEvento
            LEFT JOIN pagamento ON pedido.idPedido = pagamento.pedido_idPedido
            WHERE pagamento.pag_status = ?";

    // Prepara e executa a consulta
    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        die('Erro na preparação da consulta: ' . $conexao->error);
    }
    
    $stmt->bind_param("s", $statusFilter);
    $stmt->execute();
    $result = $stmt->get_result();

    // Array para armazenar os dados recuperados do banco de dados
    $dados = [];
    while ($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }

    // Definir o tipo de conteúdo conforme o tipo de exportação
    switch ($type) {
        case 'pdf':
            // Lógica para gerar PDF usando TCPDF
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Seu Nome');
            $pdf->SetTitle('Exportação de Inscrições');
            $pdf->SetSubject('Inscrições em Eventos');
            $pdf->SetKeywords('Inscrições, Eventos, PDF');
            $pdf->AddPage();

            // Cabeçalho do PDF
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Lista de Inscrições em Eventos', 0, 1, 'C');
            $pdf->Ln(10);

            // Dados das inscrições
            foreach ($dados as $row) {
                $pdf->SetFont('times', '', 10);
                $pdf->Cell(30, 10, 'ID Inscrição:', 1, 0, 'L');
                $pdf->Cell(50, 10, $row["idInscricao"], 1, 0, 'L');
                $pdf->Cell(40, 10, 'Data de Registro:', 1, 0, 'L');
                $pdf->Cell(70, 10, date('d/m/Y H:i:s', strtotime($row["insDataRegistro"])), 1, 1, 'L');
                $pdf->Cell(30, 10, 'Evento:', 1, 0, 'L');
                $pdf->Cell(160, 10, $row["eveTitulo"], 1, 1, 'L');
                $pdf->Cell(30, 10, 'Nome:', 1, 0, 'L');
                $pdf->Cell(160, 10, $row["nomeCompleto"], 1, 1, 'L');
                $pdf->Cell(30, 10, 'E-mail:', 1, 0, 'L');
                $pdf->Cell(160, 10, $row["email"], 1, 1, 'L');
                $pdf->Cell(30, 10, 'Status Pagamento:', 1, 0, 'L');
                $pdf->Cell(160, 10, ucfirst($row["pag_status"]), 1, 1, 'L');
                $pdf->Ln(5);
            }

            // Saída do PDF
            $pdf->Output('inscricoes.pdf', 'D');
            exit;
            break;
        case 'csv':
            // Cabeçalho para download do arquivo CSV
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=inscricoes.csv');
            $output = fopen('php://output', 'w');

            // Cabeçalho do CSV
            fputcsv($output, array('ID Inscrição', 'Data de Registro', 'Evento', 'Nome Completo', 'E-mail', 'Status Pagamento'));

            // Dados das inscrições
            foreach ($dados as $row) {
                fputcsv($output, array(
                    $row["idInscricao"],
                    date('d/m/Y H:i:s', strtotime($row["insDataRegistro"])),
                    $row["eveTitulo"],
                    $row["nomeCompleto"],
                    $row["email"],
                    ucfirst($row["pag_status"])
                ));
            }

            fclose($output);
            exit;
            break;
        case 'excel':
                       // Cabeçalho para download do arquivo Excel
                       header('Content-Type: application/vnd.ms-excel');
                       header('Content-Disposition: attachment; filename=inscricoes.xls');
           
                       // Saída dos dados em formato Excel
                       foreach ($dados as $row) {
                           echo $row["idInscricao"] . "\t" .
                                date('d/m/Y H:i:s', strtotime($row["insDataRegistro"])) . "\t" .
                                $row["eveTitulo"] . "\t" .
                                $row["nomeCompleto"] . "\t" .
                                $row["email"] . "\t" .
                                ucfirst($row["pag_status"]) . "\n";
                       }
                       exit;
                       break;
        default:
            echo "Tipo de exportação inválido.";
            exit;
            break;
    }
} else {
    echo "Parâmetros type ou status não foram fornecidos.";
    exit;
}
?>
