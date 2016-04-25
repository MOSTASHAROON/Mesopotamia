jQuery(document).ready(function ($) {
    var MesopotamiaObject = {
        addClassesDynamically: function () {
            $('.widget_archive').find('select').addClass('form-control');
        },
        repositionLastMenuItem: function () {
            $("#primary-menu").find("li").on('mouseenter mouseleave', function (e) {
                if ($('ul', this).length) {

                    var elm = $('ul:first', this);
                    var off = elm.offset();
                    var l = off.left;
                    var w = elm.width();
                    var container = $(".container-fluid");
                    var docH = container.height();
                    var docW = container.width();

                    var isEntirelyVisible = (l + w <= docW);
                    if (!isEntirelyVisible) {
                        $('ul:first', this).addClass('dropdown-menu-right');
                        $('ul:first', this).removeClass('dropdown-menu-left');

                    } else {
                        $('ul:first', this).removeClass('dropdown-menu-right');
                        $('ul:first', this).addClass('dropdown-menu-left');

                    }
                }
            });
        },
        //Without this function the sidebar jump up and the content area goes down on small screen size
        fixLeftSidebarLayout: function () {
            var winWidth, row, content, sidebar;
            // var winHeight = $(window).height();
            winWidth = $(window).outerWidth();

            if (winWidth < 992) {
                row = $("#content").find(".row");
                sidebar = $(".col-md-4.col-xs-12, .col-md-3.col-xs-12").prop('outerHTML');
                content = $(".col-md-8.col-xs-12, .col-md-9.col-xs-12").prop('outerHTML');
                row.empty().append(content).append(sidebar);
            } else if (winWidth >= 992) {
                // console.log('Yes');
                row = $("#content").find(".row");
                sidebar = $(".col-md-4.col-xs-12, .col-md-3.col-xs-12").prop('outerHTML');
                content = $(".col-md-8.col-xs-12, .col-md-9.col-xs-12").prop('outerHTML');
                row.empty().append(sidebar).append(content);
            }
        },
        init: function () {
            this.masonry();
            this.scrollToTopButton();
            this.body_offset();

            //Add Hover effect to menus
            $('ul.nav li.dropdown').hover(function () {
                $(this).find('.dropdown-menu').stop(true, true).show();
            }, function () {
                $(this).find('.dropdown-menu').stop(true, true).hide();
            });

            //Fix the dropdown of the last menu item goes out of the screen
            this.repositionLastMenuItem();

            this.addClassesDynamically();

            if ($(".left-sidebar").length) {
                this.fixLeftSidebarLayout();
                $(window).on("resize", this.fixLeftSidebarLayout);
            }
        },
        adjust_body_offset: function adjust_body_offset() {
            $('body').css('padding-top', $('#site-navigation').outerHeight(true) + 'px');
        },
        body_offset: function () {
            if ($(".navbar-fixed-top").length) {
                $(window).resize(MesopotamiaObject.adjust_body_offset);
                $(document).ready(MesopotamiaObject.adjust_body_offset);
            }
        },
        masonry: function () {
            var $container = $('.container-fluid');
            $container.imagesLoaded(function () {
                $('.mesopotamia-posts, .mesopotamia-widgets').masonry({
                    itemSelector: '.post-box',
                    columnWidth: '.post-box',
                    transitionDuration: '0.2s'
                });
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
