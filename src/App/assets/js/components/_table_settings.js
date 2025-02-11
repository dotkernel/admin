$(function() {
    if (! storeSettingsUrl) {
        console.error("Invalid or no storeSettingsUrl provided.")
        return;
    }

    if (! columnsSettings) {
        console.error("Invalid or no column settings provided.")
        return;
    }

    if (! tableId) {
        console.error("Invalid or no tableId provided.")
        return;
    }

    const hideColumns = (tableId, visibleColumns) => {
        const table = $(tableId);
        if (visibleColumns.length === 0) {
            table.show();
            return;
        }
        $('.table-column').each((_, element) => {
            const column = $(element).data('column');
            toggleColumnVisibility(column, visibleColumns.includes(column));
        });

        table.show();
    };

    const saveColumnSettings = (url) => {
        return fetch(url, {
            method: 'POST',
            body: JSON.stringify({
                value: $('.toggle-column-checkbox:checked').map((_, element) => $(element).data('column')).get()
            })
        })
    };

    const toggleColumnVisibility = (column, visible) => {
        if (visible) {
            $(`.column-${column}`).show();
        } else {
            $(`.column-${column}`).hide();
        }
    };

    const populateColumnSelector = (columnSelectorId, columnsSettings) => {
        const columnSelector = $(columnSelectorId);
        $('.table-column').map((_, element) => {
            return {
                text: $(element).text().trim(),
                column: $(element).data('column'),
            };
        }).each((_, element) => {
            columnSelector.append(
                $('<li>').append(
                    $('<div>').addClass('dropdown-item pT-0 pB-0').append(
                        $('<input>')
                            .prop('type', 'checkbox')
                            .prop('id', `column-selector-${element.column}`)
                            .prop('checked', columnsSettings.includes(element.column) || columnsSettings.length === 0)
                            .addClass('toggle-column-checkbox')
                            .data('column', element.column)
                    ).append(
                        $('<label>')
                            .prop('for', `column-selector-${element.column}`)
                            .addClass('pL-5').text(element.text)
                    )
                )
            );
        });
    };

    populateColumnSelector('#column-selector', columnsSettings);
    hideColumns(tableId, columnsSettings);

    $(document).on('change', '.toggle-column-checkbox', function () {
        const table = $(tableId);
        if (! table) {
            console.error(`Table not found by table id: ${tableId}`);
            return;
        }

        table.addClass('border-danger-subtle');
        saveColumnSettings(storeSettingsUrl)
            .then(() => toggleColumnVisibility($(this).data('column'), $(this).prop('checked')))
            .then(() => {
                table.removeClass('border-danger-subtle');
            })
            .catch(error => console.error('Error: ', error));
    });
});
