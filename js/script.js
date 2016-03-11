jQuery(document).ready(function ($) {
    var MesopotamiaObject = {
        init: function () {
            this.masonry();
            this.scrollToTopButton();
        },
        masonry: function () {
            $('.mesopotamia-posts').masonry({
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
