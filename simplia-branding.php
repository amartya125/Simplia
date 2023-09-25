<?php
/*
Plugin Name: Simplia Branding
Description: Replaces WordPress branding with Simplia throughout the website.
Version: 1.0
Author: Amarteya
*/

// Replace WordPress branding throughout the website
function replace_wordpress_branding($content) {
    $content = str_replace('WordPress', 'Simplia', $content);
    // Add more replacements if needed
    return $content;
}
add_filter('the_content', 'replace_wordpress_branding');


// Replace WordPress branding
function replace_wordpress_branding_footer($footer_text) {
    return 'Simplia';
}
add_filter('admin_footer_text', 'replace_wordpress_branding_footer');

// Remove update and notification banners
function remove_update_banners() {
    remove_action('admin_notices', 'update_nag', 3);
    remove_action('admin_notices', 'maintenance_nag', 10);
    remove_action('all_admin_notices', 'print_admin_notice_templates');
}
add_action('admin_head', 'remove_update_banners');


function remove_dashboard_widgets() {
    global $wp_meta_boxes;
   
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
   
}
   
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );


function remove_wp_version() {
    return '';
}
add_filter('the_generator', 'remove_wp_version');


function remove_wp_version_footer() {
    remove_filter('update_footer', 'core_update_footer');
}
add_action('admin_menu', 'remove_wp_version_footer');

// Function to hide the Updates menu item
function hide_updates_menu() {
    global $menu;

    // Specify the user roles for which you want to hide the Updates menu item
    $disallowed_roles = array('editor', 'author'); // Replace with the desired roles

    foreach ($menu as $menu_key => $menu_data) {
        if (in_array($menu_data[1], $disallowed_roles)) {
            unset($menu[$menu_key]);
        }
    }
}

// Hook into the 'admin_menu' action to run the function
add_action('admin_menu', 'hide_updates_menu');
