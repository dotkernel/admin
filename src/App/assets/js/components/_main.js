import * as bootstrap from 'bootstrap'

$(document).ready(function () {
    $('.current-route').closest('.nav-group').addClass('open');

    let toasts = [].slice.call(document.querySelectorAll('.toast'))
    toasts.forEach(function (toastEl) {
        (new bootstrap.Toast(toastEl)).show();
    });
});
