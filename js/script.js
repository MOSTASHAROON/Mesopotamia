jQuery(document).ready(function ($) {
    var MesopotamiaObject = {
        init: function () {
            this.masonry();
        },
        masonry: function () {
            $('.mesopotamia-posts').masonry({
                itemSelector: '.post-box',
                columnWidth: '.post-box',
                transitionDuration: 0
            });
        },
        doSomething: function (e) {
            e.preventDefault();
            var self = $(this),
                form = self.closest('form'),
                params = {action: 'tajer_action'},
                data = form.serialize() + '&' + $.param(params);

            self.addClass('loading');
            $.ajax({
                url: Tajer.ajaxurl,
                type: 'POST',
                data: data,
                success: function (result) {
                    //in case we got unexpected result then just extract our json string
                    var extractJsonString = result.match(/\[tajer_json\](\{.+\})\[\/tajer_json\]/);
                    result = $.parseJSON(extractJsonString[1]);
                    self.removeClass('loading');
                    if (result.status != 'example') {

                    } else {
                        setTimeout(
                            function () {
                                successMessage.empty();
                            }, 3000);
                    }
                }
            });
        }
    };
    MesopotamiaObject.init();
});
