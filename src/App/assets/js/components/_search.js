import $ from 'jquery';

(function () {
    $('.search-toggle').on('click', e => {
        $('.search-box, .search-input').toggleClass('active');
        $('.search-input input').trigger('focus');
        e.preventDefault();
    });
}());
