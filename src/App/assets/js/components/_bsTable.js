$( document ).ready(function(){
    var showFailDialog = function (data) {
        if(data.status == 0 && data.statusText == 'abort')
            return;

        if (data.status == 401) {
            $("#modalCloseButton").click(function () {
                window.location.reload();
            });
            showAlertDialog('Authorization error',
                'You session has expired. The page will be reloaded in order to re-authenticate',
                'error');
        }
        else if (data.status == 403) {
            showAlertDialog('Authorization error',
                'You are not authorized to run this operation',
                'error');
        }
        else {
            showAlertDialog('Unexpected server error',
                'Could not load form due to a server error. Please try again',
                'error');
        }
    };

    var uiButtons = function (selections) {
        var count = selections.length;
        if (count == 0) {
            $("#adminEditButton").prop('disabled', true);
            $("#adminDeleteButton").prop('disabled', true);
            $("#userEditButton").prop('disabled', true);
            $("#userDeleteButton").prop('disabled', true);
        }
        else if (count == 1) {
            $("#adminEditButton").prop('disabled', false);
            $("#adminDeleteButton").prop('disabled', false);
            $("#userEditButton").prop('disabled', false);
            $("#userDeleteButton").prop('disabled', false);
        }
        else {
            $("#adminEditButton").prop('disabled', true);
            $("#adminDeleteButton").prop('disabled', false);
            $("#userEditButton").prop('disabled', true);
            $("#userDeleteButton").prop('disabled', false);
        }
    };

    $("#formModalSubmit").click(function () {
        $('#formModal').modal('handleUpdate');
        $("#loading").modal({backdrop:false,show:true});

        $.post($("#ajaxForm").attr('action'), $("#ajaxForm").serialize())
            .done(function (data) {
                if (data.success == 'success') {
                    $("#loading").modal('hide');
                    $("#formMessages").html('<div class="alert alert-success alert-dismissible" ' +
                        'role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">×</span></button> <div>'+data.message+'</div>' +
                        '</div>');
                    $("#bsTable").bootstrapTable('refresh');
                    setTimeout(function () {
                        $('#formModal').modal('hide');
                    },1500);
                } else {
                    $("#loading").modal('hide');
                    $("#formMessages").html('<div class="alert alert-danger alert-dismissible" ' +
                        'role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">×</span></button> <div>'+data.message+'</div>' +
                        '<div>');
                }
            })
            .fail(function (data) {
                $("#loading").modal('hide');
                $('#formModal').modal('hide');
            });
    });

    var resetUiButtonState = function () {
        $("#adminEditButton").prop('disabled', true);
        $("#adminDeleteButton").prop('disabled', true);
        $("#userEditButton").prop('disabled', true);
        $("#userDeleteButton").prop('disabled', true);
    };

    $("#bsTable").on('load-success.bs.table', function () {
        resetUiButtonState();
    });

    $("#bsTable").on('load-error.bs.table', function (e, status, res) {
        showFailDialog(res);
        resetUiButtonState();
    });

    $("#bsTable").on('check.bs.table', function () {
        var selections = $("#bsTable").bootstrapTable('getSelections');
        uiButtons(selections);
    });

    $("#bsTable").on('uncheck.bs.table', function () {
        var selections = $("#bsTable").bootstrapTable('getSelections');
        uiButtons(selections);
    });

    $("#bsTable").on('check-all.bs.table', function () {
        var selections = $("#bsTable").bootstrapTable('getSelections');
        uiButtons(selections);
    });

    $("#bsTable").on('uncheck-all.bs.table', function () {
        var selections = $("#bsTable").bootstrapTable('getSelections');
        uiButtons(selections);
    });
});