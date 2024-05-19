/**
 * File custom.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
const bodyClass = document.getElementsByTagName("body");
const headerClass = document.querySelector('header.has-sticky');
const navBarToggler = (document.querySelector('.open-menu-toggle')) ? document.querySelector('.open-menu-toggle') : null;
const hamtoggle = (document.querySelector('.ham-toggle')) ? document.querySelector('.ham-toggle') : null;
const customToggler = (document.querySelector('.close-custom-toggler')) ? document.querySelector('.close-custom-toggler') : null;
const backToTop = document.getElementById("back-to-top");
const sidebarToggleBtn = (document.querySelectorAll('[data-toggle="sidebar"]').length > 0) ? document.querySelectorAll('[data-toggle="sidebar"]') : null;
const sidebar = (document.querySelector('.sidebar-default') != null) ? document.querySelector('.sidebar-default') : null;
const reviewToggler = (document.querySelector('.course-ratings .value')) ? document.querySelector('.course-ratings .value') : null;

const sendcompose = (document.getElementById('send-to-input')) ? document.getElementById('send-to-input') : null;
if (headerClass !== null && headerClass !== undefined) {
	window.addEventListener('scroll', (e) => {
		if (document.documentElement.scrollTop > 0) {
			headerClass.classList.add("header-sticky");
		} else {
			headerClass.classList.remove("header-sticky");
		}
	});
}

/*------------------------
 header height
--------------------------*/

const headerHeightCount = () => {
	const isHeader = (document.querySelector('header')) ? document.querySelector('header') : null;
	if (isHeader != null) {
		let headerHeight = isHeader.getBoundingClientRect().height;
		document.querySelector(':root').style.setProperty('--header-height', headerHeight + 'px');
	}
}
headerHeightCount();

jQuery(window).on('resize', function () {
	headerHeightCount();
});


/*------------------------
 main menu toggle
--------------------------*/

if (navBarToggler !== null) {
	navBarToggler.addEventListener('click', () => {
		if (window.outerWidth < 1200) {
			document.querySelector('body').classList.toggle('overflow-hidden');
		}
		document.querySelector('.socialv-mobile-menu').classList.toggle('menu-open');
	});

}
if (hamtoggle !== null) {
	hamtoggle.addEventListener('click', () => {
		document.querySelector('.ham-toggle .menu-btn').classList.toggle('is-active');
	});
}

if (customToggler !== null) {
	customToggler.addEventListener('click', () => {
		if (window.outerWidth < 1200) {
			document.querySelector('body').classList.remove('overflow-hidden');
		}
		document.querySelector('.socialv-mobile-menu').classList.remove('menu-open');
	});
}
document.addEventListener("click", function (e) {
	if (window.outerWidth < 1200) {
		if (document.querySelector(".socialv-mobile-menu") != null && e.target.closest(".socialv-mobile-menu") == null && document.querySelector(".socialv-mobile-menu").classList.contains("menu-open")) {
			document.querySelector(".socialv-mobile-menu").classList.remove("menu-open");
			document.querySelector('body').classList.remove('overflow-hidden');
		}
		if ((document.querySelectorAll("#sidebar-scrollbar").length > 0) && e.target.closest("#sidebar-scrollbar") == null && !document.querySelector("#sidebar-scrollbar").classList.contains("sidebar-mini")) {
			document.querySelector("#sidebar-scrollbar").classList.add("sidebar-mini");
			document.querySelector('body').classList.remove('overflow-hidden')
		}
	}
}, true);
/*------------------------
  Back To Top
--------------------------*/
if (backToTop !== null && backToTop !== undefined) {
	window.addEventListener('scroll', (e) => {
		if (document.documentElement.scrollTop > 150) {
			backToTop.style.opacity = "1";
		} else {
			backToTop.style.opacity = "0";
		}
	});
	// scroll body to 0px on click
	document.querySelector('#top').addEventListener('click', (e) => {
		e.preventDefault()
		window.scrollTo({
			top: 0,
			behavior: 'smooth'
		});
	});
}

