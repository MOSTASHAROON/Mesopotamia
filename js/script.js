jQuery(document).ready(function ($) {
    var MesopotamiaObject = {
        addClassesDynamically: function () {
            $('.widget_archive').find('select').addClass('form-control');
        },
        init: function () {
            this.masonry();
            this.scrollToTopButton();

            //Add Hover effect to menus
            $('ul.nav li.dropdown').hover(function () {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();
            }, function () {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut();
            });

            this.addClassesDynamically();
        },
        //adjust_body_offset: function adjust_body_offset() {
        //    $('body').css('padding-top', $('#site-navigation').outerHeight(true) + 'px');
        //},
        //body_offset: function () {
        //    $(window).resize(MesopotamiaObject.adjust_body_offset);
        //    $(document).ready(MesopotamiaObject.adjust_body_offset);
        //},
        masonry: function () {
            $('.mesopotamia-posts, .mesopotamia-widgets').masonry({
                itemSelector: '.post-box',
                columnWidth: '.post-box',
                transitionDuration: 0
            });
        },
        scrollToTopButton: function () {

            //Check to see if the window is top if not then display button
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('.scrollToTop').fadeIn();
                } else {
                    $('.scrollToTop').fadeOut();
                }
            });

            //Click event to scroll to top
            $('.scrollToTop').click(function () {
                $('html, body').animate({scrollTop: 0}, 800);
                return false;
            });


        }
    };
    MesopotamiaObject.init();
});
