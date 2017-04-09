function initUpButton() { $("#upbutton").hide(); $(function () { $(window).scroll(function () { if ($(this).scrollTop() > 80) { $('#upbutton').fadeIn(); } else { $('#upbutton').fadeOut(); } }); $('#upbutton').click(function () { $('body,html').animate({ scrollTop: 0 }, 500); return false; }); }); }
/*Navi*/
function initJsMenu() {
var pull = $('#pull');
menu = $('nav ul');
menuHeight = menu.height();
$(pull).on('click', function (e) {e.preventDefault();menu.slideToggle();});
$(window).resize(function () {var w = $(window).width();if (w > 320 && menu.is(':hidden')) {menu.removeAttr('style');}});
}
window.onload = function(){
    //pagePreload.endLoad();
    pagePreload.lazyLoad();
    initUpButton();
    initJsMenu();
    if (typeof initArticlesEvent == 'function') {
        initArticlesEvent();
    }
};