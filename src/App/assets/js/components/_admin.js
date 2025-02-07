$(document).ready(() => {
    const request = async (url, options = {}) => {
        try {
            const response = await fetch(url, options);
            const body = await response.text();
            if (! response.ok) {
                throw {
                    data: body,
                }
            }
            return body;
        } catch (error) {
            throw {
                data: error.data,
            }
        }
    }


    const btnEdit = $('#btn-edit-admin');
    const btnDelete = $('#btn-delete-admin');

    btnEdit?.prop('disabled', true);
    btnDelete?.prop('disabled', true);

    $(document).on('click', '.ui-checkbox', () => {
        if ($('.ui-checkbox:checked').length === 1) {
            btnEdit?.prop('disabled', false);
            btnDelete?.prop('disabled', false);
        } else {
            btnEdit?.prop('disabled', true);
            btnDelete?.prop('disabled', true);
        }
    });

    $("#add-admin-modal").on('show.bs.modal', function () {
        const modal = $(this);
        const url = modal.data('add-url');

        request(url, {
            method: 'GET'
        }).then(data => {
            modal.find('.modal-dialog').html(data);
        }).catch(error => {
            console.error('Error', error)
        });
    });

    $("#edit-admin-modal").on('show.bs.modal', function () {
        const selectedElement = $('.ui-checkbox:checked');
        if (selectedElement.length !== 1) {
            return;
        }

        const modal = $(this);
        const url = selectedElement.data('edit-url');

        request(url, {
            method: 'GET'
        }).then(data => {
            modal.find('.modal-dialog').html(data);
        }).catch(() => {
            location.reload();
        });
    });

    $("#delete-admin-modal").on('show.bs.modal', function () {
        const selectedElement = $('.ui-checkbox:checked');
        if (selectedElement.length !== 1) {
            return;
        }

        const modal = $(this);
        const url = selectedElement.data('delete-url');

        request(url, {
            method: 'GET'
        }).then(data => {
            modal.find('.modal-dialog').html(data);
        }).catch(() => {
            location.reload();
        });
    });

    $(document).on("submit", "#admin-form", (event) => {
        event.preventDefault();

        const form = event.target;
        if (! form.checkValidity()) {
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        const url = form.getAttribute('action');
        const modal = $(form.closest('.modal'));

        request(url, {
            method: 'POST',
            body: new FormData(form),
        }).then(data => {
            location.reload();
        }).catch(error => {
            console.error('Error', error);
            modal.find('.modal-dialog').html(error.data);
        });
    });

    $(document).on("submit", "#delete-admin-form", (event) => {
        event.preventDefault();

        const form = event.target;
        if (! form.checkValidity()) {
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        const url = form.getAttribute('action');
        const modal = $(form.closest('.modal'));

        request(url, {
            method: 'POST',
            body: new FormData(form),
        }).then(() => {
            location.reload();
        }).catch(error => {
            modal.find('.modal-dialog').html(error.data);
        });
    });
});
