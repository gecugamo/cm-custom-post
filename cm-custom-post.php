<?php
  /*
  Plugin Name: CM Custom Post
  Plugin URI:  https://github.com/gecugamo/cm-custom-post.git
  Description: Plugin boilerplate with custom post type and custom meta boxes.
  Version:     1.0
  Author:      Gary Cuga-Moylan
  Author URI:  https://cuga-moylan.com
  License:     GPL2

  CM Custom Post is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 2 of the License, or
  any later version.

  CM Custom Post is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with CM Custom Post. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html.
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  exit;
}

// Only run plugin code in admin area.
if ( is_admin() ) {
     require_once plugin_dir_path( __FILE__ ) . 'admin/cm-custom-post-cpt.php';
     require_once plugin_dir_path( __FILE__ ) . 'admin/cm-custom-post-fields.php';
}

function cm_custom_post_activate() {

    // Trigger our function that registers the custom post type
    cm_custom_post_type_register();

    // Clear the permalinks after the post type has been registered
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'cm_custom_post_activate' );

function cm_custom_post_deactivation() {

    // Clear the permalinks to remove our post type's rules
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'cm_custom_post_deactivation' );
