<?php
$user_id = um_get_requested_user();

if (function_exists('admin_lab_render_giveaway_promo_table')) {
    admin_lab_render_giveaway_promo_table();
}

echo do_shortcode('[admin_lab_participation_table]');
?>
