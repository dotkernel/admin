import {request} from "./_request";

$( document ).ready(function(){
    const TYPE_ERROR = 'error';
    const ERROR_TITLE_AUTHORIZATION = 'Authorization error';
    const ERROR_UNEXPECTED_SERVER = 'Unexpected server error';
    const adminEditButton = $("#adminEditButton");
    const adminDeleteButton = $("#adminDeleteButton");
    const bsTable = $("#bsTable");

    const showFailDialog = (data) => {
        if(data.status === 0 && data.statusText === 'abort') {
            return;
        }

        if (data.status === 401) {
            $("#modalCloseButton").click(function () {
                window.location.reload();
            });
            showAlertDialog(
                ERROR_TITLE_AUTHORIZATION,
                'You session has expired. The page will be reloaded in order to re-authenticate',
                TYPE_ERROR
            );
        }
        else if (data.status === 403) {
            showAlertDialog(
                ERROR_TITLE_AUTHORIZATION,
                'You are not authorized to run this operation',
                TYPE_ERROR
            );
        }
        else {
            showAlertDialog(
                ERROR_UNEXPECTED_SERVER,
                'Could not load form due to a server error. Please try again',
                TYPE_ERROR
            );
        }
    };

    const uiButtons = (selections) => {
        const count = selections.length;
        if (count === 0) {
            adminEditButton.prop('disabled', true);
            adminDeleteButton.prop('disabled', true);
        }
        else if (count === 1) {
            adminEditButton.prop('disabled', false);
            adminDeleteButton.prop('disabled', false);
        }
        else {
            adminEditButton.prop('disabled', true);
            adminDeleteButton.prop('disabled', false);
        }
    };

    $("#formModalSubmit").click(function () {
        const formModal = $('#formModal');

        formModal.modal('handleUpdate');
        let form = $("#ajaxForm");
        let formData = new FormData(document.querySelector("#ajaxForm"));

        $.ajax({
            url: form.attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            type: form.attr('method')
        })
            .done((data) => {
                const formMessages = $("#formMessages");
                formMessages.html(
                    $('<div>').prop({
                        innerHTML: data.message,
                        className: 'alert alert-success alert-dismissible',
                        role: "alert"
                    })
                );
                bsTable.bootstrapTable('refresh');
                setTimeout(function () {
                    formModal.modal('hide');
                },1500);
            })
            .fail((data) => {
                const formMessages = $("#formMessages");
                formMessages.html(
                    $('<div>').prop({
                        innerHTML: data.responseJSON.message,
                        className: 'alert alert-danger alert-dismissible',
                        role: "alert"
                    })
                );
            });
    });

    const resetUiButtonState = () => {
        adminEditButton.prop('disabled', true);
        adminDeleteButton.prop('disabled', true);
    };

    bsTable.on('load-success.bs.table', () => {
        resetUiButtonState();
    });

    bsTable.on('load-error.bs.table', (e, status, res) => {
        showFailDialog(res);
        resetUiButtonState();
    });

    bsTable.on('check.bs.table', () => {
        const selections = bsTable.bootstrapTable('getSelections');
        uiButtons(selections);
    });

    bsTable.on('uncheck.bs.table', () => {
        const selections = bsTable.bootstrapTable('getSelections');
        uiButtons(selections);
    });

    bsTable.on('check-all.bs.table', () => {
        const selections = bsTable.bootstrapTable('getSelections');
        uiButtons(selections);
    });

    bsTable.on('uncheck-all.bs.table', () => {
        const selections = bsTable.bootstrapTable('getSelections');
        uiButtons(selections);
    });

    const identifier = bsTable.data('identifier');
    if (! identifier) {
        return ;
    }

    bsTable.on('column-switch.bs.table', () => {
        const visibleColumns = bsTable.bootstrapTable('getVisibleColumns').map(it => {
            return it.field;
        });
        request('POST', `/setting/store-setting/${identifier}`, {
            value: visibleColumns,
        }).catch(error => console.error('Error:', error));
    });

    request('GET', `/setting/get-setting/${identifier}`)
        .then(data => {
            const visibleColumns = bsTable.bootstrapTable('getVisibleColumns');
            visibleColumns.forEach(column => {
                bsTable.bootstrapTable('hideColumn', column.field);
            });
            data?.data?.value?.forEach(column => {
                bsTable.bootstrapTable('showColumn', column);
            });
        }).catch(error => console.error('Error:', error));

});