window.addEventListener('resize', function () {
	resizePlugins();
	if (window.outerWidth > 1200) {
		if (bodyClass[0].classList.contains('overflow-hidden')) {
			bodyClass[0].classList.remove('overflow-hidden');
		}
	} else {
		if (navBarToggler !== null && navBarToggler.classList.contains('moblie-menu-active')) {
			bodyClass[0].classList.add('overflow-hidden');
		}
	}
	if (window.innerWidth > 992) {
		if ((document.querySelectorAll("#sidebar-scrollbar").length > 0) && document.querySelector("#sidebar-scrollbar").classList.contains("sidebar-mini")) {
			document.querySelector("#sidebar-scrollbar").classList.remove("sidebar-mini");
			document.querySelector('body').classList.remove('overflow-hidden')
		}
	}
});

/*---------------------------------------------------------------------
			 Sidebar Toggle
 -----------------------------------------------------------------------*/
const sidebarToggle = (elem) => {
	elem.addEventListener('click', (e) => {
		const sidebar = document.querySelector('.sidebar')
		if (sidebar.classList.contains('sidebar-mini')) {
			sidebar.classList.remove('sidebar-mini');
			if (window.screen.width < 992) {
				bodyClass[0].classList.toggle('overflow-hidden');
			}
		} else {
			sidebar.classList.add('sidebar-mini');
			if (window.screen.width < 992) {
				bodyClass[0].classList.remove('overflow-hidden');
			}
		}
	});
}

if (sidebar !== null) {
	const sidebarActiveItem = sidebar.querySelectorAll('.active')
	Array.from(sidebarActiveItem, (elem) => {
		elem.classList.add('active')
		if (!elem.closest('ul').classList.contains('iq-main-menu')) {
			const childMenu = elem.closest('ul')
			const parentMenu = childMenu.closest('li').querySelector('.nav-link')
			parentMenu.classList.add('active')
			new bootstrap.Collapse(childMenu, {
				toggle: true
			});
		}
	})
}

if (sidebarToggleBtn !== null) {
	Array.from(sidebarToggleBtn, (sidebarBtn) => {
		sidebarToggle(sidebarBtn)
	})
}

const resizePlugins = () => {
	// For sidebar-mini & responsive
	const tabs = document.querySelectorAll('.nav')
	const sidebarResponsive = (document.querySelector('[data-sidebar="responsive"]')) ? document.querySelector('[data-sidebar="responsive"]') : null;
	if (document.getElementsByTagName("body")[0].classList.contains('socialv-body-overflow')) {
		document.getElementsByTagName("body")[0].classList.toggle('socialv-body-overflow')
	}
	if (window.innerWidth < 992) {
		Array.from(tabs, (elem) => {
			if (!elem.classList.contains('flex-column') && elem.classList.contains('nav-tabs') && elem.classList.contains('nav-pills')) {
				elem.classList.add('flex-column', 'on-resize');
			}
		})
		if (sidebarResponsive !== null) {
			if (!sidebarResponsive.classList.contains('sidebar-mini')) {
				sidebarResponsive.classList.add('sidebar-mini', 'on-resize')
			}
		}
	} else {
		if (window.innerWidth < 1200 && sidebarResponsive) {
			sidebarResponsive.classList.add('sidebar-mini');
		}
		Array.from(tabs, (elem) => {
			if (elem.classList.contains('on-resize')) {
				elem.classList.remove('flex-column', 'on-resize');
			}
		})
		if (sidebarResponsive !== null) {
			if (sidebarResponsive.classList.contains('sidebar-mini') && sidebarResponsive.classList.contains('on-resize')) {
				sidebarResponsive.classList.add('sidebar-mini', 'on-resize');

			}
		}
	}
}

resizePlugins();

window.onload = function () {
	if (window.innerWidth < 992) {
		if ((document.querySelectorAll("#sidebar-scrollbar").length > 0) && !document.querySelector("#sidebar-scrollbar").classList.contains("sidebar-mini")) {
			document.querySelector("#sidebar-scrollbar").classList.add("sidebar-mini");
			document.querySelector('body').classList.remove('overflow-hidden')
		}
	}
}

/*---------------------------------------------------------------------
		 Tooltip
 -----------------------------------------------------------------------*/
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	return new bootstrap.Tooltip(tooltipTriggerEl)
})
/*---------------------------------------------------------------------
		 smooth scroll
 -----------------------------------------------------------------------*/
let Scrollbar;
if (typeof Scrollbar !== typeof null) {
	if (document.querySelectorAll(".data-scrollbar").length) {
		Scrollbar = window.Scrollbar;
		Scrollbar.init(document.querySelector('.data-scrollbar'), {
			continuousScrolling: false,
		});
	}
}


/*---------------------------------------------------------------------
	 Group Btn Swicher
 -----------------------------------------------------------------------*/
