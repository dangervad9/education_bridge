(function ($) {
  "use strict";

  $(window).on("load", function () {
    $(".post-pagination > li:nth-child(1) > a").addClass("current");
    $(".newest_posts").addClass("active-short");
    docly_forum.docly_search(
      "#search_field",
      "#UserList .userlist",
      ".current-user"
    );
    docly_forum.docly_search(
      "#search_fields",
      "#tagList .tagList",
      ".dropdown-item"
    );
    docly_forum.docly_loading_forum();
    docly_forum.docly_open_forum();
    docly_forum.docly_sort_forum();
  });

  var docly_forum = {
    docly_search: function (
      search_field,
      searchable_elements,
      searchable_text_class
    ) {
      $(search_field).keyup(function (e) {
        e.preventDefault();
        var query = $(this).val().toLowerCase();
        if (query) {
          $.each($(searchable_elements), function () {
            var title = $(this)
              .find(searchable_text_class)
              .text()
              .toLowerCase();
            if (title.indexOf(query) == -1) {
              $(this).hide();
            } else {
              $(this).show();
            }
          });
        } else {
          $(searchable_elements).show();
        }
      });
    },
    docly_auth_select: function () {
      $(document).on("click", ".data-auth", function () {
        var _this = $(this),
          text = _this.text();
        $(".UserList").html(text);
      });
    },
    docly_tag_select: function () {
      $(document).on("click", ".data-tag", function () {
        var _this = $(this),
          text = _this.text();
        $(".tagLista").html(text);
      });
    },
    docly_loading_forum: function () {
      $(document).on("click", ".docly-data", function () {
        $(".docly-data").removeClass("loading");
        $(".reset-btn").addClass("reset-btn-active");
        $('.reset-btn').removeClass("reset-none");
        var _this = $(this),
          _ajaxUrl = DoclyForum.ajax_url,
          _class = _this.addClass("loading selected"),
          _a = "docly_loading_post",
          _n = DoclyForum.docly_nonce,
          _t = _this.data("type"),
          _id = _this.data("id"),
          _parent = _this.data("parent"),
          _count = _this.data("count"),
          data = {
            type: _t,
            action: _a,
            nonce: _n,
            a_t_id: _id,
            count: _count,
            parent: _parent,
          };

        if ($(this).hasClass("loading")) {
          $.ajax({
            url: _ajaxUrl,
            method: "post",
            data: data,
            beforeSend: function () {
              $(".load-forum").html(
                "<div class='forum-loading'><div class='configure-border-1'><div class='configure-core'></div></div><div class='configure-border-2'><div class='configure-core'></div></div></div>"
              );
            },
            success: function (response) {
              $(".load-forum").html(response);
            },
            error: function () {
              console.log("Oops! Something wrong, try again!");
            },
          });
        }

        return false;
      });
    },
    docly_open_forum: function () {
      $(document).on("click", ".open-data", function () {
        $(".open-data").removeClass("loading");
        $(this).parent().removeClass("reset-btn-active");
        $('.reset-btn').toggleClass("reset-none");
        $('.sort-by').removeClass('active-short');
        $('.newest_posts').addClass('active-short');
        var _this = $(this),
          _ajaxUrl = DoclyForum.ajax_url,
          _class = _this.addClass("loading selected"),
          _a = "docly_open_post",
          _n = DoclyForum.docly_nonce,
          _t = _this.data("type"),
          _id = _this.data("id"),
          _count = _this.data("count"),
          _parent = _this.data("parent"),
          data = {
            type: _t,
            action: _a,
            nonce: _n,
            a_t_id: _id,
            count: _count,
            parent: _parent,
          };

        if ($(this).hasClass("loading")) {
          $.ajax({
            url: _ajaxUrl,
            method: "post",
            data: data,
            beforeSend: function () {
              $(".load-forum").html(
                "<div class='forum-loading'><div class='configure-border-1'><div class='configure-core'></div></div><div class='configure-border-2'><div class='configure-core'></div></div></div>"
              );
            },
            success: function (response) {
              $(".load-forum").html(response);
            },
            error: function () {
              console.log("Oops! Something wrong, try again!");
            },
          });
        }

        return false;
      });
    },
    docly_sort_forum: function () {
      $(document).on("click", ".sort-by", function () {
        $(".sort-by").removeClass("loading");
        $(".reset-btn").addClass("reset-btn-active");
        $('.reset-btn').removeClass("reset-none");
        var _this = $(this),
          _ajaxUrl = DoclyForum.ajax_url,
          _class = _this.addClass("loading active-short"),
          _parent = _this.data("parent"),
          _a = "docly_loading_sort_post",
          _n = DoclyForum.docly_nonce,
          _sort = _this.data("sort"),
          data = {
            action: _a,
            nonce: _n,
            sort: _sort,
            parent: _parent,
          };
        if ($(this).hasClass("loading")) {
          $.ajax({
            url: _ajaxUrl,
            method: "post",
            data: data,
            beforeSend: function () {
              $(".load-forum").html(
                "<div class='forum-loading'><div class='configure-border-1'><div class='configure-core'></div></div><div class='configure-border-2'><div class='configure-core'></div></div></div>"
              );
            },
            success: function (response) {
              $(".load-forum").html(response);
            },
            error: function () {
              console.log("Oops! Something wrong, try again!");
            },
          });
        }

        return false;
      });
    },
  };

  $('[id]').each(function () {
    $('[id="' + this.id + '"]:gt(0)').remove();
  });

  $('a.prev.page-numbers').html('<i class="arrow_carrot-left"></i>');
  $('a.next.page-numbers').html('<i class="arrow_carrot-right"></i>');

})(jQuery);
