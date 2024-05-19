<?php

/**
 * SocialV\Utility\Custom_Helper\Helpers\Members class
 *
 * @package socialv
 */

namespace SocialV\Utility\Custom_Helper\Helpers;

use MPP_Assets_Loader;
use MPP_Core_Component;
use SocialV\Utility\Custom_Helper\Component;
use function add_action;

class Media  extends Component
{
    public $theme_directory;

    public function __construct()
    {
        if (!defined('MPP_GALLERY_SLUG')) {
            define('MPP_GALLERY_SLUG', 'media');
        }
        $this->theme_directory = get_template_directory_uri();
        $core = MPP_Core_Component::get_instance();
        add_filter("mpp_gallery_actions_links", [$this, "socialv_gallery_actions_links"], 10, 3);

        remove_action('mpp_setup_globals', 'mpp_setup_gallery_nav');
        remove_action('bp_member_plugin_options_nav',  [$core, 'context_menu_edit']);
        remove_action('mpp_group_nav', [$core, 'context_menu_edit']);
        remove_action('mpp_actions', 'mpp_action_create_gallery', 2);
        add_action('mpp_actions', [$this, 'socialv_action_create_gallery'], 2);
        remove_action('mpp_group_nav', 'mp_group_nav', 0);
        add_action('mpp_group_nav', [$this, 'socialv_mp_group_sub_nav'], 2);

        // delete
        add_action('wp_ajax_user_delete_media', [$this, 'socialv_user_delete_media']);
        add_action('wp_ajax_nopriv_user_delete_media', [$this, 'socialv_user_delete_media']);

        // default media placeholders
        add_filter('mpp_get_gallery_default_cover_image_src',  [$this, 'socialv_default_gallery_placeholders'], 10, 3);
        add_filter('mpp_get_media_default_cover_image_src',  [$this, 'socialv_default_media_placeholders'], 10, 3);
        if (class_exists('MPP_Assets_Loader')) {
            remove_action('wp_footer', [MPP_Assets_Loader::get_instance(), 'footer']);
            add_action('wp_footer', [$this, 'socialv_media_footer']);
        }
        add_filter('mpp_directory_gallery_search_form', [$this, 'socialv_mpp_directory_gallery_search_form']);
        add_action('socialv_mpp_upload_dropzone',  [$this,  'socialv_mpp_upload_dropzone']);
    }

    function socialv_mp_group_sub_nav()
    {

        if (!bp_is_group()) {
            return;
        }
        $bp = buddypress();

        $selected = "";
        $group_media_my_gallery_links = "";
        $group_media_type_links = "";
        $selected_media = true;
        $component    = 'groups';
        $component_id = groups_get_current_group()->id;
        $supported_types = mpp_component_get_supported_types($component);

        foreach ($supported_types as $type) {

            if (!mpp_is_active_type($type)) {
                continue;
            }

            $list_type = 'type/' . $type . '-' . $component . '-li';
            $type_object = mpp_get_type_object($type);
            $selected = isset($bp->action_variables) && in_array($type, $bp->action_variables) ? 'class="current selected"' : '';
            if (!empty($selected)) $selected_media = false;
            $group_media_type_links .= sprintf("<li id='%1s' %2s><a href='%3s'>%4s</a></li>", $list_type, $selected, mpp_get_gallery_base_url($component, $component_id) . 'type/' . $type, esc_html($type_object->label));
        }

        // my-gallery
        if (mpp_group_is_my_galleries_enabled()) {
            $my_gallery_selected = isset($bp->action_variables) && in_array("my-gallery", $bp->action_variables) ? 'class="my-gallery current selected"' : "";
            if (!empty($my_gallery_selected)) $selected_media = false;
            $group_media_my_gallery_links = sprintf("<li %1s><a href='%2s'>%3s</a></li>", $my_gallery_selected, mpp_group_get_user_galleries_url(), esc_html__('My Galleries', 'socialv'));
        }

        // all
        $is_all_selected = $selected_media ? 'class="current selected"' : "";
        $group_media_nav_links = sprintf("<li %1s><a href='%2s'>%3s</a></li>", $is_all_selected, mpp_get_gallery_base_url($component, $component_id), esc_html__('All', 'socialv'));

        $group_media_nav_links .= $group_media_my_gallery_links . $group_media_type_links;
        echo apply_filters("groups_media_nav_links", $group_media_nav_links);
    }

