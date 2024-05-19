(function (jQuery) {
	"use strict";
	jQuery(document).ready(function () {

		if (jQuery(document).find('.product-single-slider').length > 0) {
			jQuery(document).find('.product-single-slider').each(function () {
				let slider = jQuery(this);
				var config;
				if (slider.hasClass("image-slider")) {
					config = {
						slidesPerView: 1,
						paginationClickable: true,
						pagination: '.swiper-pagination',
						paginationType: "bullets",
						navigation: {
							nextEl: '.swiper-button-next',
							prevEl: '.swiper-button-prev'
						},
						loop: true,
						spaceBetween: 0
					};
				}

				if (slider.hasClass("related-slider") || slider.hasClass("upsells-slider")) {
					var sliderAutoplay = slider.data('autoplay');
					if (sliderAutoplay) {
						sliderAutoplay = {
							delay: slider.data('autoplay')
						};
					}
					config = {
						loop: slider.data('loop'),
						speed: slider.data('speed'),
						spaceBetween: 0,
						slidesPerView: slider.data('slide'),
						navigation: {
							nextEl: '.swiper-button-next',
							prevEl: '.swiper-button-prev'
						},
						autoplay: sliderAutoplay,
						pagination: {
							el: ".swiper-pagination",
							clickable: true
						},
						grabCursor: true,
						breakpoints: {
							0: {
								slidesPerView: slider.data('mobile'),
							},
							768: {
								slidesPerView: slider.data('tab'),
							},
							999: {
								slidesPerView: slider.data('laptop'),
							},
							1400: {
								slidesPerView: slider.data('slide'),
							}
						},
					};
				}

				let swiper = new Swiper(slider[0], config);
				document.addEventListener('theme_scheme_direction', (e) => {
					swiper.destroy(true, true)
					setTimeout(() => {
						swiper = new Swiper('.product-single-slider', config);
					}, 500);
				})
			});
			/* Resize window on load */
			window.dispatchEvent(new Event('resize'));
		}

	});
}(jQuery));