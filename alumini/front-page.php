<?php
get_header();

while (have_posts()) : the_post();

$hero_title    = get_post_meta(get_the_ID(), '_hero_title', true);
$hero_subtitle = get_post_meta(get_the_ID(), '_hero_subtitle', true);
$hero_bg       = get_post_meta(get_the_ID(), '_hero_bg', true);
?>
<main class="alumni-page">
<!-- HERO SECTION -->
<div class="rb-block-cover rb-backdrop rb-block-cover--py-0 bg-rb--color--charcoal rb-custom-career-section">
    <div class="rb-backdrop__inner">

        <?php if($hero_bg): ?>
        <picture class="rb-picture rb-backdrop__picture">
            <img src="<?php echo esc_url($hero_bg); ?>" class="rb-picture__image" alt="Hero Image" />
        </picture>
        <?php endif; ?>

        <div class="rb-block-container bg-rb--color--primary text-white">
            <div class="rb-backdrop__heading">
                <hgroup class="rb-lockupgroup">

                    <?php if($hero_title): ?>
                        <h1 class="rb-lockup alumni-lockup text-white">
                            <?php echo nl2br(esc_html($hero_title)); ?>
                        </h1>
                    <?php endif; ?>

                    <?php if($hero_subtitle): ?>
                        <p class="rb-lockup text-rb--font-size--xl normal-case">
                            <?php echo esc_html($hero_subtitle); ?>
                        </p>
                    <?php endif; ?>

                </hgroup>
            </div>
        </div>

    </div>
</div>

<?php
$current    = get_post_meta(get_the_ID(), '_about_current', true);

$title      = get_post_meta(get_the_ID(), '_about_title', true);
$subtitle   = get_post_meta(get_the_ID(), '_about_subtitle', true);
$desc       = get_post_meta(get_the_ID(), '_about_desc', true);
$image      = get_post_meta(get_the_ID(), '_about_image', true);

$btn_text   = get_post_meta(get_the_ID(), '_about_btn_text', true);
$btn_link   = get_post_meta(get_the_ID(), '_about_btn_link', true);
$btn_target = get_post_meta(get_the_ID(), '_about_btn_target', true);
$about_bg_color = get_post_meta(get_the_ID(), '_about_bg_color', true);
$about_bg_color = sanitize_hex_color($about_bg_color);
?>

<section class="rb-block-cover alumni-about rb-block-cover--pt-0"
    <?php echo $about_bg_color ? 'style="background-color: ' . esc_attr($about_bg_color) . ';"' : ''; ?>>

    <!-- Breadcrumb -->
 <nav class="rb-breadcrumbs rb-block-container">
    <ol class="rb-breadcrumbs__list">
        <li class="rb-breadcrumbs__list__home">
            <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="Home">
                Home
            </a>
        </li>
        <li>
            <?php echo esc_html($current); ?>
        </li>
    </ol>
</nav>

    <div class="rb-block-container">
        <div class="rb-top-level-page rb-content-flow">

            <header>
                <?php if($title): ?>
                    <h2><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if($subtitle): ?>
                    <p class="rb-summary"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
            </header>

            <article class="rb-top-level-page__content">

                <?php if($image): ?>
                <picture class="rb-picture">
                    <img src="<?php echo esc_url($image); ?>" class="rb-picture__image" />
                </picture>
                <?php endif; ?>

                <div class="rb-content-flow alumni-col-2">

                    <?php if($desc): ?>
                        <p><?php echo esc_html($desc); ?></p>
                    <?php endif; ?>

                    <?php if($btn_text && $btn_link): ?>
                        <a href="<?php echo esc_url($btn_link); ?>"
                           class="rb-button rb-button--secondary"
                           <?php echo ($btn_target === 'on') ? 'target="_blank"' : ''; ?>>
                           <?php echo esc_html($btn_text); ?>
                        </a>
                    <?php endif; ?>

                </div>

            </article>

        </div>
    </div>

</section>

<?php
$stats_bg_color = get_post_meta(get_the_ID(), '_stats_bg_color', true);
$stats_bg_color = sanitize_hex_color($stats_bg_color);

$selected_stats = get_post_meta(get_the_ID(), '_selected_stats', true);
?>

