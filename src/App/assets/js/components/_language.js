$(document).ready(function () {
    $(document).on('click', '.language-container .language-active', function () {
        $(".language-list").slideToggle("fast");
    });

    $(document).on('click', '.language-container .language', function () {
        let language = $(this);
        let languageKey = $(this).data('language-key');
        let langImageSrc = language.find('img').attr('src');

        $('.language-container .language-active').find('img').attr('src', langImageSrc);

        $(".language-list").slideToggle("fast");
        $(".language-list .language").removeClass('active');

        $.post(
            '/language/change',
            {
                'languageKey': languageKey
            }
        )
        .done(function () {
            // activate language in list
            language.addClass('active');

            // reload page
            location.reload();
        });
    });
});
