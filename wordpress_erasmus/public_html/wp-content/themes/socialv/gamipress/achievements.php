<?php

/**
 * Achievements template
 *
 * This template can be overridden by copying it to yourtheme/gamipress/achievements.php
 * To override a specific achievement type just copy it as yourtheme/gamipress/achievements-{achievement-type}.php
 */
global $gamipress_template_args;

// Shorthand
$a = $gamipress_template_args; 
$limit = $a['limit'];
$total = $a['query']['query_count'];?>
<div class="card-main">
    <div class="card-inner">
        <div class="card-head card-header-border d-flex align-items-center justify-content-between">
            <div class="head-title">
                <h5 class="card-title"><?php echo gamipress_bp_get_option('achievements_tab_title', esc_html__('Achievements', 'socialv'));  ?><?php echo ' (' . esc_html((($a['query']['query_count'] / 10) % 10 != 1) ? ('0' . $a['query']['query_count']) : $a['query']['query_count']) . ')';  ?></h5>
            </div>
        </div>
        <div id="gamipress-achievements-list" class="gamipress-achievements-list">
            <?php
            if ($a['query']['query_count'] == 0) {
                echo '<h6>' . esc_html__('There have no badges', 'socialv') . '</h6>';
            }
            ?>
            <?php
            /**
             * Before render achievements list
             *
             * @since 1.0.0
             *
             * @param array $template_args Template received arguments
             */
            do_action('gamipress_before_render_achievements_list', $a); ?>

            <div id="gamipress-achievements-filters-wrap">

                <?php
                /**
                 * Before render achievements list filters
                 *
                 * @since 1.0.0
                 *
                 * @param array $template_args Template received arguments
                 */
                do_action('gamipress_before_render_achievements_list_filters', $a); ?>

                <?php // Hidden fields for ajax request
                echo gamipress_array_as_hidden_inputs($a, array('filter', 'search', 'query')); ?>

                <?php // Filter
                if ($a['filter'] === 'no') : ?>

                    <input type="hidden" name="achievements_list_filter" id="achievements_list_filter" value="<?php echo esc_attr($a['filter_value']); ?>">

                <?php elseif (is_user_logged_in()) : ?>

                    <div id="gamipress-achievements-filter">

                        <label for="achievements_list_filter"><?php esc_html_e('Filter:', 'socialv'); ?></label>

                        <?php
                        $filter_options = array(
                            'all' => sprintf(__('All %s', 'socialv'), $a['plural_label']),
                            'completed' => sprintf(__('Completed %s', 'socialv'), $a['plural_label']),
                            'not-completed' => sprintf(__('Not Completed %s', 'socialv'), $a['plural_label']),
                        );

                        /**
                         * Achievements list filter options
                         *
                         * @since 1.5.9
                         *
                         * @param array $filter_options Filter options
                         * @param array $template_args  Template received arguments
                         *
                         * @return array
                         */
                        $filter_options = apply_filters('gamipress_achievements_list_filter_options', $filter_options, $a);
                        ?>

                        <select name="achievements_list_filter" id="achievements_list_filter">

                            <?php // Loop all filter options
                            foreach ($filter_options as $value => $label) : ?>
                                <option value="<?php echo esc_attr($value); ?>" <?php selected($a['filter_value'], $value); ?>><?php echo esc_html($label); ?></option>
                            <?php endforeach; ?>

                        </select>

                    </div>

                <?php endif;

                // Search
                if ($a['search'] === 'yes') :
                    $search = isset($_POST['achievements_list_search']) ? sanitize_text_field($_POST['achievements_list_search']) : '';

                    /**
                     * Achievements search button text
                     *
                     * @since 1.4.5
                     *
                     * @param string    $search_button_text The search button text
                     * @param array     $template_args      Template received arguments
                     *
                     * @return string
                     */
                    $search_button_text = apply_filters('gamipress_achievements_search_button_text', esc_html__('Go', 'socialv'), $a); ?>

                    <div id="gamipress-achievements-search">

                        <form id="gamipress-achievements-search-form" action="" method="post">
                            <label for="achievements_list_search"><?php esc_html_e('Search:', 'socialv'); ?></label>
                            <input type="text" id="gamipress-achievements-search-input" name="achievements_list_search" value="<?php echo esc_attr($search); ?>">
                            <input type="submit" id="gamipress-achievements-search-submit" name="achievements_list_search_go" value="<?php echo esc_attr($search_button_text); ?>">
                        </form>

                    </div>

                <?php endif; ?>

                <?php
                /**
                 * After render achievements list filters
                 *
                 * @since 1.0.0
                 *
                 * @param array $template_args Template received arguments
                 */
                do_action('gamipress_after_render_achievements_list_filters', $a); ?>

            </div><!-- #gamipress-achievements-filters-wrap -->

            <?php // Content Container 
            ?>
            <div id="gamipress-achievements-container" class="gamipress-achievements-container gamipress-columns-<?php echo esc_attr($a['columns']); ?>">
                <?php
                echo wp_kses($a['query']['achievements'], 'post');
                ?>
            </div>

            <?php // Hidden fields 
            ?>
            <input type="hidden" id="gamipress-achievements-offset" value="<?php echo esc_attr($a['query']['offset']); ?>">
            <input type="hidden" id="gamipress-achievements-count" value="<?php echo esc_attr($a['query']['achievement_count']); ?>">

            <?php // Load More button 
            ?>
            <?php if ($a['load_more'] === 'yes') :
                $hide_load_more = $a['query']['query_count'] <= $a['query']['offset'];
                if ( $limit < $total ) {
                /**
                 * Achievements load more button text
                 *
                 * @since 1.4.5
                 *
                 * @param string    $load_more_button_text  The load more button text
                 * @param array     $template_args          Template received arguments
                 *
                 * @return string
                 */
                $load_more_button_text = apply_filters('gamipress_achievements_load_more_button_text', esc_html__('Load More', 'socialv'), $a); ?>
                <div class="text-center">
                    <button type="button" id="gamipress-achievements-load-more" class="gamipress-load-more-button socialv-button" ><?php echo wp_kses( $load_more_button_text, 'alltext_allow' ); ?></button>
                </div>
                <div id="gamipress-achievements-spinner" class="gamipress-spinner"></div>
            <?php  }  endif; ?>

            <?php // Loading spinner 
            ?>

            <?php
            /**
             * After render achievements list
             *
             * @since 1.0.0
             *
             * @param array $template_args Template received arguments
             */
            do_action('gamipress_after_render_achievements_list', $a); ?>

        </div>
    </div>
</div>