<?php /* Template: Profile Custom */if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
/**
 * Template for the profile page
 *
 * This template can be overridden by copying it to your-theme/ultimate-member/templates/profile.php
 *
 * Page: "Profile"
 *
 * @version 2.10.0
 *
 * @var string $mode
 * @var int    $form_id
 * @var array  $args
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$description_key = UM()->profile()->get_show_bio_key( $args );
?>
<div class="um <?php echo esc_attr( $this->get_class( $mode ) ); ?> um-<?php echo esc_attr( $form_id ); ?> um-role-<?php echo esc_attr( um_user( 'role' ) ); ?>">
	<div class="um-form" data-mode="<?php echo esc_attr( $mode ); ?>" data-form_id="<?php echo esc_attr( $form_id ); ?>">
		<?php
		/**
		 * Fires before User Profile header.
		 * It's the first hook at User Profile wrapper.
		 *
		 * Internal Ultimate Member callbacks (Priority -> Callback name -> Excerpt):
		 * 10 - `um_profile_completeness_show_notice()` displays Profile Completeness notices.
		 *
		 * @param {array} $args User Profile data.
		 *
		 * @since 1.3.x
		 * @hook  um_profile_before_header
		 *
		 * @example <caption>Display some content before User Profile.</caption>
		 * function my_um_profile_before_header( $args ) {
		 *     // your code here
		 *     echo $notice;
		 * }
		 * add_action( 'um_profile_before_header', 'my_um_profile_before_header' );
		 */
		do_action( 'um_profile_before_header', $args );

		if ( um_is_on_edit_profile() ) {
			?>
			<form method="post" action="" data-description_key="<?php echo esc_attr( $description_key ); ?>">
			<?php
		}
		/**
		 * Fires for displaying User Profile cover area.
		 *
		 * Internal Ultimate Member callbacks (Priority -> Callback name -> Excerpt):
		 * 9 - `um_profile_header_cover_area()` displays User Profile cover photo.
		 *
		 * @param {array} $args User Profile data.
		 *
		 * @since 1.3.x
		 * @hook  um_profile_header_cover_area
		 *
		 * @example <caption>Display some content before or after User Profile cover.</caption>
		 * function my_um_profile_header_cover_area( $args ) {
		 *     // your code here
		 *     echo $content;
		 * }
		 * add_action( 'um_profile_header_cover_area', 'my_um_profile_header_cover_area' );
		 */
		do_action( 'um_profile_header_cover_area', $args );

		if (function_exists('admin_lab_user_is_partner') && admin_lab_user_is_partner( um_profile_id() )) {
			?>
			<div class="um-profile-badge-partenaire-wrapper">
				<div class="um-profile-badge-partenaire">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/ultimate-member/img/badge-partenaire.png" alt="Partenaire">
				</div>
			</div>
			<?php
		}

		/**
		 * Fires for displaying User Profile header.
		 *
		 * Internal Ultimate Member callbacks (Priority -> Callback name -> Excerpt):
		 * 9 - `um_profile_header()` displays User Profile header.
		 *
		 * @param {array} $args User Profile data.
		 *
		 * @since 1.3.x
		 * @hook  um_profile_header
		 *
		 * @example <caption>Display some content before or after User Profile header.</caption>
		 * function my_um_profile_header( $args ) {
		 *     // your code here
		 *     echo $content;
		 * }
		 * add_action( 'um_profile_header', 'my_um_profile_header' );
		 */
		do_action( 'um_profile_header', $args );

		$current_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 
               (isset($_GET['edit-profile']) && $_GET['edit-profile'] === 'true' ? 'edit-profile' : 
               (isset($_GET['edit-socials']) && $_GET['edit-socials'] === 'true' ? 'edit-socials' : 'profile'));

		// List of functional tabs (tabs that are handled in the switch statement)
		$functional_tabs = [
			'profile',
			'giveaways',
			'game-pokemon-go',
			'account-settings',
			'account-datas',
			'edit-profile',
			'edit-socials'
		];

		// Helper function to check if a tab is functional
		function um_is_tab_functional($tab, $functional_tabs) {
			return in_array($tab, $functional_tabs);
		}

		// Helper function to check if a menu has any functional tab
		function um_has_functional_tab($menu_prefix, $submenu_tabs, $functional_tabs) {
			// Check if menu prefix itself is functional
			if (um_is_tab_functional($menu_prefix, $functional_tabs)) {
				return true;
			}
			// Check if any submenu tab is functional
			foreach ($submenu_tabs as $submenu_tab) {
				if (um_is_tab_functional($submenu_tab, $functional_tabs)) {
					return true;
				}
			}
			return false;
		}

		// Helper function to check if a menu or submenu is active
		// Only active if a submenu is selected, not if the tab matches the menu prefix
		function um_is_menu_active($current_tab, $menu_prefix, $submenu_tabs = []) {
			// Check if current tab matches any of the submenu tabs
			foreach ($submenu_tabs as $submenu_tab) {
				if ($current_tab === $submenu_tab) {
					return true;
				}
			}
			// Also check if the tab exactly matches the menu prefix (for menus that have their own tab)
			if ($current_tab === $menu_prefix) {
				return true;
			}
			return false;
		}

		// Helper function to get menu class
		// Menus are disabled if they have no functional tab (parent or submenu)
		function um_get_menu_class($current_tab, $menu_prefix, $submenu_tabs = [], $functional_tabs = []) {
			$is_active = um_is_menu_active($current_tab, $menu_prefix, $submenu_tabs);
			$has_functional_tab = um_has_functional_tab($menu_prefix, $submenu_tabs, $functional_tabs);
			
			$class = $is_active ? 'active' : '';
			if (!$has_functional_tab) {
				$class .= ' um-tab-disabled';
			}
			return trim($class);
		}

		?>
