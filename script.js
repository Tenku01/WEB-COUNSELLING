document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById('container');
    const signUpButton = document.getElementById('register');
    const signInButton = document.getElementById('login');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
});
