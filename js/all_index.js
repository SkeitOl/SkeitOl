$(function () {
    var pull = $('#pull');
    menu = $('nav ul');
    menuHeight = menu.height();
    $(pull).on('click', function (e) {
        e.preventDefault();
        menu.slideToggle();
    });
    $(window).resize(function () {
        var w = $(window).width();
        if (w > 320 && menu.is(':hidden')) {
            menu.removeAttr('style');
        }
    });
    if( $('.main_page_slider').length>0){
    $('.main_page_slider').show();
    $('.main_page_slider').slick({dots: true,arrows: false,autoplay: true,autoplaySpeed:3500,});}
});
$(document).ready(function () { $("#upbutton").hide(); $(function () { $(window).scroll(function () { if ($(this).scrollTop() > 80) { $('#upbutton').fadeIn(); } else { $('#upbutton').fadeOut(); } }); $('#upbutton').click(function () { $('body,html').animate({ scrollTop: 0 }, 500); return false; }); }); });   