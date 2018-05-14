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

            let $recent_post_prev   =   $( '.wp_recent_posts_thumbs_prev' ),
                $recent_post_next   =   $( '.wp_recent_posts_thumbs_next' ),
                $data_settings_post =   $(this).parents( '.wp_recent_posts_thumbs_widget_warp' ).data( 'settings' ),
                $data_cat_id        =   $(this).data( 'cat' ),
                $data_limit         =   parseInt( $data_settings_post['limit'] ),
                $data_order         =   $data_settings_post['order'],
                $data_orderby       =   $data_settings_post['orderby'],
                $data_type_post     =   $data_settings_post['type-post'],
                $data_total_page    =   parseInt( $data_settings_post['total_page'] ),
                $data_prev_page     =   parseInt( $(this).parent().find( '.wp_recent_posts_thumbs_prev' ).attr( 'data-prev-page' ) ),
                $data_next_page     =   parseInt( $(this).attr( 'data-next-page' ) );

            $.ajax({

                url: wp_recent_posts_thumbs_prev_next.url,
                type: 'POST',
                data: ({

                    action: 'wp_recent_posts_thumbs_prev_next',
                    wp_recent_posts_thumbs_cat_id: $data_cat_id,
                    wp_recent_posts_thumbs_limit: $data_limit,
                    wp_recent_posts_thumbs_order: $data_order,
                    wp_recent_posts_thumbs_orderby: $data_orderby,
                    wp_recent_posts_thumbs_type_post: $data_type_post,
                    wp_recent_posts_thumbs_paged: $data_next_page,

                }),

                beforeSend: function () {

                },

                success: function( data ) {

                    if ( data ) { } else { }

                    let $data_prev_page_new =   $data_prev_page + 1,
                        $data_next_page_new =   $data_next_page + 1;

                        $recent_post_prev.attr( 'data-prev-page', $data_prev_page_new );
                        $recent_post_next.attr( 'data-next-page', $data_next_page_new );

                    console.log( $data_next_page_new );

                    // if ( $data_total_page < $data_next_page  ) {
                    //
                    //     $recent_post_next.parent().find( '.wp_recent_posts_thumbs_next' ).removeClass( 'wp_recent_posts_thumbs_next_active' ).off();
                    // }

                }

            });


        } )
        /* End load prev next ajax */

    });

} )( jQuery );