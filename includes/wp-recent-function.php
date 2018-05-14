<?php
/* Start Output recent post */
if ( ! function_exists( 'wp_recent_posts_thumbs_item' ) ) :

    function wp_recent_posts_thumbs_item( $wp_recent_posts_thumbs_hide_date = false, $wp_recent_posts_thumbs_type_post = 'list', $wp_recent_posts_thumbs_query ) {

?>

        <div class="wp_recent_posts_thumbs_item">
            <div class="wp_recent_posts_thumbs_item--image">
                <?php
                if ( has_post_thumbnail() ) :
                    the_post_thumbnail( 'medium' );
                else:
                ?>

                    <img src="<?php echo esc_url( wp_recent_posts_thumbs_path . 'assets/images/no-image.png' ) ?>" alt="<?php the_title(); ?>">

                <?php endif; ?>
            </div>

            <div class="wp_recent_posts_thumbs_item--content">
                <h3 class="wp_recent_posts_thumbs_item--title">
                    <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h3>

                <?php if ( $wp_recent_posts_thumbs_hide_date == false ) : ?>

                    <span class="wp_recent_posts_thumbs_item--meta">
                        <?php echo get_the_date(); ?>
                    </span>

                <?php endif; ?>

                <?php if ( $wp_recent_posts_thumbs_type_post == 'fist_large_post' && $wp_recent_posts_thumbs_query->current_post == 0 ) : ?>

                    <div class="wp_recent_posts_thumbs_item--describe">
                        <?php
                        if ( has_excerpt() ) :
                            the_excerpt();
                        else:
                        ?>

                            <p>
                                <?php echo wp_trim_words( get_the_content(), 20, '...' ); ?>
                            </p>

                        <?php endif; ?>

                    </div>

                <?php endif; ?>
            </div>
        </div>

<?php
    }

endif;
/* End  Output recent post */

/* Start prev next loading */
add_action( 'wp_ajax_nopriv_wp_recent_posts_thumbs_prev_next', 'wp_recent_posts_thumbs_prev_next' );
add_action( 'wp_ajax_wp_recent_posts_thumbs_prev_next', 'wp_recent_posts_thumbs_prev_next' );

function wp_recent_posts_thumbs_prev_next() {

    $wp_recent_posts_thumbs_cat_id      =   $_POST['wp_recent_posts_thumbs_cat_id'];
    $wp_recent_posts_thumbs_limit       =   $_POST['wp_recent_posts_thumbs_limit'];
    $wp_recent_posts_thumbs_order       =   $_POST['wp_recent_posts_thumbs_order'];
    $wp_recent_posts_thumbs_orderby     =   $_POST['wp_recent_posts_thumbs_orderby'];
    $wp_recent_posts_thumbs_paged       =   $_POST['wp_recent_posts_thumbs_paged'];
    $wp_recent_posts_thumbs_type_post   =   $_POST['wp_recent_posts_thumbs_type_post'];
    $wp_recent_posts_thumbs_hide_date   =   $_POST['wp_recent_posts_thumbs_hide_date'];

    $wp_recent_posts_thumbs_hide_date   =   $wp_recent_posts_thumbs_hide_date === 'true'? true: false;

    if ( in_array( 0, $wp_recent_posts_thumbs_cat_id ) ) :

        $wp_recent_posts_thumbs_args    =   array(
            'post_type'             =>  'post',
            'post_status'           =>  'publish',
            'posts_per_page'        =>  $wp_recent_posts_thumbs_limit,
            'order'                 =>  $wp_recent_posts_thumbs_order,
            'orderby'               =>  $wp_recent_posts_thumbs_orderby,
            'ignore_sticky_posts'   =>  1,
            'paged'                 =>  $wp_recent_posts_thumbs_paged,
        );

    else:

        $wp_recent_posts_thumbs_args    =   array(
            'post_type'             =>  'post',
            'post_status'           =>  'publish',
            'cat'                   =>  $wp_recent_posts_thumbs_cat_id,
            'posts_per_page'        =>  $wp_recent_posts_thumbs_limit,
            'order'                 =>  $wp_recent_posts_thumbs_order,
            'orderby'               =>  $wp_recent_posts_thumbs_orderby,
            'ignore_sticky_posts'   =>  1,
            'paged'                 =>  $wp_recent_posts_thumbs_paged,
        );

    endif;

    $wp_recent_posts_thumbs_query   =   new WP_Query( $wp_recent_posts_thumbs_args );

    while ( $wp_recent_posts_thumbs_query->have_posts() ):
        $wp_recent_posts_thumbs_query->the_post();

        do_action( 'wp_recent_post_thumbs_item_content', $wp_recent_posts_thumbs_hide_date, $wp_recent_posts_thumbs_type_post, $wp_recent_posts_thumbs_query );

    endwhile;
    wp_reset_postdata();

    exit();

}
/* End prev next loading */