<?php
// Exit if the file is accessed directly over web
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Groups Component Gallery list(MediaPress landing page) template
 *  Used by /groups/group_name/mediapress/
 */
?>
<div class="card-main card-space-bottom">
	<div class="card-inner pt-0 pb-0">
		<div role="navigation" id="subnav" class="item-list-tabs no-ajax mpp-group-nav">
			<div class="socialv-subtab-lists">
				<div class="left" onclick="slide('left',event)">
					<i class="iconly-Arrow-Left-2 icli"></i>
				</div>
				<div class="right" onclick="slide('right',event)">
					<i class="iconly-Arrow-Right-2 icli"></i>
				</div>
				<div class="socialv-subtab-container custom-nav-slider">
					<ul class="list-inline m-0">
						<?php do_action('mpp_group_nav'); ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="mpp-container mpp-clearfix" id="mpp-container">

	<?php
	// main file loaded by MediaPress
	// it loads the requested file.
	$template = '';
	if (mpp_is_gallery_create()) {
		$template = 'gallery/create.php';
	} elseif (mpp_is_gallery_management()) {
		$template = 'buddypress/groups/gallery/manage.php';
	} elseif (mpp_is_media_management()) {
		$template = 'buddypress/groups/media/manage.php';
	} elseif (mpp_is_single_media()) {
		$template = 'buddypress/groups/media/single.php';
	} elseif (mpp_is_single_gallery()) {
		$template = 'buddypress/groups/gallery/single.php';
	} elseif (mpp_is_gallery_home()) {
		$template = 'gallery/loop-gallery.php';
	} else {
		$template = 'gallery/404.php'; // not found.
	}

	$template = mpp_locate_template(array($template), false);

	$template = apply_filters('mpp_groups_gallery_located_template', $template);

	if (is_readable($template)) {
		include $template;
	}
	unset($template);
	?>
</div> <!-- end of mpp-container -->