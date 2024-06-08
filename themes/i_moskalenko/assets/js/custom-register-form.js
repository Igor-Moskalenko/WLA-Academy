document.addEventListener('DOMContentLoaded', function () {
    var passwordField = document.querySelector('.gf_password input[type="password"]');
    var confirmPasswordField = document.querySelector('.gf_confirm_password input[type="password"]');
    confirmPasswordField.addEventListener('input', function () {
        if (passwordField.value !== confirmPasswordField.value) {
            confirmPasswordField.setCustomValidity('Пароли должны совпадать');
        } else {
            confirmPasswordField.setCustomValidity('');
        }
    });
});