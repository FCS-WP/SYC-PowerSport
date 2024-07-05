<?php
class WPRT_recent_news extends WP_Widget {
    // Holds widget settings defaults, populated in constructor.
    protected $defaults;

    // Constructor
    function __construct() {
        $this->defaults = array(
            'title' 	=> 'Recent Posts', 
            'count'     => 3,
            'bottom_margin' => '60px',
            'thumb_width' => '80px',
            'thumb_style' => 'hide',
            'thumb_right_margin' => '20px',
            'title_size' => '',
            'title_color' => '',
            'border_color' => '',
            'meta_color' => '',
            'title_length' => '6'
        );

        parent::__construct(
            'widget_news_post',
            esc_html__( 'Recent Posts Advanced', 'agrikole' ),
            array(
                'classname'   => 'widget_recent_posts',
                'description' => esc_html__( 'Display recent blog posts.', 'agrikole' )
            )
        );
    }

    // Display widget
    function widget( $args, $instance ) {
        $instance = wp_parse_args( $instance, $this->defaults );
        extract( $instance );
        extract( $args );

        echo $before_widget;

        if ( ! empty( $title ) ) { echo $before_title . $title . $after_title; }

        $bottom_margin = intval( $bottom_margin );
        $thumb_width = intval( $thumb_width );
        $thumb_right_margin = intval( $thumb_right_margin );
        $title_size = intval( $title_size );

        $item_css = '';
        if ( ! empty( $bottom_margin ) )
            $item_css .= 'padding-bottom:'. $bottom_margin/2 .'px;margin-bottom:'. $bottom_margin/2 .'px';

        if ( ! empty( $border_color ) )
            $item_css .= ';border-color:'. $border_color;

        $icon_css = $thumb_css = '';
        if ( isset( $thumb_width ) ) {
            $thumb_css .= 'width:'. $thumb_width .'px;height:'. $thumb_width .'px;';
            $icon_css .= 'width:'. $thumb_width .'px;height:'. $thumb_width .'px;line-height:'. $thumb_width .'px;';
        }

        if ( isset( $thumb_right_margin ) )
            $thumb_css .= ';margin-right:'. $thumb_right_margin .'px';

        $title_css = '';
        if ( ! empty( $title_size ) )
            $title_css .= 'font-size:'. $title_size .'px';

        if ( ! empty( $title_color ) )
            $title_css .= ';color:'. $title_color;

        $meta_css = '';
        if ( ! empty( $meta_color ) )
            $meta_css .= 'color:'. $meta_color;

        $query_args = array(
            'post_type' => 'post',
            'posts_per_page' => intval($count)
        );
       
        $query = new WP_Query( $query_args ); ?>

        <ul class="recent-news clearfix">
		<?php $i = 0; if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post(); ?>
				<li class="clearfix" style="<?php echo esc_attr( $item_css ); ?>">
                    <?php if ( $thumb_width ) : ?>
                    <div class="thumb <?php echo esc_attr( $thumb_style ); ?>" style="<?php echo esc_attr( $thumb_css ); ?>">
                        <?php

                            $size = 'agrikole-post-widget';

                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( $size );
                            } elseif ( get_post_format() == 'gallery' ) {
                                $images = agrikole_metabox( 'gallery_images', "type=image&size=$size" );
                                
                                if ( ! empty( $images ) ) {
                                    foreach ( $images as $image ) {
                                        if ( $image === reset( $images ) )
                                        printf( '<img src="%s" alt="gallery">', esc_url( $image['url'] ) );
                                    }
                                }
                            }
                        ?>
                    </div>
                    <?php endif;

                    $title = get_the_title();
                    if ( ! empty( $title_length ) ) {
                        $title = agrikole_trim_words( $title, $title_length );
                    }
                    echo '<div class="texts">';

                    printf( '
                        <h3><a href="%1$s" style="%3$s">%2$s</a></h3>%3$s',
                        esc_url( get_the_permalink() ),
                        $title,
                        esc_attr( $title_css )
                    );

                    printf( '<span class="post-author"><a style="%s" class="name" href="%s" title="%s">%s</a></span>',
                        esc_attr( $meta_css ),
                        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                        esc_attr( sprintf( esc_html__( 'View all posts by %s', 'agrikole' ), get_the_author() ) ),
                        get_the_author()
                    );