function switchbtnClicked() {
	document.querySelectorAll('.list-grid-btn-switcher li').forEach(button => {
		button.classList.remove('active');
	});
	this.classList.add('active');
	var data = this.querySelector(".user-view-trigger").getAttribute("data-type");
	var target = document.querySelector('.group-list');
	if (data === "grid") {
		target.classList.remove("list-view");
		target.classList.add("grid-view")
	} else if (data === "list") {
		target.classList.remove("grid-view");
		target.classList.add("list-view");
	}
}

document.querySelectorAll('.list-grid-btn-switcher li').forEach(button => {
	button.onclick = switchbtnClicked;
});

/*---------------------------------------------------------------------
	 Compose Message 
 -----------------------------------------------------------------------*/
if (sendcompose != null) {
	sendcompose.focus();
}

/*-------------------------------------
Slide scroll clickble Tab
-------------------------------------*/
var slider;
if (typeof slider !== typeof null) {
	if (document.querySelectorAll(".custom-nav-slider").length) {
		const slider = document.querySelectorAll('.custom-nav-slider');

		function slide(direction, e) {
			var container = e.target.closest("div").parentElement.getElementsByClassName("custom-nav-slider");
			var parent = e.target.closest("div").parentElement;
			container.innerHTML = slidescroll(container, direction, parent);
		}

		function navslide(direction, e) {
			var container = document.getElementsByClassName('socialv-horizontal-container');
			var is_vertical = container[0].closest("#sidebar-scrollbar") != null && container[0].closest("#sidebar-scrollbar").classList.contains("sidebar-mini")
			var parent = e.target.closest(".socialv-horizontal-main-box");
			container.innerHTML = slidescroll(container, direction, parent, is_vertical);
		}

		function slidescroll(container, direction, parent, is_vertical = false) {
			var scrollCompleted = 0,
				rightArrow = (parent != null) ? parent.getElementsByClassName("right")[0] : null,
				leftArrow = (parent != null) ? parent.getElementsByClassName("left")[0] : null,
				maxScroll = (parent != null) ? container[0].scrollWidth - container[0].offsetWidth - 30 : null,
				slideVar = setInterval(function () {

					if (direction == 'left') {
						if (is_vertical) {
							container[0].scrollTop -= 5;
						} else {
							container[0].scrollLeft -= 20;
						}
						if (parent != null) {
							rightArrow.style.display = "block";
							if (container[0].scrollLeft == 0)
								leftArrow.style.display = "none";
						}
					} else {
						if (is_vertical) {
							container[0].scrollTop += 5;
						} else {
							container[0].scrollLeft += 20;
						}
						if (parent != null) {
							leftArrow.style.display = "block";
							if (container[0].scrollLeft > maxScroll)
								rightArrow.style.display = "none";
						}
					}
					scrollCompleted += 10;
					if (scrollCompleted >= 100) {
						window.clearInterval(slideVar);
					}

				}, 40);
		}

		if (slider) {
			slider.forEach(function (element) {
				slideDrag(element);
			});
			enableSliderNav();
		}

		function enableSliderNav() {
			slider.forEach(function (element) {
				if (element.parentElement.querySelector(".left")) {
					var left = element.parentElement.querySelector(".left"),
						right = element.parentElement.querySelector(".right");
					if (element.scrollWidth - element.clientWidth > 0) {
						right.style.display = "block";
						left.style.display = "block";
					} else {
						right.style.display = "none";
						left.style.display = "none";
					}
				}
			});
		}

		function slideDrag(eslider) {
			var isDown = false;
			var startX;
			var scrollLeft;
			var maxScroll = eslider.scrollWidth - eslider.clientWidth - 20;
			var rightArrow = eslider.parentElement.getElementsByClassName("right")[0];
			var leftArrow = eslider.parentElement.getElementsByClassName("left")[0];
			eslider.addEventListener('mousedown', (e) => {
				isDown = true;
				eslider.classList.add('active');
				startX = e.pageX - eslider.offsetLeft;
				scrollLeft = eslider.scrollLeft;
			});

			eslider.addEventListener('mouseleave', () => {
				isDown = false;
				eslider.classList.remove('active');
			});

			eslider.addEventListener('mouseup', () => {
				isDown = false;
				eslider.classList.remove('active');
			});

			eslider.addEventListener('mousemove', (e) => {
				if (!isDown) return;
				e.preventDefault();
				const x = e.pageX - eslider.offsetLeft;
				const walk = (x - startX) * 3; //scroll-fast
				eslider.scrollLeft = scrollLeft - walk;
				if (eslider.scrollLeft > maxScroll) {
					rightArrow.style.display = "none";
				} else {
					if (eslider.scrollLeft == 0) {
						leftArrow.style.display = "none";
					} else {
						leftArrow.style.display = "block";
					}
					rightArrow.style.display = "block";
				}

			});
		}

		window.addEventListener('resize', function () {
			enableSliderNav();
		});
	}
}

