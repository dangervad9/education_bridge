<?php

/**
 * Template part for displaying the header search
 *
 * @package socialv
 */

namespace SocialV\Utility;

$socialv_options = get_option('socialv-options');
?>
<form id="header-search-form" method="get" class="search-form search__form" action="<?php echo esc_url(home_url('/')); ?>"  onsubmit="return false;">
    <div class="form-search">
        <input type="search" name='s' value="<?php get_search_query() ?>" class="search-input ajax_search_input" placeholder="<?php echo esc_attr(!empty($socialv_options['header_search_text']) ? $socialv_options['header_search_text'] : ''); ?>">
        <button type="button" class="search-submit ajax_search_input">
            <i class="iconly-Search icli" aria-hidden="true"></i>
        </button>
    </div>
</form>
<div class="socialv-search-result search-result-dislogbox">
    <div class="socialv-search-member">
        <h6 class="search-label"><?php esc_html_e('Members', 'socialv') ?></h6>
        <ul class="socialv-search-member-content socialv-member-list list-inline">
            <li><span></span></li>
            <li><span class="socialv-loader"></span></li>
        </ul>
    </div>

    <div class="socialv-search-group">
        <h6 class="search-label"><?php esc_html_e('Groups', 'socialv') ?></h6>
        <ul class="socialv-search-group-content socialv-member-list list-inline">
            <li><span></span></li>
            <li><span class="socialv-loader"></span></li>
        </ul>
    </div>

    <div class="socialv-search-post">
        <h6 class="search-label"><?php esc_html_e('Posts', 'socialv') ?></h6>
        <ul class="socialv-search-post-content socialv-member-list list-inline">
            <li><span></span></li>
            <li><span class="socialv-loader"></span></li>
        </ul>
    </div>
    <?php if (class_exists('WooCommerce')) : ?>
        <div class="socialv-search-product">
            <h6 class="search-label"><?php esc_html_e('Products', 'socialv') ?></h6>
            <ul class="socialv-search-product-content socialv-member-list list-inline">
                <li><span></span></li>
                <li><span class="socialv-loader"></span></li>
            </ul>
        </div>
    <?php endif; ?>
    <?php if (class_exists('LearnPress')) : ?>
        <div class="socialv-search-course">
            <h6 class="search-label"><?php esc_html_e('Courses', 'socialv') ?></h6>
            <ul class="socialv-search-course-content socialv-member-list list-inline">
                <li><span></span></li>
                <li><span class="socialv-loader"></span></li>
            </ul>
        </div>
    <?php endif; ?>
</div>