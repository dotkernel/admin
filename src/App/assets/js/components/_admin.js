$( document ).ready(function(){
    $("#adminEditButton").prop('disabled', true);
    $("#adminDeleteButton").prop('disabled', true);

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

    $("#adminEditButton").click(function () {
        var selections = $("#bsTable").bootstrapTable('getSelections');
        if (selections.length != 1) {
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

    $("#adminDeleteButton").click(function () {
        var selections = $("#bsTable").bootstrapTable('getSelections');
        if (selections.length === 0) {
            return;
        }
        $("#deleteFormPlaceholder").text('Are you sure you want to delete ' + selections[0].identity + '?');
        $("#deleteFormMessages").empty();
        $("#deleteFormModal").modal('show');
    });

    $("#deleteAdminFormModalSubmit").click(function () {
        var selections = $("#bsTable").bootstrapTable('getSelections');
        $('#deleteFormModal').modal('handleUpdate');

        $.post('/admin/delete', selections[0])
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