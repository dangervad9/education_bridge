;(function ($) {
	"use strict";

	$(document).ready(function() {
		/**
		 * Search Keywords
		 */
		
		$('.header_search_keyword ul li a').on('click', function (e) {
			e.preventDefault();
			var content = $(this).text();
			$('#searchInput').val(content).focus();
			$('#searchInput').keyup();
			$('#docy-search-result').css({ "z-index": "9999" });
		  });

		/**
		 * Disable  enter key press on Forum Topics Filter search input field
		 */
		$('.post-header .category-menu .cate-search-form').keypress(
			function(event){
				if (event.which == '13') {
					event.preventDefault();
				}
			}
		)

		$('.onepage-doc .nav-sidebar .nav-item:first-child').addClass('active');

		if($('.single-docs .elementor-widget-container > h2').length) {
			anchors.options = {
				icon: '#'
			};
			anchors.add('.elementor-widget-container > h2');
		}

		$('#searchInput').on('input', function(e) {
			if ( '' == this.value ) {
				$('#docly-search-result').removeClass('ajax-search');
			}
		});


		// Update cart button
		$('.ar_top').on('click', function () {
			var getID = $(this).next().attr('id');
			var result = document.getElementById(getID);
			var qty = result.value;
			$('.shopping_cart_area .cart_btn.cart_btn_two').removeAttr('disabled');
			if (!isNaN(qty)) {
				result.value++;
				$('.cart_btn.ajax_add_to_cart').attr('data-quantity', result.value )
			} else {
				return false;
			}
		});

		$('.ar_down').on('click', function () {
			var getID = $(this).prev().attr('id');
			var result = document.getElementById(getID);
			var qty = result.value;
			$('.shopping_cart_area .cart_btn.cart_btn_two').removeAttr('disabled');
			if (!isNaN(qty) && qty > 0) {
				result.value--;
				$('.cart_btn.ajax_add_to_cart').attr('data-quantity', result.value )
			} else {
				return false;
			}
		});

		//*=============menu sticky js =============*//
		var $window = $(window);
		var didScroll,
			lastScrollTop = 0,
			delta = 5,
			$mainNav = $("#sticky"),
			$mainNavHeight = $mainNav.outerHeight(),
			scrollTop;

		$window.on("scroll", function () {
			didScroll = true;
			scrollTop = $(this).scrollTop();
		});

		setInterval(function () {
			if (didScroll) {
				hasScrolled();
				didScroll = false;
			}
		}, 200);

		function hasScrolled() {
			if (Math.abs(lastScrollTop - scrollTop) <= delta) {
				return;
			}
			if (scrollTop > lastScrollTop && scrollTop > $mainNavHeight) {
				$mainNav.removeClass("fadeInDown").addClass("fadeInUp").css('top', -$mainNavHeight);
			} else {
				if (scrollTop + $(window).height() < $(document).height()) {
					$mainNav.removeClass("fadeInUp").addClass("fadeInDown").css('top', 0);
				}
			}
			lastScrollTop = scrollTop;
		}

		function navbarFixed() {
			if ($('#sticky').length) {
				$(window).scroll(function () {
					var scroll = $(window).scrollTop();
					if (scroll) {
						$("#sticky").addClass("navbar_fixed");
						$(".sticky-nav-doc .body_fixed").addClass("body_navbar_fixed");
					} else {
						$("#sticky").removeClass("navbar_fixed");
						$(".sticky-nav-doc .body_fixed").removeClass("body_navbar_fixed");
					}
				})
			}
		}
		navbarFixed();

		function navbarFixedTwo() {
			if ($('#stickyTwo').length) {
				$(window).scroll(function () {
					var scroll = $(window).scrollTop();
					if (scroll) {
						$("#stickyTwo").addClass("navbar_fixed");
					} else {
						$("#stickyTwo").removeClass("navbar_fixed");
					}
				});
			}
		}
		navbarFixedTwo();

		//*=============menu sticky js =============*//

		//         page scroll
		function bodyFixed() {
			var windowWidth = $(window).width();
			if ($('#sticky_doc').length) {
				if (windowWidth > 576) {
					var tops = $('#sticky_doc');
					var leftOffset = tops.offset().top;

					$(window).on('scroll', function () {
						var scroll = $(window).scrollTop();
						if (scroll >= leftOffset) {
							tops.addClass("body_fixed");
						} else {
							tops.removeClass("body_fixed");
						}
					})
				}
			}
		}

		bodyFixed();


		/*  Menu Click js  */
		function Menu_js() {
			if ($('.submenu').length) {
				$('.submenu > .dropdown-toggle').click(function () {
					var location = $(this).attr('href');
					window.location.href = location;
					return false;
				});
			}
		}
		Menu_js();


		$('.doc_menu a[href^="#"]:not([href="#"]').on('click', function (event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top
			}, 900);
			event.preventDefault();
		});

		/*--------------- doc_documentation_area Switcher js--------*/
		if ($(".doc_documentation_area").length > 0) {
			//switcher
			var switchs = true;
			$("#right").on("click", function (e) {
				e.preventDefault();
				if (switchs) {
					$(".doc_documentation_area,#right").addClass("overlay");
					$(".doc_right_mobile_menu").animate({
						"right": "0px"
					}, 100);
					$('.doc_rightsidebar').show()
					switchs = false;
				} else {
					$(".doc_documentation_area,#right").removeClass("overlay");
					$(".doc_right_mobile_menu").animate({
						"right": "-250px"
					}, 100);
					switchs = true;
				}
			});

			$("#left").on("click", function (e) {
				e.preventDefault();
				if (switchs) {
					$(".doc_documentation_area,#left").addClass("overlay");
					$(".doc_mobile_menu").animate({
						"left": "0px"
					}, 300);
					switchs = false;
				} else {
					$(".doc_documentation_area,#left").removeClass("overlay");
					$(".doc_mobile_menu").animate({
						"left": "-245px"
					}, 300);
					switchs = true;
				}
			});
		}

		if ($(".mobile_menu").length > 0) {
			var switchs = true;
			$(".mobile_btn").on("click", function (e) {
				if (switchs) {
					$(".mobile_menu").addClass("open");
				}
			})
		}

		/*--------------- parallaxie js--------*/
		function parallax() {
			if ($(".parallaxie").length) {
				$('.parallaxie').parallaxie({
					speed: 0.5,
				});
			}
		}

		parallax();

		/*--------------- tooltip js--------*/
		function tooltip() {
			if ($('.tooltips').length) {
				$('.tooltips').tooltipster({
					interactive: true,
					arrow: true,
					animation: 'grow',
					delay: 200,
				});
			}
		}

		tooltip();
		$('.tooltips_one').data('tooltip-custom-class', 'tooltip_blue').tooltip();
		$('.tooltips_two').data('tooltip-custom-class', 'tooltip_danger').tooltip();

		$(document).on('inserted.bs.tooltip', function (e) {
			var tooltip = $(e.target).data('bs.tooltip');
			$(tooltip.tip).addClass($(e.target).data('tooltip-custom-class'));
		});

		/*--------------- wavify js--------*/
		if ($('.animated-waves').length) {
			$('#animated-wave-three').wavify({
				height: 40,
				bones: 4,
				amplitude: 70,
				color: "rgba(188, 214, 234, 0.14)",
				speed: .3
			});

			$('#animated-wave-four').wavify({
				height: 60,
				bones: 5,
				amplitude: 90,
				color: "rgba(188, 214, 234, 0.14)",
				speed: .2
			});
		}


		/*--------------- mobile dropdown js--------*/
		function active_dropdown2() {
			$('.menu > li .mobile_dropdown_icon').on('click', function (e) {
				$(this).parent().find('ul').first().slideToggle(300);
				$(this).parent().siblings().find('ul').hide(300);
			});
		}

		active_dropdown2();

		/*--------------- niceSelect js--------*/
		function select() {
			if ($('.custom-select').length) {
				$('.custom-select').niceSelect();
			}
			if ($('#mySelect').length) {
				$('#mySelect').selectpicker();
			}
		}

		select();

		/*--------------- counterUp js--------*/
		function counterUp() {
			if ($('.counter').length) {
				$('.counter').counterUp({
					delay: 1,
					time: 250
				});
			}
			;
		};

		counterUp();

		/*--------------- popup-js--------*/
		function popupGallery() {
			if ($(".img_popup").length) {
				$(".img_popup").each(function () {
					$(".img_popup").magnificPopup({
						type: 'image',
						closeOnContentClick: true,
						closeBtnInside: false,
						fixedContentPos: true,
						removalDelay: 300,
						mainClass: 'mfp-no-margins mfp-with-zoom',
						image: {
							enabled: true,
							navigateByImgClick: true,
							preload: [0, 1] // Will preload 0 - before current, and 1 after the current image,
						}
					});
				})
			}
		}

		popupGallery();

		/*--------------- video js--------*/
		function video() {
			if ($("#inline-popups").length) {
				$('#inline-popups').magnificPopup({
					delegate: 'a',
					removalDelay: 500, //delay removal by X to allow out-animation
					mainClass: 'mfp-no-margins mfp-with-zoom',
					preloader: false,
					midClick: true
				});
			}
		}

		video();

		/*=========== anchors js ===========*/
		// initialize anchor.js
		if ( $('.shortcode_info').length ) {
			anchors.options = {
				icon: '#'
			};
			anchors.add('.load-order-2, .shortcode_info .elementor-widget-heading h2.elementor-heading-title, .shortcode_info h2');
		}



		/*--------- WOW js-----------*/
		function bodyScrollAnimation() {
			var scrollAnimate = $('body').data('scroll-animation');
			if (scrollAnimate === true) {
				new WOW({}).init()
			}
		}

		bodyScrollAnimation();


		/*------------ Video js ------------*/
		if ($(".video-js").length) {
			videojs('vid2', {
				"techOrder": ["wistia"],
				"sources": [{
					"type": "video/wistia",
					"src": "http://fast.wistia.com/embed/iframe/b0767e8ebb?version=v1&controlsVisibleOnLoad=false&playerColor=aae3d8"
				}]
			}).ready(function () {
				this.on('pause', function () {
					console.log("video.js - pause");
				});

				this.on('play', function () {
					console.log("video.js - play");
				});

				this.on('seeked', function () {
					console.log("video.js - seeked");
				});

				this.on('volumechange', function () {
					console.log("video.js - volumechange");
				});

				this.one('ended', function () {
					console.log("video.js - ended");
					this.src("https://home.wistia.com/medias/oefj398m6q?playerColor=ff0000");
					this.play();
				});
			});
		}

		$('.mobile_menu_btn').on('click', function () {
			$('body').removeClass('menu-is-closed').addClass('menu-is-opened');
		});
		$('.close_nav').on("click", function (e) {
			if ($('.side_menu').hasClass('menu-opened')) {
				$('.side_menu').removeClass('menu-opened');
				$('body').removeClass('menu-is-opened')
			} else {
				$('.side_menu').addClass('menu-opened');
			}
		});

		$('.click_capture').on('click', function () {
			$('body').removeClass('menu-is-opened').addClass('menu-is-closed');
			$('.side_menu').removeClass('menu-opened');
		});


		/*--------------- Tab button js--------*/
		$('.next').on('click', function () {
			$('.v_menu .nav-item > .active').parent().next('li').find('a').trigger('click');
		});

		$('.previous').on('click', function () {
			$('.v_menu .nav-item > .active').parent().prev('li').find('a').trigger('click');
		});

		/** Doc Side Menu Click & Hover State  */
		function Click_menu_hover() {
			if ($('.tab-demo').length) {
				$.fn.tab = function (options) {
					var opts = $.extend({}, $.fn.tab.defaults, options);
					return this.each(function () {
						var obj = $(this);

						$(obj).find('.tabHeader li').on(opts.trigger_event_type, function () {
							$(obj).find('.tabHeader li').removeClass('active');
							$(this).addClass('active');

							$(obj).find('.tabContent .tab-pane').removeClass('active show');
							$(obj).find('.tabContent .tab-pane').eq($(this).index()).addClass('active show');

						})
					});
				}
				$.fn.tab.defaults = {
					trigger_event_type: 'click', //mouseover | click é»˜è®¤æ˜¯click
				};
			}
		}

		Click_menu_hover();

		function Tab_menu_activator() {
			if ($('.tab-demo').length) {
				$('.tab-demo').tab({
					trigger_event_type: 'mouseover'
				});
			}
		}

		Tab_menu_activator();

		function fAqactive() {
			$(".doc_faq_info .card").on('click', function () {
				$(".doc_faq_info .card").removeClass("active");
				$(this).addClass('active');
			});
		}

		fAqactive();

		function general() {

			$('.collapse-btn').on('click', function (e) {
				e.preventDefault();
				$(this).toggleClass('active')
				$(".collapse-wrap").slideToggle(500);

			});


			$('.short-by a').click(function () {
				$(this).toggleClass('active-short').siblings().removeClass('active-short');
			});
		}

		general()
		/*-------------------------------------
        Intersection Observer
        -------------------------------------*/
		if (!!window.IntersectionObserver) {
			let observer = new IntersectionObserver((entries, observer) => {
				entries.forEach(entry => {
					if (entry.isIntersecting) {
						entry.target.classList.add("active-animation");
						//entry.target.src = entry.target.dataset.src;
						observer.unobserve(entry.target);
					}
				});
			}, {
				rootMargin: "0px 0px -100px 0px"
			});
			document.querySelectorAll('.has-animation').forEach(block => {
				observer.observe(block)
			});
		} else {
			document.querySelectorAll('.has-animation').forEach(block => {
				block.classList.remove('has-animation')
			});
		}

		// === Image Magnify
		if ($('.zoom').length) {
			$('.zoom').magnify({
				afterLoad: function () {
					console.log('Magnification powers activated!');
				}
			});
		}

		// === Focus Search Form
		if ($('.focused-form').length) {
			$(document).on('keydown', function (e) {
				if (e.keyCode === 191) {
					e.preventDefault();
					$('.focused-form input[type=search]').focus();
					return;
				}
			});
		}

		$('.focused-form').focusin(function() {
			$('body').addClass('search-focused');
			$('.search-focused .banner_search_form .input-group').css('z-index', '9999')
		})

		$('.focused-form').focusout(function() {
			$('body').removeClass('search-focused');
			$('.input-group').attr('style', '')
		})

		// === YouTube Channel Videos Playlist
		if ($('#ycp').length) {
			$("#ycp").ycp({
				apikey: 'AIzaSyBS5J1A7o-M8X78JuiqF5h103XLmSQiReE',
				playlist: 6,
				autoplay: true,
				related: true
			});
		}

		// === Back to Top Button
		var back_top_btn = $('#back-to-top');

		$(window).scroll(function () {
			if ($(window).scrollTop() > 300) {
				back_top_btn.addClass('show');
			} else {
				back_top_btn.removeClass('show');
			}
		});

		back_top_btn.on('click', function (e) {
			e.preventDefault();
			$('html, body').animate({scrollTop: 0}, '300');
		});
	});

})(jQuery);

/**
 * Registration Form
 */
if ( jQuery('.registerform').length ) {
	jQuery('.registerform').on("submit", function (e) {
		e.preventDefault();
		let ajax_url = docly_local_object.ajaxurl;
		jQuery.post(
			ajax_url,
			{
				data: jQuery(this).serialize(),
				action: 'dt_custom_registration_form'
			},
			function (res) {
				jQuery('#reg-form-validation-messages').html(res.data.message);
			}
		);
		return false;
	})
}