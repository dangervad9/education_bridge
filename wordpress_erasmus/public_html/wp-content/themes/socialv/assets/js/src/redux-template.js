document.addEventListener('click', (event) => {
	var element = event.target;
	if (element.closest('.redux-dark-mode') !== null) {
		var rootStyle = custom_redux_options_params.root;
		var is_dark_mode = custom_redux_options_params.is_dark_mode;
		if (is_dark_mode) {
			const styleEl = document.createElement('style');
			styleEl.id = "redux-template-inline-css";
			styleEl.append(rootStyle);
			document.head.appendChild(styleEl);
			document.querySelector(".redux-content").classList.add("light-mode");
			custom_redux_options_params.is_dark_mode = 0;
		} else {
			document.getElementById('redux-template-inline-css')?.remove();
			custom_redux_options_params.is_dark_mode = 1;
			document.querySelector(".redux-content").classList.remove("light-mode");
		}

		saveOption(event);
	} else if (element.closest('.searched-tab') !== null) {
		var $this = element;
		var dataRel = $this.dataset.rel;
		document.querySelector(".redux-main").classList.remove("socialv-searched");
		document.querySelector("a[data-rel='" + dataRel + "']:not(.searched-tab)")?.click();
		document.querySelector(".socialv-redux-search").value = "";
		document.querySelector(".result-wrap").remove();
	}

	var domHasSerarchResult = (document.querySelector(".result-wrap") != null)
	if (element.closest(".redux-search") == null) {
		if (domHasSerarchResult)
			document.querySelector(".result-wrap").style.display = "none";
	} else {
		if (domHasSerarchResult)
			document.querySelector(".result-wrap").style.display = "block";
	}
}, true);
var saveOption = _.debounce(function (event) {
	var xhr = new XMLHttpRequest();

	// // Making our connection  
	var url = custom_redux_options_params.ajaxUrl;
	url += "?action=" + custom_redux_options_params.action + "&is_dark_mode=" + custom_redux_options_params.is_dark_mode;
	xhr.open("GET", url, true);

	// function execute after request is successful 
	xhr.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			// console.log(true);
		}
	}
	// Sending our request
	xhr.send();
}, 500);

/* global jQuery, reduxSearch */


(function ($) {
	$(document).ready(
		function () {

			$('.socialv-redux-search').on(
				'keypress',
				function (evt) {
					// Determine where our character code is coming from within the event.
					var charCode = evt.charCode || evt.keyCode;

					if (13 === charCode) { // Enter key's keycode.
						return false;
					}
				}
			).typeWatch({
				callback: function (searchString) {
					var searchArray;
					var parent;
					// var expanded_options;
					$(".result-wrap").remove();

					searchString = searchString.toLowerCase();
					if (searchString.length < 3) return;


					searchArray = searchString.split(' ');
					parent = $(this).parents('.redux-container:first');

					// expanded_options = parent.find('.expand_options');
					if ('' !== searchString) {
						$('.redux-search').append("<div class='result-wrap'></div>");
						parent.find('.redux-main').addClass('socialv-searched');
					} else {
						parent.find('.redux-main').removeClass('socialv-searched');
					}

					const titles = [];
					parent.find('.form-table tr').filter(
						function () {
							var isMatch = true,
								text = $(this).find('.redux_field_th').text().toLowerCase();

							if (!text || '' === text) {
								return false;
							}

							$.each(
								searchArray,
								function (i, searchStr) {
									if (-1 === text.indexOf(searchStr)) {
										isMatch = false;
									}
								}
							);

							if (isMatch) {
								if ($(".redux-main").hasClass("socialv-searched")) {
									var groupTab = $(this).closest(".redux-group-tab");
									var title = groupTab.find("h2:first").html();
									if (!titles.includes(title)) {
										titles.push(title);
										var dataRel = groupTab.data("rel");
										$('.result-wrap').append("<a href='javascript:void(0);' data-key='" + dataRel + "' data-rel='" + dataRel + "' class='searched-tab' >" + title + "</a>");
									}
								} else {
									$(".result-wrap").remove();
								}
							}

							return isMatch;
						}
					);
				},
				wait: 400,
				highlight: false,
				captureLength: 0
			}).show();

		}
	);

})(jQuery);
