document.addEventListener('DOMContentLoaded', function () {
    var resetButton = document.querySelector('[data-reset-filters]');
    var form = document.querySelector('.filter-form');

    if (!resetButton || !form) {
        return;
    }

    resetButton.addEventListener('click', function (event) {
        event.preventDefault();
        form.reset();
    });
});
