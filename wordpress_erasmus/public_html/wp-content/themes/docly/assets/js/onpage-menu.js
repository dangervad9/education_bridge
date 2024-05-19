! function($) {
    $(document).ready(function() {

        /**
         * Onepage Search
         */
        // the input field
        var $input = $("#onepage-search"),
            // clear button
            $clearBtn = $(".search_form button[data-search='clear']"),
            // prev button
            $prevBtn = $(".search_form button[data-search='prev']"),
            // next button
            $nextBtn = $(".search_form button[data-search='next']"),
            // the context where to search
            $content = $("#post"),
            // jQuery object to save <mark> elements
            $results,
            // the class that will be appended to the current
            // focused element
            currentClass = "current",
            // top offset for the jump (the search bar)
            offsetTop = 90,
            // the current index of the focused element
            currentIndex = 0;

        /**
         * Jumps to the element matching the currentIndex
         */
        function jumpTo() {
            if ($results.length) {
                var position,
                    $current = $results.eq(currentIndex);
                $results.removeClass(currentClass);
                if ($current.length) {
                    $current.addClass(currentClass);
                    position = $current.offset().top - offsetTop;
                    window.scrollTo(0, position);
                }
            }
        }

        /**
         * Searches for the entered keyword in the
         * specified context on input
         */
        $input.on("input", function() {
            var searchVal = this.value;
            $content.unmark({
                done: function() {
                    $content.mark(searchVal, {
                        separateWordSearch: true,
                        done: function() {
                            $results = $content.find("mark");
                            currentIndex = 0;
                            jumpTo();
                        }
                    });
                }
            });
        });

        /**
         * Clears the search
         */
        $clearBtn.on("click", function() {
            $content.unmark();
            $input.val("").focus();
        });

        /**
         * Next and previous search jump to
         */
        $nextBtn.add($prevBtn).on("click", function() {
            if ($results.length) {
                currentIndex += $(this).is($prevBtn) ? -1 : 1;
                if (currentIndex < 0) {
                    currentIndex = $results.length - 1;
                }
                if (currentIndex > $results.length - 1) {
                    currentIndex = 0;
                }
                jumpTo();
            }
        });

        $(window);
        var t = $(document.body),
            n = $(".doc-container").find(".doc-nav");
        t.scrollspy({
            target: ".doc-sidebar"
        })
        n.find("> li > a").before($('<span class="docs-progress-bar" />'));
        n.offset().top;
        $(window).scroll(function() {
            $(".doc-nav").height();
            var t = $(this).scrollTop(),
                n = $(this).innerHeight(),
                e = $(".doc-nav li a").filter(".active").index();
            $(".doc-section").each(function(i) {
                var c = $(this).offset().top,
                    s = $(this).height(),
                    a = c + s,
                    r = 0;
                t >= c && t <= a ? (r = (t - c) / s * 100) >= 100 && (r = 100) : t > a && (r = 100), a < t + n - 70 && (r = 100);
                var d = $(".doc-nav .docs-progress-bar:eq(" + i + ")");
                e > i && d.parent().addClass("viewed"), d.css("width", r + "%")
            })
        })
    })
}(jQuery)

var originalAddClassMethod = jQuery.fn.addClass;

jQuery.fn.addClass = function(){
    // Execute the original method.
    var result = originalAddClassMethod.apply( this, arguments );

    // trigger a custom event
    jQuery(this).trigger('cssClassChanged');

    // return the original result
    return result;
}

jQuery( window ).on('scroll', function() {
    jQuery(".doc-nav .nav-item .nav-link").each( function() {
        if ( jQuery(this).hasClass('active') ) {
            jQuery(this).parent().addClass('active')
            //jQuery(this).removeClass('active')
        } else {
            jQuery(this).parent().removeClass('active')
        }
    })
    jQuery('.dropdown_nav li.active').parent().closest('li').addClass('active');

    //jQuery('.doc-nav .nav-item .nav-link.active').removeClass('active')
});