/**
 * File ajax-custom.js.
 */

// Ajax Search
if (typeof iqSearchInputs == "undefined") {
	let iqSearchInputs = document.getElementsByClassName('ajax_search_input');
	for (let ind = 0; ind < iqSearchInputs.length; ind++) {
		let element = iqSearchInputs[ind];

		element.addEventListener('keyup', function (event) {
			getAjaxSearch(event);
		});

	}
}
var getAjaxSearch = _.debounce(function (event) {
	let _this = event.target;
	var search = _this.value;
	if (search.length > 3) {
		_this.closest('.header-search').querySelector('.socialv-search-result').classList.remove("search-result-dislogbox");

		var formData = new FormData();

		//Members Datu
		formData.append("action", "ajax_search_member");
		formData.append("keyword", search);
		let request = new XMLHttpRequest();
		request.open('POST', socialv_loadmore_params.ajaxurl, true);
		request.onload = function () {
			if (this.status >= 200 && this.status < 400) {
				// Success!
				var resp = JSON.parse(this.response)['data'];
				_this.closest('.header-search').querySelector('.socialv-search-member-content').innerHTML = resp;
			} else {
				_this.closest('.header-search').querySelector('.socialv-search-member-content').innerHTML = "";
			}
		};

		request.onerror = function () {
			_this.closest('.header-search').querySelector('.socialv-search-member-content').innerHTML = "";

		};

		request.onprogress = function () {
			var resp = '<li><span class="socialv-loader"></span></li>';
			_this.closest('.header-search').querySelector('.socialv-search-member-content').innerHTML = resp;
		};

		request.send(formData);


		//Groups Data	 
		formData.append("action", "ajax_search_group");
		formData.append("keyword", search);
		let request_grp = new XMLHttpRequest();
		request_grp.open('POST', socialv_loadmore_params.ajaxurl, true);
		request_grp.onload = function () {
			if (this.status >= 200 && this.status < 400) {
				// Success!
				var resp = JSON.parse(this.response)['data'];
				_this.closest('.header-search').querySelector('.socialv-search-group-content').innerHTML = resp;
			} else {
				_this.closest('.header-search').querySelector('.socialv-search-group-content').innerHTML = "";
			}
		};

		request_grp.onprogress = function () {
			var resp = '<li><span class="socialv-loader"></span></li>';
			_this.closest('.header-search').querySelector('.socialv-search-group-content').innerHTML = resp;
		};

		request_grp.onerror = function () {
			_this.closest('.header-search').querySelector('.socialv-search-group-content').innerHTML = "";
		};

		request_grp.send(formData);


		// Posts Data	
		formData.append("action", "ajax_search_post");
		formData.append("keyword", search);
		let request_post = new XMLHttpRequest();
		request_post.open('POST', socialv_loadmore_params.ajaxurl, true);
		request_post.onload = function () {
			if (this.status >= 200 && this.status < 400) {
				// Success!
				var resp = JSON.parse(this.response)['data'];
				_this.closest('.header-search').querySelector('.socialv-search-post-content').innerHTML = resp;
			} else {
				_this.closest('.header-search').querySelector('.socialv-search-post-content').innerHTML = "";
			}
		};

		request_post.onprogress = function () {
			var resp = '<li><span class="socialv-loader"></span></li>';
			_this.closest('.header-search').querySelector('.socialv-search-post-content').innerHTML = resp;
		};

		request_post.onerror = function () {
			_this.closest('.header-search').querySelector('.socialv-search-post-content').innerHTML = "";
		};

		request_post.send(formData);



		// Woocomerce Data	
		formData.append("action", "ajax_search_product");
		formData.append("keyword", search);
		let request_product = new XMLHttpRequest();
		request_product.open('POST', socialv_loadmore_params.ajaxurl, true);
		request_product.onload = function () {
			if (this.status >= 200 && this.status < 400) {
				// Success!
				var resp = JSON.parse(this.response)['data'];
				_this.closest('.header-search').querySelector('.socialv-search-product-content').innerHTML = resp;
			} else {
				_this.closest('.header-search').querySelector('.socialv-search-product-content').innerHTML = "";
			}
		};

		request_product.onprogress = function () {
			var resp = '<li><span class="socialv-loader"></span></li>';
			_this.closest('.header-search').querySelector('.socialv-search-product-content').innerHTML = resp;
		};

		request_product.onerror = function () {
			_this.closest('.header-search').querySelector('.socialv-search-product-content').innerHTML = "";
		};

		request_product.send(formData);


		// LearnPress Data	
		formData.append("action", "ajax_search_course");
		formData.append("keyword", search);
		let request_course = new XMLHttpRequest();
		request_course.open('POST', socialv_loadmore_params.ajaxurl, true);
		request_course.onload = function () {
			if (this.status >= 200 && this.status < 400) {
				// Success!
				var resp = JSON.parse(this.response)['data'];
				_this.closest('.header-search').querySelector('.socialv-search-course-content').innerHTML = resp;
			} else {
				_this.closest('.header-search').querySelector('.socialv-search-course-content').innerHTML = "";
			}
		};

		request_course.onprogress = function () {
			var resp = '<li><span class="socialv-loader"></span></li>';
			_this.closest('.header-search').querySelector('.socialv-search-course-content').innerHTML = resp;
		};

		request_course.onerror = function () {
			_this.closest('.header-search').querySelector('.socialv-search-course-content').innerHTML = "";
		};

		request_course.send(formData);


	} else {
		_this.closest('.header-search').querySelector('.socialv-search-result').classList.add("search-result-dislogbox");
	}
}, 500);

