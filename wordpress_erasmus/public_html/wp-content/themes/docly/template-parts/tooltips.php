<?php
if ( have_rows('tooltips') ) {
    while ( have_rows('tooltips') ) : the_row();
        $featured_image = get_sub_field('featured_image');
        ?>
        <div class="tooltip_templates d-none">
            <div id="tooltip-<?php echo esc_attr(get_sub_field('tooltip_id')) ?>" class="tip_content">
                <?php echo !empty($featured_image) ? wp_get_attachment_image( $featured_image, 'full' ) : ''; ?>
                <div class="text">
                    <?php echo get_sub_field('tooltip_content'); ?>
                </div>
            </div>
        <?php
    endwhile;
}