import $ from 'jquery';

// jquery-migrate and jquery-sparkline are plugins that attach themselves to the
// global jQuery, so it has to be exposed before either of them is imported.
window.$ = window.jQuery = $;

$.migrateMute = true;
