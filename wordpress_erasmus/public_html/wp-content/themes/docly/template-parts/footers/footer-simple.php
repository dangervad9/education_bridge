<?php
$opt = get_option('docly_opt' );
?>
<footer class="simple_footer">
    <?php if ( !empty($opt['fs_illustration']['url']) ) : ?>
        <img class="leaf_right" src="<?php echo esc_url($opt['fs_illustration']['url']) ?>" alt="<?php esc_attr_e('Leaf Illustration', 'docly'); ?>">
    <?php endif; ?>
    <div class="container custom_container">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <?php
                $copyright_text = !empty($opt['copyright_txt']) ? $opt['copyright_txt'] : esc_html__('© 2021 CreativeGigs. All rights reserved', 'docly');
                echo wp_kses_post(wpautop($copyright_text));
                ?>
            </div>
            <div class="col-sm-6 text-right">
                <ul class="list-unstyled f_social_icon">
                    <?php Docly_helper()->social_links() ?>
                </ul>
            </div>
        </div>
    </div>
</footer>