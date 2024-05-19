<?php
/**
 * Template Name: Sign up Page
 */

get_header('empty');

// Left Column
$left_title = '';
$top_ornament = '';
$bottom_ornament = '';
$featured_image = '';
// Right Column
$right_title = '';
$right_subtitle = '';
$submit_btn_label = '';

if ( function_exists('get_field') ) {
    // Left Column.
    $left_title = get_field('left_title');
    $top_ornament = get_field('top_ornament');
    $bottom_ornament = get_field('bottom_ornament');
    $featured_image = get_field('featured_image');

    // Right Column.
	$right_title = get_field('right_title');
	$right_subtitle = get_field('right_subtitle');
	$submit_btn_label = get_field('submit_button_label');
}
?>

    <section class="signup_area signup_area_height">
        <div class="row ml-0 mr-0">
            <div class="sign_left signup_left">
                <?php echo !empty($left_title) ? "<h2> {$left_title} </h2>" : ''; ?>
                <?php
                if ( !empty($top_ornament['id']) ) {
                    echo wp_get_attachment_image($top_ornament['id'], 'full');
                } else { ?>
                    <img src="<?php echo DOCLY_DIR_IMG ?>/sign-up/top_ornamate.png" class="position-absolute top" alt="<?php esc_attr_e('top ornament', 'docly'); ?>">
                    <?php
                }
                if ( !empty($bottom_ornament['id']) ) {
                    echo wp_get_attachment_image($bottom_ornament['id'], 'full');
                } else { ?>
                    <img src="<?php echo DOCLY_DIR_IMG ?>/sign-up/bottom_ornamate.png" class="position-absolute bottom" alt="<?php esc_attr_e('bottom ornament', 'docly'); ?>">
                    <?php
                }
                if ( !empty($featured_image['id']) ) {
                    echo wp_get_attachment_image($featured_image['id'], 'full');
                } else { ?>
                    <img src="<?php echo DOCLY_DIR_IMG ?>/sign-up/man_image.png" class="position-absolute middle wow fadeInRight" alt="<?php esc_attr_e('man image with lock', 'docly'); ?>">
                    <?php
                }
                ?>
                <div class="round wow zoomIn" data-wow-delay="0.2s"></div>
            </div>
            <div class="sign_right signup_right">
                <div class="sign_inner signup_inner">
                    <div class="text-center">
	                    <?php echo !empty($right_title) ? "<h3> {$right_title} </h3>" : ''; ?>
                        <?php echo !empty($right_subtitle) ? wpautop(wp_kses_post($right_subtitle)) : ''; ?>
                    </div>
                    <div id="reg-form-validation-messages"> </div>
                    <?php dt_reg_form($submit_btn_label) ?>
                </div>
            </div>
        </div>
    </section>

<?php
get_footer('empty');