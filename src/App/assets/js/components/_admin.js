import {request} from "./_request";

$(document).ready(() => {
    const adminModal = $('#adminModal');
    const adminDeleteModal = $('#deleteFormModal');
    const bsTable = $("#bsTable");

    $("#adminEditBtn").prop('disabled', true);
    $("#adminDeleteBtn").prop('disabled', true);

    $(document).on('click', '#adminAddBtn', () => {
        adminModal.find('.modal-messages').html('');
        request('GET', '/admin/add')
            .catch(error => console.error('Error:', error))
            .then(data => {
                adminModal.find('.modal-title').text('Add admin');
                adminModal.find('.modal-form').html(data.data);
                adminModal.modal('show');
            });
    });

    $(document).on('click', '#formModalSubmit', () => {
        const form = $('#ajaxForm');
        const messages = adminModal.find('.modal-messages');
        if (form.length < 1) {
            return;
        }

        request(form.attr('method'), form.attr('action'), new FormData(form.get(0)))
            .then(data => {
                messages.html('');
                messages.append(
                    $('<div>').prop({
                        innerHTML: data.message,
                        className: 'alert alert-success',
                        role: "alert"
                    })
                );
                bsTable.bootstrapTable('refresh');
                setTimeout(function () {
                    adminModal.modal('hide');
                },1500);
            }).catch(error => {
                messages.html('');
                messages.append(
                    $('<div>').prop({
                        innerHTML: error.cause,
                        className: 'alert alert-danger',
                        role: "alert"
                    })
                );
            }).finally(() => {
                adminModal.modal('show');
            });
    });

    $(document).on('click', '#adminEditBtn', () => {
        const selections = $("#bsTable").bootstrapTable('getSelections');
        if (selections.length !== 1) {
            return;
        }

        adminModal.find('.modal-messages')?.html('');
        request('GET', `/admin/edit/${selections[0].uuid}`)
            .catch(error => console.error('Error:', error))
            .then(data => {
                adminModal.find('.modal-title').text('Edit admin');
                adminModal.find('.modal-form').html(data.data);
                adminModal.modal('show');
            });
    });

    $(document).on('click', '#adminDeleteBtn', () => {
        const selections = $("#bsTable").bootstrapTable('getSelections');
        if (selections.length !== 1) {
            return;
        }

        adminDeleteModal.find('#adminIdentity').html(`<b>${selections[0].identity}</b>`);
        adminDeleteModal.modal('show');
    });

    $("#deleteAdminForm").on('submit', (e) => {
        e.preventDefault();
        const selections = $("#bsTable").bootstrapTable('getSelections');
        const form = $('#deleteAdminForm');
        const messages = $(form).find('.modal-messages');
        messages.html('');
        request('POST', `/admin/delete/${selections[0].uuid}`, new FormData(form.get(0)))
            .then(data => {
                messages.append(
                    $('<div>').prop({
                        innerHTML: data.message,
                        className: 'alert alert-success',
                        role: "alert"
                    })
                );
                bsTable.bootstrapTable('refresh');
                setTimeout(function () {
                    adminDeleteModal.modal('hide');
                    messages.html('');
                },1500);
            }).catch(error => {
            messages.append(
                $('<div>').prop({
                    innerHTML: error.cause,
                    className: 'alert alert-danger',
                    role: "alert"
                })
            );
        }).finally(() => {
            adminDeleteModal.modal('show');
        });
    });

    adminDeleteModal.on('show.bs.modal', 'hidden.bs.modal', function () {
        adminDeleteModal.find('#confirmation').prop('checked', false);
    });
});
