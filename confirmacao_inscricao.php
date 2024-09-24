<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Inscrição</title>
    <link rel="stylesheet" href="CSS/confirmacao_inscricao.css">
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script> <!-- Adicionando QRCode.js via CDN -->
</head>
<body>
    <nav class="navbar bg-body-tertiary tab">
        <div class="container-fluid" id="navbar_marca">
            <div id="logo">
                <span class="navbar-brand mb-0" style="color: white;"><img src="img/logo.jpg" alt="BrFideliza"> BrFideliza</span> 
            </div>
            <div id="menu">
                <a href="home.php"><img src="img/home-icon.png" alt="Página Inicial"></a> <!-- Ícone para página inicial -->
                <a href="login.php"><img src="img/user-icon.png" alt="Perfil do Usuário"></a> <!-- Ícone para perfil do usuário -->
                <a href="historico.php"><img src="img/historico-icon.png" alt="Histórico"></a> <!-- Ícone para histórico -->
            </div>
        </div>
    </nav>
    <div class="container">
        <h2>Confirmação de Inscrição</h2>
        <p>Sua inscrição foi realizada com sucesso!</p>

        <div id="qrcode" class=""></div>

        <form id="notificationForm" method="post">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            <input type="hidden" id="qr_code" name="qr_code">
            <button type="submit">Enviar Notificação</button>
        </form>
        
        <script>
            // Função para pegar o parâmetro 'qr_code' da URL
            function getQueryParam(param) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }

            // Verificar se o parâmetro qr_code está presente na URL
            const qrCodeURL = getQueryParam('qr_code');
            if (qrCodeURL) {
                // Gerar o QR Code
                new QRCode(document.getElementById("qrcode"), {
                    text: qrCodeURL,
                    width: 128,
                    height: 128
                });

                // Definir o valor do campo hidden com o código QR
                document.getElementById('qr_code').value = qrCodeURL;
            } else {
                document.getElementById("qrcode").innerText = "QR Code não encontrado.";
            }
        </script>
    </div>
    <footer>
       <p class="rodape" style="color: white;">© 2024 BrFideliza. Todos os direitos reservados.</p> <!-- Modificado para cor branca -->
    </footer>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Dados do formulário
            $email = $_POST['email'];
            $qr_code = $_POST['qr_code'];

            // Assunto do e-mail
            $subject = "Confirmação de Inscrição - Código de Pagamento PIX";

            // Corpo do e-mail
            $message = "
            <html>
            <head>
            <title>Confirmação de Inscrição</title>
            </head>
            <body>
            <h2>Confirmação de Inscrição</h2>
            <p>Sua inscrição foi realizada com sucesso! Use o código PIX abaixo para o pagamento:</p>
            <p>$qr_code</p>
            <div style='text-align:center;'>
                <img src='https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=$qr_code' alt='QR Code PIX'>
            </div>
            </body>
            </html>
            ";

            // Cabeçalhos do e-mail -- Waderson preencher
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: <no-reply@brfideliza.com>' . "\r\n"; 
            $headers .= 'Reply-To: no-reply@brfideliza.com' . "\r\n";

            // Configuração dinâmica do SMTP para Gmail com TLS -- Waderson preencher
            ini_set('SMTP', 'smtp.gmail.com');
            ini_set('smtp_port', 587);
            ini_set('username', 'your_email@gmail.com');
            ini_set('password', 'your_password');
            ini_set('auth_username', 'your_email@gmail.com');
            ini_set('auth_password', 'your_password');
            ini_set('smtp_crypto', 'tls'); // Use 'tls' for TLS encryption

            // Enviar o e-mail
            if (mail($email, $subject, $message, $headers)) {
                echo "<script>alert('E-mail enviado com sucesso!');</script>";
            } else {
                echo "<script>alert('Falha no envio do e-mail. Verifique as configurações do servidor.');</script>";
            }
        }
?>
</body>
</html>
