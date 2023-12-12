const showAlertDialog = (title, message, type) => {
    let iconClass = 'fa-info-circle color-blue';
    if (type === 'error') {
        iconClass = 'fa-exclamation-circle color-red';
    }
    let modal = $("#modalAlert");
    if (! modal) {
        return;
    }

    modal.find("#modalAlertIcon").addClass(iconClass);
    modal.find("#modalAlertTitle").text(title);
    modal.find("#modalAlertMessage").text(message);
    modal.modal('show');
}