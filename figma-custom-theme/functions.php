<?php

// ===============================
// THEME SETUP
// ===============================
function figma_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );

	register_nav_menus(
		array(
			'primary_menu' => 'Primary Menu',
			'footer_menu'  => 'Footer Menu',
		)
	);
}
add_action( 'after_setup_theme', 'figma_theme_setup' );


// ===============================
// ENQUEUE STYLES
// ===============================
function figma_enqueue_scripts() {
	wp_enqueue_style( 'main-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'figma_enqueue_scripts' );

// ===============================
// DEFAULT OPTIONS + HELPERS
// ===============================
function figma_theme_default_options() {
	return array(
		'phone'                 => '',
		'email'                 => '',
		'facebook'              => '',
		'instagram'             => '',
		'linkedin'              => '',
		'site_logo'             => '',
		'btn1_text'             => '',
		'btn1_link'             => '',
		'btn2_text'             => '',
		'btn2_link'             => '',
		'footer_text'           => '',
		'copyright'             => '',
		'footer_quick_title'    => 'Quick Link',
		'footer_services_title' => 'Services',
		'footer_legal_title'    => 'Legal',
		'newsletter_kicker'     => 'Stay In Touch',
		'newsletter_title'      => 'Subscribe To Our Newsletter',
		'newsletter_placeholder'=> 'Enter Your Email',
		'newsletter_button_text'=> 'Submit',
		'footer_phone_label'    => 'Give us a call',
		'footer_email_label'    => 'send us an email',
		'footer_quick_links'    => array(),
		'footer_services_links' => array(),
		'footer_legal_links'    => array(),
	);
}

function figma_theme_get_options() {
	$stored   = get_option( 'figma_theme_options', array() );
	$defaults = figma_theme_default_options();

	if ( ! is_array( $stored ) ) {
		$stored = array();
	}

	return wp_parse_args( $stored, $defaults );
}

function figma_theme_get_option( $key, $default = '' ) {
	$options = figma_theme_get_options();
	return isset( $options[ $key ] ) ? $options[ $key ] : $default;
}

function figma_sanitize_link_rows( $rows ) {
	$sanitized = array();

	if ( ! is_array( $rows ) ) {
		return $sanitized;
	}

	foreach ( $rows as $row ) {
		$label = isset( $row['label'] ) ? sanitize_text_field( wp_unslash( $row['label'] ) ) : '';
		$url   = isset( $row['url'] ) ? esc_url_raw( wp_unslash( $row['url'] ) ) : '';

		if ( '' !== $label || '' !== $url ) {
			$sanitized[] = array(
				'label' => $label,
				'url'   => $url,
			);
		}
	}

	return $sanitized;
}

function figma_render_link_group_rows( $field_name, $rows, $minimum_rows = 5 ) {
	if ( ! is_array( $rows ) ) {
		$rows = array();
	}

	$rows = array_values( $rows );
	$rows_count = count( $rows );

	if ( $rows_count < $minimum_rows ) {
		for ( $index = $rows_count; $index < $minimum_rows; $index++ ) {
			$rows[] = array(
				'label' => '',
				'url'   => '',
			);
		}
	}

	foreach ( $rows as $index => $row ) :
		$label = isset( $row['label'] ) ? $row['label'] : '';
		$url   = isset( $row['url'] ) ? $row['url'] : '';
		?>
		<tr>
			<td>
				<input
					type="text"
					name="<?php echo esc_attr( $field_name ); ?>[<?php echo esc_attr( $index ); ?>][label]"
					value="<?php echo esc_attr( $label ); ?>"
					class="regular-text"
					placeholder="Label"
				>
			</td>
			<td>
				<input
					type="url"
					name="<?php echo esc_attr( $field_name ); ?>[<?php echo esc_attr( $index ); ?>][url]"
					value="<?php echo esc_attr( $url ); ?>"
					class="regular-text"
					placeholder="https://example.com"
				>
			</td>
		</tr>
		<?php
	endforeach;
}

function figma_render_footer_links( $items ) {
	if ( empty( $items ) || ! is_array( $items ) ) {
		return;
	}

	foreach ( $items as $item ) {
		$label = isset( $item['label'] ) ? $item['label'] : '';
		$url   = isset( $item['url'] ) ? $item['url'] : '';

		if ( empty( $label ) || empty( $url ) ) {
			continue;
		}
		?>
		<li>
			<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a>
		</li>
		<?php
	}
}


// ===============================
// CREATE THEME SETTINGS PAGE
// ===============================
function figma_theme_settings_menu() {
	add_menu_page(
		'Theme Settings',
		'Theme Settings',
		'manage_options',
		'theme-settings',
		'figma_theme_settings_page',
		'dashicons-admin-generic',
		60
	);
}
add_action( 'admin_menu', 'figma_theme_settings_menu' );


// ===============================
// THEME SETTINGS PAGE UI
// ===============================
function figma_theme_settings_page() {
	$options = figma_theme_get_options();
	?>
	<div class="wrap">
		<h1>Theme Settings</h1>

		<form method="post">
			<?php wp_nonce_field( 'save_theme_settings', 'theme_settings_nonce' ); ?>

			<h2>Header Settings</h2>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="phone">Phone Number</label></th>
					<td><input type="text" id="phone" name="phone" value="<?php echo esc_attr( $options['phone'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="email">Email</label></th>
					<td><input type="email" id="email" name="email" value="<?php echo esc_attr( $options['email'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="facebook">Facebook Link</label></th>
					<td><input type="url" id="facebook" name="facebook" value="<?php echo esc_attr( $options['facebook'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="instagram">Instagram Link</label></th>
					<td><input type="url" id="instagram" name="instagram" value="<?php echo esc_attr( $options['instagram'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="linkedin">LinkedIn Link</label></th>
					<td><input type="url" id="linkedin" name="linkedin" value="<?php echo esc_attr( $options['linkedin'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="site_logo">Logo URL</label></th>
					<td>
						<input type="url" id="site_logo" name="site_logo" value="<?php echo esc_attr( $options['site_logo'] ); ?>" class="regular-text">
						<p class="description">Paste an image URL for the fallback custom logo.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="btn1_text">Button 1 Text</label></th>
					<td><input type="text" id="btn1_text" name="btn1_text" value="<?php echo esc_attr( $options['btn1_text'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="btn1_link">Button 1 Link</label></th>
					<td><input type="url" id="btn1_link" name="btn1_link" value="<?php echo esc_attr( $options['btn1_link'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="btn2_text">Button 2 Text</label></th>
					<td><input type="text" id="btn2_text" name="btn2_text" value="<?php echo esc_attr( $options['btn2_text'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="btn2_link">Button 2 Link</label></th>
					<td><input type="url" id="btn2_link" name="btn2_link" value="<?php echo esc_attr( $options['btn2_link'] ); ?>" class="regular-text"></td>
				</tr>
			</table>

			<h2>Footer Settings</h2>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="footer_text">Footer Text</label></th>
					<td><input type="text" id="footer_text" name="footer_text" value="<?php echo esc_attr( $options['footer_text'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="copyright">Copyright</label></th>
					<td><input type="text" id="copyright" name="copyright" value="<?php echo esc_attr( $options['copyright'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="footer_quick_title">Quick Links Title</label></th>
					<td><input type="text" id="footer_quick_title" name="footer_quick_title" value="<?php echo esc_attr( $options['footer_quick_title'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="footer_services_title">Services Title</label></th>
					<td><input type="text" id="footer_services_title" name="footer_services_title" value="<?php echo esc_attr( $options['footer_services_title'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="footer_legal_title">Legal Title</label></th>
					<td><input type="text" id="footer_legal_title" name="footer_legal_title" value="<?php echo esc_attr( $options['footer_legal_title'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="newsletter_kicker">Newsletter Kicker</label></th>
					<td><input type="text" id="newsletter_kicker" name="newsletter_kicker" value="<?php echo esc_attr( $options['newsletter_kicker'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="newsletter_title">Newsletter Title</label></th>
					<td><input type="text" id="newsletter_title" name="newsletter_title" value="<?php echo esc_attr( $options['newsletter_title'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="newsletter_placeholder">Newsletter Input Placeholder</label></th>
					<td><input type="text" id="newsletter_placeholder" name="newsletter_placeholder" value="<?php echo esc_attr( $options['newsletter_placeholder'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="newsletter_button_text">Newsletter Button Text</label></th>
					<td><input type="text" id="newsletter_button_text" name="newsletter_button_text" value="<?php echo esc_attr( $options['newsletter_button_text'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="footer_phone_label">Phone Label</label></th>
					<td><input type="text" id="footer_phone_label" name="footer_phone_label" value="<?php echo esc_attr( $options['footer_phone_label'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="footer_email_label">Email Label</label></th>
					<td><input type="text" id="footer_email_label" name="footer_email_label" value="<?php echo esc_attr( $options['footer_email_label'] ); ?>" class="regular-text"></td>
				</tr>
			</table>

			<h2>Footer Link Groups</h2>
			<p class="description">Add links as label + URL pairs. Empty rows are ignored on save.</p>

			<h3>Quick Links</h3>
			<table class="widefat striped" style="max-width: 900px; margin-bottom: 24px;">
				<thead>
					<tr>
						<th>Label</th>
						<th>URL</th>
					</tr>
				</thead>
				<tbody>
					<?php figma_render_link_group_rows( 'footer_quick_links', $options['footer_quick_links'] ); ?>
				</tbody>
			</table>
			<p class="description" style="margin-top: -14px; margin-bottom: 20px;">Need more items? Click Add Row.</p>
			<p><button type="button" class="button figma-add-link-row" data-target="footer_quick_links">Add Row</button></p>

			<h3>Services Links</h3>
			<table class="widefat striped" style="max-width: 900px; margin-bottom: 24px;">
				<thead>
					<tr>
						<th>Label</th>
						<th>URL</th>
					</tr>
				</thead>
				<tbody>
					<?php figma_render_link_group_rows( 'footer_services_links', $options['footer_services_links'] ); ?>
				</tbody>
			</table>
			<p class="description" style="margin-top: -14px; margin-bottom: 20px;">Need more items? Click Add Row.</p>
			<p><button type="button" class="button figma-add-link-row" data-target="footer_services_links">Add Row</button></p>

			<h3>Legal Links</h3>
			<table class="widefat striped" style="max-width: 900px;">
				<thead>
					<tr>
						<th>Label</th>
						<th>URL</th>
					</tr>
				</thead>
				<tbody>
					<?php figma_render_link_group_rows( 'footer_legal_links', $options['footer_legal_links'] ); ?>
				</tbody>
			</table>
			<p class="description" style="margin-top: 10px;">Need more items? Click Add Row.</p>
			<p><button type="button" class="button figma-add-link-row" data-target="footer_legal_links">Add Row</button></p>

			<?php submit_button(); ?>
		</form>
	</div>
	<script>
	(function () {
		const addButtons = document.querySelectorAll('.figma-add-link-row');
		addButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				const target = button.getAttribute('data-target');
				const tbody = button.parentElement.previousElementSibling.previousElementSibling.querySelector('tbody');
				if (!tbody || !target) {
					return;
				}
				const nextIndex = tbody.querySelectorAll('tr').length;
				const row = document.createElement('tr');
				row.innerHTML =
					'<td><input type="text" name="' + target + '[' + nextIndex + '][label]" value="" class="regular-text" placeholder="Label"></td>' +
					'<td><input type="url" name="' + target + '[' + nextIndex + '][url]" value="" class="regular-text" placeholder="https://example.com"></td>';
				tbody.appendChild(row);
			});
		});
	})();
	</script>
	<?php
}


