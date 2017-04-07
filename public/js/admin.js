$(document).ready(function() {

    var sideslider = $('[data-toggle=collapse-side]');
    var sel = sideslider.attr('data-target');
    var sel2 = sideslider.attr('data-target-2');
    sideslider.click(function(event){
        $(sel).toggleClass('in');
        $(sel2).toggleClass('out');
    });

    // on refresh close any submenu
    $("#sidebar-collapse .children").removeClass("in").attr("aria-expanded", "false");

    <!-- Menu Toggle Right-Left Script -->
    $("#left-menu-toggle").click(function(e) {
        e.preventDefault();

        $(".main-content").toggleClass("toggled");
        $("#sidebar-collapse").toggleClass("sideRightIn sideRightOut");
        $("#sidebar-collapse .children").removeClass("in").attr("aria-expanded", "false");
    });

    // on small devices click on menu item will not open the left sidebar
    $(".sideRightIn i, .sideRightIn .submenu").click(function(e) {
        e.preventDefault();
        if ($(window).width() > 767)
        {
            $(".main-content").addClass("toggled");
            $("#sidebar-collapse").addClass("sideRightOut").removeClass("sideRightIn");
        }
    });

    //show notification container
    $(".notification i, .notification .notes_no").click(function(e) {
        $(".notification .notis-container").toggle();

        // nanoScroller for notifications
        $(".nano-note").nanoScroller();
    });

    // init nanoScroller for left menu
    $(".nano-sidebar").nanoScroller();

    $( window ).resize(function() {
        // on refresh close any submenu
        $("#sidebar-collapse .children").removeClass("in").attr("aria-expanded", "false");

        if ($("#sidebar-collapse").hasClass("sideRightOut"))
        {
            $("#sidebar-collapse").removeClass("sideRightOut").addClass("sideRightIn");
            $(".main-content").removeClass("toggled");
        }
    });

});
