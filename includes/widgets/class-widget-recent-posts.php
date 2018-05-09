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

        echo esc_html__( 'Hello, World!', 'wp-recent-posts-thumbs' );

        echo $args['after_widget'];

    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {

        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;

    ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
                <?php esc_attr_e( 'Title:', 'wp-recent-posts-thumbs' ); ?>
            </label>

            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>">
                <?php esc_attr_e( 'Number of posts to show:', 'wp-recent-posts-thumbs' ); ?>
            </label>

            <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
        </p>

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
        $instance['title']  =   ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['number'] =   (int) $new_instance['number'];

        return $instance;

    }
}

// Register recent posts thumbs widget
function wp_recent_posts_thumbs_register_widget() {
    register_widget( 'Wp_Recent_Posts_Thumbs_Widget' );
}
add_action( 'widgets_init', 'wp_recent_posts_thumbs_register_widget' );