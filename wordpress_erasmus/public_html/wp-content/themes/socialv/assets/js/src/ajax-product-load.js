(function (jQuery) {
    loadmore_product();
    update_product_count();
})(jQuery);
function loadmore_product() {
    let canBeLoaded = true,
        bottomOffset = 2000; // the distance (in px) from the page bottom when you want to load more posts
    jQuery(window).unbind('scroll').scroll(function () {

        //** search load more *//
        if (jQuery(document).scrollTop() > (jQuery(document).height() - bottomOffset) && canBeLoaded == true) {
            canBeLoaded = false;
            let data = {
                'action': 'loadmore_product',
                'query': socialv_loadmore_params.posts, // that's how we get params from wp_localize_script() function
                'page': socialv_loadmore_params.current_page,
                'is_grid': jQuery('.socialv-product-view-buttons').find('.btn.active').hasClass('socialv-view-grid')
            };

            jQuery.ajax({ // you can also use jQuery.post here
                url: socialv_loadmore_params.ajaxurl, // AJAX handler
                data: data,
                type: 'POST',
                beforeSend: function (xhr) {
                    jQuery(".loader-container .load-more").addClass('loading');
                },
                success: function (data) {
                    if (data) {
                        jQuery('.socialv-product-main-list').find('.products').append(data);
                        socialv_loadmore_params.current_page++;
                        canBeLoaded = true; // the ajax is completed, now we can run it again
                        jQuery('.socialv-product-main-list').attr('data-pagedno', socialv_loadmore_params.current_page);
                        if (socialv_loadmore_params.current_page == socialv_loadmore_params.max_page)
                            jQuery(".loader-container").html('');
                    }
                    else {
                        jQuery(".loader-container").html('');
                    }
                }
            });
        }
    });
}

function update_product_count(result_count_element = jQuery('.woocommerce-result-count'), per_paged = jQuery('.woocommerce-result-count').data('product-per-page')) {
    let text = result_count_element.text();
    let content_text_arr = text.trim().split(' ');
    let count_arr = content_text_arr[1].split('–');

    count_arr[1] = Number(count_arr[1]) + Number(per_paged);
    if (count_arr[1] > content_text_arr[3]) {
        count_arr[1] = content_text_arr[3];
    }
    content_text_arr[1] = count_arr.join('–')
    result_count_element.html(content_text_arr.join(' '));
}
