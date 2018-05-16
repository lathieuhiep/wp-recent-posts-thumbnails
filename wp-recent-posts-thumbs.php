<?php
/*
Plugin Name: Recent Posts Thumbs Widget
Plugin URI: https://www.facebook.com/lathieuhiep
Description: Plugin recent posts thumbnails widget type list post, 1ST large post, grid post vs pagination next prev ajax.
Version: 1.0.0
Author: La Thiếu Hiệp
Author URI: https://www.facebook.com/lathieuhiep
License: GPLv2 or later
Text Domain: wp-recent-posts-thumbs
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( !class_exists( 'wp_recent_posts_thumbs' ) ) :

    class wp_recent_posts_thumbs {

        /*
        * This method loads other methods of the class.
        */
        function __construct() {

            /* Load define */
            $this->wp_recent_posts_thumbs_prev_next_define();

            /* load languages */
            $this->wp_recent_posts_thumbs_prev_next_languages();

            /* load includes */
            $this->wp_recent_posts_thumbs_prev_next_includes();

            /*load script*/
            $this -> wp_recent_posts_thumbs_prev_next_script();

        }

        /* Load define */
        function wp_recent_posts_thumbs_prev_next_define() {

            define( 'wp_recent_posts_thumbs_path', plugin_dir_url( __FILE__ ) );

            define( 'wp_recent_posts_thumbs_server_path', dirname( __FILE__ ) );

        }

        /* Load languages */
        function wp_recent_posts_thumbs_prev_next_languages() {

            add_action( 'plugins_loaded', array( $this, 'wp_recent_posts_thumbs_text_domain' ) );

        }

        /* Text domain */
        function wp_recent_posts_thumbs_text_domain() {

            load_plugin_textdomain( 'wp-recent-posts-thumbs', false, wp_recent_posts_thumbs_path . 'languages' );

        }

        /* Load includes */
        function wp_recent_posts_thumbs_prev_next_includes() {

            require_once wp_recent_posts_thumbs_server_path . '/includes/wp-recent-posts-includes.php';

        }

        /* Load script */
        function wp_recent_posts_thumbs_prev_next_script() {

            add_action( 'wp_enqueue_scripts',array( $this, 'wp_recent_posts_thumbs_frontend_scripts' ) );

        }

        /* Frontend scripts */
        function wp_recent_posts_thumbs_frontend_scripts() {

            wp_enqueue_style( 'wp-recent-posts-thumbs', wp_recent_posts_thumbs_path. 'assets/css/wp-recent-posts-thumbs.css', array(), '' );

        }

    }

    $wp_recent_posts_thumbs_oj = new wp_recent_posts_thumbs();

endif;