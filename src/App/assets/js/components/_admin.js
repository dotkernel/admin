import {request} from "./_request";

$(document).ready(() => {
    const adminEditButton = $("#adminEditButton");
    const adminDeleteButton = $("#adminDeleteButton");

    adminEditButton.prop('disabled', true);
    adminDeleteButton.prop('disabled', true);

    $("#adminAddButton").click(function () {
        $.get('/admin/add')
            .done(function (data) {
                $("#formModalTitle").html('Add Admin');
                $("#formPlaceholder").html(data);

                $('#formMessages').empty();
                $("#formModal").modal('show');
            })
            .fail(function (data) {
                showFailDialog(data);
            });
    });

    adminEditButton.click(function () {
        let selections = $("#bsTable").bootstrapTable('getSelections');
        if (selections.length !== 1) {
            showAlertDialog('Selection error',
                'Multiple or no Admin selected. Only one Admin can be edited a time',
                'error');
        } else {
            $.get('/admin/edit/' + selections[0].uuid)
                .done(function (data) {
                    $("#formModalTitle").html('Edit Admin');
                    $("#formPlaceholder").html(data);

                    $('#formMessages').empty();
                    $("#formModal").modal('show');
                })
                .fail(function (data) {
                    showFailDialog(data);
                });
        }
    });

    adminDeleteButton.click(function () {
        let selections = $("#bsTable").bootstrapTable('getSelections');
        if (selections.length === 0) {
            return;
        }
        $("#deleteFormPlaceholder").text('Are you sure you want to delete ' + selections[0].identity + '?');
        $("#deleteFormMessages").empty();
        $("#deleteFormModal").modal('show');
    });

    $("#deleteAdminFormModalSubmit").click(function () {
        let selections = $("#bsTable").bootstrapTable('getSelections');
        $('#deleteFormModal').modal('handleUpdate');


        request('POST', `/admin/delete`, {
            value: selections[0],
        })
            .then((data) => {
                $('#deleteFormMessages').html(
                    $('<div>').prop({
                        innerHTML: data.message,
                        className: 'alert alert-success alert-dismissible',
                        role: "alert"
                    })
                );
                $("#bsTable").bootstrapTable('refresh');
                setTimeout(function () {
                    $('#deleteFormModal').modal('hide');
                },1500);
            })
            .catch(
                $('#deleteFormMessages').html(
                    $('<div>').prop({
                        innerHTML: "An error occurred",
                        className: 'alert alert-danger alert-dismissible',
                        role: "alert"
                    })
                ))
                setTimeout(function () {
                    $('#deleteFormModal').modal('hide');
                },2000
            )
    });
});