document.addEventListener('DOMContentLoaded', function () {
	const searchResult = document.querySelector('.socialv-search-result');

	// Remove search results when the user clicks outside the container
	document.addEventListener('click', function (event) {
		const target = event.target;
		if (!searchResult.contains(target)) {
			searchResult.classList.add('search-result-dislogbox');
		}
	});
});


// accept/reject friend request
document.addEventListener("DOMContentLoaded", function () {
	var friendshipButtons = document.querySelectorAll(".socialv-friendship-btn");
	friendshipButtons.forEach(function (button) {
		button.addEventListener("click", function (e) {
			e.preventDefault();
			e.stopPropagation();
			var $this = this,
				friendshipId = $this.getAttribute("data-friendship-id"),
				dataAction = $this.classList.contains("accept") ? "friends_accept_friendship" : "friends_reject_friendship";
			var xhr = new XMLHttpRequest();
			xhr.open("POST", ajaxurl);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function () {
				if (xhr.readyState === XMLHttpRequest.DONE) {
					if (xhr.status === 200) {
						var data = JSON.parse(xhr.responseText);
						var response = data.data.feedback;
						$this.closest(".socialv-friend-request").querySelector(".response").innerHTML = response;
						if (data.success)
							$this.closest(".request-button").remove();
						updateConfirmCount(); // Update the confirm count
					} else {
						console.error("An error occurred during the AJAX request.");
					}
				}
			};
			xhr.send("action=socialv_ajax_addremove_friend&friendship_id=" + friendshipId + "&data_action=" + dataAction);
			return false;
		});
	});
	// Function to update the confirm count
	function updateConfirmCount() {
		var countElement = document.getElementById("notify-count");
		if (countElement) {
			var currentCount = parseInt(countElement.textContent);
			if (currentCount > 1) {
				countElement.textContent = currentCount - 1;
			} else {
				countElement.textContent = "";
				countElement.classList.remove("notify-count");
			}
		}
	}
});

// Toggle Remove On Click
document.addEventListener("click", function (e) {
	var btnDropdown = e.target.closest(".btn-dropdown");
	if (btnDropdown) {
		var sharingOptions = document.querySelectorAll('.sharing-options');
		sharingOptions.forEach(function (option) {
			option.classList.remove('open');
		});
	}

	var dropdownToggle = e.target.closest(".socialv-header-right .dropdown-toggle");
	if (dropdownToggle) {
		var searchResult = document.querySelector('.socialv-search-result');
		searchResult.classList.add('search-result-dislogbox');
	}
});

// Share activity Post  
document.addEventListener('DOMContentLoaded', function () {
	var shareBtns = document.querySelectorAll('.socialv-share-post .share-btn');
	// Share button click event
	shareBtns.forEach(function (shareBtn) {
		shareBtn.addEventListener('click', function (e) {
			e.preventDefault();
			var option = this.parentElement.querySelector('.sharing-options');

			if (option) { // Check if option element exists
				if (option.classList.contains('open')) {
					document.querySelectorAll('.sharing-options').forEach(function (elem) {
						elem.classList.remove('open');
					});
				} else {
					document.querySelectorAll('.sharing-options').forEach(function (elem) {
						elem.classList.remove('open');
					});
					option.classList.add('open');
				}
			}
		});
	});

});

document.addEventListener('click', function (e) {
	if (e.target.matches('a.share_activity-share')) {
		var loading_icon = '<i class="icon-loader-circle"></i>';
		var share_icon = '<i class="icon-share"></i>';
		var ok_icon = '<i class="icon-circle-check"></i>';
		e.preventDefault();
		var target = e.target;
		var activity_id = target.getAttribute('href');

		var xhr = new XMLHttpRequest();
		xhr.open('POST', ajaxurl);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function () {
			if (xhr.status === 200) {
				var response = xhr.responseText;
				if (response) {
					target.closest('.socialv-share-post').querySelector('.share-btn .share_icon').innerHTML = ok_icon;
				}
				setTimeout(function () {
					target.closest('.socialv-share-post').querySelector('.share-btn .share_icon').innerHTML = share_icon;
				}, 3000);
			}
		};

		xhr.send('action=socialv_post_share_activity&activity_id=' + encodeURIComponent(activity_id));

		target.closest('.sharing-options').classList.remove('open');
		target.closest('.socialv-share-post').querySelector('.share-btn .share_icon').innerHTML = loading_icon;
	}
});