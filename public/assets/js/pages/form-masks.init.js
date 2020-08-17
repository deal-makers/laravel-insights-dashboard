/*
Template Name: Ubold - Responsive Bootstrap 4 Admin Dashboard
Author: CoderThemes
Version: 3.0.0
Website: https://coderthemes.com/
Contact: support@coderthemes.com
File: Form mask init js
*/

$( document ).ready(function() {
    $('[data-toggle="input-mask"]').each(function (idx, obj) {
        var maskFormat = $(obj).data("maskFormat");
        var reverse = $(obj).data("reverse");
        if (reverse != null)
            $(obj).mask(maskFormat, {'reverse': reverse});
        else
            $(obj).mask(maskFormat);
    });
});

jQuery(function($) {
    $('.autonumber').autoNumeric('init');
});
