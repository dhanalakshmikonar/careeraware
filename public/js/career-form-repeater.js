document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.repeater-add').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var fieldName = btn.getAttribute('data-target');
            var container = document.querySelector('.repeater[data-field="' + fieldName + '"]');

            var row = document.createElement('div');
            row.className = 'input-group mb-2 repeater-row';
            row.innerHTML = '<input type="text" name="' + fieldName + '[]" class="form-control form-control-custom" value="">' +
                '<button type="button" class="btn btn-glass-secondary repeater-remove" title="Remove"><i class="fa-solid fa-xmark"></i></button>';

            container.appendChild(row);
            attachRemove(row.querySelector('.repeater-remove'));
        });
    });

    document.querySelectorAll('.repeater-remove').forEach(attachRemove);

    function attachRemove(btn) {
        btn.addEventListener('click', function () {
            var row = btn.closest('.repeater-row');
            var container = row.parentElement;
            if (container.querySelectorAll('.repeater-row').length > 1) {
                row.remove();
            } else {
                row.querySelector('input').value = '';
            }
        });
    }
});
