jQuery(document).ready(function ($) {
    var Settings = {
        container: $(".mostasharoon-container"),
        dropDowns: $('.MOSTASHAROON .ui.dropdown'),
        mostasharoonModal: $('.ui.suimodal'),
        init: function () {

            $('[data-toggle="tooltip"]').tooltip({
                trigger: 'hover'
            });

            $('.mostasharoon-color-field').wpColorPicker();
            //this.tab();
            //this.dismissableMessages();
            //this.dropDowns.mostasharoondropdown({
            //    context: Settings.container,
            //    keepOnScreen: true
            //});
            //$(".MOSTASHAROON form *[data-content]").popup({
            //    context: Settings.container,
            //    inline: true
            //});
            //
            $('button#mostasharoon-save-settings').off('click').on('click', this.saveSettings);
            //this.modalSetup();
            $(".mostasharoon-upload-file").off('click').on('click', this.openMediaLibrary);
            $(".mostasharoon-remove-image").off('click').on('click', this.removeImage);
        },
        removeImage: function (e) {
            e.preventDefault();
            var self = $(this),
                container = self.closest(".mostasharoon-field");
            container.find("img").attr('src', '');
            container.find("input[type='hidden']").val('');
            // container.find("button").removeClass('bottom attached');
            container.find(".img-wrap").hide();
        },
        openMediaLibrary: function () {
            var file_frame, image_data,
                self = $(this),
                container = self.closest(".mostasharoon-field");

            //window.mostasharoonRowWrapper = self.closest("td");

            if (undefined !== file_frame) {
                file_frame.open();
                return;
            }

            file_frame = wp.media.frames.file_frame = wp.media({
                frame: 'post',
                state: 'insert',
                multiple: false
            });

            file_frame.on('menu:render:default', function (view) {
                // Store our views in an object.
                var views = {};

                // Initialize the views in our view object.
                view.set(views);
            });

            file_frame.on('insert', function () {

                // Read the JSON data returned from the Media Uploader
                json = file_frame.state().get('selection').first().toJSON();

                // First, make sure that we have the URL of an image to display
                if (0 > $.trim(json.url.length)) {
                    return;
                }
                //console.log(json);

                container.find("input[type='hidden']").val(json.id);
                //container.find(".mostasharoon-file-name").val(json.filename);
                container.find("img").attr('src', json.url);

                // container.find("button").addClass('bottom attached');
                container.find(".img-wrap").show();
            });

            file_frame.open();
        },
        modalSetup: function () {
            Settings.mostasharoonModal.suimodal({
                observeChanges: true,
                context: $("div.mostasharoon-container"),
                transition: 'vertical flip'
            });
        },
        tab: function () {
            $('.ui.menu .item').tab();
        },
        dismissableMessages: function () {
            $('.message .close')
                .on('click', function () {
                    $(this)
                        .closest('.message')
                        .transition('fade')
                    ;
                })
            ;
        },
        getMaxRowIndex: function () {
            var highest = 1;
            $('div.mostasharoon_tax_rates_div').find('tr.mostasharoon_repeatable_row').each(function () {
                var current = parseInt($(this).attr("data-index"));
                if (current > highest) {
                    highest = current;
                }
            });
            return highest += 1;
        },
        newInputName: function (self, maxIndex) {
            //console.log(self.html()+'|'+maxIndex);
            var currentName = self.attr("name");
            if (currentName.indexOf("mostasharoon") >= 0) {
                //just replace the number in the name by a new number
                return currentName.replace(/\d+/, maxIndex);
            }
            return currentName;
        },
        saveSettings: function () {
            var params = {action: 'mostasharoon_save_settings'},
                self = $(this),
            //saving = $("span.mostasharoon-saving"),
            //     buttonText = self.find("span"),
            //     savingText = self.find(".mostasharoon-saving"),
            //     buttonCurrentText = self.find("span").text(),
                buttonIcon = self.find("i"),
                data = $("form.mostasharoon-settings-form").serialize() + '&' + $.param(params);

            buttonIcon.removeClass('fa-floppy-o').addClass('fa-cog fa-spin');
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                success: function (result) {
                    //in case we got unexpected result then just extract our json string
                    var extractJsonString = result.match(/\[mostasharoon_json\](\{.+\})\[\/mostasharoon_json\]/);
                    result = $.parseJSON(extractJsonString[1]);

                    // $.each(result.success_messages, function (index, value) {
                    //     $('<div class="ui success message"><i class="close icon"></i><p>' + value + '</p></div>').appendTo('.ui.segment');
                    // });
                    // $.each(result.error_messages, function (index, value) {
                    //     $('<div class="ui negative message"><i class="close icon"></i><p>' + value + '</p></div>').appendTo('.ui.segment');
                    // });

                    if (result.status) {
                        buttonIcon.removeClass('fa-cog fa-spin').addClass('fa-check');
                    }


                    // Settings.dismissableMessages();

                    // buttonText.text('Saved successfully!');
                    // buttonIcon.removeClass("save").addClass("checkmark");
                    setTimeout(
                        function () {
                            buttonIcon.removeClass('fa-check').addClass('fa-floppy-o');
                        }, 1500);
                }
            });
        }
    };
    Settings.init();
});