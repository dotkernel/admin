import $ from 'jquery';
import * as bootstrap from 'bootstrap'

$(document).ready(function () {
    let toasts = [].slice.call(document.querySelectorAll('.toast'))
    toasts.forEach(function (toastEl) {
        (new bootstrap.Toast(toastEl)).show();
    });

    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    });

    $('.current-route').closest('.nav-group').addClass('open');
});
