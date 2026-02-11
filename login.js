document.getElementById("loginForm").addEventListener("submit", function(event) {

    const username = document.querySelector("input[name='username']").value.trim();
    const password = document.querySelector("input[name='password']").value.trim();

    if (username.length < 3) {
        alert("O utilizador deve ter pelo menos 3 caracteres.");
        event.preventDefault();
        return;
    }

    if (password.length < 4) {
        alert("A password deve ter pelo menos 4 caracteres.");
        event.preventDefault();
        return;
    }
});