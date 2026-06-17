import $ from 'jquery';

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

    $("#add-user-modal").on('show.bs.modal', function () {
        const modal = $(this);
        request(modal.data('add-url'), {
            method: 'GET'
        }).then(data => {
            modal.find('.modal-dialog').html(data);
        }).catch(error => {
            console.error(error);
            location.reload();
        });
    }).on('hidden.bs.modal', function () {
        const modal = $(this);
        modal.find('.modal-dialog').find('.modal-body').html('Loading...');
    });

    $("#edit-user-modal").on('show.bs.modal', function () {
        const selectedElement = $('.ui-checkbox:checked');
        if (selectedElement.length !== 1) {
            return;
        }

        const modal = $(this);
        request(selectedElement.data('edit-url'), {
            method: 'GET'
        }).then(data => {
            modal.find('.modal-dialog').html(data);
        }).catch(error => {
            console.error(error);
            location.reload();
        });
    }).on('hidden.bs.modal', function () {
        const modal = $(this);
        modal.find('.modal-dialog').find('.modal-body').html('Loading...');
    });

    $("#delete-user-modal").on('show.bs.modal', function () {
        const selectedElement = $('.ui-checkbox:checked');
        if (selectedElement.length !== 1) {
            return;
        }

        const modal = $(this);
        request(selectedElement.data('delete-url'), {
            method: 'GET'
        }).then(data => {
            modal.find('.modal-dialog').html(data);
        }).catch(error => {
            console.error(error);
            location.reload();
        });
    }).on('hidden.bs.modal', function () {
        const modal = $(this);
        modal.find('.modal-dialog').find('.modal-body').html('Loading...');
    });

    $(document).on('click', '#user-avatar-preview', () => $('#user-avatar-selector').click());

    $(document).on("submit", "#user-avatar-form", (event) => {
        event.preventDefault();

        const form = event.target;
        if (! form.checkValidity()) {
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        request(form.getAttribute('action'), {
            method: 'POST',
            body: new FormData(form),
        }).then(() => {
            location.reload();
        }).catch(() => {
            location.reload();
        });
    });

    $(document).on("submit", "#user-form", (event) => {
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

    $(document).on("submit", "#delete-user-form", (event) => {
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

    $(document).on('change', '#user-avatar-selector', (event) => {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.onload = function (e) {
                $('#user-avatar-preview')
                    .attr('src', e.target.result)
                    .show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#user-avatar-preview').hide();
        }
    });
});
