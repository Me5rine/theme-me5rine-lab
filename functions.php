<?php
if ( ! defined('ABSPATH') ) exit;


/**
 * =========================
 * Enqueue style.css du thème enfant (toujours)
 * =========================
 */
add_action( 'wp_enqueue_scripts', function() {

	$rel  = '/style.css';
	$path = get_stylesheet_directory() . $rel;

	wp_enqueue_style(
		'me5rine-child-style',
		get_stylesheet_directory_uri() . $rel,
		[ 'hello-elementor', 'hello-elementor-theme-style', 'hello-elementor-header-footer' ],
		file_exists($path) ? filemtime($path) : null
	);

}, 99999 );

/**
 * =========================
 * ENQUEUE (avec filemtime safe)
 * =========================
 */
function me5rine_safe_file_version( $path ) {
	return file_exists( $path ) ? filemtime( $path ) : time();
}

function me5rine_enqueue_um_profile_assets() {

	if ( function_exists('um_is_core_page') && um_is_core_page('user') ) {

		$js_rel  = '/ultimate-member/js/profile-menu.js';
		$js_path = get_stylesheet_directory() . $js_rel;

		if ( file_exists( $js_path ) ) {
			wp_enqueue_script(
				'me5rine-um-profile-script',
				get_stylesheet_directory_uri() . $js_rel,
				[],
				filemtime( $js_path ),
				true
			);
		}

		// ✅ Pas de CSS dédié ici : tout est dans style.css du thème
	}
}
add_action('wp_enqueue_scripts', 'me5rine_enqueue_um_profile_assets', 99999);



/**
 * =========================
 * Traductions thème
 * =========================
 */
add_action( 'after_setup_theme', function() {
	load_theme_textdomain( 'me5rine', get_stylesheet_directory() . '/languages' );
});


/**
 * =========================
 * Redirect après sauvegarde UM
 * -> rester sur l'onglet edit + ajouter une notice
 * =========================
 */
add_filter( 'um_update_profile_redirect_after', function( $url, $user_id, $args ) {

	$profile_url = um_user_profile_url( (int) $user_id );

	$edit_profile  = ! empty($_REQUEST['edit-profile']);
	$edit_socials  = ! empty($_REQUEST['edit-socials']);

	// Edit profile
	if ( $edit_profile ) {
		return add_query_arg(
			[
				'um_action'    => 'edit',
				'edit-profile' => 'true',

				// Notre système de notice
				'notice'       => 'success',
				'notice_key'   => 'profile',
				'notice_msg'   => rawurlencode( __('Profile updated successfully', 'me5rine') ),
			],
			$profile_url
		);
	}

	// Edit socials
	if ( $edit_socials ) {
		return add_query_arg(
			[
				'um_action'     => 'edit',
				'edit-socials'  => 'true',

				// Notre système de notice
				'notice'        => 'success',
				'notice_key'    => 'socials',
				'notice_msg'    => rawurlencode( __('Social networks updated successfully', 'me5rine') ),
			],
			$profile_url
		);
	}

	return $url;
}, 10, 3 );


/**
 * =========================
 * Affichage des notices (NOTRE système)
 * À appeler dans le template custom-profile.php
 * =========================
 */
if ( ! function_exists('me5rine_display_profile_notice') ) {
	function me5rine_display_profile_notice() {

		$type = $_GET['notice'] ?? '';
		if ( ! in_array( $type, ['success','error','info','warning'], true ) ) {
			return;
		}

		// message optionnel
		$msg = $_GET['notice_msg'] ?? '';
		$msg = is_string($msg) ? rawurldecode($msg) : '';

		// fallback message selon type si vide
		if ( $msg === '' ) {
			$defaults = [
				'success' => __('Saved successfully.', 'me5rine'),
				'error'   => __('An error occurred.', 'me5rine'),
				'warning' => __('Please check the information.', 'me5rine'),
				'info'    => __('Information message.', 'me5rine'),
			];
			$msg = $defaults[$type] ?? '';
		}

		printf(
			'<p class="um-notice %1$s" role="alert">%2$s</p>',
			esc_attr($type),
			esc_html($msg)
		);
	}
}
