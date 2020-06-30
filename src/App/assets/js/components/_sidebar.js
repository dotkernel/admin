$(document).ready(function() {

    var sideslider = $('[data-toggle=collapse-side]'),
        sel = sideslider.attr('data-target'),
        sel2 = sideslider.attr('data-target-2');

    sideslider.click(function (event) {
        $(sel).toggleClass('in');
        $(sel2).toggleClass('out');

        console.log('test');
    });

    // on refresh close any submenu
    $("#sidebar-collapse .children").removeClass("in").attr("aria-expanded", "false");

    // add scroll for sidebar
    setLeftSidebarScroll();

    // Menu Toggle Right-Left Script
    $("#left-menu-toggle").click(function (e) {
        e.preventDefault();

        console.log('test');

        $(".main-content").toggleClass("toggled");
        $("#sidebar-collapse").toggleClass("sideRightIn sideRightOut");
        $("#sidebar-collapse .children").removeClass("in").attr("aria-expanded", "false");

    });

    // on small devices click on menu item will not open the left sidebar
    $(".sideRightIn .submenu").click(function (e) {
        e.preventDefault();

        if ($(window).width() > 767) {
            $(".main-content").addClass("toggled");
            $("#sidebar-collapse").addClass("sideRightOut").removeClass("sideRightIn");
        }

        // add scroll for sidebar
        setTimeout(function () {
            setLeftSidebarScroll();
        }, 400);
    });

    //show notification container
    $(".notification i, .notification .notes_no").click(function (e) {
        $(".notification .notis-container").toggle();

        // nanoScroller for notifications
        $(".nano-note").nanoScroller();
    });

    $(window).resize(function () {
        // on refresh close any submenu
        $("#sidebar-collapse .children").removeClass("in").attr("aria-expanded", "false");

        if ($("#sidebar-collapse").hasClass("sideRightOut")) {
            $("#sidebar-collapse").removeClass("sideRightOut").addClass("sideRightIn");
            $(".main-content").removeClass("toggled");
        }

        // add scroll for sidebar
        setLeftSidebarScroll();
    });

    // show sidebar items title
    $(".sideRightIn").find(".master-tooltip").hover(function () {
        var title = $(this).attr("title");
        $(this).data("tipText", title).removeAttr("title");
        $('<p class="tooltip-title"></p>')
            .text(title)
            .appendTo("body")
            .fadeIn("slow");
    }, function () {
        // Hover out code
        $(this).attr("title", $(this).data("tipText"));
        $(".tooltip-title").remove();
    }).mousemove(function (e) {
        var mousex = e.pageX + 20; //Get X coordinates
        var mousey = e.pageY + 10; //Get Y coordinates
        if (($(".sideRightIn").find(".master-tooltip").length > 0) && ($(window).width() > 767)) {
            $(".tooltip-title").css({top: mousey, left: mousex});
        }
    });

});

function setLeftSidebarScroll() {
    var headerHeight = $("#sidebar-collapse .nav-placeholder").outerHeight(),
        leftMenuButtonHeight = $("#sidebar-collapse .toggle").height(),
        leftMenuHeight = $("#sidebar-collapse .nano-sidebar .nano-content").height(),
        leftSidebarHeight = headerHeight + leftMenuButtonHeight + leftMenuHeight;

    if (leftSidebarHeight > $(window).height())
    {
        // init nanoScroller for left menu
        $(".nano-sidebar").css("height", $(window).height() - headerHeight - leftMenuButtonHeight + "px");
        $(".nano-sidebar .nano-content").css("height", $(window).height() - headerHeight - leftMenuButtonHeight + "px");
        $(".nano-sidebar").nanoScroller();
    }
    else
    {
        $(".nano-sidebar").css("height", "100%");
        $(".nano-sidebar .nano-content").css("height", "auto");
        $(".nano-sidebar").nanoScroller({ destroy: true });
    }
}