$(function() {
    if (! storeSettingsUrl) {
        console.error("Invalid or no storeSettingsUrl provided.")
        return;
    }

    if (! getSettingsUrl) {
        console.error("Invalid or no getSettingsUrl provided.")
        return;
    }

    if (! tableId) {
        console.error("Invalid or no tableId provided.")
        return;
    }

    const getSettings = () => {
        return fetch(getSettingsUrl, {
            method: 'GET',
        });
    };

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

    $(document).on('click', '.ui-checkbox', () => {
        toggleUiButtons();
    });

    const toggleUiButtons = () => {
        const btnEdit = $('#btn-edit-admin');
        const btnDelete = $('#btn-delete-admin');
        if (! btnEdit || ! btnDelete) {
            return;
        }

        if ($('.ui-checkbox:checked').length === 1) {
            btnEdit?.prop('disabled', false);
            btnDelete?.prop('disabled', false);
        } else {
            btnEdit?.prop('disabled', true);
            btnDelete?.prop('disabled', true);
        }
    }

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

    $(document).on('click', '.table-row', function (e) {
        const checkbox = $(e.currentTarget).find('.checkbox');
        if (! checkbox) {
            return;
        }

        checkbox.prop('checked', !checkbox.prop('checked'));
        toggleUiButtons();
    });

    $(document).on('click', '.ui-checkbox', function (e) {
        $(e.currentTarget).prop('checked', !$(e.currentTarget).prop('checked'));
    });

    getSettings()
        .then((response) => response.json())
        .then(settings => {
            if (settings.data) {
                populateColumnSelector('#column-selector', settings.data.value);
                hideColumns(tableId, settings.data.value);
            } else {
                populateColumnSelector('#column-selector', []);
                hideColumns(tableId, []);
            }
        })
        .catch(error => {
            populateColumnSelector('#column-selector', []);
            hideColumns(tableId, []);
            console.error('Error: ', error)
        });
});
