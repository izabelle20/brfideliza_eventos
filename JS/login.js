function togglePasswordVisibility() {
    var senhaInput = document.getElementById("form-senha");
    if (senhaInput.type === "password") {
        senhaInput.type = "text";
        document.getElementById("togglePassword").textContent = "Ocultar Senha";
    } else {
        senhaInput.type = "password";
        document.getElementById("togglePassword").textContent = "Mostrar Senha";
    }
}