<div class="rb-block-cover rb-block-cover--py-0 alumni-countr-box text-white bg-rb--color--blue"
     <?php echo $stats_bg_color ? 'style="background-color: ' . esc_attr($stats_bg_color) . ';"' : ''; ?>>

    <div class="rb-block-container">
        <div class="rb-statisticgroup grid-cols-auto">

            <?php if (!empty($selected_stats) && is_array($selected_stats)) : ?>
                <?php foreach ($selected_stats as $stat_id) :
                    $stat_id = (int) $stat_id;
                    if (!$stat_id) {
                        continue;
                    }

                    $count = get_post_meta($stat_id, 'stat_count', true);
                    $post_obj = get_post($stat_id);
                    if (!$post_obj || 'statistics' !== $post_obj->post_type) {
                        continue;
                    }
                    $stat_title = get_the_title($stat_id);
                    $desc = $post_obj->post_content;
                ?>

                <div class="rb-statistic">
                    <figure class="rb-statistic__inner">
                        <div class="rb-statistic__content rb-content-flow">
                           
                            <?php if (!empty($stat_title)) : ?>
                                <div class="rb-statistic__title">
                                    <?php echo esc_html($stat_title); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <figcaption>
                            <?php echo wp_kses_post(wpautop($desc)); ?>
                        </figcaption>
                    </figure>
                </div>

                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php
$benefits_title = get_post_meta(get_the_ID(), '_benefits_section_title', true);
$benefits_desc  = get_post_meta(get_the_ID(), '_benefits_section_desc', true);
$benefits_bg_color = get_post_meta(get_the_ID(), '_benefits_bg_color', true);
$benefits_bg_color = sanitize_hex_color($benefits_bg_color);
$benefits_items = get_post_meta(get_the_ID(), '_benefits_items', true);
$benefits_items = is_array($benefits_items) ? $benefits_items : array();
?>

<?php if ($benefits_title || $benefits_desc || !empty($benefits_items)) : ?>
<section class="rb-block-cover" <?php echo $benefits_bg_color ? 'style="background-color: ' . esc_attr($benefits_bg_color) . ';"' : ''; ?>>
    <div class="rb-block-container">
        <?php if ($benefits_title) : ?>
            <h2><?php echo esc_html($benefits_title); ?></h2>
        <?php endif; ?>

        <?php if ($benefits_desc) : ?>
            <div class="rb-content-flow">
                <p class="rb-summary"><?php echo esc_html($benefits_desc); ?></p>
            </div>
        <?php endif; ?>

        <?php
        $chunks = array_chunk($benefits_items, 3);
        foreach ($chunks as $chunk) :
            ?>
            <ul class="rb-link-grid alumni-link-grid">
                <?php foreach ($chunk as $item) :
                    $icon  = isset($item['icon']) ? (string) $item['icon'] : '';
                    $ititle = isset($item['title']) ? (string) $item['title'] : '';
                    $idesc  = isset($item['desc']) ? (string) $item['desc'] : '';
                    $link   = isset($item['link']) ? (string) $item['link'] : '';

                    $icon  = esc_url($icon);
                    $link  = esc_url($link);
                    ?>
                    <li>
                        <?php if ($icon) : ?>
                            <div class="alumni-link-icon">
                                <img src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($ititle); ?>" loading="lazy">
                            </div>
                        <?php endif; ?>

                        <div>
                            <?php if ($ititle) : ?>
                                <?php if ($link) : ?>
                                    <a href="<?php echo esc_url($link); ?>"><?php echo esc_html($ititle); ?></a>
                                <?php else : ?>
                                    <a href="#"><?php echo esc_html($ititle); ?></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <?php if ($idesc) : ?>
                            <p><?php echo esc_html($idesc); ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php
$prospectus_id = get_post_meta(get_the_ID(), '_selected_prospectus', true);

if ($prospectus_id):

$title = get_the_title($prospectus_id);
$desc  = get_post_field('post_content', $prospectus_id);
$svg   = get_post_meta($prospectus_id, '_prospectus_svg', true);
$link  = get_post_meta($prospectus_id, '_prospectus_link', true);
?>

<section class="rb-block-cover alumni-singup-banner">
    <section class="alumni-signup-banner rb-banner">
        <div class="rb-block-container bg-rb--color--yellow">
            <div class="rb-banner__inner">
