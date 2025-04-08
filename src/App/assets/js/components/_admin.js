$(document).ready(() => {
    const request = async(url, options = {}) => {
        try {
            const response = await fetch(url, options);
            const body     = await response.text();
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

    $("#add-admin-modal").on('show.bs.modal', function () {
        const modal = $(this);
        request(modal.data('add-url'), {
            method: 'GET'
        }).then(data => {
            modal.find('.modal-dialog').html(data);
        }).catch(error => {
            console.error('Error', error)
        });
    }).on('hidden.bs.modal', function () {
        const modal = $(this);
        modal.find('.modal-dialog').find('.modal-body').html('Loading...');
    });

    $("#edit-admin-modal").on('show.bs.modal', function () {
        const selectedElement = $('.ui-checkbox:checked');
        if (selectedElement.length !== 1) {
            return;
        }

        const modal = $(this);
        request(selectedElement.data('edit-url'), {
            method: 'GET'
        }).then(data => {
            modal.find('.modal-dialog').html(data);
        }).catch(() => {
            location.reload();
        });
    }).on('hidden.bs.modal', function () {
        const modal = $(this);
        modal.find('.modal-dialog').find('.modal-body').html('Loading...');
    });

    $("#delete-admin-modal").on('show.bs.modal', function () {
        const selectedElement = $('.ui-checkbox:checked');
        if (selectedElement.length !== 1) {
            return;
        }

        const modal = $(this);
        request(selectedElement.data('delete-url'), {
            method: 'GET'
        }).then(data => {
            modal.find('.modal-dialog').html(data);
        }).catch(() => {
            location.reload();
        });
    }).on('hidden.bs.modal', function () {
        const modal = $(this);
        modal.find('.modal-dialog').find('.modal-body').html('Loading...');
    });

    $(document).on("submit", "#admin-form", (event) => {
        event.preventDefault();

        const form = event.target;
        if (! form.checkValidity()) {
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        const modal = $(form.closest('.modal'));
        request(form.getAttribute('action'), {
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

        const modal = $(form.closest('.modal'));
        request(form.getAttribute('action'), {
            method: 'POST',
            body: new FormData(form),
        }).then(() => {
            location.reload();
        }).catch(error => {
            modal.find('.modal-dialog').html(error.data);
        });
    });
});
