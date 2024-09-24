<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração de Mensagens</title>
    <link rel="stylesheet" href="../CSS/envio_participante.css">
</head>
<body>
<nav class="navbar bg-body-tertiary tab">
        <div class="container-fluid" id="navbar_marca">
            <div id="logo">
                <span class="navbar-brand mb-0" style="color: white;"><img src="../IMG/logo.jpg" alt="BrFideliza">BrFideliza</span>
            </div>
            <div id="menu">
                <a href="../home.php"><img src="../IMG/home-icon.png" alt="Página Inicial"></a>
                <a href="../login.php"><img src="../IMG/user-icon.png" alt="Perfil do Usuário"></a>
                <a href="../historico.php"><img src="../IMG/historico-icon.png" alt="Histórico"></a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Administração de Mensagens</h1>
        <div class="alert">
            <p>Alerta de mensagem importante. <a href="#">Saiba mais.</a></p>
        </div>
        <form action="enviar_mensagem.php" method="post">
            <label for="tipo">Tipo de Mensagem:</label>
            <select name="tipo" id="tipo">
                <option value="email">Email</option>
                <option value="whatsapp">WhatsApp</option>
                <option value="push">Push Notification</option>
            </select>
            <br><br>
            <label for="mensagem">Mensagem:</label><br>
            <textarea name="mensagem" id="mensagem" cols="30" rows="10"></textarea>
            <br><br>
            <label for="agendamento">Agendar Envio:</label>
            <input type="datetime-local" id="agendamento" name="agendamento">
            <br><br>
            <button type="submit">Enviar Mensagem</button>
        </form>
    </div>

    <footer class="rodape">
        &copy; 2024 Projeto Eventos. Todos os direitos reservados.
    </footer>
</body>
</html>