<rb-icon class="rb-icon rb-banner__icon" hx-get="/media/livacuk/redbrick/icons/laptop.svg" hx-trigger="load">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 100 100">
                            <path d="M35.3,33.2l3,2.2v4.9c0,0.3,0.1,0.6,0.4,0.8l10.8,8.1c0.2,0.1,0.4,0.2,0.6,0.2s0.4-0.1,0.6-0.2l5.9-4.4v3.6c0,0.6,0.4,1,1,1
                              s1-0.4,1-1v-5.1l2.9-2.2c0.3-0.2,0.4-0.5,0.4-0.8v-4.9l3-2.2c0.3-0.2,0.4-0.5,0.4-0.8s-0.2-0.6-0.4-0.8L50.7,21.3
                              c-0.3-0.3-0.8-0.3-1.2,0L35.3,31.6c-0.3,0.2-0.4,0.5-0.4,0.8C34.9,32.7,35,33.1,35.3,33.2z M50.1,47.1l-9.8-7.3v-2.9l9.2,6.7
                              c0.2,0.1,0.4,0.2,0.6,0.2s0.4-0.1,0.6-0.2l5.9-4.3v3L50.1,47.1z M60,39.8l-1.3,1v-3l1.3-1V39.8z M50.1,23.4l12.6,9.1L58,35.8
                              L50.7,31c-0.5-0.3-1.1-0.2-1.4,0.3s-0.2,1.1,0.3,1.4l6.7,4.4l-6.2,4.4l-12.6-9.1L50.1,23.4z"></path>
                            <path d="M78.8,16.5H20.5c-0.6,0-1,0.4-1,1v34.8c0,0.6,0.4,1,1,1h58.3c0.6,0,1-0.4,1-1V17.5C79.8,16.9,79.4,16.5,78.8,16.5z
                              M77.8,51.2H21.5V18.5h56.3V51.2z"></path>
                            <path d="M13.1,90.5h73.3c1,0,1.9-0.4,2.6-1.2c0.6-0.7,0.9-1.7,0.7-2.7l-4.9-28.7V15.8c0-2.9-2.4-5.3-5.3-5.3H19.8
                              c-2.9,0-5.3,2.4-5.3,5.3V58L9.8,86.7c-0.2,1,0.1,1.9,0.7,2.7C11.2,90.1,12.1,90.5,13.1,90.5z M16.5,15.8c0-1.8,1.5-3.3,3.3-3.3h59.8
                              c1.8,0,3.3,1.5,3.3,3.3v41.3H16.5V15.8z M11.8,87l4.5-27.9H83L87.7,87c0.1,0.4,0,0.8-0.3,1.1c-0.3,0.3-0.6,0.5-1,0.5H13.1
                              c-0.4,0-0.8-0.2-1-0.5C11.9,87.7,11.7,87.4,11.8,87z"></path>
                            <path d="M18.4,82.3h62.7c0.3,0,0.6-0.1,0.8-0.3s0.3-0.5,0.2-0.8l-2.3-17c-0.1-0.5-0.5-0.9-1-0.9H20.5c-0.5,0-0.9,0.4-1,0.9l-2.1,17
                              c0,0.3,0.1,0.6,0.2,0.8C17.9,82.2,18.1,82.3,18.4,82.3z M20.4,73.8h13.1l-0.6,6.5H19.6L20.4,73.8z M50.8,71.8v-6.5h11.9l0.6,6.5
                              H50.8z M63.5,73.8l0.6,6.5H50.8v-6.5H63.5z M48.8,71.8H35.7l0.6-6.5h12.5V71.8z M48.8,73.8v6.5h-14l0.6-6.5H48.8z M66.1,80.3
                              l-0.6-6.5h13.6l0.9,6.5H66.1z M78.8,71.8H65.3l-0.6-6.5H78L78.8,71.8z M34.3,65.3l-0.6,6.5H20.6l0.8-6.5H34.3z"></path>
                        </svg>
                      </rb-icon>

                <div class="rb-banner__content">

                    <h2 class="rb-banner__title text-rb--color--primary">
                        <?php echo esc_html($title); ?>
                    </h2>

                    
                        <?php echo wp_kses_post($desc); ?>
                   

                </div>

                <footer class="rb-banner__footer">

                    <?php if($link): ?>
                    <a href="<?php echo esc_url($link); ?>"
                       target="_blank"
                       class="rb-button rb-button--primary rb-button--icon"
                       data-icon="download">

                        Download Prospectus
                    </a>
                    <?php endif; ?>

                </footer>

            </div>
        </div>
    </section>
</section>

<?php endif; ?>

<?php
$image_case_ids = get_post_meta(get_the_ID(), '_selected_image_casestudies', true);
$image_case_ids = is_array($image_case_ids) ? $image_case_ids : array();

