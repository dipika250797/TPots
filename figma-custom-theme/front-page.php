<?php get_header(); ?>

<?php
$hero_title = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'hero_title' ) : '';
$hero_desc  = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'hero_desc' ) : '';
$hero_btn   = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'hero_btn_text' ) : '';
$hero_link  = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'hero_btn_link' ) : '';
$hero_img   = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'hero_bg', array( 'size' => 'full' ) ) : array();
$bg_url     = isset( $hero_img['url'] ) ? $hero_img['url'] : '';

$services_eyebrow = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'services_eyebrow' ) : '';
$services_title   = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'services_title' ) : '';
$services_intro   = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'services_intro' ) : '';
$services_btn     = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'services_btn_text' ) : '';
$services_btn_url = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'services_btn_link' ) : '';
$service_images   = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'service_item_image' ) : array();
$service_titles   = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'service_item_title' ) : array();
$service_descs    = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'service_item_desc' ) : array();
$service_links    = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'service_item_link' ) : array();
$why_choose_eyebrow = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'why_choose_eyebrow' ) : '';
$why_choose_title   = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'why_choose_title' ) : '';
$why_choose_btn     = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'why_choose_btn_text' ) : '';
$why_choose_btn_url = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'why_choose_btn_link' ) : '';
$why_choose_images  = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'why_choose_item_image' ) : array();
$why_choose_titles  = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'why_choose_item_title' ) : array();
$why_choose_descs   = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'why_choose_item_desc' ) : array();
$stats_section_image = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'stats_section_image', array( 'size' => 'full' ) ) : array();
$stats_numbers       = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'stats_item_number' ) : array();
$stats_labels        = function_exists( 'rwmb_meta' ) ? rwmb_meta( 'stats_item_label' ) : array();

if ( ! is_array( $service_titles ) ) {
	$service_titles = array();
}
if ( ! is_array( $service_images ) ) {
	$service_images = array();
}
if ( ! is_array( $service_descs ) ) {
	$service_descs = array();
}
if ( ! is_array( $service_links ) ) {
	$service_links = array();
}
if ( ! is_array( $why_choose_titles ) ) {
	$why_choose_titles = array();
}
if ( ! is_array( $why_choose_images ) ) {
	$why_choose_images = array();
}
if ( ! is_array( $why_choose_descs ) ) {
	$why_choose_descs = array();
}
if ( ! is_array( $stats_numbers ) ) {
	$stats_numbers = array();
}
if ( ! is_array( $stats_labels ) ) {
	$stats_labels = array();
}

$stats_bg_url = isset( $stats_section_image['url'] ) ? $stats_section_image['url'] : '';
?>

<!-- HERO SECTION -->
<section class="hero" style="background-image:url('<?php echo esc_url($bg_url); ?>');">

    <div class="overlay"></div>

    <div class="container hero-content">

        <h1><?php echo esc_html($hero_title); ?></h1>

        <p><?php echo esc_html($hero_desc); ?></p>

        <?php if ( $hero_btn && $hero_link ) : ?>
            <a href="<?php echo esc_url( $hero_link ); ?>" class="hero-btn">
                <?php echo esc_html( $hero_btn ); ?> <svg class="btn-icon" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
            <path d="M14 3l-1.4 1.4L17.2 9H3v2h14.2l-4.6 4.6L14 17l7-7-7-7z"></path>
        </svg>
            </a>
        <?php endif; ?>

    </div>

    <!-- TRACK BOX -->
    <div class="tracking-box">
        <h3>Track Your Delivery</h3>
        <input type="text" placeholder="Enter Tracking Number">
        <button>Track</button>
    </div>

</section>
<?php 
$why_bg = "http://localhost/figmatask/wp-content/uploads/2026/04/Background.png";
?>