                    echo '</div>';

                    ?>
                </li>
			<?php $i++; endwhile; wp_reset_postdata(); ?>
		<?php endif; ?>        
        </ul>
        
		<?php echo $after_widget;
    }

    // Update widget
    function update( $new_instance, $old_instance ) {
        $instance                   = $old_instance;
        $instance['title']          = strip_tags( $new_instance['title'] );
        $instance['bottom_margin']         = strip_tags( $new_instance['bottom_margin'] );
        $instance['thumb_width']         = strip_tags( $new_instance['thumb_width'] );
        $instance['thumb_right_margin'] = strip_tags( $new_instance['thumb_right_margin'] );
        $instance['title_size']         = strip_tags( $new_instance['title_size'] );
        $instance['title_color']         = strip_tags( $new_instance['title_color'] );
        $instance['meta_color']         = strip_tags( $new_instance['meta_color'] );
        $instance['border_color']         = strip_tags( $new_instance['border_color'] );
        $instance['bottom_margin']         = strip_tags( $new_instance['bottom_margin'] );
        $instance['count']          = intval( $new_instance['count'] );
        $instance['title_length']  = intval( $new_instance['title_length'] );
        $instance[ 'thumb_style' ] = $new_instance[ 'thumb_style' ];

        return $instance;
    }

    // Widget setting
    function form( $instance ) {
        $instance = wp_parse_args( $instance, $this->defaults );       
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'agrikole' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Count:', 'agrikole' ); ?></label>
            <input class="widefat" type="number" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" value="<?php echo esc_attr( $instance['count'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title_length' ) ); ?>"><?php esc_html_e( 'Title Word Count Length (ex: 4):', 'agrikole' ); ?></label>
            <input class="widefat" type="number" id="<?php echo esc_attr( $this->get_field_id( 'title_length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_length' ) ); ?>" value="<?php echo esc_attr( $instance['title_length'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'bottom_margin' ) ); ?>"><?php esc_html_e('Item Bottom Margin:', 'agrikole') ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'bottom_margin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'bottom_margin' ) ); ?>" type="text" size="2" value="<?php echo esc_attr( $instance['bottom_margin'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'thumb_style' ) ); ?>"><?php esc_html_e( 'Thumbnail', 'agrikole' ); ?></label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'thumb_style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_style' ) ); ?>">
                <option value="hide" <?php selected( 'hide', $instance['thumb_style'] ); ?>><?php esc_html_e( 'Hide', 'agrikole' ) ?></option>
                <option value="show" <?php selected( 'show', $instance['thumb_style'] ); ?>><?php esc_html_e( 'Show', 'agrikole' ) ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'thumb_width' ) ); ?>"><?php esc_html_e('Thumbnail Width:', 'agrikole') ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'thumb_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_width' ) ); ?>" type="text" size="2" value="<?php echo esc_attr( $instance['thumb_width'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'thumb_right_margin' ) ); ?>"><?php esc_html_e('Thumbnail Right Margin:', 'agrikole') ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'thumb_right_margin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_right_margin' ) ); ?>" type="text" size="2" value="<?php echo esc_attr( $instance['thumb_right_margin'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title_size' ) ); ?>"><?php esc_html_e('Title Size (ex: 18px):', 'agrikole') ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_size' ) ); ?>" type="text" size="2" value="<?php echo esc_attr( $instance['title_size'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title_color' ) ); ?>"><?php esc_html_e('Title Color (ex: #e3e3e3):', 'agrikole') ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_color' ) ); ?>" type="text" size="2" value="<?php echo esc_attr( $instance['title_color'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'meta_color' ) ); ?>"><?php esc_html_e('Meta Color (ex: #303030):', 'agrikole') ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'meta_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'meta_color' ) ); ?>" type="text" size="2" value="<?php echo esc_attr( $instance['meta_color'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'border_color' ) ); ?>"><?php esc_html_e('Border Color (ex: #303030):', 'agrikole') ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'border_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'border_color' ) ); ?>" type="text" size="2" value="<?php echo esc_attr( $instance['border_color'] ); ?>">
        </p>
    <?php
    }
}
add_action( 'widgets_init', 'register_agrikole_recent_news' );

// Register widget
function register_agrikole_recent_news() {
    register_widget( 'WPRT_recent_news' );
}