$video_case_ids = get_post_meta(get_the_ID(), '_selected_video_casestudies', true);
$video_case_ids = is_array($video_case_ids) ? $video_case_ids : array();

$casestudy_bg = get_post_meta(get_the_ID(), '_casestudy_section_bg_color', true);
$casestudy_bg = sanitize_hex_color($casestudy_bg);

$success_title = get_post_meta(get_the_ID(), '_casestudy_images_title', true);
$voices_title  = get_post_meta(get_the_ID(), '_casestudy_videos_title', true);

if (!$success_title) {
    $success_title = 'Success snapshots';
}
if (!$voices_title) {
    $voices_title = 'Voices of our alumni';
}

function alumini_get_youtube_id_from_url($url) {
    $url = (string) $url;
    if ('' === $url) {
        return '';
    }
    $parts = wp_parse_url($url);
    if (empty($parts['host'])) {
        return '';
    }
    $host = strtolower($parts['host']);

    // youtu.be/<id>
    if (false !== strpos($host, 'youtu.be')) {
        $path = isset($parts['path']) ? trim($parts['path'], '/') : '';
        return preg_match('/^[A-Za-z0-9_-]{6,}$/', $path) ? $path : '';
    }

    // youtube.com/watch?v=<id>
    if (false !== strpos($host, 'youtube.com')) {
        if (!empty($parts['query'])) {
            parse_str($parts['query'], $q);
            if (!empty($q['v']) && preg_match('/^[A-Za-z0-9_-]{6,}$/', $q['v'])) {
                return $q['v'];
            }
        }
        // youtube.com/embed/<id> or /shorts/<id>
        if (!empty($parts['path']) && preg_match('~/(embed|shorts)/([A-Za-z0-9_-]{6,})~', $parts['path'], $m)) {
            return $m[2];
        }
    }

    return '';
}
?>

<?php if (!empty($image_case_ids) || !empty($video_case_ids)) : ?>
<section class="program-cards-container alumni-cards rb-block-cover bg-rb--color--mist rb-block-cover-sec1 common-slider-container" <?php echo $casestudy_bg ? 'style="background-color: ' . esc_attr($casestudy_bg) . ';"' : ''; ?>>
    <div class="rb-block-container">
        <h2><?php echo esc_html($success_title); ?></h2>
        <div class="rb-cardgroup grid-cols-auto">
            <?php foreach ($image_case_ids as $cid) :
                $cid = (int) $cid;
                if (!$cid) {
                    continue;
                }
                $post_obj = get_post($cid);
                if (!$post_obj || 'casestudy' !== $post_obj->post_type) {
                    continue;
                }
                $thumb = get_the_post_thumbnail_url($cid, 'large');
                $program = get_post_meta($cid, '_casestudy_program_name', true);
                ?>
                <section class="rb-card bg-white">
                    <a href="<?php echo esc_url(get_permalink($cid)); ?>">
                    </a>
                    <div class="rb-card__inner">
                        <a href="<?php echo esc_url(get_permalink($cid)); ?>">
                            <picture class="rb-picture rb-card__header">
                                <?php if ($thumb) : ?>
                                    <img src="<?php echo esc_url($thumb); ?>" title="<?php echo esc_attr(get_the_title($cid)); ?>" alt="" loading="lazy">
                                <?php endif; ?>
                            </picture>
                        </a>
                        <div class="rb-card__content">
                            <h2 class="rb-card__title">
                                <a href="javascript:void(0);"><?php echo esc_html(get_the_title($cid)); ?></a>
                            </h2>
                            <?php if ($program) : ?>
                                <h3 class="rb-card__subtitle"><?php echo esc_html($program); ?></h3>
                            <?php endif; ?>
                            <?php echo wp_kses_post(wpautop($post_obj->post_content)); ?>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="rb-block-container alumni-videos-box">
        <h2><?php echo esc_html($voices_title); ?></h2>
        <div class="rb-cardgroup grid-cols-auto">
            <?php foreach ($video_case_ids as $cid) :
                $cid = (int) $cid;
                if (!$cid) {
                    continue;
                }
                $post_obj = get_post($cid);
                if (!$post_obj || 'casestudy' !== $post_obj->post_type) {
                    continue;
                }
                $program  = get_post_meta($cid, '_casestudy_program_name', true);
                $video_url = get_post_meta($cid, '_casestudy_video_url', true);
                $yt_id    = alumini_get_youtube_id_from_url($video_url);
                $yt_thumb = $yt_id ? ('https://img.youtube.com/vi/' . rawurlencode($yt_id) . '/maxresdefault.jpg') : '';
                $play_icon = get_template_directory_uri() . '/img/YouTube_play_button_icon.png';
                ?>
                <section
                    class="rb-card bg-white alumni-video-card"
                    data-video="<?php echo esc_attr($yt_id); ?>"
                    data-title="<?php echo esc_attr(get_the_title($cid)); ?>"
                >
                    <div class="rb-card__inner">
                        <picture class="rb-picture rb-card__picture alumni-video-thumb">
                            <?php if ($yt_thumb) : ?>
                                <img
                                    src="<?php echo esc_url($yt_thumb); ?>"
                                    alt=""
                                    loading="lazy"
                                    class="rb-picture__image aspect-3/2"
                                />
                            <?php endif; ?>
    
                            <img
                                src="<?php echo esc_url($play_icon); ?>"
                                alt="Play Video"
                                loading="lazy"
                                class="video-play-icon"
                            />
                        </picture>
    
                        <div class="rb-card__content">
                            <h2 class="rb-card__title">
                                <a href="javascript:void(0);"><?php echo esc_html(get_the_title($cid)); ?></a>
                            </h2>
                            <?php if ($program) : ?>
                                <h3 class="rb-card__subtitle"><?php echo esc_html($program); ?></h3>
                            <?php endif; ?>
                            <?php echo wp_kses_post(wpautop($post_obj->post_content)); ?>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<dialog
    class="rb-dialog rb-dialog--dismissable alumni-yt-video-dialog"
    id="alumniYtVideo_dialog"
    popover="auto"
    role="dialog"
    aria-labelledby="alumniYtVideo_dialog__title"
