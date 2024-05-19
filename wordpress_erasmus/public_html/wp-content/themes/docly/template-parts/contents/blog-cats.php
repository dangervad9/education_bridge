<?php
/**
 * Category colors
 */
$post_cats = get_terms( array(
    'taxonomy' => 'category',
    'hide_empty' => true,
));

global $wp;
$current_url = home_url(add_query_arg(array(), $wp->request));
$is_all_active = empty( $_GET['category'] ) ? 'active' : '';
$tab_url = !empty($_GET['blog_layout']) ? '' : 'category';
?>
<div class="blog_grid_inner bg_color" id="post-cats">
    <div class="container">
        <ul class="nav blog_tab">
            <li class="nav-item">
                <a class="nav-link <?php echo esc_attr($is_all_active) ?>" href="<?php echo esc_url($current_url) ?>">
                    <?php esc_html_e('All', 'docly') ?>
                </a>
            </li>
            <?php
            foreach ( $post_cats as $item ) {
                $active = (!empty($_GET['category']) && $item->slug == $_GET['category']) ? 'active' : '';
                $cat_color = function_exists('get_field') ? get_field('cat_normal_color', $item->taxonomy . '_' . $item->term_id) : '';
                $cat_color = !empty($cat_color) ? "style='color: $cat_color;'" : '';

                $hover_colors = function_exists('get_field') ? get_field('hover', $item->taxonomy . '_' . $item->term_id) : '';

                if ( !empty($hover_colors['text_color']) || !empty($hover_colors['background_color']) || !empty($hover_colors['border_top_color']) ) {
                    ?>
                    <style>
                        .blog_tab .nav-item .nav-link.<?php echo wp_kses_post($item->slug); ?>:hover {
                            <?php
                            echo !empty($hover_colors['text_color']) ? "color: {$hover_colors['text_color']} !important;" : '';
                            echo !empty($hover_colors['background_color']) ? "background: {$hover_colors['background_color']};" : '';
                            ?>
                        }
                        .blog_tab .nav-item .nav-link.<?php echo wp_kses_post($item->slug); ?>:before {
                            <?php
                            echo !empty($hover_colors['border_top_color']) ? "background: {$hover_colors['border_top_color']};" : '';
                            ?>
                        }
                    </style>
                    <?php
                }

                if ( !empty($hover_colors['text_color']) || !empty($hover_colors['background_color']) || !empty($hover_colors['border_top_color']) ) {
                    if ( !empty($_GET['category']) && $item->slug == $_GET['category'] ) {
                        ?>
                        <style>
                            .blog_tab .nav-item .nav-link.active:hover {
                                <?php
                                echo !empty($hover_colors['text_color']) ? "color: {$hover_colors['text_color']};" : '';
                                echo !empty($hover_colors['background_color']) ? "background: {$hover_colors['background_color']};" : '';
                                ?>
                            }
                            .blog_tab .nav-item .nav-link.active:before {
                                <?php
                                echo !empty($hover_colors['border_top_color']) ? "background: {$hover_colors['border_top_color']};" : '';
                                ?>
                            }
                        </style>
                        <?php
                    }
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo esc_attr( $active.' '.$item->slug ) ?>" href="?category=<?php echo esc_attr($item->slug); ?>#post-cats" <?php echo wp_kses_post($cat_color) ?>>
                    <?php echo esc_html($item->name); ?>
                    </a>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</div>