<div class="um-profile-connect um-member-connect">
    <?php
    $socials_list = admin_lab_get_global_option('admin_lab_socials_list', []);
    $profile_user_id = function_exists('um_profile_id') ? um_profile_id() : null;
	
	if (is_string($socials_list)) {
		$maybe_unserialized = @unserialize($socials_list);
		if ($maybe_unserialized !== false || $socials_list === 'b:0;') {
			$socials_list = $maybe_unserialized;
		}
	}

    if (!empty($socials_list) && $profile_user_id) {
        uasort($socials_list, function($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        foreach ($socials_list as $social_key => $social) {
            if (empty($social['enabled']) || $social['type'] !== 'social') continue;

            $social_url = get_user_meta($profile_user_id, $social['meta_key'], true);
            if (empty($social_url)) continue;

            $label = esc_html($social['label']);
            $title = esc_attr($label);
            $bg = !empty($social['color']) ? $social['color'] : '#000';
            $icon_class = !empty($social['fa']) ? $social['fa'] : 'fa-' . strtolower($social_key);
            ?>
            <a href="<?php echo esc_url($social_url); ?>"
               style="background: <?php echo esc_attr($bg); ?>;"
               target="_blank"
               class="um-tip-n"
               original-title="<?php echo $title; ?>">
                <i class="<?php echo esc_attr($icon_class); ?>"></i>
            </a>
            <?php
        }
    }
    ?>
</div>






		<div class="um-profile-layout">
			<div class="um-profile-menu-wrapper">
				<button class="um-profile-menu-toggle" aria-expanded="false" aria-controls="um-profile-menu">
				<p class="um-menu-toggle-text"><?php _e( 'Menu', 'me5rine' ); ?></p>
				</button>
				<nav id="um-profile-menu" class="um-profile-menu-vertical">

					<a href="?tab=profile" class="<?= $current_tab === 'profile' ? 'active' : '' ?>">
						<span class="um-menu-icon"><i class="fa fa-user"></i></span>
						<span><?php _e( 'Profile', 'me5rine' ); ?></span>
					</a>
					<?php if ( is_user_logged_in() && get_current_user_id() === um_profile_id() ) : ?>
						<div class="has-sub">
							<a href="?tab=notifications" class="<?= um_get_menu_class($current_tab, 'notifications', ['notifications-new', 'notifications-archived'], $functional_tabs) ?>">
								<span class="um-menu-icon"><i class="fa fa-bell"></i></span>
								<span><?php _e( 'Notifications', 'me5rine' ); ?></span>
							</a>
							<div class="submenu">
							<a href="?tab=notifications-new" class="<?= $current_tab === 'notifications-new' ? 'active' : '' ?>"><?php _e( 'New notifications', 'me5rine' ); ?></a>
							<a href="?tab=notifications-archived" class="<?= $current_tab === 'notifications-archived' ? 'active' : '' ?>"><?php _e( 'Archived notifications', 'me5rine' ); ?></a>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( is_user_logged_in() && get_current_user_id() === um_profile_id() ) : ?>
						<div class="has-sub">
							<a href="?tab=messaging" class="<?= um_get_menu_class($current_tab, 'messaging', ['messaging-received', 'messaging-pinned', 'messaging-send', 'messaging-new'], $functional_tabs) ?>">
								<span class="um-menu-icon"><i class="fa fa-envelope"></i></span>
								<span><?php _e( 'Messaging', 'me5rine' ); ?></span>
							</a>
							<div class="submenu">
							<a href="?tab=messaging-received" class="<?= $current_tab === 'messaging-received' ? 'active' : '' ?>"><?php _e( 'Inbox', 'me5rine' ); ?></a>
							<a href="?tab=messaging-pinned" class="<?= $current_tab === 'messaging-pinned' ? 'active' : '' ?>"><?php _e( 'Pinned messages', 'me5rine' ); ?></a>
							<a href="?tab=messaging-send" class="<?= $current_tab === 'messaging-send' ? 'active' : '' ?>"><?php _e( 'Sent messages', 'me5rine' ); ?></a>
							<a href="?tab=messaging-new" class="<?= $current_tab === 'messaging-new' ? 'active' : '' ?>"><?php _e( 'Send a message', 'me5rine' ); ?></a>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( is_user_logged_in() && get_current_user_id() === um_profile_id() ) : ?>
						<div class="has-sub">
							<a href="?tab=shop" class="<?= um_get_menu_class($current_tab, 'shop', ['shop-orders', 'shop-order-tracking', 'shop-downloads', 'shop-addresses', 'shop-payment-methods'], $functional_tabs) ?>">
								<span class="um-menu-icon"><i class="fa fa-shopping-cart"></i></span>
								<span><?php _e( 'Shop', 'me5rine' ); ?></span>
							</a>
							<div class="submenu">
							<a href="?tab=shop-orders" class="<?= $current_tab === 'shop-orders' ? 'active' : '' ?>"><?php _e( 'Orders', 'me5rine' ); ?></a>
							<a href="?tab=shop-order-tracking" class="<?= $current_tab === 'shop-order-tracking' ? 'active' : '' ?>"><?php _e( 'Order tracking', 'me5rine' ); ?></a>
							<a href="?tab=shop-downloads" class="<?= $current_tab === 'shop-downloads' ? 'active' : '' ?>"><?php _e( 'Downloads', 'me5rine' ); ?></a>
							<a href="?tab=shop-addresses" class="<?= $current_tab === 'shop-addresses' ? 'active' : '' ?>"><?php _e( 'Addresses', 'me5rine' ); ?></a>
							<a href="?tab=shop-payment-methods" class="<?= $current_tab === 'shop-payment-methods' ? 'active' : '' ?>"><?php _e( 'Payment methods', 'me5rine' ); ?></a>
							</div>
						</div>
					<?php endif; ?>

					<div class="has-sub">
						<a href="?tab=rewards" class="<?= um_get_menu_class($current_tab, 'rewards', ['rewards-points', 'rewards-badges', 'rewards-levels'], $functional_tabs) ?>">
							<span class="um-menu-icon"><i class="fa fa-star"></i></span>
							<span><?php _e( 'Rewards', 'me5rine' ); ?></span>
						</a>
						<div class="submenu">
						<a href="?tab=rewards-points" class="<?= $current_tab === 'rewards-points' ? 'active' : '' ?>"><?php _e( 'Points', 'me5rine' ); ?></a>
						<a href="?tab=rewards-badges" class="<?= $current_tab === 'rewards-badges' ? 'active' : '' ?>"><?php _e( 'Badges', 'me5rine' ); ?></a>
						<a href="?tab=rewards-levels" class="<?= $current_tab === 'rewards-levels' ? 'active' : '' ?>"><?php _e( 'Levels', 'me5rine' ); ?></a>
						</div>
					</div>

					<div class="has-sub">
						<a href="?tab=games" class="<?= um_get_menu_class($current_tab, 'games', ['game-pokemon-go'], $functional_tabs) ?>">
							<span class="um-menu-icon"><i class="fa fa-gamepad"></i></span>
							<span><?php _e( 'Games', 'me5rine' ); ?></span>
						</a>
						<div class="submenu">
						<a href="?tab=game-pokemon-go" class="<?= $current_tab === 'game-pokemon-go' ? 'active' : '' ?>"><?php _e( 'Pokémon GO', 'me5rine' ); ?></a>
						</div>
					</div>

						<a href="?tab=servers" class="<?= $current_tab === 'servers' ? 'active' : '' ?> um-tab-disabled">
							<span class="um-menu-icon"><i class="fa fa-server"></i></span>
							<span><?php _e( 'Servers', 'me5rine' ); ?></span>
						</a>

					<?php if ( is_user_logged_in() && get_current_user_id() === um_profile_id() ) : ?>
						<a href="?tab=giveaways" class="<?= $current_tab === 'giveaways' ? 'active' : '' ?>">
							<span class="um-menu-icon"><i class="fa fa-gift"></i></span>
							<span><?php _e( 'Giveaways', 'me5rine' ); ?></span>
						</a>
					<?php endif; ?>

					<?php if ( is_user_logged_in() && get_current_user_id() === um_profile_id() ) : ?>
						<div class="has-sub">
							<a href="?tab=account" class="<?= um_get_menu_class($current_tab, 'account', ['account-settings', 'linked-accounts', 'account-notifications', 'account-visibility', 'account-datas', 'edit-profile', 'edit-socials'], $functional_tabs) ?>">
								<span class="um-menu-icon"><i class="fa fa-cog"></i></span>
								<span><?php _e( 'Account', 'me5rine' ); ?></span>
							</a>
							<div class="submenu">
<?php if ( get_current_user_id() === um_profile_id() ) : ?>
    <?php
        // URL de l'édition du profil avec l'ajout du paramètre `edit-profile=true`
        $profile_url = remove_query_arg('tab', um_user_profile_url(um_profile_id()));
        $edit_url = add_query_arg(array(
            'um_action' => 'edit',
            'edit-profile' => 'true'  // Paramètre spécifique pour l'édition du profil
        ), $profile_url);
    ?>
    <a href="<?php echo esc_url($edit_url); ?>" class="<?= $current_tab === 'edit-profile' ? 'active' : '' ?>"><?php _e('Edit Profile', 'me5rine'); ?></a>
<?php endif; ?>

<?php if ( get_current_user_id() === um_profile_id() ) : ?>
    <?php
        // URL de l'édition des réseaux sociaux avec le paramètre `edit-socials=true`
        $profile_url = remove_query_arg('tab', um_user_profile_url(um_profile_id()));
        $edit_socials_url = add_query_arg(array(
            'um_action' => 'edit',
            'edit-socials' => 'true'  // Paramètre spécifique pour éditer les réseaux sociaux
        ), $profile_url);
    ?>
    <a href="<?php echo esc_url($edit_socials_url); ?>" class="<?= $current_tab === 'edit-socials' ? 'active' : '' ?>"><?php _e('Edit Socials', 'me5rine'); ?></a>
<?php endif; ?>


							<a href="?tab=account-settings" class="<?= $current_tab === 'account-settings' ? 'active' : '' ?>"><?php _e( 'Email & Password', 'me5rine' ); ?></a>
							<a href="?tab=linked-accounts" class="<?= $current_tab === 'linked-accounts' ? 'active' : '' ?>"><?php _e( 'Linked accounts', 'me5rine' ); ?></a>
							<a href="?tab=account-notifications" class="<?= $current_tab === 'account-notifications' ? 'active' : '' ?>"><?php _e( 'Notification settings', 'me5rine' ); ?></a>
							<a href="?tab=account-visibility" class="<?= $current_tab === 'account-visibility' ? 'active' : '' ?>"><?php _e( 'Visibility Settings', 'me5rine' ); ?></a>
							<a href="?tab=account-datas" class="<?= $current_tab === 'account-datas' ? 'active' : '' ?>"><?php _e( 'Data management', 'me5rine' ); ?></a>
							</div>
						</div>
					<?php endif; ?>

				</nav>
			</div>

	<!-- Contenu à droite -->
	<main class="um-profile-main-content">
		<?php
		// Affiche la notice EXACTEMENT ici
		if ( function_exists('me5rine_display_profile_notice') ) {
			me5rine_display_profile_notice();
		}
		?>

		<?php
		switch ($current_tab) {
			case 'giveaways':
				include get_stylesheet_directory() . '/ultimate-member/tabs/giveaways.php';
				break;
			case 'game-pokemon-go':
				include get_stylesheet_directory() . '/ultimate-member/tabs/pokehub-profil.php';
				break;
			case 'account-settings':
				include get_stylesheet_directory() . '/ultimate-member/tabs/account-settings.php';
				break;
			case 'account-datas':
				include get_stylesheet_directory() . '/ultimate-member/tabs/account-datas.php';
				break;
			default:
				include get_stylesheet_directory() . '/ultimate-member/tabs/profile.php';
				break;
			}
			?>
        </main>
    </div>

    <?php if ( um_is_on_edit_profile() ) : ?>
        </form>
    <?php endif; ?>

    </div>
</div>