>
    <div class="rb-dialog__inner">
        <header>
            <div id="alumniYtVideo_dialog__title" class="rb-dialog__title">
                <?php echo esc_html($voices_title); ?>
            </div>
            <button
                data-icon="close"
                class="rb-button rb-button--borderless rb-button--icon rb-button--icon--before"
                popovertarget="alumniYtVideo_dialog"
                popovertargetaction="hide"
                autofocus=""
            >
                Close
            </button>
        </header>
        <section class="rb-dialog__content rb-content-flow">
            <figure class="rb-video">
                <iframe
                    src=""
                    class="rb-video__iframe aspect-video"
                    id="alumniYtVideoIframe"
                    title=""
                ></iframe>
            </figure>
        </section>
    </div>
</dialog>
<?php endif; ?>

<?php
$next_title = get_post_meta(get_the_ID(), '_next_section_title', true);
$next_subtitle = get_post_meta(get_the_ID(), '_next_section_subtitle', true);
$next_image = get_post_meta(get_the_ID(), '_next_section_image', true);
$next_btn_text = get_post_meta(get_the_ID(), '_next_section_btn_text', true);
$next_btn_link = get_post_meta(get_the_ID(), '_next_section_btn_link', true);
$next_btn_target = get_post_meta(get_the_ID(), '_next_section_btn_target', true);
$next_desc_items = get_post_meta(get_the_ID(), '_next_section_desc_items', true);
$next_desc_items = is_array($next_desc_items) ? $next_desc_items : array();
$next_bg_color = get_post_meta(get_the_ID(), '_next_bg_color', true);
$next_bg_color = sanitize_hex_color($next_bg_color);
?>

<?php if ($next_title || $next_subtitle || $next_image || ($next_btn_text && $next_btn_link) || !empty($next_desc_items)) : ?>
<section class="rb-block-cover bg-white"  <?php echo $next_bg_color ? 'style="background-color: ' . esc_attr($next_bg_color) . ';"' : ''; ?>>>
    <div class="rb-block-container">
        <div class="rb-top-level-page rb-content-flow up-news-alumni">
            <article>
                <?php if ($next_image) : ?>
                    <picture class="rb-picture">
                        <img
                            src="<?php echo esc_url($next_image); ?>"
                            class="rb-picture__image aspect-3/2"
                            loading="lazy"
                            alt="<?php echo esc_attr($next_title ? $next_title : ''); ?>"
                        />
                    </picture>
                <?php endif; ?>

                <div class="rb-content-flow alumni-col-2">
                    <header>
                        <?php if ($next_title) : ?>
                            <h2><?php echo esc_html($next_title); ?></h2>
                        <?php endif; ?>

                        <?php if ($next_subtitle) : ?>
                            <p class="rb-summary">
                                <?php echo esc_html($next_subtitle); ?>
                            </p>
                        <?php endif; ?>
                    </header>

                    <?php if (!empty($next_desc_items)) : ?>
                        <?php foreach ($next_desc_items as $html) :
                            $html = is_string($html) ? $html : '';
                            echo wp_kses_post(wpautop($html));
                        endforeach; ?>
                    <?php endif; ?>

                    <?php if ($next_btn_text && $next_btn_link) : ?>
                        <button
                            class="uol-gallery-mode-btn uol-network-btn"
                            href="<?php echo esc_url($next_btn_link); ?>"
                            <?php echo ('on' === $next_btn_target) ? 'target="_blank" rel="noopener"' : ''; ?>
                        >
                            <?php echo esc_html($next_btn_text); ?>
                    </button>
                    <?php endif; ?>
                </div>
            </article>
        </div>
    </div>
