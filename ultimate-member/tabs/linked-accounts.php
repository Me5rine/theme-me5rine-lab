<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

$user_id = um_get_requested_user();

// Vérifier si le shortcode existe et l'exécuter
if (shortcode_exists('admin_lab_kap_connections')) {
	echo do_shortcode('[admin_lab_kap_connections]');
} else {
	// Fallback : essayer directement avec do_shortcode même si non détecté
	echo do_shortcode('[admin_lab_kap_connections]');
}
?>

