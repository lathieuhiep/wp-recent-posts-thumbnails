<?php
/* Output recent post */
if ( ! function_exists( 'wp_recent_posts_thumbs_item' ) ) :

    function wp_recent_posts_thumbs_item( $wp_recent_posts_thumbs_item_class = '', $wp_recent_posts_thumbs_hide_date = false ) {
?>

        <div class="wp_recent_posts_thumbs_item <?php echo esc_attr( $wp_recent_posts_thumbs_item_class ); ?>">
            <div class="wp_recent_posts_thumbs_item--image">
                <?php

                if ( has_post_thumbnail() ) :
                    the_post_thumbnail( 'thumbnail' );
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
            </div>
        </div>

<?php
    }

endif;