<?php
if ( ! defined('ABSPATH') ) exit;


/**
 * =========================
 * Génération dynamique des variables CSS dans .elementor-kit-{id}
 * =========================
 */
function me5rine_generate_css_variables() {
	// Récupération de l'ID du kit Elementor depuis la base de données
	$kit_id = get_option('admin_lab_elementor_kit_id', '');
	
	// Nettoyage de l'ID (suppression des espaces, etc.)
	$kit_id = trim($kit_id);
	
	// Si l'option n'est pas définie, on essaie de récupérer l'ID du kit actif Elementor
	if ( empty($kit_id) && class_exists('\Elementor\Plugin') ) {
		$active_kit = \Elementor\Plugin::$instance->kits_manager->get_active_id();
		if ( $active_kit ) {
			$kit_id = $active_kit;
		}
	}
	
	// Si l'ID n'est pas défini, on utilise :root comme fallback
	$selector = !empty($kit_id) ? '.elementor-kit-' . esc_attr($kit_id) : ':root';
	
	// Contenu des variables CSS
	$css = "/* ============================================
   VARIABLES CSS GLOBALES
   ============================================ */

{$selector} {
    /* Fonts */
    --me5rine-lab-font: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Helvetica, Arial, sans-serif;
    
    /* Variables CSS unifiées front-end */
    --me5rine-lab-primary: var(--e-global-color-primary, #2E576F);
    --me5rine-lab-secondary: var(--e-global-color-secondary, #0485C8);
    --me5rine-lab-white: var(--e-global-color-338f618, #ffffff);
    
    /* Couleurs de fond */
    --me5rine-lab-bg: var(--e-global-color-338f618, #ffffff);
    --me5rine-lab-bg-secondary: var(--e-global-color-3d5ef52, #F9FAFB);
    --me5rine-lab-bg-odd: #f6f7f7;
    
    /* Couleurs de texte */
    --me5rine-lab-text: var(--e-global-color-09712b1, #11161E);
    --me5rine-lab-text-light: var(--e-global-color-text, #5D697D);
    --me5rine-lab-text-muted: #a7aaad;
    
    /* Couleurs de bordures */
    --me5rine-lab-border: var(--e-global-color-6b6f4d4, #DEE5EC);
    --me5rine-lab-border-light: #B5C2CF;
    
    /* Couleurs de boutons */
    --me5rine-lab-button-primary-bg: var(--me5rine-lab-secondary, #0485C8);
    --me5rine-lab-button-primary-hover: var(--e-global-color-primary, #2E576F);
    --me5rine-lab-button-secondary-bg: var(--me5rine-lab-bg-secondary, #F9FAFB);
    --me5rine-lab-button-secondary-border: var(--me5rine-lab-border, #DEE5EC);
    
    /* Couleurs de boutons - Remove/Danger */
    --me5rine-lab-button-remove: #dc3545;
    --me5rine-lab-button-remove-hover: #c82333;
    
    /* Couleurs de messages et états */
    --me5rine-lab-success: #4CAF50;
    --me5rine-lab-success-bg: rgba(76, 175, 80, 0.1);
    --me5rine-lab-success-border: rgba(76, 175, 80, 0.2);
    
    --me5rine-lab-error: #F44336;
    --me5rine-lab-error-bg: rgba(244, 67, 54, 0.1);
    --me5rine-lab-error-border: rgba(244, 67, 54, 0.2);
    
    --me5rine-lab-warning: #FF9800;
    --me5rine-lab-warning-bg: rgba(255, 152, 0, 0.1);
    --me5rine-lab-warning-border: rgba(255, 152, 0, 0.2);
    
    --me5rine-lab-info: #2196F3;
    --me5rine-lab-info-bg: rgba(33, 150, 243, 0.1);
    --me5rine-lab-info-border: rgba(33, 150, 243, 0.2);
    
    /* Couleurs de statuts (basées sur les notifications) */
    --me5rine-lab-status-success-bg: var(--me5rine-lab-success-bg, rgba(76, 175, 80, 0.1));
    --me5rine-lab-status-success-text: var(--me5rine-lab-success, #4CAF50);
    --me5rine-lab-status-success-border: var(--me5rine-lab-success-border, rgba(76, 175, 80, 0.2));
    
    --me5rine-lab-status-warning-bg: var(--me5rine-lab-warning-bg, rgba(255, 152, 0, 0.1));
    --me5rine-lab-status-warning-text: var(--me5rine-lab-warning, #FF9800);
    --me5rine-lab-status-warning-border: var(--me5rine-lab-warning-border, rgba(255, 152, 0, 0.2));
    
    --me5rine-lab-status-error-bg: var(--me5rine-lab-error-bg, rgba(244, 67, 54, 0.1));
    --me5rine-lab-status-error-text: var(--me5rine-lab-error, #F44336);
    --me5rine-lab-status-error-border: var(--me5rine-lab-error-border, rgba(244, 67, 54, 0.2));
    
    --me5rine-lab-status-info-bg: var(--me5rine-lab-info-bg, rgba(33, 150, 243, 0.1));
    --me5rine-lab-status-info-text: var(--me5rine-lab-info, #2196F3);
    --me5rine-lab-status-info-border: var(--me5rine-lab-info-border, rgba(33, 150, 243, 0.2));
    
    /* Couleurs de focus/active avec transparence */
    --me5rine-lab-focus-ring: rgba(4, 133, 200, 0.1);
    --me5rine-lab-focus-ring-medium: rgba(4, 133, 200, 0.15);
    --me5rine-lab-focus-ring-strong: rgba(4, 133, 200, 0.2);
    --me5rine-lab-focus-ring-secondary: rgba(93, 105, 125, 0.2);
    
    /* Couleurs de texte sur fond coloré */
    --me5rine-lab-white-hover: rgba(255, 255, 255, 0.8);
    
    /* Couleurs de médailles (Podium) */
    --me5rine-lab-medal-gold: #ffd700;
    --me5rine-lab-medal-silver: #c0c0c0;
    --me5rine-lab-medal-bronze: #cd7f32;
    
    /* Espacements */
    --me5rine-lab-spacing-xs: 5px;
    --me5rine-lab-spacing-sm: 10px;
    --me5rine-lab-spacing-md: 15px;
    --me5rine-lab-spacing-lg: 20px;
    --me5rine-lab-spacing-xl: 25px;
    
    /* Rayons de bordure */
    --me5rine-lab-radius-sm: 6px;
    --me5rine-lab-radius-md: 8px;
    --me5rine-lab-radius-lg: 12px;
    --me5rine-lab-radius-bg: 20px;
    
    /* Ombres */
    --me5rine-lab-shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
    --me5rine-lab-shadow-md: 0 2px 4px rgba(0, 0, 0, 0.1);
    --me5rine-lab-shadow-lg: 0 4px 8px rgba(0, 0, 0, 0.15);
    
    /* Transitions */
    --me5rine-lab-transition: all 0.2s ease;
}
";
	
	return $css;
}

/**
 * =========================
 * Injection des variables CSS dans le head
 * =========================
 */
add_action( 'wp_head', function() {
	$css = me5rine_generate_css_variables();
	// Nettoyage du CSS (suppression des espaces en début/fin)
	$css = trim($css);
	echo '<style id="me5rine-lab-variables">' . "\n" . $css . "\n" . '</style>' . "\n";
}, 1 );

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

	// Charger le script sur toutes les pages pour que les menus (UM et me5rine-lab) fonctionnent partout
	// Le JavaScript vérifiera lui-même si les menus sont présents avant de les initialiser
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
