<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
$phone = figma_theme_get_option( 'phone' );
$email = figma_theme_get_option( 'email' );

$facebook = figma_theme_get_option( 'facebook' );
$instagram = figma_theme_get_option( 'instagram' );
$linkedin = figma_theme_get_option( 'linkedin' );

$logo = figma_theme_get_option( 'site_logo' );

$btn1_text = figma_theme_get_option( 'btn1_text' );
$btn1_link = figma_theme_get_option( 'btn1_link' );

$btn2_text = figma_theme_get_option( 'btn2_text' );
$btn2_link = figma_theme_get_option( 'btn2_link' );
?>

<!-- TOP BAR -->
<div class="top-bar">
    <div class="container top-flex">
        <div>
            <?php if ( ! empty( $phone ) ) : ?>
                <span><?php echo esc_html( $phone ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $email ) ) : ?>
                <span><?php echo esc_html( $email ); ?></span>
            <?php endif; ?>
        </div>
        <div class="top-right">

<?php if ( ! empty( $facebook ) ) : ?>
    <a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
            <path d="M22 12a10 10 0 1 0-11.6 9.9v-7h-2.6v-2.9h2.6V9.4c0-2.6 1.6-4 3.9-4 1.1 0 2.2.2 2.2.2v2.4h-1.3c-1.3 0-1.7.8-1.7 1.6v1.9h2.9l-.5 2.9h-2.4v7A10 10 0 0 0 22 12z"/>
        </svg>
    </a>
<?php endif; ?>

<?php if ( ! empty( $instagram ) ) : ?>
    <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
            <path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm5 5.2A4.8 4.8 0 1 1 7.2 12 4.8 4.8 0 0 1 12 7.2zm6.2-.3a1.2 1.2 0 1 1-1.2-1.2 1.2 1.2 0 0 1 1.2 1.2zM12 9a3 3 0 1 0 3 3 3 3 0 0 0-3-3z"/>
        </svg>
    </a>
<?php endif; ?>

<?php if ( ! empty( $linkedin ) ) : ?>
    <a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
            <path d="M6.9 6.5a1.9 1.9 0 1 1 0-3.8 1.9 1.9 0 0 1 0 3.8zM4.9 8.5h4v12h-4zm7 0h3.8v1.6h.1a4.2 4.2 0 0 1 3.8-2.1c4.1 0 4.8 2.7 4.8 6.2v6.3h-4v-5.6c0-1.3 0-3-1.8-3s-2.1 1.4-2.1 2.9v5.7h-4z"/>
        </svg>
    </a>
<?php endif; ?>

</div>
    </div>
    
</div>

<!-- HEADER -->
<header class="main-header">
    <div class="container header-flex">

       <div class="logo">
		<?php if ( ! empty( $logo ) ) : ?>
			<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
		<?php elseif ( has_custom_logo() ) : ?>
			<?php the_custom_logo(); ?>
		<?php else : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
		<?php endif; ?>
	</div>

        <nav>
            <?php
            wp_nav_menu([
                'theme_location' => 'primary_menu',
                'menu_class' => 'menu'
            ]);
            ?>
        </nav>

        <div class="header-buttons">

<?php if ( ! empty( $btn1_text ) && ! empty( $btn1_link ) ) : ?>
    <a href="<?php echo esc_url( $btn1_link ); ?>" class="btn1">
        <span><?php echo esc_html( $btn1_text ); ?></span>
        <svg class="btn-icon" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
            <path d="M14 3l-1.4 1.4L17.2 9H3v2h14.2l-4.6 4.6L14 17l7-7-7-7z"/>
        </svg>
    </a>
<?php endif; ?>

<?php if ( ! empty( $btn2_text ) && ! empty( $btn2_link ) ) : ?>
    <a href="<?php echo esc_url( $btn2_link ); ?>" class="btn2">
        <span><?php echo esc_html( $btn2_text ); ?></span>
        <svg class="btn-icon" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
            <path d="M12 2C8.1 2 5 5.1 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-3.9-3.1-7-7-7zm0 9.5c-1.4 0-2.5-1.1-2.5-2.5S10.6 6.5 12 6.5s2.5 1.1 2.5 2.5S13.4 11.5 12 11.5z"/>
        </svg>
    </a>
<?php endif; ?>

</div>

    </div>
</header>