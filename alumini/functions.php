<?php

// ===============================
// THEME SETUP
// ===============================
function alumini_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'alumini_theme_setup');


// ===============================
// ENQUEUE FRONTEND STYLES
// ===============================
function alumini_enqueue_styles() {

    // Main CSS
    wp_enqueue_style(
        'alumini-style',
        get_stylesheet_uri(),
        array(),
        '1.0'
    );

    // Custom CSS
    wp_enqueue_style(
        'alumini-custom-style',
        get_template_directory_uri() . '/css/custom.css',
        array('alumini-style'),
        '1.0'
    );

    // Google Font - Poppins
    wp_enqueue_style(
        'alumini-poppins',
        'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap',
        array(),
        null
    );

    // Material Symbols
    wp_enqueue_style(
        'alumini-material-icons',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined',
        array(),
        null
    );

    // External Redbrick CSS
    wp_enqueue_style(
        'redbrick-css',
        'https://www.liverpool.ac.uk/rb/latest/assets/redbrick.css',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'alumini_enqueue_styles');


// ===============================
// ADMIN SCRIPTS (MEDIA UPLOADER)
// ===============================
function alumini_admin_scripts($hook) {

    if ($hook == 'post.php' || $hook == 'post-new.php') {

        wp_enqueue_media();

        wp_enqueue_script(
            'alumini-admin-js',
            get_template_directory_uri() . '/js/admin.js',
            array('jquery'),
            '1.0',
            true
        );

        $screen = function_exists('get_current_screen') ? get_current_screen() : null;
        if ($screen && in_array($screen->post_type, array('page', 'casestudy'), true)) {
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script(
                'alumini-statistics-admin',
                get_template_directory_uri() . '/js/statistics-admin.js',
                array('jquery', 'jquery-ui-sortable', 'wp-color-picker'),
                '1.0',
                true
            );
        }
    }
}
add_action('admin_enqueue_scripts', 'alumini_admin_scripts');

// Allow SVG upload
function alumini_allow_svg_upload($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'alumini_allow_svg_upload');


// ===============================
// HERO META BOX
// ===============================
function alumini_add_meta_boxes() {
    add_meta_box(
        'alumini_hero_section',
        'Hero Section',
        'alumini_hero_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'alumini_add_meta_boxes');


// HERO FIELDS UI
function alumini_hero_callback($post) {

    wp_nonce_field('alumini_save_meta', 'alumini_nonce');

    $title    = get_post_meta($post->ID, '_hero_title', true);
    $subtitle = get_post_meta($post->ID, '_hero_subtitle', true);
    $bg_image = get_post_meta($post->ID, '_hero_bg', true);
    ?>

    <p>
        <label><strong>Hero Title</strong></label><br>
        <textarea name="hero_title" style="width:100%; height:80px;"><?php echo esc_textarea($title); ?></textarea>
    </p>

    <p>
        <label><strong>Hero Subtitle</strong></label><br>
        <input type="text" name="hero_subtitle" value="<?php echo esc_attr($subtitle); ?>" style="width:100%;">
    </p>

    <p>
        <label><strong>Background Image</strong></label><br>
        <input type="text" name="hero_bg" value="<?php echo esc_attr($bg_image); ?>" style="width:80%;">
        <button class="button upload_image_button">Upload</button>
    </p>

    <?php
}


// SAVE HERO DATA
function alumini_save_hero_meta($post_id) {

    // Security
    if (!isset($_POST['alumini_nonce']) || !wp_verify_nonce($_POST['alumini_nonce'], 'alumini_save_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['hero_title'])) {
        update_post_meta($post_id, '_hero_title', sanitize_textarea_field($_POST['hero_title']));
    }

    if (isset($_POST['hero_subtitle'])) {
        update_post_meta($post_id, '_hero_subtitle', sanitize_text_field($_POST['hero_subtitle']));
    }

    if (isset($_POST['hero_bg'])) {
        update_post_meta($post_id, '_hero_bg', esc_url_raw($_POST['hero_bg']));
    }
}
add_action('save_post', 'alumini_save_hero_meta');


// ===============================
// ABOUT META BOX
// ===============================
function alumini_about_meta_box() {
    add_meta_box(
        'alumini_about_section',
        'About Section',
        'alumini_about_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'alumini_about_meta_box');


// ABOUT FIELDS UI
function alumini_about_callback($post) {

    $current     = get_post_meta($post->ID, '_about_current', true);
    $title       = get_post_meta($post->ID, '_about_title', true);
    $subtitle    = get_post_meta($post->ID, '_about_subtitle', true);
    $desc        = get_post_meta($post->ID, '_about_desc', true);
    $image       = get_post_meta($post->ID, '_about_image', true);

    $btn_text    = get_post_meta($post->ID, '_about_btn_text', true);
    $btn_link    = get_post_meta($post->ID, '_about_btn_link', true);
    $btn_target  = get_post_meta($post->ID, '_about_btn_target', true);
    $about_bg_color = get_post_meta($post->ID, '_about_bg_color', true);


    ?>

    <p>
        <label><strong>Breadcrumb Current Page</strong></label><br>
        <input type="text" name="about_current" value="<?php echo esc_attr($current); ?>" style="width:100%;">
    </p>

    <p>
        <label><strong>Title</strong></label><br>
        <input type="text" name="about_title" value="<?php echo esc_attr($title); ?>" style="width:100%;">
    </p>

    <p>
        <label><strong>Subtitle</strong></label><br>
        <textarea name="about_subtitle" style="width:100%;"><?php echo esc_textarea($subtitle); ?></textarea>
    </p>

    <p>
        <label><strong>Description</strong></label><br>
        <textarea name="about_desc" style="width:100%;"><?php echo esc_textarea($desc); ?></textarea>
    </p>

    <p>
        <label><strong>Image</strong></label><br>
        <input type="text" name="about_image" value="<?php echo esc_attr($image); ?>" style="width:80%;">
        <button class="button upload_image_button">Upload</button>
    </p>

    <p>
        <label><strong>Button Text</strong></label><br>
        <input type="text" name="about_btn_text" value="<?php echo esc_attr($btn_text); ?>" style="width:100%;">
    </p>

    <p>
        <label><strong>Button Link</strong></label><br>
        <input type="text" name="about_btn_link" value="<?php echo esc_attr($btn_link); ?>" style="width:100%;">
    </p>

    <p>
        <label>
            <input type="checkbox" name="about_btn_target" <?php checked($btn_target, 'on'); ?>>
            Open in new tab
        </label>
    </p>
    <p>
        <label for="alumini_about_bg_color"><strong><?php echo esc_html__('Section Background Color', 'alumini'); ?></strong></label><br>
        <input
            type="text"
            class="alumini-color-field"
            id="alumini_about_bg_color"
            name="about_bg_color"
            value="<?php echo esc_attr($about_bg_color); ?>"
            data-default-color=""
        />
    </p>

    <?php
}


// SAVE ABOUT DATA
function alumini_save_about_meta($post_id) {

    if (!isset($_POST['alumini_nonce']) || !wp_verify_nonce($_POST['alumini_nonce'], 'alumini_save_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    update_post_meta($post_id, '_about_current', sanitize_text_field($_POST['about_current'] ?? ''));
    update_post_meta($post_id, '_about_title', sanitize_text_field($_POST['about_title'] ?? ''));
    update_post_meta($post_id, '_about_subtitle', sanitize_textarea_field($_POST['about_subtitle'] ?? ''));
    update_post_meta($post_id, '_about_desc', sanitize_textarea_field($_POST['about_desc'] ?? ''));
    update_post_meta($post_id, '_about_image', esc_url_raw($_POST['about_image'] ?? ''));

    update_post_meta($post_id, '_about_btn_text', sanitize_text_field($_POST['about_btn_text'] ?? ''));
    update_post_meta($post_id, '_about_btn_link', esc_url_raw($_POST['about_btn_link'] ?? ''));
    update_post_meta($post_id, '_about_btn_target', isset($_POST['about_btn_target']) ? 'on' : '');

    update_post_meta($post_id, '_about_bg_color', sanitize_hex_color($_POST['about_bg_color'] ?? ''));
}
add_action('save_post', 'alumini_save_about_meta');


// ===============================
// STATISTICS CPT
// ===============================
function alumini_register_stats_cpt() {

    $labels = array(
        'name'                  => __('Statistics', 'alumini'),
        'singular_name'         => __('Statistic', 'alumini'),
        'add_new'               => __('Add New', 'alumini'),
        'add_new_item'          => __('Add New Statistic', 'alumini'),
        'edit_item'             => __('Edit Statistic', 'alumini'),
        'new_item'              => __('New Statistic', 'alumini'),
        'view_item'             => __('View Statistic', 'alumini'),
        'search_items'          => __('Search Statistics', 'alumini'),
        'not_found'             => __('No statistics found.', 'alumini'),
        'not_found_in_trash'    => __('No statistics found in Trash.', 'alumini'),
        'all_items'             => __('All Statistics', 'alumini'),
        'menu_name'             => __('Statistics', 'alumini'),
        'name_admin_bar'        => __('Statistic', 'alumini'),
    );

    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'menu_icon'     => 'dashicons-chart-bar',
        'supports'      => array('title', 'editor', 'page-attributes'),
        'show_in_rest'  => true,
        'has_archive'   => false,
        'rewrite'       => array('slug' => 'statistics'),
    );

    register_post_type('statistics', $args);
}
add_action('init', 'alumini_register_stats_cpt');

// ===============================
// CASE STUDY CPT + TAXONOMY
// ===============================
function alumini_register_casestudy_cpt() {
    $labels = array(
        'name'               => __('Case Studies', 'alumini'),
        'singular_name'      => __('Case Study', 'alumini'),
        'add_new_item'       => __('Add New Case Study', 'alumini'),
        'edit_item'          => __('Edit Case Study', 'alumini'),
        'new_item'           => __('New Case Study', 'alumini'),
        'view_item'          => __('View Case Study', 'alumini'),
        'search_items'       => __('Search Case Studies', 'alumini'),
        'not_found'          => __('No case studies found.', 'alumini'),
        'not_found_in_trash' => __('No case studies found in Trash.', 'alumini'),
        'menu_name'          => __('Case Studies', 'alumini'),
    );

    register_post_type(
        'casestudy',
        array(
            'labels'       => $labels,
            'public'       => true,
            'menu_icon'    => 'dashicons-portfolio',
            'supports'     => array('title', 'editor', 'thumbnail', 'page-attributes'),
            'show_in_rest' => true,
            'has_archive'  => false,
            'rewrite'      => array('slug' => 'casestudy'),
        )
    );

    register_taxonomy(
        'casestudy_category',
        array('casestudy'),
        array(
            'labels'            => array(
                'name'          => __('Case Study Categories', 'alumini'),
                'singular_name' => __('Case Study Category', 'alumini'),
            ),
            'public'            => true,
            'hierarchical'      => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => array('slug' => 'casestudy-category'),
        )
    );
}
add_action('init', 'alumini_register_casestudy_cpt');

function alumini_casestudy_seed_terms() {
    if (!taxonomy_exists('casestudy_category')) {
        return;
    }
    $terms = array(
        'Image casestudy' => 'image-casestudy',
        'Video casestudy' => 'video-casestudy',
    );
    foreach ($terms as $name => $slug) {
        if (!term_exists($slug, 'casestudy_category')) {
            wp_insert_term($name, 'casestudy_category', array('slug' => $slug));
        }
    }
}
add_action('init', 'alumini_casestudy_seed_terms', 20);

// ===============================
// CASE STUDY META (Program name + Video URL)
// ===============================
function alumini_casestudy_meta_boxes() {
    add_meta_box(
        'alumini_casestudy_program',
        __('Case Study Details', 'alumini'),
        'alumini_casestudy_program_meta_box_callback',
        'casestudy',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'alumini_casestudy_meta_boxes');

function alumini_casestudy_program_meta_box_callback($post) {
    wp_nonce_field('alumini_save_casestudy_meta', 'alumini_casestudy_nonce');

    $program_name = get_post_meta($post->ID, '_casestudy_program_name', true);
    $video_url    = get_post_meta($post->ID, '_casestudy_video_url', true);

    $video_term = get_term_by('slug', 'video-casestudy', 'casestudy_category');
    $video_term_id = $video_term ? (int) $video_term->term_id : 0;
    $is_video = has_term('video-casestudy', 'casestudy_category', $post);
    ?>
    <p>
        <label for="alumini_casestudy_program_name"><strong><?php echo esc_html__('Program name', 'alumini'); ?></strong></label><br>
        <input type="text" id="alumini_casestudy_program_name" name="alumini_casestudy_program_name" value="<?php echo esc_attr($program_name); ?>" style="width:100%;">
    </p>

    <div class="alumini-casestudy-video-fields" data-video-term-id="<?php echo esc_attr((string) $video_term_id); ?>" data-video-term-slug="video-casestudy" data-video-term-label="Video casestudy" <?php echo $is_video ? '' : 'style="display:none;"'; ?>>
        <p>
            <label for="alumini_casestudy_video_url"><strong><?php echo esc_html__('Video URL', 'alumini'); ?></strong></label><br>
            <input type="url" id="alumini_casestudy_video_url" name="alumini_casestudy_video_url" value="<?php echo esc_attr($video_url); ?>" style="width:100%;" placeholder="https://">
        </p>
    </div>
    <p class="description alumini-casestudy-video-note" <?php echo $is_video ? 'style="display:none;"' : ''; ?>>
        <?php echo esc_html__('Assign the “Video casestudy” category to enable the Video URL field.', 'alumini'); ?>
    </p>
    <?php
}

function alumini_save_casestudy_meta($post_id) {
    if (!isset($_POST['alumini_casestudy_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['alumini_casestudy_nonce'])), 'alumini_save_casestudy_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if ('casestudy' !== get_post_type($post_id)) {
        return;
    }

    $program_name = sanitize_text_field(wp_unslash($_POST['alumini_casestudy_program_name'] ?? ''));
    update_post_meta($post_id, '_casestudy_program_name', $program_name);

    $video_term = get_term_by('slug', 'video-casestudy', 'casestudy_category');
    $video_term_id = $video_term ? (int) $video_term->term_id : 0;

    // Prefer the posted terms (block editor) over already-saved terms.
    $is_video = false;
    if (isset($_POST['tax_input']['casestudy_category']) && is_array($_POST['tax_input']['casestudy_category']) && $video_term_id) {
        $posted_terms = array_map('intval', wp_unslash($_POST['tax_input']['casestudy_category']));
        $is_video = in_array($video_term_id, $posted_terms, true);
    } else {
        $is_video = has_term('video-casestudy', 'casestudy_category', $post_id);
    }

    if ($is_video) {
        $video_url = esc_url_raw(wp_unslash($_POST['alumini_casestudy_video_url'] ?? ''));
        update_post_meta($post_id, '_casestudy_video_url', $video_url);
    }
}
add_action('save_post', 'alumini_save_casestudy_meta');

// ===============================
// STATISTICS META (stat_count)
// ===============================
function alumini_statistics_add_count_meta_box() {
    add_meta_box(
        'alumini_statistics_count',
        __('Statistic Count', 'alumini'),
        'alumini_statistics_count_meta_box_callback',
        'statistics',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'alumini_statistics_add_count_meta_box');

function alumini_statistics_count_meta_box_callback($post) {
    wp_nonce_field('alumini_save_stat_count', 'alumini_stat_count_nonce');

    $stat_count = get_post_meta($post->ID, 'stat_count', true);
    ?>
    <p>
        <label for="alumini_stat_count"><strong><?php echo esc_html__('Count', 'alumini'); ?></strong></label>
        <input
            type="text"
            id="alumini_stat_count"
            name="alumini_stat_count"
            value="<?php echo esc_attr($stat_count); ?>"
            style="width:100%;"
            placeholder="<?php echo esc_attr__('e.g. 3,491 or TOP 4', 'alumini'); ?>"
        />
    </p>
    <?php
}

function alumini_statistics_save_count_meta($post_id) {
    if (!isset($_POST['alumini_stat_count_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['alumini_stat_count_nonce'])), 'alumini_save_stat_count')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if ('statistics' !== get_post_type($post_id)) {
        return;
    }

    if (isset($_POST['alumini_stat_count'])) {
        $value = sanitize_text_field(wp_unslash($_POST['alumini_stat_count']));
        update_post_meta($post_id, 'stat_count', $value);
    }
}
add_action('save_post', 'alumini_statistics_save_count_meta');

// ===============================
// STATS SECTION META BOX (PAGE)
// ===============================
function alumini_stats_section_meta_box() {
    add_meta_box(
        'alumini_stats_section',
        'Statistics Section',
        'alumini_stats_section_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'alumini_stats_section_meta_box');

// ===============================
// CASE STUDY SELECTION (FRONT PAGE)
// ===============================
function alumini_casestudy_section_meta_boxes() {
    add_meta_box(
        'alumini_casestudy_images',
        __('Case Studies (Images)', 'alumini'),
        'alumini_casestudy_images_meta_box_callback',
        'page',
        'normal',
        'high'
    );

    add_meta_box(
        'alumini_casestudy_videos',
        __('Case Studies (Videos)', 'alumini'),
        'alumini_casestudy_videos_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'alumini_casestudy_section_meta_boxes');

function alumini_render_casestudy_picker($post, $box_id, $meta_key, $term_slug) {
    $front_page_id = (int) get_option('page_on_front');
    if ($front_page_id && (int) $post->ID !== $front_page_id) {
        echo '<p>' . esc_html__('This meta box is intended for the current Front Page only.', 'alumini') . '</p>';
        return;
    }

    $selected = get_post_meta($post->ID, $meta_key, true);
    $selected = is_array($selected) ? array_values(array_filter($selected)) : array();
    $selected = array_values(array_unique(array_filter(array_map('intval', $selected))));
    $selected = array_slice($selected, 0, 3);

    $available = get_posts(
        array(
            'post_type'      => 'casestudy',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => array(
                'menu_order' => 'ASC',
                'date'       => 'DESC',
            ),
            'tax_query'      => array(
                array(
                    'taxonomy' => 'casestudy_category',
                    'field'    => 'slug',
                    'terms'    => array($term_slug),
                ),
            ),
            'fields'         => 'ids',
        )
    );
    ?>
    <div class="alumini-post-picker" data-max="3" data-selected-input="<?php echo esc_attr($box_id . '_input'); ?>">
        <div style="display:flex; gap:20px; align-items:flex-start;">
            <div style="width:45%;">
                <h4 style="margin-top:0;"><?php echo esc_html__('Available', 'alumini'); ?></h4>
                <p style="margin-top:0;">
                    <input type="search" class="alumini-post-search" placeholder="<?php echo esc_attr__('Search…', 'alumini'); ?>" style="width:100%;">
                </p>
                <ul class="alumini-post-available" style="border:1px solid #ccd0d4; padding:8px; margin:0; max-height:280px; overflow:auto;">
                    <?php foreach ($available as $id) :
                        $id = (int) $id;
                        $title = get_the_title($id);
                        $title = $title ? $title : sprintf(__('(no title) #%d', 'alumini'), $id);
                        $is_selected = in_array($id, $selected, true);
                        ?>
                        <li
                            class="alumini-post-item <?php echo $is_selected ? 'is-selected' : ''; ?>"
                            data-id="<?php echo esc_attr((string) $id); ?>"
                            data-title="<?php echo esc_attr(wp_strip_all_tags($title)); ?>"
                            style="display:flex; justify-content:space-between; gap:10px; padding:6px 8px; border:1px solid #e5e5e5; background:#fff; margin:0 0 6px; cursor:pointer;"
                        >
                            <span><?php echo esc_html($title); ?></span>
                            <span class="alumini-post-hint" style="color:#646970;">
                                <?php echo $is_selected ? esc_html__('Selected', 'alumini') : esc_html__('Click to add', 'alumini'); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div style="width:55%;">
                <h4 style="margin-top:0;"><?php echo esc_html__('Selected (Max 3)', 'alumini'); ?></h4>
                <ul class="alumini-post-selected" style="border:1px solid #ccd0d4; padding:8px; margin:0; min-height:120px;">
                    <?php foreach ($selected as $id) :
                        $title = get_the_title($id);
                        if (!$title) {
                            continue;
                        }
                        ?>
                        <li
                            class="alumini-selected-item"
                            data-id="<?php echo esc_attr((string) $id); ?>"
                            style="display:flex; justify-content:space-between; gap:10px; padding:6px 8px; border:1px solid #e5e5e5; background:#fff; margin:0 0 6px; cursor:move;"
                        >
                            <span class="alumini-selected-title"><?php echo esc_html($title); ?></span>
                            <button type="button" class="button-link-delete alumini-remove-item" aria-label="<?php echo esc_attr__('Remove', 'alumini'); ?>">
                                <?php echo esc_html__('Remove', 'alumini'); ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <input
                    type="hidden"
                    id="<?php echo esc_attr($box_id . '_input'); ?>"
                    name="<?php echo esc_attr($box_id . '_selected'); ?>"
                    value="<?php echo esc_attr(implode(',', $selected)); ?>"
                />
                <p class="description" style="margin-top:8px;">
                    <?php echo esc_html__('Tip: drag to reorder. Click an item on the left to add it.', 'alumini'); ?>
                </p>
            </div>
        </div>
    </div>
    <?php
}

function alumini_casestudy_images_meta_box_callback($post) {
    wp_nonce_field('alumini_save_casestudy_sections', 'alumini_casestudy_sections_nonce');

    $title = get_post_meta($post->ID, '_casestudy_images_title', true);
    $bg    = get_post_meta($post->ID, '_casestudy_section_bg_color', true);
    ?>
    <p>
        <label for="alumini_casestudy_section_bg"><strong><?php echo esc_html__('Section Background Color', 'alumini'); ?></strong></label><br>
        <input
            type="text"
            class="alumini-color-field"
            id="alumini_casestudy_section_bg"
            name="alumini_casestudy_section_bg"
            value="<?php echo esc_attr($bg); ?>"
            data-default-color=""
        />
    </p>
    <p>
        <label for="alumini_casestudy_images_title"><strong><?php echo esc_html__('Title (Success snapshots)', 'alumini'); ?></strong></label><br>
        <input type="text" id="alumini_casestudy_images_title" name="alumini_casestudy_images_title" value="<?php echo esc_attr($title); ?>" style="width:100%;">
    </p>
    <hr>
    <?php

    alumini_render_casestudy_picker($post, 'alumini_casestudy_images', '_selected_image_casestudies', 'image-casestudy');
}

function alumini_casestudy_videos_meta_box_callback($post) {
    wp_nonce_field('alumini_save_casestudy_sections', 'alumini_casestudy_sections_nonce');

    $title = get_post_meta($post->ID, '_casestudy_videos_title', true);
    ?>
    <p>
        <label for="alumini_casestudy_videos_title"><strong><?php echo esc_html__('Title (Voices of our alumni)', 'alumini'); ?></strong></label><br>
        <input type="text" id="alumini_casestudy_videos_title" name="alumini_casestudy_videos_title" value="<?php echo esc_attr($title); ?>" style="width:100%;">
    </p>
    <hr>
    <?php

    alumini_render_casestudy_picker($post, 'alumini_casestudy_videos', '_selected_video_casestudies', 'video-casestudy');
}

function alumini_save_casestudy_sections($post_id) {
    if (!isset($_POST['alumini_casestudy_sections_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['alumini_casestudy_sections_nonce'])), 'alumini_save_casestudy_sections')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array(
        'alumini_casestudy_images_selected' => '_selected_image_casestudies',
        'alumini_casestudy_videos_selected' => '_selected_video_casestudies',
    );

    foreach ($fields as $post_field => $meta_key) {
        if (!isset($_POST[$post_field])) {
            delete_post_meta($post_id, $meta_key);
            continue;
        }
        $raw = sanitize_text_field(wp_unslash($_POST[$post_field]));
        $ids = array_filter(array_map('intval', explode(',', $raw)));
        $ids = array_values(array_unique($ids));
        $ids = array_slice($ids, 0, 3);
        update_post_meta($post_id, $meta_key, $ids);
    }

    $images_title = sanitize_text_field(wp_unslash($_POST['alumini_casestudy_images_title'] ?? ''));
    update_post_meta($post_id, '_casestudy_images_title', $images_title);

    $videos_title = sanitize_text_field(wp_unslash($_POST['alumini_casestudy_videos_title'] ?? ''));
    update_post_meta($post_id, '_casestudy_videos_title', $videos_title);

    $bg = sanitize_text_field(wp_unslash($_POST['alumini_casestudy_section_bg'] ?? ''));
    $bg = sanitize_hex_color($bg);
    update_post_meta($post_id, '_casestudy_section_bg_color', $bg ? $bg : '');
}
add_action('save_post', 'alumini_save_casestudy_sections');

function alumini_stats_section_callback($post) {

    wp_nonce_field('alumini_save_stats_section', 'alumini_stats_section_nonce');

    $front_page_id = (int) get_option('page_on_front');
    if ($front_page_id && (int) $post->ID !== $front_page_id) {
        echo '<p>' . esc_html__('This meta box is intended for the current Front Page only. Set this page as your Front Page in Settings → Reading to use it.', 'alumini') . '</p>';
        return;
    }

    $selected_stats = get_post_meta($post->ID, '_selected_stats', true);
    $selected_stats = is_array($selected_stats) ? array_values(array_filter($selected_stats)) : array();

    $stats_bg_color = get_post_meta($post->ID, '_stats_bg_color', true);
    $stats_bg_color = $stats_bg_color ? $stats_bg_color : '';

    $available_stats = get_posts(
        array(
            'post_type'      => 'statistics',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => array(
                'menu_order' => 'ASC',
                'title'      => 'ASC',
            ),
            'fields'         => 'ids',
        )
    );

    $selected_ids_int = array_map('intval', $selected_stats);
    $selected_ids_int = array_values(array_unique(array_filter($selected_ids_int)));
    ?>

    <p>
        <label for="alumini_stats_bg_color"><strong><?php echo esc_html__('Section Background Color', 'alumini'); ?></strong></label><br>
        <input
            type="text"
            class="alumini-color-field"
            id="alumini_stats_bg_color"
            name="stats_bg_color"
            value="<?php echo esc_attr($stats_bg_color); ?>"
            data-default-color=""
        />
    </p>

    <div class="alumini-stats-picker" style="display:flex; gap:20px; align-items:flex-start;">
        <div style="width:45%;">
            <h4 style="margin-top:0;"><?php echo esc_html__('Available Statistics', 'alumini'); ?></h4>

            <p style="margin-top:0;">
                <input
                    type="search"
                    class="alumini-stats-search"
                    placeholder="<?php echo esc_attr__('Search statistics…', 'alumini'); ?>"
                    style="width:100%;"
                />
            </p>

            <ul class="alumini-stats-available" style="border:1px solid #ccd0d4; padding:8px; margin:0; max-height:280px; overflow:auto;">
                <?php
                foreach ($available_stats as $stat_id) :
                    $stat_id = (int) $stat_id;
                    $title   = get_the_title($stat_id);
                    if (!$title) {
                        $title = sprintf(__('(no title) #%d', 'alumini'), $stat_id);
                    }
                    $is_selected = in_array($stat_id, $selected_ids_int, true);
                    ?>
                    <li
                        class="alumini-stat-item <?php echo $is_selected ? 'is-selected' : ''; ?>"
                        data-id="<?php echo esc_attr((string) $stat_id); ?>"
                        data-title="<?php echo esc_attr(wp_strip_all_tags($title)); ?>"
                        style="display:flex; justify-content:space-between; gap:10px; padding:6px 8px; border:1px solid #e5e5e5; background:#fff; margin:0 0 6px; cursor:pointer;"
                    >
                        <span><?php echo esc_html($title); ?></span>
                        <span class="alumini-stat-hint" style="color:#646970;">
                            <?php echo $is_selected ? esc_html__('Selected', 'alumini') : esc_html__('Click to add', 'alumini'); ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div style="width:55%;">
            <h4 style="margin-top:0;"><?php echo esc_html__('Selected Statistics (Max 4)', 'alumini'); ?></h4>

            <ul id="alumini-selected-stats" class="alumini-stats-selected" style="border:1px solid #ccd0d4; padding:8px; margin:0; min-height:120px;">
                <?php
                foreach ($selected_ids_int as $stat_id) :
                    $title = get_the_title($stat_id);
                    if (!$title) {
                        continue;
                    }
                    ?>
                    <li
                        class="alumini-selected-item"
                        data-id="<?php echo esc_attr((string) $stat_id); ?>"
                        style="display:flex; justify-content:space-between; gap:10px; padding:6px 8px; border:1px solid #e5e5e5; background:#fff; margin:0 0 6px; cursor:move;"
                    >
                        <span class="alumini-selected-title"><?php echo esc_html($title); ?></span>
                        <button type="button" class="button-link-delete alumini-remove-stat" aria-label="<?php echo esc_attr__('Remove', 'alumini'); ?>">
                            <?php echo esc_html__('Remove', 'alumini'); ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <input
                type="hidden"
                name="selected_stats"
                id="alumini_selected_stats_input"
                value="<?php echo esc_attr(implode(',', $selected_ids_int)); ?>"
            />

            <p class="description" style="margin-top:8px;">
                <?php echo esc_html__('Tip: drag to reorder. Click an item on the left to add it.', 'alumini'); ?>
            </p>
        </div>
    </div>

    <?php
}
function alumini_save_stats_section($post_id) {

    if (!isset($_POST['alumini_stats_section_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['alumini_stats_section_nonce'])), 'alumini_save_stats_section')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['selected_stats'])) {
        $raw = sanitize_text_field(wp_unslash($_POST['selected_stats']));
        $ids = array_filter(array_map('intval', explode(',', $raw)));
        $ids = array_values(array_unique($ids));
        $ids = array_slice($ids, 0, 4);
        update_post_meta($post_id, '_selected_stats', $ids);
    } else {
        delete_post_meta($post_id, '_selected_stats');
    }

    if (isset($_POST['stats_bg_color'])) {
        $color = sanitize_text_field(wp_unslash($_POST['stats_bg_color']));
        $color = sanitize_hex_color($color);
        if (!$color) {
            $color = '';
        }
        update_post_meta($post_id, '_stats_bg_color', $color);
    }
}
add_action('save_post', 'alumini_save_stats_section');

// ===============================
// BENEFITS & SERVICES (PAGE)
// ===============================
function alumini_benefits_section_meta_box() {
    add_meta_box(
        'alumini_benefits_section',
        __('Benefits & Services', 'alumini'),
        'alumini_benefits_section_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'alumini_benefits_section_meta_box');

function alumini_benefits_section_callback($post) {
    wp_nonce_field('alumini_save_benefits_section', 'alumini_benefits_section_nonce');

    $front_page_id = (int) get_option('page_on_front');
    if ($front_page_id && (int) $post->ID !== $front_page_id) {
        echo '<p>' . esc_html__('This meta box is intended for the current Front Page only.', 'alumini') . '</p>';
        return;
    }

    $section_title = get_post_meta($post->ID, '_benefits_section_title', true);
    $section_desc  = get_post_meta($post->ID, '_benefits_section_desc', true);
    $bg_color      = get_post_meta($post->ID, '_benefits_bg_color', true);

    $items = get_post_meta($post->ID, '_benefits_items', true);
    $items = is_array($items) ? $items : array();
    ?>
    <p>
        <label for="alumini_benefits_bg_color"><strong><?php echo esc_html__('Section Background Color', 'alumini'); ?></strong></label><br>
        <input
            type="text"
            class="alumini-color-field"
            id="alumini_benefits_bg_color"
            name="alumini_benefits_bg_color"
            value="<?php echo esc_attr($bg_color); ?>"
            data-default-color=""
        />
    </p>

    <p>
        <label for="alumini_benefits_title"><strong><?php echo esc_html__('Section Title', 'alumini'); ?></strong></label><br>
        <input type="text" id="alumini_benefits_title" name="alumini_benefits_title" value="<?php echo esc_attr($section_title); ?>" style="width:100%;">
    </p>

    <p>
        <label for="alumini_benefits_desc"><strong><?php echo esc_html__('Section Description', 'alumini'); ?></strong></label><br>
        <textarea id="alumini_benefits_desc" name="alumini_benefits_desc" style="width:100%; min-height:90px;"><?php echo esc_textarea($section_desc); ?></textarea>
    </p>

    <hr>

    <div class="alumini-benefits-repeater" style="display:flex; flex-direction:column; gap:12px;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h4 style="margin:0;"><?php echo esc_html__('Benefit Boxes', 'alumini'); ?></h4>
            <button type="button" class="button alumini-add-benefit"><?php echo esc_html__('Add Box', 'alumini'); ?></button>
        </div>

        <div class="alumini-benefits-items">
            <?php foreach ($items as $index => $item) :
                $icon  = isset($item['icon']) ? (string) $item['icon'] : '';
                $title = isset($item['title']) ? (string) $item['title'] : '';
                $desc  = isset($item['desc']) ? (string) $item['desc'] : '';
                $link  = isset($item['link']) ? (string) $item['link'] : '';
                ?>
                <div class="alumini-benefit-item" style="border:1px solid #ccd0d4; padding:12px; background:#fff;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong><?php echo esc_html__('Box', 'alumini'); ?> <span class="alumini-benefit-index"><?php echo esc_html((string) ((int) $index + 1)); ?></span></strong>
                        <button type="button" class="button-link-delete alumini-remove-benefit"><?php echo esc_html__('Remove', 'alumini'); ?></button>
                    </div>

                    <p>
                        <label><strong><?php echo esc_html__('Icon', 'alumini'); ?></strong></label><br>
                        <input type="text" class="regular-text alumini-benefit-icon" name="benefits_items[<?php echo esc_attr((string) $index); ?>][icon]" value="<?php echo esc_attr($icon); ?>" style="width:70%;">
                        <button type="button" class="button upload_image_button"><?php echo esc_html__('Upload', 'alumini'); ?></button>
                    </p>

                    <p>
                        <label><strong><?php echo esc_html__('Link Title', 'alumini'); ?></strong></label><br>
                        <input type="text" class="regular-text" name="benefits_items[<?php echo esc_attr((string) $index); ?>][title]" value="<?php echo esc_attr($title); ?>" style="width:100%;">
                    </p>

                    <p>
                        <label><strong><?php echo esc_html__('Link URL', 'alumini'); ?></strong></label><br>
                        <input type="url" class="regular-text" name="benefits_items[<?php echo esc_attr((string) $index); ?>][link]" value="<?php echo esc_attr($link); ?>" style="width:100%;" placeholder="https://">
                    </p>

                    <p>
                        <label><strong><?php echo esc_html__('Description', 'alumini'); ?></strong></label><br>
                        <textarea name="benefits_items[<?php echo esc_attr((string) $index); ?>][desc]" style="width:100%; min-height:80px;"><?php echo esc_textarea($desc); ?></textarea>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>

        <script type="text/html" id="tmpl-alumini-benefit-item">
            <div class="alumini-benefit-item" style="border:1px solid #ccd0d4; padding:12px; background:#fff;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <strong><?php echo esc_html__('Box', 'alumini'); ?> <span class="alumini-benefit-index">__INDEX_LABEL__</span></strong>
                    <button type="button" class="button-link-delete alumini-remove-benefit"><?php echo esc_html__('Remove', 'alumini'); ?></button>
                </div>

                <p>
                    <label><strong><?php echo esc_html__('Icon', 'alumini'); ?></strong></label><br>
                    <input type="text" class="regular-text alumini-benefit-icon" name="benefits_items[__INDEX__][icon]" value="" style="width:70%;">
                    <button type="button" class="button upload_image_button"><?php echo esc_html__('Upload', 'alumini'); ?></button>
                </p>

                <p>
                    <label><strong><?php echo esc_html__('Link Title', 'alumini'); ?></strong></label><br>
                    <input type="text" class="regular-text" name="benefits_items[__INDEX__][title]" value="" style="width:100%;">
                </p>

                <p>
                    <label><strong><?php echo esc_html__('Link URL', 'alumini'); ?></strong></label><br>
                    <input type="url" class="regular-text" name="benefits_items[__INDEX__][link]" value="" style="width:100%;" placeholder="https://">
                </p>

                <p>
                    <label><strong><?php echo esc_html__('Description', 'alumini'); ?></strong></label><br>
                    <textarea name="benefits_items[__INDEX__][desc]" style="width:100%; min-height:80px;"></textarea>
                </p>
            </div>
        </script>
    </div>
    <?php
}

function alumini_save_benefits_section($post_id) {
    if (!isset($_POST['alumini_benefits_section_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['alumini_benefits_section_nonce'])), 'alumini_save_benefits_section')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    update_post_meta($post_id, '_benefits_section_title', sanitize_text_field(wp_unslash($_POST['alumini_benefits_title'] ?? '')));
    update_post_meta($post_id, '_benefits_section_desc', sanitize_textarea_field(wp_unslash($_POST['alumini_benefits_desc'] ?? '')));
    $bg_color = sanitize_text_field(wp_unslash($_POST['alumini_benefits_bg_color'] ?? ''));
    $bg_color = sanitize_hex_color($bg_color);
    update_post_meta($post_id, '_benefits_bg_color', $bg_color ? $bg_color : '');

    $items = array();
    if (isset($_POST['benefits_items']) && is_array($_POST['benefits_items'])) {
        foreach ($_POST['benefits_items'] as $item) {
            if (!is_array($item)) {
                continue;
            }
            $icon  = isset($item['icon']) ? esc_url_raw(wp_unslash($item['icon'])) : '';
            $title = isset($item['title']) ? sanitize_text_field(wp_unslash($item['title'])) : '';
            $desc  = isset($item['desc']) ? sanitize_textarea_field(wp_unslash($item['desc'])) : '';
            $link  = isset($item['link']) ? esc_url_raw(wp_unslash($item['link'])) : '';

            // Skip fully empty rows.
            if ('' === $icon && '' === $title && '' === $desc && '' === $link) {
                continue;
            }

            $items[] = array(
                'icon'  => $icon,
                'title' => $title,
                'desc'  => $desc,
                'link'  => $link,
            );
        }
    }
    update_post_meta($post_id, '_benefits_items', $items);
}
add_action('save_post', 'alumini_save_benefits_section');

// ===============================
// NEXT SECTION (PAGE)
// ===============================
function alumini_next_section_meta_box() {
    add_meta_box(
        'alumini_next_section',
        __('Next Section', 'alumini'),
        'alumini_next_section_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'alumini_next_section_meta_box');

function alumini_next_section_callback($post) {
    wp_nonce_field('alumini_save_next_section', 'alumini_next_section_nonce');

    $front_page_id = (int) get_option('page_on_front');
    if ($front_page_id && (int) $post->ID !== $front_page_id) {
        echo '<p>' . esc_html__('This meta box is intended for the current Front Page only.', 'alumini') . '</p>';
        return;
    }

    $title     = get_post_meta($post->ID, '_next_section_title', true);
    $subtitle  = get_post_meta($post->ID, '_next_section_subtitle', true);
    $image     = get_post_meta($post->ID, '_next_section_image', true);
    $btn_text  = get_post_meta($post->ID, '_next_section_btn_text', true);
    $btn_link  = get_post_meta($post->ID, '_next_section_btn_link', true);
    $btn_newtab = get_post_meta($post->ID, '_next_section_btn_target', true);

    $items = get_post_meta($post->ID, '_next_section_desc_items', true);
    $items = is_array($items) ? $items : array();
    ?>
 <p>
    <label for="alumini_next_bg_color">
        <strong><?php echo esc_html__('Section Background Color', 'alumini'); ?></strong>
    </label><br>

    <?php
    $next_bg_color = get_post_meta($post->ID, '_next_bg_color', true);
    ?>

    <input
        type="text"
        class="alumini-color-field"
        id="alumini_next_bg_color"
        name="next_bg_color"
        value="<?php echo esc_attr($next_bg_color); ?>"
        data-default-color=""
    />
</p>
    <p>
        <label for="alumini_next_section_title"><strong><?php echo esc_html__('Title', 'alumini'); ?></strong></label><br>
        <input type="text" id="alumini_next_section_title" name="alumini_next_section_title" value="<?php echo esc_attr($title); ?>" style="width:100%;">
    </p>

    <p>
        <label for="alumini_next_section_subtitle"><strong><?php echo esc_html__('Subtitle', 'alumini'); ?></strong></label><br>
        <textarea id="alumini_next_section_subtitle" name="alumini_next_section_subtitle" style="width:100%; min-height:70px;"><?php echo esc_textarea($subtitle); ?></textarea>
    </p>

    <p>
        <label for="alumini_next_section_image"><strong><?php echo esc_html__('Image', 'alumini'); ?></strong></label><br>
        <input type="text" id="alumini_next_section_image" name="alumini_next_section_image" value="<?php echo esc_attr($image); ?>" style="width:70%;">
        <button type="button" class="button upload_image_button"><?php echo esc_html__('Upload', 'alumini'); ?></button>
    </p>

    <p>
        <label for="alumini_next_section_btn_text"><strong><?php echo esc_html__('Button text', 'alumini'); ?></strong></label><br>
        <input type="text" id="alumini_next_section_btn_text" name="alumini_next_section_btn_text" value="<?php echo esc_attr($btn_text); ?>" style="width:100%;">
    </p>

    <p>
        <label for="alumini_next_section_btn_link"><strong><?php echo esc_html__('Button link', 'alumini'); ?></strong></label><br>
        <input type="url" id="alumini_next_section_btn_link" name="alumini_next_section_btn_link" value="<?php echo esc_attr($btn_link); ?>" style="width:100%;" placeholder="https://">
    </p>

    <p>
        <label>
            <input type="checkbox" name="alumini_next_section_btn_target" <?php checked($btn_newtab, 'on'); ?>>
            <?php echo esc_html__('Open in new tab', 'alumini'); ?>
        </label>
    </p>

    <hr>

    <div class="alumini-next-desc-repeater" style="display:flex; flex-direction:column; gap:12px;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h4 style="margin:0;"><?php echo esc_html__('Description blocks', 'alumini'); ?></h4>
            <button type="button" class="button alumini-add-next-desc"><?php echo esc_html__('Add description', 'alumini'); ?></button>
        </div>

        <div class="alumini-next-desc-items">
            <?php foreach ($items as $index => $html) :
                $html = is_string($html) ? $html : '';
                ?>
                <div class="alumini-next-desc-item" style="border:1px solid #ccd0d4; padding:12px; background:#fff;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong><?php echo esc_html__('Block', 'alumini'); ?> <span class="alumini-next-desc-index"><?php echo esc_html((string) ((int) $index + 1)); ?></span></strong>
                        <button type="button" class="button-link-delete alumini-remove-next-desc"><?php echo esc_html__('Remove', 'alumini'); ?></button>
                    </div>
                    <p class="description" style="margin-top:8px;">
                        <?php echo esc_html__('Basic HTML allowed (e.g. <strong>, <em>, <a>).', 'alumini'); ?>
                    </p>
                    <textarea name="next_desc_items[<?php echo esc_attr((string) $index); ?>]" style="width:100%; min-height:90px;"><?php echo esc_textarea($html); ?></textarea>
                </div>
            <?php endforeach; ?>
        </div>

        <script type="text/html" id="tmpl-alumini-next-desc-item">
            <div class="alumini-next-desc-item" style="border:1px solid #ccd0d4; padding:12px; background:#fff;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <strong><?php echo esc_html__('Block', 'alumini'); ?> <span class="alumini-next-desc-index">__INDEX_LABEL__</span></strong>
                    <button type="button" class="button-link-delete alumini-remove-next-desc"><?php echo esc_html__('Remove', 'alumini'); ?></button>
                </div>
                <p class="description" style="margin-top:8px;">
                    <?php echo esc_html__('Basic HTML allowed (e.g. <strong>, <em>, <a>).', 'alumini'); ?>
                </p>
                <textarea name="next_desc_items[__INDEX__]" style="width:100%; min-height:90px;"></textarea>
            </div>
        </script>
    </div>

    <?php
}

function alumini_save_next_section($post_id) {
     // Save BG color
    if (isset($_POST['next_bg_color'])) {
        update_post_meta(
            $post_id,
            '_next_bg_color',
            sanitize_hex_color($_POST['next_bg_color'])
        );
    }
    if (!isset($_POST['alumini_next_section_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['alumini_next_section_nonce'])), 'alumini_save_next_section')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    update_post_meta($post_id, '_next_section_title', sanitize_text_field(wp_unslash($_POST['alumini_next_section_title'] ?? '')));
    update_post_meta($post_id, '_next_section_subtitle', sanitize_textarea_field(wp_unslash($_POST['alumini_next_section_subtitle'] ?? '')));
    update_post_meta($post_id, '_next_section_image', esc_url_raw(wp_unslash($_POST['alumini_next_section_image'] ?? '')));
    update_post_meta($post_id, '_next_section_btn_text', sanitize_text_field(wp_unslash($_POST['alumini_next_section_btn_text'] ?? '')));
    update_post_meta($post_id, '_next_section_btn_link', esc_url_raw(wp_unslash($_POST['alumini_next_section_btn_link'] ?? '')));
    update_post_meta($post_id, '_next_section_btn_target', isset($_POST['alumini_next_section_btn_target']) ? 'on' : '');

    $items = array();
    if (isset($_POST['next_desc_items']) && is_array($_POST['next_desc_items'])) {
        foreach ($_POST['next_desc_items'] as $html) {
            $html = is_string($html) ? wp_unslash($html) : '';
            $html = wp_kses_post($html);
            if ('' === trim(wp_strip_all_tags($html))) {
                continue;
            }
            $items[] = $html;
        }
    }
    update_post_meta($post_id, '_next_section_desc_items', $items);
}
add_action('save_post', 'alumini_save_next_section');

// ===============================
// NEWS SECTION META BOX
// ===============================
function alumini_news_meta_box() {
    add_meta_box(
        'alumini_news_section',
        'Latest News Section',
        'alumini_news_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'alumini_news_meta_box');
function alumini_news_callback($post) {

    wp_nonce_field('alumini_save_meta', 'alumini_nonce');

    $news_title = get_post_meta($post->ID, '_news_section_title', true);
   
    ?>

    <p>
        <label><strong>Section Title</strong></label><br>
        <input type="text" name="news_section_title"
               value="<?php echo esc_attr($news_title); ?>"
               style="width:100%;">
    </p>

    <p>
    <label for="alumini_news_bg_color">
        <strong><?php echo esc_html__('Section Background Color', 'alumini'); ?></strong>
    </label><br>

    <?php
    $news_bg_color = get_post_meta($post->ID, '_news_bg_color', true);
    ?>

    <input
        type="text"
        class="alumini-color-field"
        id="alumini_news_bg_color"
        name="news_bg_color"
        value="<?php echo esc_attr($news_bg_color); ?>"
        data-default-color=""
    />
</p>

    <?php
}
function alumini_save_news_meta($post_id) {
      // Save BG color
    if (isset($_POST['news_bg_color'])) {
        update_post_meta(
            $post_id,
            '_news_bg_color',
            sanitize_hex_color($_POST['news_bg_color'])
        );
    }

    if (!isset($_POST['alumini_nonce']) || !wp_verify_nonce($_POST['alumini_nonce'], 'alumini_save_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['news_section_title'])) {
        update_post_meta($post_id, '_news_section_title', sanitize_text_field($_POST['news_section_title']));
    }

   
}
add_action('save_post', 'alumini_save_news_meta');

// ===============================
// QUICK LINKS CPT
// ===============================
function alumini_register_quicklinks_cpt() {

    $args = array(
        'label' => 'Quick Links',
        'public' => true,
        'menu_icon' => 'dashicons-admin-links',
        'supports' => array('title', 'editor', 'page-attributes'),
        'show_in_rest' => true,
    );

    register_post_type('quicklinks', $args);
}
add_action('init', 'alumini_register_quicklinks_cpt');

// Quick Links Meta Box
function alumini_quicklinks_meta_box() {
    add_meta_box(
        'alumini_quicklinks_fields',
        'Quick Link Details',
        'alumini_quicklinks_callback',
        'quicklinks',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'alumini_quicklinks_meta_box');

function alumini_quicklinks_callback($post) {

    wp_nonce_field('alumini_save_meta', 'alumini_nonce');

    $link = get_post_meta($post->ID, '_quicklink_url', true);
    ?>

    <p>
        <label><strong>Link URL</strong></label><br>
        <input type="text" name="quicklink_url"
               value="<?php echo esc_attr($link); ?>"
               style="width:100%;">
    </p>

    <?php
}
function alumini_save_quicklinks_meta($post_id) {

    if (!isset($_POST['alumini_nonce']) || !wp_verify_nonce($_POST['alumini_nonce'], 'alumini_save_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['quicklink_url'])) {
        update_post_meta($post_id, '_quicklink_url', esc_url_raw($_POST['quicklink_url']));
    }
}
add_action('save_post', 'alumini_save_quicklinks_meta');
// ===============================
// QUICK LINKS SECTION META BOX
// ===============================
function alumini_quicklinks_section_meta_box() {
    add_meta_box(
        'alumini_quicklinks_section',
        'Quick Links Section',
        'alumini_quicklinks_section_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'alumini_quicklinks_section_meta_box');
function alumini_quicklinks_section_callback($post) {

    wp_nonce_field('alumini_save_meta', 'alumini_nonce');
    $selected = get_post_meta($post->ID, '_selected_quicklinks', true);
    $selected = is_array($selected) ? $selected : [];

    $items = get_posts([
        'post_type' => 'quicklinks',
        'numberposts' => -1
    ]);
?>
 <p>
    <label for="alumini_quicklinks_bg_color">
        <strong><?php echo esc_html__('Section Background Color', 'alumini'); ?></strong>
    </label><br>

    <?php
    $quicklinks_bg_color = get_post_meta($post->ID, '_quicklinks_bg_color', true);
    ?>

    <input
        type="text"
        class="alumini-color-field"
        id="alumini_quicklinks_bg_color"
        name="quicklinks_bg_color"
        value="<?php echo esc_attr($quicklinks_bg_color); ?>"
        data-default-color=""
    />
</p>
<div style="display:flex; gap:20px;">

    <!-- LEFT -->
    <div style="width:45%;">
        <h4>Available Links</h4>

        <ul id="available-quicklinks" style="border:1px solid #ccc; padding:10px;">
            <?php foreach($items as $item): ?>
                <li data-id="<?php echo $item->ID; ?>" style="cursor:pointer;">
                    <?php echo esc_html($item->post_title); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- RIGHT -->
    <div style="width:55%;">
        <h4>Selected Links (Max 3)</h4>

        <ul id="selected-quicklinks" style="border:1px solid #ccc; min-height:120px; padding:10px;">
            <?php foreach($selected as $id): ?>
                <li data-id="<?php echo $id; ?>">
                    <?php echo esc_html(get_the_title($id)); ?>
                    <span class="remove-link" style="float:right;cursor:pointer;color:red;">×</span>
                </li>
            <?php endforeach; ?>
        </ul>

        <input type="hidden" name="selected_quicklinks" id="selected_quicklinks_input"
               value="<?php echo esc_attr(implode(',', $selected)); ?>">
    </div>

</div>

<?php
}
function alumini_save_quicklinks_section($post_id) {

    // Security FIRST
    if (!isset($_POST['alumini_nonce']) || !wp_verify_nonce($_POST['alumini_nonce'], 'alumini_save_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    // Save BG color
    if (isset($_POST['quicklinks_bg_color'])) {
        update_post_meta(
            $post_id,
            '_quicklinks_bg_color',
            sanitize_hex_color($_POST['quicklinks_bg_color'])
        );
    }

    // Save selected posts
    if (isset($_POST['selected_quicklinks'])) {
        $ids = array_filter(explode(',', $_POST['selected_quicklinks']));
        update_post_meta($post_id, '_selected_quicklinks', $ids);
    }
}
add_action('save_post', 'alumini_save_quicklinks_section');

// ===============================
// PROSPECTUS CPT
// ===============================
function alumini_register_prospectus_cpt() {

    $args = array(
        'label' => 'Prospectus',
        'public' => true,
        'menu_icon' => 'dashicons-media-document',
        'supports' => array('title', 'editor'),
        'show_in_rest' => true,
    );

    register_post_type('prospectus', $args);
}
add_action('init', 'alumini_register_prospectus_cpt');
function alumini_prospectus_meta_box() {
    add_meta_box(
        'alumini_prospectus_fields',
        'Prospectus Details',
        'alumini_prospectus_callback',
        'prospectus',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'alumini_prospectus_meta_box');
function alumini_prospectus_callback($post) {

    wp_nonce_field('alumini_save_meta', 'alumini_nonce');

    $svg  = get_post_meta($post->ID, '_prospectus_svg', true);
    $link = get_post_meta($post->ID, '_prospectus_link', true);
?>

<p>
    <label><strong>SVG Code</strong></label><br>
    <textarea name="prospectus_svg" style="width:100%; height:120px;"><?php echo esc_textarea($svg); ?></textarea>
</p>

<p>
    <label><strong>Button Link</strong></label><br>
    <input type="text" name="prospectus_link"
           value="<?php echo esc_attr($link); ?>"
           style="width:100%;">
</p>

<?php
}
function alumini_save_prospectus_meta($post_id) {

    if (!isset($_POST['alumini_nonce']) || !wp_verify_nonce($_POST['alumini_nonce'], 'alumini_save_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['prospectus_svg'])) {
        update_post_meta($post_id, '_prospectus_svg', wp_kses_post($_POST['prospectus_svg']));
    }

    if (isset($_POST['prospectus_link'])) {
        update_post_meta($post_id, '_prospectus_link', esc_url_raw($_POST['prospectus_link']));
    }
}
add_action('save_post', 'alumini_save_prospectus_meta');
// ===============================
// PROSPECTUS SECTION SELECTION
// ===============================
function alumini_prospectus_section_meta_box() {
    add_meta_box(
        'alumini_prospectus_section',
        'Prospectus Section',
        'alumini_prospectus_section_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'alumini_prospectus_section_meta_box');
function alumini_prospectus_section_callback($post) {

    wp_nonce_field('alumini_save_meta', 'alumini_nonce');

    $selected = get_post_meta($post->ID, '_selected_prospectus', true);

    $items = get_posts([
        'post_type' => 'prospectus',
        'numberposts' => -1
    ]);
?>

<p><strong>Select Prospectus (Only One)</strong></p>

<ul id="available-prospectus" style="border:1px solid #ccc; padding:10px;">
    <?php foreach($items as $item): ?>
        <li data-id="<?php echo $item->ID; ?>" style="cursor:pointer;">
            <?php echo esc_html($item->post_title); ?>
        </li>
    <?php endforeach; ?>
</ul>

<p><strong>Selected</strong></p>

<ul id="selected-prospectus" style="border:1px solid #ccc; padding:10px;">
    <?php if($selected): ?>
        <li data-id="<?php echo $selected; ?>">
            <?php echo esc_html(get_the_title($selected)); ?>
            <span class="remove-prospectus" style="float:right;cursor:pointer;">×</span>
        </li>
    <?php endif; ?>
</ul>

<input type="hidden" name="selected_prospectus" id="selected_prospectus_input"
       value="<?php echo esc_attr($selected); ?>">

<?php
}
function alumini_save_prospectus_section($post_id) {

    if (!isset($_POST['alumini_nonce']) || !wp_verify_nonce($_POST['alumini_nonce'], 'alumini_save_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['selected_prospectus'])) {
        update_post_meta($post_id, '_selected_prospectus', intval($_POST['selected_prospectus']));
    }
}
add_action('save_post', 'alumini_save_prospectus_section');
function alumini_allow_svg_tags($tags, $context) {

    if ($context === 'post') {

        $tags['svg'] = [
            'xmlns' => true,
            'viewBox' => true,
            'width' => true,
            'height' => true
        ];

        $tags['path'] = [
            'd' => true,
            'fill' => true
        ];
    }

    return $tags;
}
add_filter('wp_kses_allowed_html', 'alumini_allow_svg_tags', 10, 2);