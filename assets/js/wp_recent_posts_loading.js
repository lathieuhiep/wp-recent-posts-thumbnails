/**
 * Wp recent posts loading
 * Copyright 2017-2020
 * Licensed under  ()
 */

( function( $ ) {

    "use strict";

    $( document ).ready( function () {

        /* Start load post next ajax */
        $( '.wp_recent_posts_thumbs_next' ).on( 'click', function () {

            let recent_post_prev    =   $(this).parent().find( '.wp_recent_posts_thumbs_prev' ),
                recent_post_next    =   $(this).parent().find( '.wp_recent_posts_thumbs_next' ),
                has_active_prev     =   recent_post_next.hasClass( 'wp_recent_posts_thumbs_next_active' );

            if ( has_active_prev === true ) {

                let posts_thumbs_widget_warp    =   $(this).parents( '.wp_recent_posts_thumbs_widget_warp' ),
                    posts_thumbs_widget         =   posts_thumbs_widget_warp.find( '.wp_recent_posts_thumbs_widget' ),
                    data_settings_post          =   posts_thumbs_widget_warp.data( 'settings' ),
                    data_cat_id                 =   data_settings_post['cat'],
                    data_limit                  =   parseInt( data_settings_post['limit'] ),
                    data_order                  =   data_settings_post['order'],
                    data_orderby                =   data_settings_post['orderby'],
                    data_type_post              =   data_settings_post['type-post'],
                    data_total_page             =   parseInt( data_settings_post['total_page'] ),
                    data_hide_date              =   data_settings_post['hide-date'],
                    data_prev_page              =   parseInt( recent_post_prev.attr( 'data-prev-page' ) ),
                    data_next_page              =   parseInt( recent_post_next.attr( 'data-next-page' ) ),
                    has_active_prev             =   recent_post_prev.hasClass( 'wp_recent_posts_thumbs_prev_active' );

                $.ajax({

                    url: wp_recent_posts_thumbs_prev_next.url,
                    type: 'POST',
                    data: ({

                        action: 'wp_recent_posts_thumbs_prev_next',
                        wp_recent_posts_thumbs_cat_id: data_cat_id,
                        wp_recent_posts_thumbs_limit: data_limit,
                        wp_recent_posts_thumbs_order: data_order,
                        wp_recent_posts_thumbs_orderby: data_orderby,
                        wp_recent_posts_thumbs_paged: data_next_page,
                        wp_recent_posts_thumbs_type_post: data_type_post,
                        wp_recent_posts_thumbs_hide_date: data_hide_date

                    }),

                    beforeSend: function () {
                        posts_thumbs_widget.addClass( 'posts_thumbs_empty' );
                    },

                    success: function( data ) {

                        if ( data ) {

                            posts_thumbs_widget.empty().append( data );
                            posts_thumbs_widget.removeClass( 'posts_thumbs_empty' );

                            if ( has_active_prev === false ) {

                                recent_post_prev.addClass( 'wp_recent_posts_thumbs_prev_active' );

                            }

                        }

                        let data_prev_page_new =   data_prev_page + 1,
                            data_next_page_new =   data_next_page + 1;

                            recent_post_prev.attr( 'data-prev-page', data_prev_page_new );
                            recent_post_next.attr( 'data-next-page', data_next_page_new );

                        if ( data_total_page < data_next_page_new  ) {

                            recent_post_next.removeClass( 'wp_recent_posts_thumbs_next_active' );

                        }

                    }

                });

            }


        } );
        /* End load post next ajax */

        /* Start load post prev ajax */
        $( '.wp_recent_posts_thumbs_prev' ).on( 'click', function () {

            let recent_post_prev    =   $(this).parent().find( '.wp_recent_posts_thumbs_prev' ),
                recent_post_next    =   $(this).parent().find( '.wp_recent_posts_thumbs_next' ),
                has_active_prev     =   recent_post_prev.hasClass( 'wp_recent_posts_thumbs_prev_active' );


            if ( has_active_prev === true ) {

                let posts_thumbs_widget_warp    =   $(this).parents( '.wp_recent_posts_thumbs_widget_warp' ),
                    posts_thumbs_widget         =   posts_thumbs_widget_warp.find( '.wp_recent_posts_thumbs_widget' ),
                    data_settings_post          =   posts_thumbs_widget_warp.data( 'settings' ),
                    data_cat_id                 =   data_settings_post['cat'],
                    data_limit                  =   parseInt( data_settings_post['limit'] ),
                    data_order                  =   data_settings_post['order'],
                    data_orderby                =   data_settings_post['orderby'],
                    data_type_post              =   data_settings_post['type-post'],
                    data_total_page             =   parseInt( data_settings_post['total_page'] ),
                    data_hide_date              =   data_settings_post['hide-date'],
                    data_prev_page              =   parseInt( recent_post_prev.attr( 'data-prev-page' ) ),
                    data_next_page              =   parseInt( recent_post_next.attr( 'data-next-page' ) ),
                    has_active_next             =   recent_post_next.hasClass( 'wp_recent_posts_thumbs_next_active' );


                $.ajax({

                    url: wp_recent_posts_thumbs_prev_next.url,
                    type: 'POST',
                    data: ({

                        action: 'wp_recent_posts_thumbs_prev_next',
                        wp_recent_posts_thumbs_cat_id: data_cat_id,
                        wp_recent_posts_thumbs_limit: data_limit,
                        wp_recent_posts_thumbs_order: data_order,
                        wp_recent_posts_thumbs_orderby: data_orderby,
                        wp_recent_posts_thumbs_paged: data_prev_page,
                        wp_recent_posts_thumbs_type_post: data_type_post,
                        wp_recent_posts_thumbs_hide_date: data_hide_date

                    }),

                    beforeSend: function () {
                        posts_thumbs_widget.addClass( 'posts_thumbs_empty' );
                    },

                    success: function( data ) {

                        if ( data ) {

                            posts_thumbs_widget.empty().append( data );
                            posts_thumbs_widget.removeClass( 'posts_thumbs_empty' );

                            if ( has_active_next === false ) {

                                recent_post_next.addClass( 'wp_recent_posts_thumbs_next_active' );

                            }

                        }

                        let data_prev_page_new  =   data_prev_page - 1,
                            data_next_page_new  =   data_next_page - 1;

                           recent_post_prev.attr( 'data-prev-page', data_prev_page_new );
                           recent_post_next.attr( 'data-next-page', data_next_page_new );

                        if ( data_prev_page_new === 0  ) {

                            recent_post_prev.removeClass( 'wp_recent_posts_thumbs_prev_active' );

                        }

                    }

                });

            }


        } );
        /* End load post prev ajax */

    });

} )( jQuery );