<?php if ( ! empty( $why_choose_title ) || ! empty( $why_choose_titles ) ) : ?>
	<section class="why-choose" style="background-image: url('<?php echo esc_url( $why_bg ); ?>');">

		<div class="container why-choose-inner">
			<div class="why-choose-content">

				<?php if ( ! empty( $why_choose_eyebrow ) ) : ?>
					<p class="why-choose-eyebrow"><?php echo esc_html( $why_choose_eyebrow ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $why_choose_title ) ) : ?>
					<h2><?php echo esc_html( $why_choose_title ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $why_choose_btn ) && ! empty( $why_choose_btn_url ) ) : ?>
					<a class="why-choose-btn" href="<?php echo esc_url( $why_choose_btn_url ); ?>">
						<?php echo esc_html( $why_choose_btn ); ?>
						<svg class="btn-icon" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
							<path d="M14 3l-1.4 1.4L17.2 9H3v2h14.2l-4.6 4.6L14 17l7-7-7-7z"></path>
						</svg>
					</a>
				<?php endif; ?>

			</div>

			<div class="why-choose-cards">
				<?php foreach ( $why_choose_titles as $index => $item_title ) : ?>
					<?php
					$item_desc  = isset( $why_choose_descs[ $index ] ) ? $why_choose_descs[ $index ] : '';
					$item_image = isset( $why_choose_images[ $index ]['url'] ) ? $why_choose_images[ $index ]['url'] : '';

					$card_class = 'why-card';
					if ( 0 === (int) $index ) {
						$card_class .= ' card-top';
					} elseif ( 1 === (int) $index ) {
						$card_class .= ' card-bottom-left';
					} elseif ( 2 === (int) $index ) {
						$card_class .= ' card-bottom-right';
					}
					?>
					<article class="<?php echo esc_attr( $card_class ); ?>">
						<?php if ( ! empty( $item_image ) ) : ?>
							<img class="why-card-icon" src="<?php echo esc_url( $item_image ); ?>" alt="<?php echo esc_attr( $item_title ); ?>">
						<?php endif; ?>

						<h3><?php echo esc_html( $item_title ); ?></h3>

						<?php if ( ! empty( $item_desc ) ) : ?>
							<p><?php echo esc_html( $item_desc ); ?></p>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		</div>

	</section>
<?php endif; ?>
<?php if ( ! empty( $service_titles ) ) : ?>
	<section class="services">
		<div class="container">
			<div class="services-head">
				<div class="services-head-left">
					<?php if ( ! empty( $services_eyebrow ) ) : ?>
						<p class="services-eyebrow"><?php echo esc_html( $services_eyebrow ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $services_title ) ) : ?>
						<h2><?php echo esc_html( $services_title ); ?></h2>
					<?php endif; ?>
				</div>

				<div class="services-head-right">
					<?php if ( ! empty( $services_intro ) ) : ?>
						<p><?php echo esc_html( $services_intro ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $services_btn ) && ! empty( $services_btn_url ) ) : ?>
						<a href="<?php echo esc_url( $services_btn_url ); ?>" class="services-btn"><?php echo esc_html( $services_btn ); ?></a>
					<?php endif; ?>
				</div>
			</div>

			<div class="services-grid">
				<?php foreach ( $service_titles as $index => $service_title ) : ?>
					<?php
					$service_desc = isset( $service_descs[ $index ] ) ? $service_descs[ $index ] : '';
					$service_link = isset( $service_links[ $index ] ) ? $service_links[ $index ] : '';
					$service_img  = isset( $service_images[ $index ]['url'] ) ? $service_images[ $index ]['url'] : '';
					?>
					<article class="service-card">
						<?php if ( ! empty( $service_img ) ) : ?>
							<img src="<?php echo esc_url( $service_img ); ?>" alt="<?php echo esc_attr( $service_title ); ?>">
						<?php endif; ?>

						<div class="service-overlay">
							<?php if ( ! empty( $service_title ) ) : ?>
								<h3><?php echo esc_html( $service_title ); ?></h3>
							<?php endif; ?>

							<?php if ( ! empty( $service_desc ) ) : ?>
								<p><?php echo esc_html( $service_desc ); ?></p>
							<?php endif; ?>

							<?php if ( ! empty( $service_link ) ) : ?>
								<a href="<?php echo esc_url( $service_link ); ?>" class="service-link">View Service</a>
							<?php endif; ?>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>



<?php if ( ! empty( $stats_bg_url ) || ! empty( $stats_numbers ) ) : ?>
	<section class="stats-content">
		<div class="container">
			<div class="stats-visual" style="background-image:url('<?php echo esc_url( $stats_bg_url ); ?>');">
				<div class="stats-grid">
					<?php foreach ( $stats_numbers as $index => $stat_number ) : ?>
						<?php
						$stat_label = isset( $stats_labels[ $index ] ) ? $stats_labels[ $index ] : '';
						$card_class = 'stats-card';
						if ( 0 === (int) $index ) {
							$card_class .= ' stats-card-top';
						} elseif ( 1 === (int) $index ) {
							$card_class .= ' stats-card-middle';
						} elseif ( 2 === (int) $index ) {
							$card_class .= ' stats-card-bottom';
						}
						?>
						<article class="<?php echo esc_attr( $card_class ); ?>">
							<?php if ( ! empty( $stat_number ) ) : ?>
								<h3><?php echo esc_html( $stat_number ); ?></h3>
							<?php endif; ?>
							<?php if ( ! empty( $stat_label ) ) : ?>
								<p><?php echo esc_html( $stat_label ); ?></p>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php get_footer(); ?>