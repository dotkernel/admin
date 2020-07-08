!function ($) {
    $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
        $(this).find('em:first').toggleClass("fa fa-minus-circle");
    });
    $(".sidebar span.icon").find('em:first').addClass("fa fa-plus-circle");
}(window.jQuery);

$(window).on('resize', function () {
    if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
});
$(window).on('resize', function () {
    if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
});

function showAlertDialog(title, message, type) {
    var iconClass = 'fa-info-circle color-blue';
    if (type == 'error') {
        iconClass = 'fa-exclamation-circle color-red';
    }

    var modal = $("#modalAlert");
    modal.find("#modalAlertIcon").addClass(iconClass);
    modal.find("#modalAlertTitle").text(title);
    modal.find("#modalAlertMessage").text(message);
    modal.modal('show');
}