    function socialv_gallery_actions_links($links, $links_array, $gallery)
    {
        // delete.
        if (mpp_user_can_delete_gallery($gallery)) {
            $c_links = sprintf('<a href="%1$s" data-id="%2$s" title="' . __('delete %3$s', 'socialv') . '" class="socialv-delete-media mpp-delete mpp-delete-gallery"><i class="iconly-Delete icli"></i></a>', mpp_get_gallery_delete_url($gallery), $gallery->id, mpp_get_gallery_title($gallery));
        } else {
            $c_links = "";
        }
        return $c_links;
    }

    function socialv_user_delete_media()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : ""; // Get the ajax call
        $type = isset($_GET['type']) ? $_GET['type'] : "";
        $is_deleted = ["status" => false];
        $is_negative = [];
        if ($type == "gallery" && (!empty($id)) && mpp_delete_gallery($id)) {
            $is_deleted = ["status" => true];
        } else if ($type == "media" && (!empty($id))) {
            $ids = explode(",", $id);

            foreach ($ids as $media_id) {
                if (mpp_delete_media($media_id)) {
                    $is_deleted = ["status" => true];
                } else {
                    $is_negative = ["negative_status" => false];
                }
            }
        }

        echo json_encode(array_merge($is_deleted, $is_negative));
        die();
    }

    function socialv_action_create_gallery()
    {

        // allow gallery to be created from anywhere.
        // the form must have mpp-action set and It should be set to 'create-gallery'.
        if (empty($_POST['mpp-action']) || 'create-gallery' !== $_POST['mpp-action']) {
            return;
        }

        $referrer = wp_get_referer();
        // if we are here, It is gallery create action.
        if (!wp_verify_nonce($_POST['mpp-nonce'], 'mpp-create-gallery')) {
            // add error message and return back to the old page.
            mpp_add_feedback(esc_html__('Action not authorized!', 'socialv'), 'error');

            if ($referrer) {
                mpp_redirect($referrer);
            }

            return;
        }
        // update it to allow passing component/id from the form.
        $component    = isset($_POST['mpp-gallery-component']) ? $_POST['mpp-gallery-component'] : mpp_get_current_component();
        $component_id = isset($_POST['mpp-gallery-component-id']) ? $_POST['mpp-gallery-component-id'] : mpp_get_current_component_id();

        // check for permission
        // we may want to allow passing of component from the form in future!
        if (!mpp_user_can_create_gallery($component, $component_id)) {
            mpp_add_feedback(esc_html__("You don't have permission to create gallery!", 'socialv'), 'error');

            if ($referrer) {
                mpp_redirect($referrer);
            }

            return;
        }

        $title       = sanitize_text_field($_POST['mpp-gallery-title']);
        $description = sanitize_textarea_field($_POST['mpp-gallery-description']);

        $type   = sanitize_text_field($_POST['mpp-gallery-type']);
        $status = sanitize_text_field($_POST['mpp-gallery-status']);
        $errors = array();

        // if we are here, validate the data and let us see if we can create.
        if (!mpp_is_active_status($status)) {
            $errors['status'] = esc_html__('Invalid Gallery status!', 'socialv');
        }

        if (!mpp_is_active_type($type)) {
            $errors['type'] = esc_html__('Invalid gallery type!', 'socialv');
        }

        // check for current component.
        if (!mpp_is_enabled($component, $component_id)) {
            $errors['component'] = esc_html__('Invalid action!', 'socialv');
        }

        if (empty($title)) {
            $errors['title'] = esc_html__('Title can not be empty', 'socialv');
        }

        // Give opportunity to other plugins to add their own validation errors.
        $validation_errors = apply_filters('mpp-create-gallery-field-validation', $errors, $_POST);

        if (!empty($validation_errors)) {
            // let us add the validation error and return back to the earlier page.
            $message = join('\r\n', $validation_errors);

            mpp_add_feedback($message, 'error');

            if ($referrer) {
                mpp_redirect($referrer);
            }

            return;
        }

        // let us create gallery.
        $gallery_id = mpp_create_gallery(array(
            'title'        => $title,
            'description'  => $description,
            'type'         => $type,
            'status'       => $status,
            'creator_id'   => get_current_user_id(),
            'component'    => $component,
            'component_id' => $component_id,
        ));

        if (!$gallery_id) {
            mpp_add_feedback(esc_html__('Unable to create gallery!', 'socialv'), 'error');

            if ($referrer) {
                mpp_redirect($referrer);
            }

            return;
        }

        // if we are here, the gallery was created successfully,
        // let us redirect to the gallery_slug/manage/upload page.
        $redirect_url = mpp_get_gallery_permalink($gallery_id);

        mpp_add_feedback(esc_html__('Gallery created successfully!', 'socialv'));

        mpp_redirect($redirect_url);
    }

    function socialv_default_gallery_placeholders($default_image, $type, $gallery)
    {
        $gallery = mpp_get_gallery($gallery);

        $thumbnail_id = mpp_get_gallery_cover_id($gallery->id);

        if ((!$thumbnail_id || !mpp_get_media($thumbnail_id)) && apply_filters('mpp_gallery_auto_update_cover', true, $gallery)) {

            // if gallery type is photo, and the media count > 0 then set the latest photo as the cover.
            if ('photo' === $gallery->type && $gallery->media_count > 0) {
                // && mpp_gallery_has_media( $gallery->id )
                $thumbnail_id = mpp_gallery_get_latest_media_id($gallery->id);

                // update gallery cover id.
                if ($thumbnail_id) {
                    mpp_update_gallery_cover_id($gallery->id, $thumbnail_id);
                }
            }


            if (!$thumbnail_id) {
                $default_image = $gallery->type . '-thumbnail.jpg';
                $default_image = $this->theme_directory . '/assets/images/' . $default_image;

                return $default_image;
            }
        }

        // Get the image src.
        $thumb_image_url = _mpp_get_cover_photo_src($type, $thumbnail_id);

        return apply_filters('mpp_get_gallery_cover_src', $thumb_image_url, $type, $gallery);
    }
    function socialv_default_media_placeholders($default_image, $type, $media)
    {
        $media = mpp_get_media($media);

        if ($media->type != "photo") {
            $default_image = $media->type . '-thumbnail.jpg';
            $default_image = $this->theme_directory . '/assets/images/' . $default_image;
        }

        return $default_image;
    }
    public function socialv_media_footer()
    {
?>
        <ul style="display: none;">
            <li id="mpp-loader-wrapper" style="display:none;" class="mpp-loader">
                <div id="mpp-loader"><img alt="<?php esc_attr_e("img", "socialv");  ?>" src="<?php echo mpp_get_asset_url('assets/images/loader.gif', 'mpp-loader'); ?>" /></div>
            </li>
        </ul>

        <div id="mpp-cover-uploading" style="display:none;" class="mpp-cover-uploading">
            <img alt="<?php esc_attr_e("img", "socialv");  ?>" src="<?php echo mpp_get_asset_url('assets/images/loader.gif', 'mpp-cover-loader'); ?>" />
        </div>


        <?php
    }

    function socialv_mpp_directory_gallery_search_form($search_form_html)
    {
        $default_search_value = bp_get_search_default_text('mediapress');
        $search_value         = !empty($_REQUEST['s']) ? stripslashes($_REQUEST['s']) : $default_search_value;

        $search_form_html = '<div class="card-main socialv-search-main"><div class="card-inner"><div id="mpp-dir-search" class="dir-search" role="search"><div class="socialv-bp-searchform"><form action="" method="get" id="search-mpp-form"><div class="search-input">
            <input type="text" name="s" id="mpp_search" placeholder="' . esc_attr($search_value) . '" /><label for="mpp_search"></label>
            <button type="submit" id="mpp_search_submit" name="mpp_search_submit" value="' . __('Search', 'socialv') . '" class="btn-search"/><i class="iconly-Search icli"></i></button>
        </form></div>    </div></div></div>';
        return $search_form_html;
    }

    public function socialv_mpp_upload_dropzone()
    {
        if (mpp_is_file_upload_enabled('activity')) :
            mpp_upload_dropzone('shortcode');
            do_action('mpp_after_activity_upload_dropzone'); ?>
            <!-- show any feedback here -->
            <div id="mpp-upload-feedback-activity" class="mpp-feedback">
                <ul></ul>
            </div>
        <?php endif; ?>
        <input type='hidden' name='mpp-context' id='mpp-context' class="mpp-context" value='gallery' />
        <input type='hidden' name='mpp-upload-gallery-id' id='mpp-upload-gallery-id' value="<?php echo mpp_get_current_gallery_id(); ?>" />
        <?php do_action('mpp_after_activity_upload_feedback');
        if (mpp_is_remote_enabled('activity')) : ?>
            <!-- remote media -->
            <div class="mpp-remote-media-container">
                <div class="mpp-remote-add-media-row">
                    <input type="text" placeholder="<?php esc_attr_e('Enter a link', 'socialv'); ?>" value="" name="mpp-remote-media-url" id="mpp-remote-media-url" class="mpp-remote-media-url" />
                    <button id="mpp-add-remote-media" class="mpp-add-remote-media"><i class="icon-add"></i></button>
                </div>
                <?php wp_nonce_field('mpp_add_media', 'mpp-remote-media-nonce'); ?>
            </div>
            <!-- end of remote media -->
<?php endif;
    }
}
