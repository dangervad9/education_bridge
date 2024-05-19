<?php

?>
<nav class="dsd-menubard">

	<span class="dsd-logo">
		<img src="<?php echo DOCLY_DIR_IMG.'/logo_sticky_retina.png'; ?>" alt="<?php echo esc_attr( $theme->name ); ?>">
		<?php printf( '<span class="v">%s</span>', $theme->version ); ?>
	</span>

    <ul class="dsd-menu">
        <li class="<?php docly_helper()->active_tab('docly'); ?>">
            <a href="">
                <span><?php esc_html_e( 'Dashboard', 'docly' ); ?></span>
            </a>
        </li>
        <li class="">
            <a href="">
                <span><?php esc_html_e( 'Install Plugins', 'docly' ); ?></span>
            </a>
        </li>
        <li class="">
            <a href="">
                <span><?php esc_html_e( 'Import Demo', 'docly' ); ?></span>
            </a>
        </li>
        <li class="">
            <a href="">
                <span><?php esc_html_e( 'Support', 'docly' ); ?></span>
            </a>
        </li>
        <li>
            <a href="https://docs.liquid-themes.com/" target="_blank">
                <i class="icon-md-help-circle"></i>
                <span><?php esc_html_e( 'Documentations', 'docly' ); ?></span>
            </a>
        </li>
    </ul>

</nav> <!-- /.dsd-menubard -->