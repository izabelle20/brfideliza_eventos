<?php
// Verificar se o método da requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    
    // Definir dados do pagamento PIX
    $valor = 50.00; // Valor da taxa de inscrição
    $chavePix = "sua_chave_pix"; // Sua chave PIX
    
    // Montar o URL para gerar o QR Code com os parâmetros necessários
    $descricao = "Inscrição no Evento";
    $qrCodeURL = "https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=PIX%3A%2F%2F"
                . urlencode($chavePix)
                . "%3F"
                . urlencode("description=" . $descricao)
                . urlencode("%26amount=" . $valor);
    
    // Redirecionar para a página de confirmação com o URL do QR Code
    header("Location: confirmacao_inscricao.php?qr_code=" . urlencode($qrCodeURL));
    exit();
} else {
    // Se não for um POST, redirecionar de volta para o formulário ou página inicial
    header("Location: formulario_inscricao.php");
    exit();
}
?>
