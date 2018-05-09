<?php
/*
Plugin Name: Recent Posts Thumbs Widget
Plugin URI: https://www.facebook.com/lathieuhiep
Description: Recent Posts Thumbs Widget list, slider.
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
            $this->wp_recent_posts_thumbs_load_define();

            /* load languages */
            $this->wp_recent_posts_thumbs_load_languages();

            /*load script*/
            $this -> wp_recent_posts_thumbs_load_script();
        }

        /* Load define */
        function wp_recent_posts_thumbs_load_define() {

            define( 'wp_recent_posts_thumbs_path', plugin_dir_url( __FILE__ ) );

            define( 'wp_recent_posts_thumbs_server_path', dirname( __FILE__ ) );

        }

        /* Load languages */
        function wp_recent_posts_thumbs_load_languages() {

            add_action( 'plugins_loaded', array( $this, 'wp_recent_posts_thumbs_text_domain' ) );

        }

        /* Text domain */
        function wp_recent_posts_thumbs_text_domain() {

            load_plugin_textdomain( 'wp-recent-posts-thumbs', false, wp_recent_posts_thumbs_path . '/languages' );

        }

        /* load_script */
        function wp_recent_posts_thumbs_load_script() {

            add_action( 'wp_enqueue_scripts',array( $this, 'wp_recent_posts_thumbs_frontend_scripts' ) );

        }

        /* frontend scripts */
        function wp_recent_posts_thumbs_frontend_scripts() {

            wp_enqueue_style( 'wp-recent-posts-thumbs', wp_recent_posts_thumbs_path. 'assets/css/wp-recent-posts-thumbs.css', array(), '' );

        }

    }

    $wp_recent_posts_thumbs_oj = new wp_recent_posts_thumbs();

endif;