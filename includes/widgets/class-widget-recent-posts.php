<?php
/*
 * Widget Recent Posts Thumbs
 * */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Wp_Recent_Posts_Thumbs_Widget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {

        $wp_recent_posts_thumbs_widget_ops = array(
            'classname'     =>  'recent_posts_thumbs_widget',
            'description'   =>  'Recent Posts Thumbs Widget',
        );

        parent::__construct( 'recent_posts_thumbs_widget', 'Recent Posts Thumbs Widget', $wp_recent_posts_thumbs_widget_ops );

    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {

        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {

            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];

        }

        $wp_recent_posts_thumbs_select_cat  =   $instance['select_cat'];

        if ( in_array( 0, $wp_recent_posts_thumbs_select_cat ) ) :

            $wp_recent_posts_thumbs_args    =   array(
                'post_type'         =>  'post',
                'post_status'       =>  'publish',
                'posts_per_page'    =>  $instance['number'],
                'order'             =>  $instance['order'],
                'orderby'           =>  $instance['order_by']
            );

        else:

            $wp_recent_posts_thumbs_args    =   array(
                'post_type'         =>  'post',
                'cat'               =>  $instance['select_cat'],
                'posts_per_page'    =>  $instance['number'],
                'order'             =>  $instance['order'],
                'orderby'           =>  $instance['order_by']
            );

        endif;

        $wp_recent_posts_thumbs_query   =   new WP_Query( $wp_recent_posts_thumbs_args );

        if ( $wp_recent_posts_thumbs_query->have_posts() ) :
    ?>

        <div class="wp_recent_posts_thumbs_widget">

            <?php
            while ( $wp_recent_posts_thumbs_query->have_posts() ) :
                $wp_recent_posts_thumbs_query->the_post();
            ?>

                <div class="wp_recent_posts_thumbs_item">
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

                        <span class="wp_recent_posts_thumbs_item--meta">
                            <?php echo get_the_date(); ?>
                        </span>
                    </div>
                </div>

            <?php
            endwhile;
            wp_reset_postdata();
            ?>

        </div>

    <?php
        endif;

        echo $args['after_widget'];

    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {

        $number     =   isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $select_cat =   isset( $instance['select_cat'] ) ? $instance['select_cat'] : 0;
        $order      =   isset( $instance['order'] ) ? $instance['order'] : 'ASC';
        $order_by   =   isset( $instance['order_by'] ) ? $instance['order_by'] : 'ID';

        $terms = get_terms( array(
            'taxonomy'  =>  'category',
            'orderby'   =>  'id'
        ) );

    ?>

        <!-- Start Title -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
                <?php esc_attr_e( 'Title:', 'wp-recent-posts-thumbs' ); ?>
            </label>

            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>
        <!-- End Title -->

        <!-- Start Select Category -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'select_cat' ) ); ?>">
                <?php esc_attr_e( 'Select Category:', 'wp-recent-posts-thumbs' ); ?>
            </label>

            <select id="<?php echo esc_attr( $this->get_field_id( 'select_cat' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'select_cat' ) ) . '[]'; ?>" class="widefat" size="10" multiple>

                <option value="0" <?php echo ( in_array( 0, $select_cat ) ? 'selected="selected"' : '' ); ?>>
                    <?php esc_html_e( 'All Category', 'wp-recent-posts-thumbs' ); ?>
                </option>

                <?php foreach( $terms as $term_item ) : ?>

                    <option value="<?php echo $term_item->term_id; ?>" <?php echo ( in_array( $term_item->term_id, $select_cat ) ? 'selected="selected"' : '' ); ?>>
                        <?php echo esc_html( $term_item->name ) . ' (' . esc_html( $term_item->count ) . ')'; ?>
                    </option>

                <?php endforeach; ?>

            </select>
        </p>
        <!-- End Select Category -->

        <!-- Start Order -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">
                <?php esc_attr_e( 'Order:', 'wp-recent-posts-thumbs' ); ?>
            </label>


            <select id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo $this->get_field_name('order') ?>" class="widefat">
                <option value="ASC" <?php echo ( $order == 'ASC' ) ? 'selected' : ''; ?>>
                    <?php esc_html_e( 'ASC', 'wp-recent-posts-thumbs' ); ?>
                </option>

                <option value="DESC" <?php echo ( $order == 'DESC' ) ? 'selected' : ''; ?>>
                    <?php esc_html_e( 'DESC', 'wp-recent-posts-thumbs' ); ?>
                </option>
            </select>
        </p>
        <!-- End Type Get Post -->

        <!-- Start OrderBy -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'order_by' ) ); ?>">
                <?php esc_attr_e( 'Order:', 'wp-recent-posts-thumbs' ); ?>
            </label>


            <select id="<?php echo esc_attr( $this->get_field_id( 'order_by' ) ); ?>" name="<?php echo $this->get_field_name('order_by') ?>" class="widefat">
                <option value="ID" <?php echo ( $order_by == 'ID' ) ? 'selected' : ''; ?>>
                    <?php esc_html_e( 'ID', 'wp-recent-posts-thumbs' ); ?>
                </option>

                <option value="date" <?php echo ( $order_by == 'date' ) ? 'selected' : ''; ?>>
                    <?php esc_html_e( 'Date', 'wp-recent-posts-thumbs' ); ?>
                </option>

                <option value="title" <?php echo ( $order_by == 'title' ) ? 'selected' : ''; ?>>
                    <?php esc_html_e( 'Title', 'wp-recent-posts-thumbs' ); ?>
                </option>

                <option value="rand" <?php echo ( $order_by == 'rand' ) ? 'selected' : ''; ?>>
                    <?php esc_html_e( 'Rand', 'wp-recent-posts-thumbs' ); ?>
                </option>
            </select>
        </p>
        <!-- End Type Get Post -->

        <!-- Start Number Post Show -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>">
                <?php esc_attr_e( 'Number of posts to show:', 'wp-recent-posts-thumbs' ); ?>
            </label>

            <input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" class="tiny-text" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3" />
        </p>
        <!-- End Number Post Show -->

    <?php

    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     *
     * @return array
     */
    public function update( $new_instance, $old_instance ) {

        $instance = array();
        $instance['title']      =   ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['select_cat'] =   $new_instance['select_cat'];
        $instance['order']      =   $new_instance['order'];
        $instance['order_by']   =   $new_instance['order_by'];
        $instance['number']     =   (int) $new_instance['number'];

        return $instance;

    }
}

// Register recent posts thumbs widget
function wp_recent_posts_thumbs_register_widget() {
    register_widget( 'Wp_Recent_Posts_Thumbs_Widget' );
}
add_action( 'widgets_init', 'wp_recent_posts_thumbs_register_widget' );