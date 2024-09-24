<!-- Ajustar: O novo evento, editar evento -->

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Eventos</title>
    <link rel="stylesheet" href="../CSS/gerenciar_eventos.css">
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
        <h2>Gerenciar Eventos</h2>

        <button onclick="showForm('add-event-form')">Adicionar Novo Evento</button>
        <button onclick="showForm('edit-event-form')">Editar Evento</button>
        <button onclick="showForm('delete-event-form')">Excluir Evento</button>

        <!-- Formulário para adicionar um novo evento -->
        <div id="add-event-form" class="form-container">
            <h3>Adicionar Novo Evento</h3>
            <form action="processar_evento.php" method="post">
                <input type="hidden" name="action" value="add_event">
                <label>Título:</label><br>
                <input type="text" name="titulo" required><br><br>
                <label>Descrição:</label><br>
                <textarea name="descricao" rows="4" required></textarea><br><br>
                <label>Local:</label><br>
                <input type="text" name="local" required><br><br>
                <label>Data:</label><br>
                <input type="datetime-local" name="data" required><br><br>
                <label>Início da Inscrição:</label><br>
                <input type="datetime-local" name="inicio_inscricao" required><br><br>
                <label>Fim da Inscrição:</label><br>
                <input type="datetime-local" name="fim_inscricao" required><br><br>
                <label>Valor do Ingresso:</label><br>
                <input type="number" step="0.01" name="vl_ingresso" required><br><br>
                <label>Valor com Desconto:</label><br>
                <input type="number" step="0.01" name="vl_com_desconto" required><br><br>
                <label>ID da Empresa:</label><br>
                <input type="number" name="empresa_id" required><br><br>
                <input type="submit" value="Adicionar Evento">
            </form>
        </div>

        <!-- Formulário para editar um evento -->
        <div id="edit-event-form" class="form-container">
            <h3>Editar Evento</h3>
            <form action="processar_evento.php" method="post">
                <input type="hidden" name="action" value="edit_event">
                <label>ID do Evento:</label><br>
                <input type="number" name="idEvento" required><br><br>
                <label>Título:</label><br>
                <input type="text" name="titulo" required><br><br>
                <label>Descrição:</label><br>
                <textarea name="descricao" rows="4" required></textarea><br><br>
                <label>Local:</label><br>
                <input type="text" name="local" required><br><br>
                <label>Data:</label><br>
                <input type="datetime-local" name="data" required><br><br>
                <label>Início da Inscrição:</label><br>
                <input type="datetime-local" name="inicio_inscricao" required><br><br>
                <label>Fim da Inscrição:</label><br>
                <input type="datetime-local" name="fim_inscricao" required><br><br>
                <label>Valor do Ingresso:</label><br>
                <input type="number" step="0.01" name="vl_ingresso" required><br><br>
                <label>Valor com Desconto:</label><br>
                <input type="number" step="0.01" name="vl_com_desconto" required><br><br>
                <input type="submit" value="Editar Evento">
            </form>
        </div>

        <!-- Formulário para excluir um evento -->
        <div id="delete-event-form" class="form-container">
            <h3>Excluir Evento</h3>
            <form action="processar_evento.php" method="post">
                <input type="hidden" name="action" value="delete_event">
                <label>ID do Evento:</label><br>
                <input type="number" name="idEvento" required><br><br>
                <input type="submit" value="Excluir Evento">
            </form>
        </div>
    </div>

    <footer>
        <p class="rodape">© 2024 BrFideliza. Todos os direitos reservados.</p>
    </footer>

    <script>
        function showForm(formId) {
            // Oculta todos os formulários
            var forms = document.getElementsByClassName('form-container');
            for (var i = 0; i < forms.length; i++) {
                forms[i].style.display = 'none';
            }

            // Mostra o formulário selecionado
            document.getElementById(formId).style.display = 'block';
        }
    </script>
</body>
</html>
