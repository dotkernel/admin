import {request} from "./_request";

$( document ).ready(function(){
    const adminEditButton = $("#adminEditBtn");
    const adminDeleteButton = $("#adminDeleteBtn");
    const bsTable = $("#bsTable");

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

        request('POST', `/setting/store-setting/${identifier}`, JSON.stringify({
            value: visibleColumns,
        })).catch(error => console.error('Error:', error));
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
