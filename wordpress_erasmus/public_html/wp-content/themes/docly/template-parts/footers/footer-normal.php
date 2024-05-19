<?php
$opt = get_option('docly_opt' );
$copyright_text = !empty($opt['copyright_txt']) ? $opt['copyright_txt'] : esc_html__( '© 2021 CreativeGigs. All rights reserved', 'docly' );
$right_content = !empty($opt['right_content']) ? $opt['right_content'] : '';
$footer_visibility = function_exists('get_field' ) ? get_field('footer_visibility' ) : '1';
$footer_visibility = isset($footer_visibility) ? $footer_visibility : '1';
?>

<footer class="footer_area f_bg_color <?php echo !is_active_sidebar('footer_widgets') ? 'no_footer_widgets' : ''; ?>">
    <?php
    if ( is_active_sidebar('footer_widgets') ) :
        // Footer Leaf SVG
        if ( !empty($opt['footer_leaf_image']['url']) ) :
            if ( !empty($opt['footer_leaf_image']['id'])) {
                echo wp_get_attachment_image( $opt['footer_leaf_image']['id'], 'full', false, array( 'class' => 'p_absolute leaf' ));
            } else { ?>
                <img class="p_absolute leaf" src="<?php echo esc_url($opt['footer_leaf_image']['url']) ?>" alt="<?php esc_attr_e( 'Footer Leaf Illustration', 'docly' ); ?>">
                <?php
            }
        endif;

        // Footer Right Image
        if ( !empty($opt['footer_right_image']['url']) ) :
            if ( !empty($opt['footer_right_image']['id'])) {
                echo wp_get_attachment_image( $opt['footer_right_image']['id'], 'full', false, array( 'class' => 'p_absolute f_man' ));
            } else { ?>
                <img class="p_absolute f_man" src="<?php echo esc_url($opt['footer_right_image']['url']) ?>" alt="<?php esc_attr_e( 'Footer Man Illustration', 'docly' ); ?>">
                <?php
            }
        endif;

        // Footer Object 01
        if ( !empty($opt['f_cloud']['url']) ) :
            if ( !empty($opt['f_cloud']['id'])) {
                echo wp_get_attachment_image( $opt['f_cloud']['id'], 'full', false, array( 'class' => 'p_absolute f_cloud' ));
            } else { ?>
                <img class="p_absolute f_cloud" src="<?php echo esc_url($opt['f_cloud']['url']) ?>" alt="<?php esc_attr_e('Footer Cloud Object', 'docly'); ?>">
                <?php
            }
        endif;

        // Footer Object 02
        if ( !empty($opt['f_email']['url']) ) :
            if ( !empty($opt['f_email']['id'])) {
                echo wp_get_attachment_image( $opt['f_email']['id'], 'full', false, array( 'class' => 'p_absolute f_email' ));
            } else { ?>
                <img class="p_absolute f_email" src="<?php echo esc_url($opt['f_email']['url']) ?>" alt="<?php esc_attr_e('Footer Email Object', 'docly'); ?>">
                <?php
            }
        endif;

        // Footer Object 03
        if ( !empty($opt['f_email_two']['url']) ) :
            if ( !empty($opt['f_email_two']['id'])) {
                echo wp_get_attachment_image( $opt['f_email_two']['id'], 'full', false, array( 'class' => 'p_absolute f_email_two' ));
            } else { ?>
                <img class="p_absolute f_email_two" src="<?php echo esc_url($opt['f_email_two']['url']) ?>" alt="<?php esc_attr_e('Footer Email Object', 'docly'); ?>">
                <?php
            }
        endif;

        // Footer Bottom Left Image
        if ( !empty($opt['footer_left_image']['url']) ) :
            if ( !empty($opt['footer_left_image']['id']) ) {
                echo wp_get_attachment_image( $opt['footer_left_image']['id'], 'full', false, array( 'class' => 'p_absolute f_man_two' ));
            } else { ?>
                <img class="p_absolute f_man_two" src="<?php echo esc_url($opt['footer_left_image']['url']) ?>" alt="<?php esc_attr_e('Footer Man Object', 'docly'); ?>">
                <?php
            }
        endif;

        $is_preset_footer = isset( $opt['is_footer_columns_preset'] ) ? $opt['is_footer_columns_preset'] : '';
        $is_preset_footer = $is_preset_footer == '1' ? 'preset_footer' : '';
        if ( is_active_sidebar('footer_widgets') ) : ?>
            <div class="footer_top">
                <div class="container">
                    <div class="row <?php echo esc_attr($is_preset_footer) ?>">
                        <?php dynamic_sidebar('footer_widgets') ?>
                    </div>
                    <div class="border_bottom"></div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="footer_bottom text-center">
        <div class="container">
            <?php
            $copyright_text = !empty($opt['copyright_txt']) ? $opt['copyright_txt'] : esc_html__('© 2021 CreativeGigs. All rights reserved', 'docly');
            echo wp_kses_post(wpautop($copyright_text));
            ?>
        </div>
    </div>
</footer>