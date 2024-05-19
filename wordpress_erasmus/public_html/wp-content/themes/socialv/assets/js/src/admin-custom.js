"use strict";
function notify_wordpress(e) {
    e = {
        action: "socialv_dismiss_notice",
        data: e
    };
    jQuery.post(ajaxurl, e)
}
jQuery, jQuery(document).ready(function () {
    jQuery(".socialv-notice-dismiss").click(function (e) {
        e.preventDefault(),
            jQuery(this).parent().parent(".socialv-notice").fadeOut(600, function () {
                jQuery(this).parent().parent(".socialv-notice").remove()
            }), notify_wordpress(jQuery(this).data("msg"))
    })
});

// Import Button
jQuery(document).ready(function () {
    jQuery('.iqonic_media_form').on('submit', function (e) {
        e.preventDefault();
        if (!confirm(socialv_global_script.admin_notice)) {
            return;
        }
        var form = jQuery(this);
        var formsParameters = {
            action: 'socialv_import_settings',
            formType: form.find('[name="media_form_type"]').val(),
            dataValue: form.find('[name="media_form_type"]').attr('data-value'),
            chatValue: form.find('[name="media_form_type"]').attr('data-chat-value'),
        };
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formsParameters,
            dataType: 'json',
            success: function (data) {
                if (data.status === 'media-success') {
                    jQuery(document).find('.socialv-notice .socialv-media').fadeIn('slow').after('<div class="iqonic-result-msg">' + data.message + '</div>');
                }
                if (data.status === 'message-success') {
                    jQuery(document).find('.socialv-notice .socialv-message').fadeIn('slow').after('<div class="iqonic-result-msg">' + data.message + '</div>');
                }
                setTimeout("location.reload(true);", 1500);
            }
        });
    });
});