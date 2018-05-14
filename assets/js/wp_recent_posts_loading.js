/**
 * Wp recent posts loading
 * Copyright 2017-2020
 * Licensed under  ()
 */

( function( $ ) {

    "use strict";

    $( document ).ready( function () {

        /* Start load prev next ajax */
        $( '.wp_recent_posts_thumbs_next_active' ).on( 'click', function () {

            let $data_settings_post =   $(this).parents( '.wp_recent_posts_thumbs_widget_warp' ).data( 'settings' ),
                $data_cat_id        =   $(this).data( 'cat' ),
                $data_limit         =   parseInt( $data_settings_post['limit'] ),
                $data_order         =   $data_settings_post['order'],
                $data_orderby       =   $data_settings_post['orderby'],
                $data_type_post     =   $data_settings_post['type-post'],
                $data_total_page    =   parseInt( $data_settings_post['total_page'] ),
                $data_next_page     =   parseInt( $(this).data( 'next-page' ) );

            console.log($data_page);

        } )
        /* End load prev next ajax */

    });

} )( jQuery );