<?php
$footer_text    = figma_theme_get_option( 'footer_text' );
$copyright      = figma_theme_get_option( 'copyright' );
$phone          = figma_theme_get_option( 'phone' );
$email          = figma_theme_get_option( 'email' );
$facebook       = figma_theme_get_option( 'facebook' );
$instagram      = figma_theme_get_option( 'instagram' );
$linkedin       = figma_theme_get_option( 'linkedin' );
$quick_links    = figma_theme_get_option( 'footer_quick_links', array() );
$services_links = figma_theme_get_option( 'footer_services_links', array() );
$legal_links    = figma_theme_get_option( 'footer_legal_links', array() );
$footer_quick_title = figma_theme_get_option( 'footer_quick_title', 'Quick Link' );
$footer_services_title = figma_theme_get_option( 'footer_services_title', 'Services' );
$footer_legal_title = figma_theme_get_option( 'footer_legal_title', 'Legal' );
$newsletter_kicker = figma_theme_get_option( 'newsletter_kicker', 'Stay In Touch' );
$newsletter_title = figma_theme_get_option( 'newsletter_title', 'Subscribe To Our Newsletter' );
$newsletter_placeholder = figma_theme_get_option( 'newsletter_placeholder', 'Enter Your Email' );
$newsletter_button_text = figma_theme_get_option( 'newsletter_button_text', 'Submit' );
$footer_phone_label = figma_theme_get_option( 'footer_phone_label', 'Give us a call' );
$footer_email_label = figma_theme_get_option( 'footer_email_label', 'send us an email' );
?>

<footer class="site-footer">
	<div class="container footer-wrap">
		<div class="footer-main">
			<div class="footer-links-area">
				<?php if ( ! empty( $footer_text ) ) : ?>
					<p class="footer-lead"><?php echo esc_html( $footer_text ); ?></p>
				<?php endif; ?>

				<div class="footer-grid">
					<div class="footer-col">
						<h3><?php echo esc_html( $footer_quick_title ); ?></h3>
						<ul class="footer-links">
							<?php figma_render_footer_links( $quick_links ); ?>
						</ul>
					</div>

					<div class="footer-col">
						<h3><?php echo esc_html( $footer_services_title ); ?></h3>
						<ul class="footer-links">
							<?php figma_render_footer_links( $services_links ); ?>
						</ul>
					</div>

					<div class="footer-col">
						<h3><?php echo esc_html( $footer_legal_title ); ?></h3>
						<ul class="footer-links">
							<?php figma_render_footer_links( $legal_links ); ?>
						</ul>
					</div>
				</div>
				<div class="footer-bottom">
			<div class="footer-bottom-row">
				<p>
					<?php
					if ( ! empty( $copyright ) ) {
						echo esc_html( $copyright );
					} else {
						echo esc_html( sprintf( 'Copyright %1$s %2$s. All rights reserved.', gmdate( 'Y' ), get_bloginfo( 'name' ) ) );
					}
					?>
				</p>

				<div class="footer-social">

    <?php if ( ! empty( $facebook ) ) : ?>
        <a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                <path d="M22 12a10 10 0 1 0-11.6 9.9v-7h-2.6v-2.9h2.6V9.4c0-2.6 1.6-4 3.9-4 1.1 0 2.2.2 2.2.2v2.4h-1.3c-1.3 0-1.7.8-1.7 1.6v1.9h2.9l-.5 2.9h-2.4v7A10 10 0 0 0 22 12z"/>
            </svg>
        </a>
    <?php endif; ?>

    <?php if ( ! empty( $instagram ) ) : ?>
        <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                <path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm5 5.2A4.8 4.8 0 1 1 7.2 12 4.8 4.8 0 0 1 12 7.2zm6.2-.3a1.2 1.2 0 1 1-1.2-1.2 1.2 1.2 0 0 1 1.2 1.2zM12 9a3 3 0 1 0 3 3 3 3 0 0 0-3-3z"/>
            </svg>
        </a>
    <?php endif; ?>

    <?php if ( ! empty( $linkedin ) ) : ?>
        <a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                <path d="M6.9 6.5a1.9 1.9 0 1 1 0-3.8 1.9 1.9 0 0 1 0 3.8zM4.9 8.5h4v12h-4zm7 0h3.8v1.6h.1a4.2 4.2 0 0 1 3.8-2.1c4.1 0 4.8 2.7 4.8 6.2v6.3h-4v-5.6c0-1.3 0-3-1.8-3s-2.1 1.4-2.1 2.9v5.7h-4z"/>
            </svg>
        </a>
    <?php endif; ?>

</div>
			</div>
	</div>
			</div>

			<div class="footer-newsletter">
				<span class="footer-newsletter-kicker"><?php echo esc_html( $newsletter_kicker ); ?></span>
				<h3><?php echo esc_html( $newsletter_title );?></h3>
				<form class="newsletter-form" action="#" method="post" onsubmit="return false;">
					<input type="email" id="newsletter-email" name="newsletter_email" placeholder="<?php echo esc_attr( $newsletter_placeholder ); ?>" required>
					<button type="submit"><?php echo esc_html( $newsletter_button_text ); ?> <span aria-hidden="true">&#8599;</span></button>
				</form>

				<div class="newsletter-contact">

<?php if ( ! empty( $phone ) ) : ?>
	<div class="newsletter-row">
		
		<span class="newsletter-icon" aria-hidden="true">
			<svg viewBox="0 0 24 24" role="presentation" focusable="false">
				<path d="M6.7 2.4c.5-.2 1-.1 1.3.3l2.1 3.1c.3.4.3.9 0 1.3L8.7 9c-.2.3-.3.7-.1 1.1.8 1.8 2.2 3.5 4 4.8.3.2.7.2 1 .1l1.9-1c.4-.2.9-.1 1.2.2l2.7 2.5c.4.4.5 1 .3 1.4l-1 2.1c-.2.4-.6.7-1 .8-1.3.3-3.6.1-6.8-1.8-3-1.9-5.1-4.5-6.3-7.5C3.2 8 3.3 5.8 3.7 4.5c.1-.4.4-.8.8-1l2.2-1.1z"/>
			</svg>
		</span>

		<div class="newsletter-contact-row">
			<p class="newsletter-contact-label">
				<?php echo esc_html( $footer_phone_label ); ?>
			</p>
			<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9\+]/', '', $phone ) ); ?>">
				<?php echo esc_html( $phone ); ?>
			</a>
		</div>

	</div>
<?php endif; ?>


<?php if ( ! empty( $email ) ) : ?>
	<div class="newsletter-row">
		
		<span class="newsletter-icon" aria-hidden="true">
			<svg viewBox="0 0 24 24" role="presentation" focusable="false">
				<path d="M3 6.5C3 5.7 3.7 5 4.5 5h15c.8 0 1.5.7 1.5 1.5v11c0 .8-.7 1.5-1.5 1.5h-15c-.8 0-1.5-.7-1.5-1.5v-11zm1.9.5l7.1 5.4 7.1-5.4H4.9zm14.6 10V8.4l-6.9 5.2c-.4.3-.9.3-1.2 0L4.5 8.4V17h15z"/>
			</svg>
		</span>

		<div class="newsletter-contact-row">
			<p class="newsletter-contact-label">
				<?php echo esc_html( $footer_email_label ); ?>
			</p>
			<a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>">
				<?php echo esc_html( antispambot( $email ) ); ?>
			</a>
		</div>

	</div>
<?php endif; ?>

</div>
			</div>
		</div>
	</div>

	
</footer>

<?php wp_footer(); ?>
</body>
</html>