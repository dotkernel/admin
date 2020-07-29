$( document ).ready(function(){
    $("#userEditButton").prop('disabled', true);
    $("#userDeleteButton").prop('disabled', true);

    $("#userAddButton").click(function () {
        $.get('/user/add')
            .done(function (data) {
                $("#formModalTitle").html('Add User');
                $("#formPlaceholder").html(data);

                $('#formMessages').empty();
                $("#formModal").modal('show');
            })
            .fail(function (data) {
                showFailDialog(data);
            });
    });

    $("#userEditButton").click(function () {
        var selections = $("#bsTable").bootstrapTable('getSelections');
        if (selections.length != 1) {
            showAlertDialog('Selection error',
                'Multiple or no User selected. Only one User can be edited a time',
                'error');
        } else {
            $.get('/user/edit/' + selections[0].uuid)
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

    $("#userDeleteButton").click(function () {
        var selections = $("#bsTable").bootstrapTable('getSelections');
        if (selections.length === 0) {
            return;
        }
        $("#deleteFormPlaceholder").text('Are you sure you want to delete ' + selections[0].identity + '?');
        $("#deleteFormMessages").empty();
        $("#deleteFormModal").modal('show');
    });

    $("#deleteUserFormModalSubmit").click(function () {
        var selections = $("#bsTable").bootstrapTable('getSelections');
        $('#deleteFormModal').modal('handleUpdate');

        $.post('/user/delete', selections[0])
            .done(function (data) {
                if (data.success == 'success') {
                    $("#deleteFormMessages").html('<div class="alert alert-success alert-dismissible" ' +
                        'role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">×</span></button> <div>'+data.message+'</div>' +
                        '</div>');
                    $("#bsTable").bootstrapTable('refresh');
                    setTimeout(function () {
                        $('#deleteFormModal').modal('hide');
                    },1500);
                } else {
                    $("#deleteFormMessages").html('<div class="alert alert-danger alert-dismissible" ' +
                        'role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">×</span></button> <div>'+data.message+'</div>' +
                        '<div>');
                    setTimeout(function () {
                        $('#deleteFormModal').modal('hide');
                    },2000);
                }
            })
            .fail(function (data) {
                $('#formModal').modal('hide');
            });
    });
});