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

        /* Start js loading */
        wp_enqueue_script( 'wp_recent_posts_loading', wp_recent_posts_thumbs_path . 'assets/js/wp_recent_posts_loading.js', array(), '', true );

        $wp_recent_posts_thumbs_admin_url   =   admin_url( 'admin-ajax.php' );
        $wp_recent_posts_thumbs_prev_next   =   array( 'url' => $wp_recent_posts_thumbs_admin_url );
        wp_localize_script( 'wp_recent_posts_loading', 'wp_recent_posts_thumbs_prev_next', $wp_recent_posts_thumbs_prev_next );
        /* End js loading */

        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {

            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];

        }

        $wp_recent_posts_thumbs_limit       =   isset( $instance['number'] ) ? $instance['number'] : 5;
        $wp_recent_posts_thumbs_type_post   =   !empty( $instance['type_post'] ) ? $instance['type_post'] : 'list';
        $wp_recent_posts_thumbs_select_cat  =   !empty( $instance['select_cat'] ) ? $instance['select_cat'] : array( '0' );
        $wp_recent_posts_thumbs_hide_date   =   isset( $instance['hide_date'] ) ? $instance['hide_date'] : false;

        $wp_recent_posts_thumbs_paged = 1;

        if ( in_array( 0, $wp_recent_posts_thumbs_select_cat ) ) :

            $wp_recent_posts_thumbs_args    =   array(
                'post_type'             =>  'post',
                'post_status'           =>  'publish',
                'posts_per_page'        =>  $wp_recent_posts_thumbs_limit,
                'order'                 =>  $instance['order'],
                'orderby'               =>  $instance['order_by'],
                'ignore_sticky_posts'   =>  1,
                'paged'                 =>  $wp_recent_posts_thumbs_paged,
            );

        else:

            $wp_recent_posts_thumbs_args    =   array(
                'post_type'             =>  'post',
                'post_status'           =>  'publish',
                'cat'                   =>  $wp_recent_posts_thumbs_select_cat,
                'posts_per_page'        =>  $wp_recent_posts_thumbs_limit,
                'order'                 =>  $instance['order'],
                'orderby'               =>  $instance['order_by'],
                'ignore_sticky_posts'   =>  1,
                'paged'                 =>  $wp_recent_posts_thumbs_paged,
            );

        endif;

        $wp_recent_posts_thumbs_query   =   new WP_Query( $wp_recent_posts_thumbs_args );

        if ( $wp_recent_posts_thumbs_type_post == 'list' ) :
            $wp_recent_post_type = ' wp_recent_posts_list';
        elseif ( $wp_recent_posts_thumbs_type_post == 'fist_large_post' ) :
            $wp_recent_post_type = ' wp_recent_posts_fist_large';
        else:
            $wp_recent_post_type = ' wp_recent_posts_grid';
        endif;

        if ( $wp_recent_posts_thumbs_query->have_posts() ) :

            $wp_recent_posts_thumbs_prev    =   0;
            $wp_recent_posts_thumbs_next    =   $wp_recent_posts_thumbs_paged + 1;

            $wp_recent_posts_thumbs_count = $wp_recent_posts_thumbs_query->found_posts;

            $wp_recent_posts_thumbs_total_page = ceil( $wp_recent_posts_thumbs_count / $wp_recent_posts_thumbs_limit );

            $wp_recent_posts_thumbs_settings =   [
                'cat'           =>  $wp_recent_posts_thumbs_select_cat,
                'limit'         =>  $wp_recent_posts_thumbs_limit,
                'order'         =>  $instance['order'],
                'orderby'       =>  $instance['order_by'],
                'type-post'     =>  $wp_recent_posts_thumbs_type_post,
                'total_page'    =>  $wp_recent_posts_thumbs_total_page,
                'hide-date'     =>  $wp_recent_posts_thumbs_hide_date
            ];

        ?>

            <div class="wp_recent_posts_thumbs_widget_warp" data-settings='<?php echo esc_attr( wp_json_encode( $wp_recent_posts_thumbs_settings ) ); ?>'>

                <div class="wp_recent_posts_thumbs_widget<?php echo esc_attr( $wp_recent_post_type ) ?>">

                    <?php
                    while ( $wp_recent_posts_thumbs_query->have_posts() ) :
                        $wp_recent_posts_thumbs_query->the_post();

                        do_action( 'wp_recent_post_thumbs_item_content', $wp_recent_posts_thumbs_hide_date, $wp_recent_posts_thumbs_type_post, $wp_recent_posts_thumbs_query , $wp_recent_posts_thumbs_limit );

                    endwhile;
                    wp_reset_postdata();
                    ?>

                </div>

                <?php
                if ( ( $wp_recent_posts_thumbs_count > $wp_recent_posts_thumbs_limit ) && ( $wp_recent_posts_thumbs_limit >= 1 ) ) :

                    if ( $wp_recent_posts_thumbs_total_page >= $wp_recent_posts_thumbs_next ) :
                        $wp_recent_posts_thumbs_class_next_active   =   ' wp_recent_posts_thumbs_next_active';
                    endif;

                ?>

                    <div class="wp_recent_posts_thumbs_next_prev">
                        <span href="#" class="wp_recent_posts_thumbs_prev" data-prev-page="<?php echo esc_attr( $wp_recent_posts_thumbs_prev ); ?>">
                            <i class="wp-post-icon-chevron-left" aria-hidden="true"></i>
                        </span>

                        <span href="#" class="wp_recent_posts_thumbs_next<?php echo esc_attr( $wp_recent_posts_thumbs_class_next_active ); ?>" data-next-page="<?php echo esc_attr( $wp_recent_posts_thumbs_next ); ?>">
                            <i class="wp-post-icon-chevron-right" aria-hidden="true"></i>
                        </span>
                    </div>

                <?php endif; ?>

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
        $type_post  =   isset( $instance['type_post'] ) ? $instance['type_post'] : 'list';
        $select_cat =   isset( $instance['select_cat'] ) ? $instance['select_cat'] : array( '0' );
        $order      =   isset( $instance['order'] ) ? $instance['order'] : 'ASC';
        $order_by   =   isset( $instance['order_by'] ) ? $instance['order_by'] : 'ID';
        $hide_date  =   isset( $instance['hide_date'] ) ? (bool) $instance['hide_date'] : false;

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

        <!-- Start Type Post -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'type_post' ) ); ?>">
                <?php esc_attr_e( 'Type post:', 'wp-recent-posts-thumbs' ); ?>
            </label>


            <select id="<?php echo esc_attr( $this->get_field_id( 'type_post' ) ); ?>" name="<?php echo $this->get_field_name('type_post') ?>" class="widefat">
                <option value="list" <?php echo ( $type_post == 'list' ) ? 'selected' : ''; ?>>
                    <?php esc_html_e( 'List', 'wp-recent-posts-thumbs' ); ?>
                </option>

                <option value="fist_large_post" <?php echo ( $type_post == 'fist_large_post' ) ? 'selected' : ''; ?>>
                    <?php esc_html_e( '1ST large post', 'wp-recent-posts-thumbs' ); ?>
                </option>

                <option value="grid_post" <?php echo ( $type_post == 'grid_post' ) ? 'selected' : ''; ?>>
                    <?php esc_html_e( 'Grid post', 'wp-recent-posts-thumbs' ); ?>
                </option>
            </select>
        </p>
        <!-- End Type Post -->

        <!-- Start Select Category -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'select_cat' ) ); ?>">
                <?php esc_attr_e( 'Select Category:', 'wp-recent-posts-thumbs' ); ?>
            </label>

            <select id="<?php echo esc_attr( $this->get_field_id( 'select_cat' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'select_cat' ) ) . '[]'; ?>" class="widefat" size="10" multiple>

                <option value="0" <?php echo ( in_array( 0, $select_cat ) ? 'selected="selected"' : '' ); ?>>
                    <?php esc_html_e( 'All Category', 'wp-recent-posts-thumbs' ); ?>
                </option>

                <?php
                if ( !empty( $terms ) ) :

                    foreach( $terms as $term_item ) :
                ?>
                        <option value="<?php echo $term_item->term_id; ?>" <?php echo ( in_array( $term_item->term_id, $select_cat ) ? 'selected="selected"' : '' ); ?>>
                            <?php echo esc_html( $term_item->name ) . ' (' . esc_html( $term_item->count ) . ')'; ?>
                        </option>

                <?php
                    endforeach;

                endif;
                ?>

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

        <!-- Start check hide date -->
        <p>
            <input class="checkbox" type="checkbox"<?php checked( $hide_date ); ?> id="<?php echo $this->get_field_id( 'hide_date' ); ?>" name="<?php echo $this->get_field_name( 'hide_date' ); ?>" />

            <label for="<?php echo $this->get_field_id( 'hide_date' ); ?>">
                <?php esc_html_e( 'Hide post date?', 'wp-recent-posts-thumbs' ); ?>
            </label>
        </p>
        <!-- End check hide date -->

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
        $instance['type_post']  =   $new_instance['type_post'];
        $instance['select_cat'] =   $new_instance['select_cat'];
        $instance['order']      =   $new_instance['order'];
        $instance['order_by']   =   $new_instance['order_by'];
        $instance['number']     =   (int) $new_instance['number'];
        $instance['hide_date']  =   isset( $new_instance['hide_date'] ) ? (bool) $new_instance['hide_date'] : false;

        return $instance;

    }
}

// Register recent posts thumbs widget
function wp_recent_posts_thumbs_register_widget() {
    register_widget( 'Wp_Recent_Posts_Thumbs_Widget' );
}
add_action( 'widgets_init', 'wp_recent_posts_thumbs_register_widget' );