/*-------------------------------------
BuddyPress
-------------------------------------*/
document.body.className = document.body.className.replace('no-js', 'js');

/*-------------------------------------
LearnPress Review Tab
-------------------------------------*/
if (reviewToggler !== null) {
	reviewToggler.addEventListener('click', () => {
		var triggerEl = document.querySelector('.course-nav-tab-reviews .nav-link');
		var reviewTab = new bootstrap.Tab(triggerEl);
		reviewTab.show();
	});
}

/*-------------------------------------
Better Messages Group Chat
-------------------------------------*/
function ChatThreadLoad() {
	if (document.querySelectorAll('.threads-list').length) {
		const ChatThreadList = Array.from(document.querySelectorAll(".threads-list .pic > img"));
		for (let i = 0; i < ChatThreadList.length; i++) {
			ChatThreadList[i].parentElement.classList.add("group-thread");
		}
	}
}
setTimeout(ChatThreadLoad, 3000);

(function ($) {
	"use strict";

	$(window).on('load', function (e) {
		/*------------------------
		Page Loader
		--------------------------*/
		$("#load").fadeOut();
		$("#loading").delay(0).fadeOut("slow");
		/*---------------------------
		Vertical Menu
		---------------------------*/
		if (jQuery('.menu-style-one.socialv-mobile-menu').length > 0) {
			jQuery('.menu-style-one nav.mobile-menu .sub-menu').css('display', 'none ');
			jQuery('.menu-style-one nav.mobile-menu .top-menu li .dropdown').hide();
			jQuery('.menu-style-one nav.mobile-menu .sub-menu').prev().prev().addClass('submenu');
			jQuery('.menu-style-one nav.mobile-menu .sub-menu').before('<span class="toggledrop"><i class="iconly-Arrow-Down-2 icli"></i></span>');

			jQuery('nav.mobile-menu .widget i,nav.mobile-menu .top-menu i').on('click', function () {
				jQuery(this).next('.children, .sub-menu').slideToggle();
			});
			jQuery('.menu-style-one nav.mobile-menu .top-menu .menu-item .toggledrop').off('click');
			jQuery('.menu-style-one nav.mobile-menu .menu-item .toggledrop').on('click', function () {
				if (jQuery(this).closest(".menu-is--open").length == 0) {
					jQuery('.menu-style-one nav.mobile-menu .menu-item').removeClass('menu-is--open');
				}
				if (jQuery(this).parent().find("ul").length > 1) {
					jQuery(this).parent().addClass('menu-is--open');
				}
				jQuery('.menu-style-one nav.mobile-menu .menu-item:not(.menu-is--open) .children,.menu-style-one nav.mobile-menu .menu-item:not(.menu-is--open) .sub-menu').slideUp();
				if (!jQuery(this).next('.children, .sub-menu').is(':visible') || jQuery(this).parent().hasClass("menu-is--open")) {
					jQuery(this).next('.children, .sub-menu').slideToggle();
				}
				jQuery('.menu-style-one nav.mobile-menu .menu-item:not(.menu-is--open) .toggledrop').not(jQuery(this)).removeClass('active');

				jQuery(this).toggleClass('active');

				jQuery('.menu-style-one nav.mobile-menu .menu-item').removeClass('menu-clicked');
				jQuery(this).parent().addClass('menu-clicked');

				jQuery('.menu-style-one nav.mobile-menu .menu-item').removeClass('current-menu-ancestor');
			});
		}

	});

	$(document).ready(function () {

		/*------------------------
				 superfish menu
		 --------------------------*/
		jQuery('ul.sf-menu').superfish({
			delay: 100,
			onBeforeShow: function (ul) {
				var elem = jQuery(this);
				var elem_offset = 0,
					elem_width = 0,
					ul_width = 0;

				if (elem.length == 1) {
					var page_width = jQuery('#page.site').width(),
						elem_offset = elem.parents('li').eq(0).offset().left,
						elem_width = elem.parents('li').eq(0).outerWidth(),
						ul_width = elem.outerWidth();
					if (elem_offset + elem_width + ul_width > page_width - 20 && elem_offset - ul_width > 0) {
						elem.addClass('open-submenu-main');
						elem.css({
							'left': 'auto',
							'right': '0'
						});
					} else {
						elem.removeClass('open-submenu-main');
						elem.css({});
					}
				}
				if (elem.parents("ul").length > 1) {
					var page_width = jQuery('#page.site').width();
					elem_offset = elem.parents("ul").eq(0).offset().left;
					elem_width = elem.parents("ul").eq(0).outerWidth();
					ul_width = elem.outerWidth();

					if (elem_offset + elem_width + ul_width > page_width - 20 && elem_offset - ul_width > 0) {
						elem.addClass('open-submenu-left');
						elem.css({
							'left': 'auto',
							'right': '100%'
						});
					} else {
						elem.removeClass('open-submenu-left');
					}
				}
			},
		});
		/*------------------------
				 Contact Form
		 --------------------------*/
		$('.form-floating .wpcf7-form-control').each(function () {
			var lable = $(this).parent().siblings().get(0);
			var currentParent = $(this).parent();
			$(lable).appendTo(currentParent);
		});
		/*-----------------------------------------------------------------------
								 Select2 
		 -------------------------------------------------------------------------*/
		if ($('select').length > 0) {
			$('select').each(function () {
				$(this).select2({
					width: '100%',
					minimumResultsForSearch: -1,
				});
			});
			$('.select2-container').addClass('wide');
		}

		/*-------------------------------------
		Gallery Popup
		-------------------------------------*/
		ScrollGallery();

		/*-------------------------------------
			  LearnPress Rating Tab
		-------------------------------------*/
		if ($('.course-ratings .value').length > 0) {
			$(document).on('click', '.course-ratings .value',
				function () {
					var review_tab = $('.course-tabs .course-nav-tab-reviews')
					if (review_tab.length > 0) {
						review_tab.trigger('click')
						$('body, html').animate({
							scrollTop: review_tab.offset().top - 50,
						}, 800)
					}
				});
		}


	});
}(jQuery));

