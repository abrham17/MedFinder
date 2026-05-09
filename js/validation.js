document.addEventListener('DOMContentLoaded', function () {
    var password = document.getElementById('password');
    var confirmPassword = document.getElementById('confirm_password');
    var note = document.getElementById('password-help');

    if (!password || !confirmPassword || !note) {
        return;
    }

    var updateNote = function () {
        if (confirmPassword.value === '') {
            note.textContent = 'Passwords must match.';
            note.className = 'form-note';
            return;
        }

        if (password.value === confirmPassword.value) {
            note.textContent = 'Passwords match.';
            note.className = 'form-note note-success';
        } else {
            note.textContent = 'Passwords do not match.';
            note.className = 'form-note note-error';
        }
    };

    password.addEventListener('input', updateNote);
    confirmPassword.addEventListener('input', updateNote);
});
