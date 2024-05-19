<?php
$footnotes_title = get_field('footnotes_title');
$column = get_field('footnotes_column');
?>
<div class="footnotes margin-top-xl">
    <?php if ( !empty($footnotes_title) ) : ?>
        <h4> <?php echo wp_kses_post($footnotes_title); ?> </h4>
    <?php endif; ?>
    <?php if ( have_rows('footnotes') ) : ?>
        <ol class="footnotes_column_<?php echo esc_attr($column) ?>">
            <?php while ( have_rows('footnotes') ) : the_row(); ?>
                <li id="note-name-<?php echo get_sub_field('reference_number') ?>" class="footnotes_item">
                    <?php if ( get_sub_field('title') ) : ?>
                        <strong> <a href="#note-link-<?php echo get_sub_field('reference_number') ?>" aria-label="Back to article"> <span class="top-arrow"> &uarr; </span> &nbsp;&nbsp;&nbsp;<?php echo get_sub_field('title') ?> </a></strong>
                    <?php endif; ?>
                    <br><?php echo get_sub_field('reference') ?>
                </li>
            <?php endwhile; ?>
        </ol>
    <?php endif; ?>
</div>

<?php while ( have_rows('footnotes') ) : the_row(); ?>
    <div class="tooltip_templates d-none">
        <div id="note-content-<?php echo get_sub_field('reference_number') ?>" class="tip_content">
            <div class="text footnotes_item">
                <?php if ( get_sub_field('title') ) : ?>
                    <strong> <?php echo get_sub_field('title') ?> </strong>
                <?php endif; ?>
                <br><?php echo get_sub_field('reference') ?>
            </div>
        </div>
    </div>
<?php endwhile; ?>