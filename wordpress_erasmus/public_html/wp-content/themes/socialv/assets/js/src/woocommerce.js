/*---------------------------------------------------------------------
        shop Filter sidebar toggle button
 -----------------------------------------------------------------------*/
const sideToggler = (document.querySelector('.shop-filter-sidebar')) ? document.querySelector('.shop-filter-sidebar') : null;
const sideCloseToggler = (document.querySelector('.socialv-filter-close')) ? document.querySelector('.socialv-filter-close') : null;
if (sideToggler !== null) {
    sideToggler.addEventListener('click', () => {
        document.querySelector('body .socialv-woo-sidebar').classList.toggle('woo-sidebar-open');
        document.querySelector('body').classList.toggle('overflow-hidden');
    });
}
if (sideCloseToggler !== null) {
    sideCloseToggler.addEventListener('click', () => {
        document.querySelector('body .socialv-woo-sidebar').classList.remove('woo-sidebar-open');
        document.querySelector('body').classList.remove('overflow-hidden');
    });
}
document.addEventListener("click", function (e) {
    if (document.querySelector(".socialv-woo-sidebar.woo-sidebar-open") != null && e.target.closest(".socialv-woo-sidebar.woo-sidebar-open") == null && document.querySelector(".socialv-woo-sidebar").classList.contains("woo-sidebar-open")) {
        document.querySelector('body .socialv-woo-sidebar').classList.remove('woo-sidebar-open');
        document.querySelector('body').classList.remove('overflow-hidden');
    }
}, true);

(function ($) {
    "use strict";
    $(document).on("woof_ajax_done", woof_ajax_done_handler);

    $(document).ready(function () {

        /*------------------------
        Add to cart with plus minus
        --------------------------*/
        $(document).on('click', 'button.plus, button.minus', function () {
            $('button[name="update_cart"]').removeAttr('disabled');
            var qty = $(this).closest('.quantity').find('.qty');
            if (qty.val() == '') {
                qty.val(0);
            }
            var val = parseFloat(qty.val());
            var max = parseFloat(qty.attr('max'));
            var min = parseFloat(qty.attr('min'));
            var step = parseFloat(qty.attr('step'));

            // Change the value if plus or minus
            if ($(this).is('.plus')) {

                if (max && (max <= val)) {
                    qty.val(max);
                } else {
                    qty.val(val + step);
                }
            } else {
                if (min && (min >= val)) {
                    qty.val(min);
                } else if (val >= 1) {
                    qty.val(val - step);
                }
            }
        });

        /*------------------------
        Wocommerce Change btn Grid View 
        --------------------------*/
        change_view_btn_event();
        /*------------------------
             Wocommerce Product Skeleton Structure   
        --------------------------*/
        if (socialv_loadmore_params.ajaxurl != null) {
            $.ajax({
                url: socialv_loadmore_params.ajaxurl, // AJAX handler
                data: {
                    'action': 'load_skeleton',
                },
                type: 'GET',
                success: function (res) {
                    localStorage.setItem('product_grid_skeleton', res['data']['skeleton-grid']);
                    localStorage.setItem('product_list_skeleton', res['data']['skeleton-list']);
                }
            });
        }
        orig = $.fn.css;
        var ev = new $.Event('stylechanged'),
            orig = $.fn.css;
        $.fn.css = function () {
            var ret = orig.apply(this, arguments);
            $(this).trigger(ev);
            return ret; // must include this
        }

        setTimeout(function () {
            $('.woof_info_popup').on('stylechanged', function () {
                $(this).append('<div class="socialv-show-loader-overlay"></div>');
            });
        }, 500);

    });

})(jQuery);

var can_loaded_product_view = true;

function ajax_product(all_products, skeleton_view) {
    jQuery.ajax({
        url: window.location.href,
        data: {
            loaded_paged: socialv_loadmore_params.current_page
        },
        type: 'POST',
        beforeSend: function (xhr) {
            if (skeleton_view == 'product_grid_skeleton') {
                let col_no = window.IQUtils.getCookie('product_view[col_no]');
                var grid_skeleton_structure = jQuery(localStorage.getItem(skeleton_view)).siblings('.column-' + col_no);

                for (let index = 0; index < col_no; index++) {
                    all_products.append(grid_skeleton_structure.clone());
                }
            } else {
                all_products.append(jQuery(localStorage.getItem(skeleton_view)));
            }
            jQuery('.loader-container').hide(0);
            can_loaded_product_view = false;
        },
        success: function (res) {
            if (res) {
                res = jQuery(res);
                jQuery('.products').replaceWith(res.find('.products'));
                all_products.find('.skeleton-main').remove();
                loadmore_product();
                can_loaded_product_view = true;

            }
        }
    });
}

var isSubdomain = function (url = window.location.hostname) {
    var regex = new RegExp(/^([a-z]+\:\/{2})?([\w-]+\.[\w-]+\.\w+)$/);
    return !!url.match(regex); // make sure it returns boolean
}
function change_view_btn_event() {
    jQuery('.socialv-view-grid,.socialv-listing').on('click', function () {
        let btn = jQuery(this);
        let products = btn.parents('.sorting-wrapper').next('.products');

        if (btn.hasClass('active') || jQuery("#woof_html_buffer").is(':visible') || !can_loaded_product_view) // Condition for Remove Same Button Click Event  And Chech Woof Ajax in on Load
            return;

        window.IQUtils.setCookie('product_view[col_no]', btn.hasClass('socialv-view-grid') ? btn.data('grid') : '1');
        window.IQUtils.setCookie('product_view[is_grid]', btn.hasClass('socialv-view-grid') ? '2' : '1');

        jQuery('.socialv-product-view-buttons .btn').removeClass('active');
        btn.addClass('active');

        if (btn.hasClass('socialv-listing')) { ////Condition for check switch to list to grid
            products.find('.product').fadeOut(0, function () {
                jQuery(this).remove()
            });
            btn.parents('.product-grid-style').removeClass('product-grid-style').addClass('product-list-style')
            ajax_product(products, 'product_list_skeleton'); // Call Ajax Function for  get and Append data
        } else {
            if (btn.parents('.product-grid-style').length != 1) { //Condition for check switch to list to grid
                products.find('.product').fadeOut(0, function () {
                    jQuery(this).remove()
                });
                btn.parents('.product-list-style').removeClass('product-list-style').addClass('product-grid-style')
                ajax_product(products, 'product_grid_skeleton'); // Call Ajax Function for  get and Append data
            }
        }

        setTimeout(function () {
            if (typeof btn.data('grid') != 'undefined') {
                products.removeClass('columns-2 columns-3 columns-4').addClass('columns-' + btn.data('grid'));
            } else {
                products.removeClass(' columns-2 columns-3 columns-4');
            }
            products.addClass('animated-product');

        }, 100);
        products.removeClass('animated-product');
    });
}
function woof_ajax_done_handler(e) {
    change_view_btn_event();
    loadmore_product();

    socialv_loadmore_params.current_page = 1;

    jQuery.ajax({
        url: socialv_loadmore_params.ajaxurl,
        data: {
            'action': 'fetch_woof_filter_ajax_query',
        },
        type: 'POST',
        success: function (res) {
            res = JSON.parse(res);
            if (res) {
                socialv_loadmore_params.posts = res['query'];
                socialv_loadmore_params.max_page = res['max_page'];
            }
        }
    });
}