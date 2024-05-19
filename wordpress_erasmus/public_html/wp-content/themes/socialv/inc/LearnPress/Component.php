<?php
/**
 * SocialV\Utility\LearnPress class
 *
 * @package socialv
 */

namespace SocialV\Utility\LearnPress;

use LP_Global;
use LP_Helper;
use LP_Page_Controller;
use LP_Section_DB;
use LP_Assets;
use SocialV\Utility\Component_Interface;
use SocialV\Utility\Templating_Component_Interface;
use function SocialV\Utility\socialv;

/**
 * Class for managing comments UI.
 *
 * Exposes template tags:
 * * `socialv()->the_comments( array $args = array() )`
 *
 * @link https://wordpress.org/plugins/amp/
 */
class Component implements Component_Interface, Templating_Component_Interface {

    /**
     * Gets the unique identifier for the theme component.
     *
     * @return string Component slug.
     */
    public function get_slug(): string {
        return 'learnpress';
    }

    public function initialize() {
        
    }

    public function __construct() {
        add_filter('learn-press/override-templates', function () {
            return true;
        });
        add_action('init', function () {
            if (class_exists('LP_Assets')) {
                // Remove the action that generates the inline CSS
                remove_action('wp_head', array(LP_Assets::instance(), 'global_config_styles'));
            }
        });

        remove_action('wp_head', 'learn_press_print_custom_styles');

        add_action('wp_print_styles', [$this, 'socialv_dequeue_unnecessary_styles']);
        add_action('wp_head', [$this, 'socialv_enqueue_styles'], 7);

        add_action('after_setup_theme', [$this, 'socialv_remove_learnpress_hooks']);
        if (class_exists('LP_Addon_Course_Review')) {
            if (function_exists('learn_press_get_course_rate')) {
                add_action('learn-press/after-courses-loop-item', [$this, 'socialv_courses_loop_item_rating'], 40);
            }
            add_action('learn-press/course-meta-primary-left', [$this, 'php_predix_course_meta_primary_review'], 40);
        }
        add_action('learn-press/course-meta-primary-left', [$this, 'php_predix_course_progress_report'], 40);
        add_action('learn-press/after-courses-loop-item', LP()->template('course')->text('<div class="course-meta">', 'course-wrap-meta-open'), 18);
        add_action('learn-press/after-courses-loop-item', [$this, 'socialv_count_object'], 18);
        add_action('learn-press/after-courses-loop-item', LP()->template('course')->text('</div> <!-- END .course-content-meta -->', 'course-wrap-meta-close'), 18);
        add_action('learn-press/before-courses-loop-item', LP()->template('course')->text('<div class="course-header">', 'course-wrap-meta-open'), 1005);
        add_action('learn-press/before-courses-loop-item', LP()->template('course')->text('</div>', 'course-wrap-meta-open'), 1011);
        remove_action('learn-press/course-meta-primary-left', 'learn_press_course_meta_primary_review', 30);
        add_action(
                'learn-press/course-content-summary',
                LP()->template('course')->text(
                        '<div class="course-detail-info"> <div class="lp-content-area"> <div class="course-info-left">',
                        'course-info-left-open'
                ),
                11
        );
        add_action('learn-press/course-content-summary', LP()->template('course')->callback('single-course/title'), 11);
        add_action(
                'learn-press/course-content-summary',
                LP()->template('course')->callback('single-course/meta-primary'),
                11
        );
        add_action('learn-press/course-content-summary', LP()->template('course')->func('course_featured_review'), 35);
        add_filter('learnpress/course/curriculum/empty', [$this, 'socialv_curriculum_empty']);
        add_filter('learn-press/user-profile-social-icon', [$this, 'socialv_get_user_profile_social_icon'], 10, 2);
        add_filter('learn-press/profile-tabs', [$this, 'socialv_change_tabs_course_profile'], 1000);
        add_filter('learn_press_course_instructor_html', [$this, 'socialv_learn_press_course_instructor_html'], 10, 3);
        add_filter('learn-press/page-template', [$this, 'socialv_learn_press_page_template']);
    }

    public function template_tags(): array {
        return array(
            'course_sidebar_meta_content' => [$this, 'course_sidebar_meta_content'],
            'socialv_review_content' => [$this, 'socialv_review_content'],
            'socialv_learn_press_get_course_tabs' => [$this, 'socialv_learn_press_get_course_tabs'],
            'socialv_course_curriculum' => [$this, 'socialv_course_curriculum'],
        );
    }

    function socialv_dequeue_unnecessary_styles() {
        wp_dequeue_style('learnpress');
    }

    function socialv_enqueue_styles() {
        wp_print_styles('learnpress');
    }