// ===============================
// SAVE THEME SETTINGS (OPTIONS API)
// ===============================
function figma_save_theme_settings() {
	if ( ! isset( $_POST['theme_settings_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['theme_settings_nonce'] ) ), 'save_theme_settings' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$options = figma_theme_get_options();

	$options['phone']                 = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$options['email']                 = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$options['facebook']              = isset( $_POST['facebook'] ) ? esc_url_raw( wp_unslash( $_POST['facebook'] ) ) : '';
	$options['instagram']             = isset( $_POST['instagram'] ) ? esc_url_raw( wp_unslash( $_POST['instagram'] ) ) : '';
	$options['linkedin']              = isset( $_POST['linkedin'] ) ? esc_url_raw( wp_unslash( $_POST['linkedin'] ) ) : '';
	$options['site_logo']             = isset( $_POST['site_logo'] ) ? esc_url_raw( wp_unslash( $_POST['site_logo'] ) ) : '';
	$options['btn1_text']             = isset( $_POST['btn1_text'] ) ? sanitize_text_field( wp_unslash( $_POST['btn1_text'] ) ) : '';
	$options['btn1_link']             = isset( $_POST['btn1_link'] ) ? esc_url_raw( wp_unslash( $_POST['btn1_link'] ) ) : '';
	$options['btn2_text']             = isset( $_POST['btn2_text'] ) ? sanitize_text_field( wp_unslash( $_POST['btn2_text'] ) ) : '';
	$options['btn2_link']             = isset( $_POST['btn2_link'] ) ? esc_url_raw( wp_unslash( $_POST['btn2_link'] ) ) : '';
	$options['footer_text']           = isset( $_POST['footer_text'] ) ? sanitize_text_field( wp_unslash( $_POST['footer_text'] ) ) : '';
	$options['copyright']             = isset( $_POST['copyright'] ) ? sanitize_text_field( wp_unslash( $_POST['copyright'] ) ) : '';
	$options['footer_quick_title']    = isset( $_POST['footer_quick_title'] ) ? sanitize_text_field( wp_unslash( $_POST['footer_quick_title'] ) ) : '';
	$options['footer_services_title'] = isset( $_POST['footer_services_title'] ) ? sanitize_text_field( wp_unslash( $_POST['footer_services_title'] ) ) : '';
	$options['footer_legal_title']    = isset( $_POST['footer_legal_title'] ) ? sanitize_text_field( wp_unslash( $_POST['footer_legal_title'] ) ) : '';
	$options['newsletter_kicker']     = isset( $_POST['newsletter_kicker'] ) ? sanitize_text_field( wp_unslash( $_POST['newsletter_kicker'] ) ) : '';
	$options['newsletter_title']      = isset( $_POST['newsletter_title'] ) ? sanitize_text_field( wp_unslash( $_POST['newsletter_title'] ) ) : '';
	$options['newsletter_placeholder']= isset( $_POST['newsletter_placeholder'] ) ? sanitize_text_field( wp_unslash( $_POST['newsletter_placeholder'] ) ) : '';
	$options['newsletter_button_text']= isset( $_POST['newsletter_button_text'] ) ? sanitize_text_field( wp_unslash( $_POST['newsletter_button_text'] ) ) : '';
	$options['footer_phone_label']    = isset( $_POST['footer_phone_label'] ) ? sanitize_text_field( wp_unslash( $_POST['footer_phone_label'] ) ) : '';
	$options['footer_email_label']    = isset( $_POST['footer_email_label'] ) ? sanitize_text_field( wp_unslash( $_POST['footer_email_label'] ) ) : '';
	$options['footer_quick_links']    = isset( $_POST['footer_quick_links'] ) ? figma_sanitize_link_rows( wp_unslash( $_POST['footer_quick_links'] ) ) : array();
	$options['footer_services_links'] = isset( $_POST['footer_services_links'] ) ? figma_sanitize_link_rows( wp_unslash( $_POST['footer_services_links'] ) ) : array();
	$options['footer_legal_links']    = isset( $_POST['footer_legal_links'] ) ? figma_sanitize_link_rows( wp_unslash( $_POST['footer_legal_links'] ) ) : array();

	update_option( 'figma_theme_options', $options );

	// Backward compatibility for currently-used template calls.
	update_option( 'phone', $options['phone'] );
	update_option( 'email', $options['email'] );
	update_option( 'facebook', $options['facebook'] );
	update_option( 'instagram', $options['instagram'] );
	update_option( 'linkedin', $options['linkedin'] );
	update_option( 'site_logo', $options['site_logo'] );
	update_option( 'btn1_text', $options['btn1_text'] );
	update_option( 'btn1_link', $options['btn1_link'] );
	update_option( 'btn2_text', $options['btn2_text'] );
	update_option( 'btn2_link', $options['btn2_link'] );
	update_option( 'footer_text', $options['footer_text'] );
	update_option( 'copyright', $options['copyright'] );
}
add_action( 'admin_init', 'figma_save_theme_settings' );


// ===============================
// META BOX (HERO SECTION - USING META BOX PLUGIN)
// ===============================
add_filter('rwmb_meta_boxes', function ($meta_boxes) {

    $meta_boxes[] = [
        'title'      => 'Hero Section',
        'id'         => 'hero_section',
        'post_types' => ['page'],
        'fields'     => [

            [
                'name' => 'Hero Title',
                'id'   => 'hero_title',
                'type' => 'text',
            ],
            [
                'name' => 'Hero Description',
                'id'   => 'hero_desc',
                'type' => 'textarea',
            ],
            [
                'name' => 'Button Text',
                'id'   => 'hero_btn_text',
                'type' => 'text',
            ],
            [
                'name' => 'Button Link',
                'id'   => 'hero_btn_link',
                'type' => 'url',
            ],
            [
                'name' => 'Background Image',
                'id'   => 'hero_bg',
                'type' => 'single_image',
            ],
        ],
    ];

	$meta_boxes[] = array(
		'title'      => 'Services Section',
		'id'         => 'services_section',
		'post_types' => array( 'page' ),
		'fields'     => array(
			array(
				'name' => 'Services Eyebrow',
				'id'   => 'services_eyebrow',
				'type' => 'text',
			),
			array(
				'name' => 'Services Section Title',
				'id'   => 'services_title',
				'type' => 'text',
			),
			array(
				'name' => 'Services Intro Text',
				'id'   => 'services_intro',
				'type' => 'textarea_small',
			),
			array(
				'name' => 'Services Button Text',
				'id'   => 'services_btn_text',
				'type' => 'text',
			),
			array(
				'name' => 'Services Button Link',
				'id'   => 'services_btn_link',
				'type' => 'url',
			),
			array(
				'name'       => 'Service Item Image',
				'id'         => 'service_item_image',
				'type'       => 'single_image',
				'clone'      => true,
				'sort_clone' => true,
			),
			array(
				'name' => 'Service Item Title',
				'id'   => 'service_item_title',
				'type' => 'text',
				'clone'      => true,
				'sort_clone' => true,
			),
			array(
				'name' => 'Service Item Description',
				'id'   => 'service_item_desc',
				'type' => 'textarea_small',
				'clone'      => true,
				'sort_clone' => true,
			),
			array(
				'name' => 'Service Item Link',
				'id'   => 'service_item_link',
				'type' => 'url',
				'clone'      => true,
				'sort_clone' => true,
			),
		),
	);

	$meta_boxes[] = array(
		'title'      => 'Why Choose Us Section',
		'id'         => 'why_choose_section',
		'post_types' => array( 'page' ),
		'fields'     => array(
			array(
				'name' => 'Section Eyebrow',
				'id'   => 'why_choose_eyebrow',
				'type' => 'text',
			),
			array(
				'name' => 'Section Title',
				'id'   => 'why_choose_title',
				'type' => 'text',
			),
			array(
				'name' => 'Button Text',
				'id'   => 'why_choose_btn_text',
				'type' => 'text',
			),
			array(
				'name' => 'Button Link',
				'id'   => 'why_choose_btn_link',
				'type' => 'url',
			),
			array(
				'name'       => 'Card Icon/Image',
				'id'         => 'why_choose_item_image',
				'type'       => 'single_image',
				'clone'      => true,
				'sort_clone' => true,
			),
			array(
				'name' => 'Card Title',
				'id'   => 'why_choose_item_title',
				'type' => 'text',
				'clone' => true,
				'sort_clone' => true,
			),
			array(
				'name' => 'Card Description',
				'id'   => 'why_choose_item_desc',
				'type' => 'textarea_small',
				'clone' => true,
				'sort_clone' => true,
			),
		),
	);

	$meta_boxes[] = array(
		'title'      => 'Stats Content Section',
		'id'         => 'stats_content_section',
		'post_types' => array( 'page' ),
		'fields'     => array(
			array(
				'name' => 'Section Background Image',
				'id'   => 'stats_section_image',
				'type' => 'single_image',
			),
			array(
				'name'       => 'Stat Number',
				'id'         => 'stats_item_number',
				'type'       => 'text',
				'clone'      => true,
				'sort_clone' => true,
			),
			array(
				'name'       => 'Stat Label',
				'id'         => 'stats_item_label',
				'type'       => 'text',
				'clone'      => true,
				'sort_clone' => true,
			),
		),
	);

    return $meta_boxes;
});