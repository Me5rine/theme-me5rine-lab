<?php
/**
 * Handler PHP pour servir style.css avec versioning dynamique des @import
 * Ce fichier injecte automatiquement les paramètres de version dans les URLs des @import
 */

if ( ! defined('ABSPATH') ) {
	// Si appelé directement, on essaie de charger WordPress
	$wp_load = dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';
	if ( file_exists($wp_load) ) {
		require_once($wp_load);
	} else {
		header('Content-Type: text/css');
		header('HTTP/1.0 404 Not Found');
		exit;
	}
}

// Définir le type de contenu
header('Content-Type: text/css; charset=utf-8');

// Activer la compression si disponible
if ( function_exists('ob_gzhandler') && !ob_get_level() ) {
	ob_start('ob_gzhandler');
}

// Récupérer le chemin du thème
$theme_dir = get_stylesheet_directory();
$style_path = $theme_dir . '/style.css';

if ( !file_exists($style_path) ) {
	header('HTTP/1.0 404 Not Found');
	exit;
}

// Lire le contenu de style.css
$content = file_get_contents($style_path);

// Extraire les @import et ajouter les versions
// Récupérer l'URL de base du thème pour générer des URLs absolues
$theme_url = get_stylesheet_directory_uri();

$content = preg_replace_callback(
	'/@import\s+(?:url\()?[\'"]?([^\'")]+)[\'"]?\)?;/i',
	function($matches) use ($theme_dir, $theme_url) {
		$import_path = trim($matches[1]);
		
		// Nettoyer le chemin (supprimer les paramètres de requête existants)
		$import_path = strtok($import_path, '?');
		
		// Construire le chemin complet pour vérifier le fichier
		$full_path = $theme_dir . '/' . $import_path;
		
		// Obtenir le timestamp du fichier
		$version = file_exists($full_path) ? filemtime($full_path) : time();
		
		// Construire l'URL absolue avec la version
		$import_url = $theme_url . '/' . $import_path . '?ver=' . $version;
		
		// Reconstruire le @import avec l'URL absolue et la version
		$original_match = $matches[0];
		
		// Si l'URL utilise url(), on doit préserver ce format
		if ( strpos($original_match, 'url(') !== false ) {
			return '@import url(\'' . $import_url . '\');';
		} else {
			return '@import \'' . $import_url . '\';';
		}
	},
	$content
);

// Définir les en-têtes de cache (optionnel, pour améliorer les performances)
// Mais on veut quand même que le navigateur vérifie les mises à jour
$cache_time = 3600; // 1 heure
header('Cache-Control: public, max-age=' . $cache_time);
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cache_time) . ' GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($style_path)) . ' GMT');

// Afficher le contenu modifié
echo $content;