    function socialv_remove_learnpress_hooks() {
        remove_action('learn-press/after-courses-loop-item', 'learn_press_course_review_loop_stars');
        LP()->template('course')->remove('learn-press/after-courses-loop-item', 'count_object', 20);
        LP()->template('course')->remove('learn-press/after-courses-loop-item', array('<div class="course-wrap-meta">', 'course-wrap-meta-open'), 20);
        LP()->template('course')->remove('learn-press/after-courses-loop-item', array('</div>', 'course-wrap-meta-close'), 20);
        LP()->template('course')->remove_callback('learn-press/after-courses-loop-item', 'single-course/meta/duration', 20);
        LP()->template('course')->remove_callback('learn-press/after-courses-loop-item', 'single-course/meta/level', 20);
        LP()->template('course')->remove('learn-press/after-courses-loop-item', 'courses_loop_item_meta', 25);
        LP()->template('general')->remove('learn-press/before-main-content', 'breadcrumb');
        LP()->template('course')->remove('learn-press/after-courses-loop-item', 'course_readmore', 55);
        LP()->template('course')->remove('learn-press/course-content-summary', 'course_comment_template', 75);
        LP()->template('course')->remove('learn-press/course-content-summary', array('<div class="course-detail-info"> <div class="lp-content-area"> <div class="course-info-left">', 'course-info-left-open'), 10);
        LP()->template('course')->remove_callback('learn-press/course-content-summary', 'single-course/meta-primary', 10);
        LP()->template('course')->remove_callback('learn-press/course-content-summary', 'single-course/title', 10);
        LP()->template('course')->remove_callback('learn-press/course-content-summary', 'single-course/meta-secondary', 10);
        LP()->template('course')->remove('learn-press/course-summary-sidebar', 'course_featured_review', 20);
        LP()->template('profile')->remove('learn-press/user-profile-account', 'socials', 10);
    }

    function socialv_courses_loop_item_rating() {
        $course_id = get_the_ID();
        $course_rate_res = learn_press_get_course_rate($course_id, false);
        $course_rate = $course_rate_res['rated'];
        ?>
        <div class="course-ratings">
            <?php
            echo '<span class="course-rating-total">' . number_format($course_rate, 1) . '</span>';
            socialv()->socialv_review_content($course_id);
            ?>
        </div>
        <?php
    }

    function php_predix_course_progress_report() {
        LP()->template('course')->user_progress();
    }

    function socialv_review_content($course_id) {
        $rated = learn_press_get_course_rate($course_id);
        $percent = (!isset($rated)) ? 0 : min(100, (round((int) $rated * 2) / 2) * 20);
        $title = sprintf(__('%s out of 5 stars', 'socialv'), round((int) $rated, 2));
        ?>
        <div class="review-stars-rated" title="<?php echo esc_attr($title); ?>">
            <?php
            for ($i = 1; $i <= 5; $i++) {
                $p = ($i * 20);
                $r = max($p <= $percent ? 100 : ($percent - ($i - 1) * 20) * 5, 0);
                ?>
                <div class="review-star">
                    <i class="far"><i class="icon-border-star"></i></i>
                    <i class="fas" style="width:<?php echo esc_attr($r); ?>%;"><i class="icon-fill-star"></i></i>
                </div>
            <?php } ?>
        </div>
        <?php
    }

    function php_predix_course_meta_primary_review() {
        if (!class_exists('LP_Addon_Course_Review')) {
            return;
        }
        $_aggregateRating = $rating_meta = '';
        $course_id = get_the_ID();
        $course_rate = learn_press_get_course_rate($course_id);
        $ratings = learn_press_get_course_rate_total($course_id);
        if (is_single() && $ratings > 0) {
            $_aggregateRating = 'itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"';
            $rating_meta = '<meta itemprop="ratingValue" content="' . esc_attr($course_rate) . '"/>
                    <meta itemprop="ratingCount" content="' . esc_attr($ratings) . '"/>
                    <div itemprop="itemReviewed" itemscope="" itemtype="http://schema.org/Organization">
                        <meta itemprop="name" content="' . get_the_title($course_id) . '"/>
                    </div>';
        }
        ?>
        <div class="course-ratings">
            <label><?php esc_html_e('Review', 'socialv'); ?></label>
            <div class="value" <?php echo esc_html($_aggregateRating); ?>>
                <?php echo number_format($course_rate, 1); ?>
                <?php socialv()->socialv_review_content($course_id); ?>
                <span><?php $ratings ? printf(_n('(%1$s rating)', '(%1$s ratings)', $ratings, 'socialv'), '<span>' . number_format_i18n($ratings) . '</span>') : printf(__('(%1$s rating)', 'socialv'), '<span>0</span>'); ?></span>
                <?php
                echo wp_kses($rating_meta, 'socialv');
                ?>
            </div>
        </div>
        <?php
    }

