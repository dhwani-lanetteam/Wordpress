<?php
/*
Plugin Name: SHIFT Short WP Admin Theme
Plugin URI: https://brshift.com/
Description: Clean the WordPress Dashboard and get more space!
Version: 1.3
Author: SHIFT
Author URI: https://brshift.com/
License: GPLv2
*/
/*
 *      Copyright 2015 Shift Empreendimentos Virtuais <producao@brshift.com>
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 3 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */
?>
<?php

// LOGIN PAGE
add_action( 'login_enqueue_scripts', 'short_theme_login' );
function short_theme_login() {
    wp_enqueue_style( 'short-login', plugins_url('css/login.css', __FILE__) );
}

add_filter( 'login_headerurl', 'short_login_url_logo' );
function short_login_url_logo() {
    return home_url();
}

add_filter( 'login_headertitle', 'short_login_logo_url_title' );
function short_login_logo_url_title() {
    return the_title();
}


// WP ADMIN
add_action( 'admin_enqueue_scripts', 'short_theme_general' );
function short_theme_general() {
        wp_enqueue_style( 'short-general', plugins_url('css/general.css', __FILE__) );
}

// CUSTOMIZE
add_action( 'admin_enqueue_scripts', 'short_theme_customize' );
function short_theme_customize() {
    global $pagenow;
	if (( $pagenow == 'customize.php' )) {
        wp_enqueue_style( 'short-customize', plugins_url('css/customize.css', __FILE__) );
	}
}

// WP ADMIN BAR
add_action( 'wp_head', 'short_theme_bar' );
function short_theme_bar() {
	if ( is_user_logged_in() ) {
        wp_enqueue_style( 'short-bar', plugins_url('css/admin-bar.css', __FILE__) );
	}
}