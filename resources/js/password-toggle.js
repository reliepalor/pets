document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeSlashIcon = document.getElementById('eyeSlashIcon');

    if (!toggleButton || !passwordInput || !eyeIcon || !eyeSlashIcon) {
        console.error('Password toggle elements not found. Check IDs: togglePassword, password, eyeIcon, eyeSlashIcon');
        return;
    }

    toggleButton.addEventListener('click', function () {
        console.log('Toggle button clicked');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeSlashIcon.classList.remove('hidden');
            console.log('Password shown');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeSlashIcon.classList.add('hidden');
            console.log('Password hidden');
        }
    });
});