function ScrollGallery() {
	if (jQuery(".zoom-gallery").length) {
		jQuery(".zoom-gallery").each(function () {
			jQuery(this).magnificPopup({
				delegate: "a.popup-zoom",
				type: "image",
				gallery: {
					enabled: true,
				},
			});
		});
	}
}


/*-------------------------------------
	  More Menu Tab
-------------------------------------*/
document.addEventListener('DOMContentLoaded', function () {
	MoreMenu();
});

function MoreMenu() {
	var deafultHeaders = document.querySelectorAll('nav.deafult-header');
	if (deafultHeaders.length > 0) {
		deafultHeaders.forEach(function (header) {
			var max_elem = header.getAttribute('data-menu');
			var max_text = header.getAttribute('data-text');
			var items = header.querySelectorAll('.menu-all-pages-container ul.sf-menu > li');
			var surplus = Array.prototype.slice.call(items, max_elem, items.length);

			if (surplus.length > 0) {
				var moreMenu = document.createElement('li');
				moreMenu.classList.add('category', 'more_menu');
				moreMenu.id = 'more_menu';
				var moreSubMenu = document.createElement('ul');
				moreSubMenu.classList.add('top-menu', 'more_sub_menu', 'sub-menu');
				surplus.forEach(function (item) {
					moreSubMenu.appendChild(item);
				});
				moreMenu.appendChild(moreSubMenu);
				var moreLink = document.createElement('a');
				moreLink.href = '#';
				moreLink.classList.add('sf-with-ul');
				moreLink.setAttribute('data-depth', '0');
				moreLink.innerHTML = '<span class="menu-title">' + max_text + '</span>';
				moreMenu.insertBefore(moreLink, moreSubMenu);

				var sfMenu = header.querySelector('.menu-all-pages-container ul.sf-menu');
				if (sfMenu) {
					sfMenu.appendChild(moreMenu);
				}

				moreMenu.addEventListener('mouseover', function () {
					moreSubMenu.style.display = 'block';
				});

				moreMenu.addEventListener('mouseout', function () {
					moreSubMenu.style.display = 'none';
				});
			}
		});
	}
}