    function socialv_count_object() {
        $course = learn_press_get_course();

        if (!$course) {
            return;
        }

        $lessons = $course->count_items(LP_LESSON_CPT);
        $students = $course->count_students();

        $counts = apply_filters(
                'learnpress/course/count/items',
                array(
                    'lesson' => sprintf(
                            '<span class="meta-number"><i class="icon-lesson"></i>' . _n('%d lesson', '%d lessons', $lessons, 'socialv') . '</span>',
                            $lessons
                    ),
                    'student' => sprintf(
                            '<span class="meta-number"><i class="icon-students"></i>' . _n('%d student', '%d students', $students, 'socialv') . '</span>',
                            $students
                    ),
                ),
                array($lessons, $students)
        );

        foreach ($counts as $object => $count) {
            learn_press_get_template(
                    'single-course/meta/count',
                    array(
                        'count' => $count,
                        'object' => $object,
                    )
            );
        }
    }

    function course_sidebar_meta_content() {
        $course = learn_press_get_course();
        $course_id = get_the_ID();
        if (!empty($course)) {
            ?>
            <div class="socialv-course-info">
                <h5 class="title"><?php esc_html_e('The Course Includes:', 'socialv'); ?></h5>
                <ul>
                    <li class="lectures-feature">
                        <i class="icon-lesson"></i>
                        <span class="value"><?php echo esc_html($course->get_curriculum_items('lp_lesson') ? count($course->get_curriculum_items('lp_lesson')) : 0); ?> <?php esc_html_e('Detailed Lessons', 'socialv'); ?></span>
                    </li>
                    <li class="quizzes-feature">
                        <i class="icon-quizz"></i>
                        <span class="label"><?php esc_html_e('Quizzes after', 'socialv'); ?> <?php echo esc_html($course->get_curriculum_items('lp_quiz') ? count($course->get_curriculum_items('lp_quiz')) : 0); ?></span>
                    </li>
                    <li class="duration-feature">
                        <i class="icon-calendar"></i>
                        <span class="label"><?php echo learn_press_get_post_translated_duration(get_the_ID(), esc_html__('Of the enitre courses', 'socialv')); ?> <?php esc_html_e('Of The Entire Course', 'socialv'); ?></span>
                    </li>
                    <li class="students-feature">
                        <i class="icon-students"></i>
                        <?php $user_count = $course->get_users_enrolled() ? $course->get_users_enrolled() : 0; ?>
                        <span class="label"><?php echo esc_html($user_count); ?> <?php esc_html_e('Students participated', 'socialv'); ?></span>
                    </li>
                    <li class="assessments-feature">
                        <i class="icon-box-check"></i>
                        <span class="label"><?php esc_html_e('Assessments', 'socialv'); ?> <?php echo (get_post_meta($course_id, '_lp_course_result', true) == 'evaluate_lesson') ? esc_html__('Yes', 'socialv') : esc_html__('Self', 'socialv'); ?></span>
                    </li>
                </ul>
            </div>
            <?php
        }
    }

    function socialv_curriculum_empty() {
        return '<div class="curriculum-empty">' . esc_html__('Curriculum is empty', 'socialv') . '</div>';
    }

    function socialv_learn_press_get_course_tabs() {

        $course = learn_press_get_course();
        $user = learn_press_get_current_user();
        $defaults = array();
        /**
         * Show tab overview if
         * 1. Course is preview
         * OR
         * 2. Course's content not empty
         */
        if (isset($_GET['preview']) || $course) {
            $defaults['overview'] = array(
                'title' => esc_html__('Overview', 'socialv'),
                'priority' => 10,
                'callback' => LP()->template('course')->callback('single-course/tabs/overview.php'),
            );
        }

        $defaults['curriculum'] = array(
            'title' => esc_html__('Curriculum', 'socialv'),
            'priority' => 30,
            'callback' => array($this, 'socialv_course_curriculum'),
        );

        $defaults['instructor'] = array(
            'title' => esc_html__('Instructor', 'socialv'),
            'priority' => 40,
            'callback' => LP()->template('course')->callback('single-course/tabs/instructor.php'),
        );

        if ($course->get_faqs()) {
            $defaults['faqs'] = array(
                'title' => esc_html__('FAQs', 'socialv'),
                'priority' => 50,
                'callback' => LP()->template('course')->func('faqs'),
            );
        }

        $tabs = apply_filters('learn-press/course-tabs', $defaults);

        if ($tabs) {
            uasort($tabs, 'learn_press_sort_list_by_priority_callback');
            $request_tab = LP_Helper::sanitize_params_submitted($_REQUEST['tab'] ?? '');
            $has_active = false;

            foreach ($tabs as $k => $v) {
                $v['id'] = !empty($v['id']) ? $v['id'] : 'tab-' . $k;

                if ($request_tab === $v['id']) {
                    $v['active'] = true;
                    $has_active = $k;
                } elseif (isset($v['active']) && $v['active']) {
                    $has_active = true;
                }
                $tabs[$k] = $v;
            }

            if (!$has_active) {
                if (
                        $course && $user->has_course_status(
                                $course->get_id(),
                                array(
                                    'enrolled',
                                    'finished',
                                )
                        ) && !empty($tabs['curriculum'])
                ) {
                    $tabs['curriculum']['active'] = true;
                } elseif (!empty($tabs['overview'])) {
                    $tabs['overview']['active'] = true;
                } else {
                    $keys = array_keys($tabs);
                    $first_key = reset($keys);
                    $tabs[$first_key]['active'] = true;
                }
            }
        }

        return $tabs;
    }