</section>
<?php endif; ?>
<?php
$news_title = get_post_meta(get_the_ID(), '_news_section_title', true);
$news_bg_color = get_post_meta(get_the_ID(), '_news_bg_color', true);
$news_bg_color = sanitize_hex_color($news_bg_color);

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 4
);

$news_query = new WP_Query($args);
?>

<div class="rb-block-cover bg-rb--color--light rb-news-homepage"
      <?php echo $news_bg_color ? 'style="background-color: ' . esc_attr($news_bg_color) . ';"' : ''; ?>>
    <div class="rb-block-container">

        <?php if($news_title): ?>
            <h2><?php echo esc_html($news_title); ?></h2>
        <?php else: ?>
            <h2>Latest news</h2>
        <?php endif; ?>

        <div class="rb-cardgroup sm:grid-cols-2">

            <?php if($news_query->have_posts()): ?>
                
                <?php 
                $count = 0;
                while($news_query->have_posts()): $news_query->the_post();
                ?>

                <?php if($count == 0): ?>
                <!-- FIRST POST (FULL CARD) -->
                <section class="rb-card bg-white rb-card--overlay-link rb-news-homepage--main rb-card--horizontal">

                    <div class="rb-card__inner">

                        <?php if(has_post_thumbnail()): ?>
                        <picture class="rb-picture rb-card__header">
                            <img class="rb-picture__image"
                                 src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>"
                                 alt="<?php the_title_attribute(); ?>">
                        </picture>
                        <?php endif; ?>

                        <div class="rb-card__content">

                            <div class="rb-card__meta">
                                <?php echo get_the_date(); ?>
                            </div>

                            <h3 class="rb-card__title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <p class="rb-card__text">
                                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                            </p>

                        </div>
                    </div>
                </section>

                <?php else: ?>
                <!-- OTHER POSTS -->
                <section class="rb-card bg-white rb-card--overlay-link rb-card__content--centered">

                    <div class="rb-card__inner">
                        <div class="rb-card__content">

                            <div class="rb-card__meta">
                                <?php echo get_the_date(); ?>
                            </div>

                            <h3 class="rb-card__title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                        </div>
                    </div>
                </section>

                <?php endif; ?>

                <?php $count++; endwhile; wp_reset_postdata(); ?>

            <?php endif; ?>

        </div>
    </div>
</div>

<?php
$quicklinks = get_post_meta(get_the_ID(), '_selected_quicklinks', true);
$quicklinks_bg_color = get_post_meta(get_the_ID(), '_quicklinks_bg_color', true);
$quicklinks_bg_color = sanitize_hex_color($quicklinks_bg_color);
?>

<section class="rb-block-cover bottom-section"
        <?php echo $quicklinks_bg_color ? 'style="background-color: ' . esc_attr($quicklinks_bg_color) . ';"' : ''; ?>>
    <div class="rb-block-container">

        <ul class="rb-link-grid">

            <?php if(!empty($quicklinks)): ?>
                <?php foreach($quicklinks as $id):

                    $title = get_the_title($id);
                    $desc  = get_post_field('post_content', $id);
                    $link  = get_post_meta($id, '_quicklink_url', true);
                ?>

                <li>
                    <div>
                        <a href="<?php echo esc_url($link); ?>">
                            <?php echo esc_html($title); ?>
                        </a>
                    </div>

                    <p><?php echo wp_kses_post($desc); ?></p>
                </li>

                <?php endforeach; ?>
            <?php endif; ?>

        </ul>

    </div>
</section>

                            </main>
<?php endwhile; ?>

<?php get_footer(); ?>