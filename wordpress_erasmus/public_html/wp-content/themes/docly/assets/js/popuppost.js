(function ($) {
  "use strict";
  $(window).on("load", function () {
    docly_popup_posts.docly_post_tooltip();
  });
  
  var docly_popup_posts = {
    docly_post_tooltip: function () {
        var moveLeft = 10;
        var moveDown = 10;
        $(".tooltips").hover(function(){
        var _this = $(this),
          _ajaxUrl = DoclyPopup.ajax_url,
          _a = "docly_tooltip_post",
          _slug_href = _this.attr("href"),
          data = {
            action: _a,
            slug_id: _slug_href,
          };
         $.ajax({
            url: _ajaxUrl,
            method: "POST",
            data: data,
            success: function (response) {
              $(".tip_content").html(response);
            },
            error: function () {
              console.log("Oops! Something wrong, try again!");
            },
          });
      });
        return false;
    },
    
  };

})(jQuery);