    function socialv_course_curriculum() {
        $course_item = LP_Global::course_item();

        if ($course_item) { // Check if current item is viewable
            $item_id = $course_item->get_id();
            $section_id = LP_Section_DB::getInstance()->get_section_id_by_item_id(absint($item_id));
        }
        ?>
        <div class="learnpress-course-curriculum" data-section="<?php echo esc_attr($section_id ?? ''); ?>" data-id="<?php echo esc_attr($item_id ?? ''); ?>">
            <ul class="lp-skeleton-animation">
                <li style="width: 100%; height: 50px"></li>
                <li style="width: 100%; height: 20px"></li>
                <li style="width: 100%; height: 20px"></li>
                <li style="width: 100%; height: 20px"></li>

                <li style="width: 100%; height: 50px; margin-top: 40px;"></li>
                <li style="width: 100%; height: 20px"></li>
                <li style="width: 100%; height: 20px"></li>
                <li style="width: 100%; height: 20px"></li>
            </ul>
        </div>
        <?php
    }

    function socialv_get_user_profile_social_icon($i, $k) {
        switch ($k) {
            case 'facebook':
                $i = '<i class="facebook icon-facebook"></i>';
                break;
            case 'twitter':
                $i = '<i class="twitter icon-twitter"></i>';
                break;
            case 'googleplus':
                $i = '<i class="googleplus icon-googleplus"></i>';
                break;
            case 'youtube':
                $i = '<i class="youtube icon-youtube"></i>';
                break;
            default:
                $i = '<i class="' . $k . ' icon-' . $k . '"></i>';
        }

        return $i;
    }

    function socialv_change_tabs_course_profile($defaults) {
        global $current_user;
        $defaults['courses']['icon'] = '<i class="icon-course"></i>';
        $defaults['quizzes']['icon'] = '<i class="icon-quiz-panel"></i>';
        $defaults['orders']['icon'] = '<i class="iconly-Buy icli"></i>';
        $defaults['settings']['icon'] = '<i class="iconly-Setting icli"></i>';
        $defaults['settings']['sections']['basic-information']['icon'] = '<i class="iconly-Home icli"></i>';
        $defaults['settings']['sections']['avatar']['icon'] = '<i class="iconly-Profile icli"></i>';
        $defaults['settings']['sections']['change-password']['icon'] = '<i class="iconly-Lock icli"></i>';
        $defaults['settings']['icon'] = '<i class="iconly-Setting icli"></i>';
        $defaults['logout']['icon'] = '<i class="iconly-Logout icli"></i>';
        if (isset($current_user->roles) && in_array('demo-user', $current_user->roles)) {
            unset($defaults['settings']['sections']['change-password']);
        }
        return $defaults;
    }

    function socialv_learn_press_course_instructor_html($html, $id) {
        $with_avatar = false;
        $link_class = '';
        $instructor = get_the_author(get_post_field('post_author', $id));
        $user_id = get_post_field('post_author', get_the_ID());
        $user_link = function_exists('bp_core_get_user_domain') ? bp_core_get_user_domain($user_id) : learn_press_user_profile_link($user_id);
        $html = sprintf(
                '<a href="%s"%s>%s<span>%s</span></a>',
                $user_link,
                $link_class ? sprintf('class="%s"', $link_class) : '',
                $with_avatar ? get_avatar(
                        $id,
                        $with_avatar === true ? 48 : $with_avatar
                ) : '',
                $instructor
        );
        return $html;
    }

    function socialv_learn_press_page_template($page_template) {

        if (LP_Page_Controller::is_page_courses()) {
            $page_template = '';
            if (is_user_logged_in()) {
                $page_template = 'archive-course.php';
            }
        }
        return $page_template;
    }
}
