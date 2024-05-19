/**
 * Search results
 */
function fetchDelay(callback, ms) {
  var timer = 0;
  return function () {
    var context = this,
      args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, ms || 0);
  };
}

jQuery('#searchInput').keyup(
  fetchDelay(function (e) {
    let keyword = jQuery('#searchInput').val();
    let noresult = jQuery('#docly-search-result').attr('data-noresult');
    if (keyword == '') {
      jQuery('#docly-search-result').removeClass('ajax-search').html('');
    } else {
      jQuery.ajax({
        url: docly_local_object.ajaxurl,
        type: 'post',
        data: { action: 'docly_search_data_fetch', keyword: keyword },
        success: function (data) {
          if (data.length > 0) {
            jQuery('#docly-search-result').addClass('ajax-search').html(data);
          } else {
            var data_error = '<h5>' + noresult + '</h5>';
            jQuery('#docly-search-result')
              .addClass('ajax-search')
              .html(data_error);
          }
        },
      });
    }
  }, 500)
);
