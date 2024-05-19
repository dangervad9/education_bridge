(function ($) {
	"use strict";

	$(document).ready(function () {
		$('form.pmpro_form').find(".pmpro_asterisk").remove();

		//adds custom required field structure in checkout form
		$('.pmpro_required').each(function () {
			if ($(this).closest('.pmpro_checkout-field').children().first().find('.pmpro_asterisk').length == 0) {
				$(this).closest('.pmpro_checkout-field').children().first().append('<span class="pmpro_asterisk"> <abbr title="Required Field">*</abbr></span>');
			}
		})

		//adds custom required field structure in change password form
		$('.pmpro_change_password-field').each(function () {
			if ($(this).children().first().find('.pmpro_asterisk').length == 0) {
				$(this).children().first().append('<span class="pmpro_asterisk"> <abbr title="Required Field">*</abbr></span>');
			}
		});
	});
})(jQuery)