<?php
/**
 * Enqueue Parent Styles
 */
add_action( 'wp_enqueue_scripts', 'dara_child_enqueue_styles' );
function dara_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

/**
 * Enqueue Theme Styles
 */
 function tgb_scripts() {
   wp_enqueue_style( 'tgb-google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600|Raleway:400' );
   wp_enqueue_style( 'tgb-custom-css', get_stylesheet_directory_uri() . '/assets/css/tgb-styles.min.css', array(),get_the_time(U) );
   wp_enqueue_style( 'dashicons' );
 }
 add_action( 'wp_enqueue_scripts', 'tgb_scripts', 999 );

/**
 * Register Front Page Area
 */
 function tgb_widgets_init() {
   register_sidebar( array(
     'name' => esc_html__('Front Page Widget Area', 'dara' ),
     'id' => 'front-page-widget-area',
     'before_widget' => '<aside id="%1$s" class="widget %2$s">',
 		 'after_widget'  => '</aside>',
 		 'before_title'  => '<h3 class="widget-title">',
 		 'after_title'   => '</h3>',
   )
 );
}
add_action( 'widgets_init', 'tgb_widgets_init' );

/**
 * New Recent Post Widget
 */
class tgb_Widget_Recent_Posts extends WP_Widget {

  function __construct() {
    $widget_ops = array('classname' => 'widget_better_recent_entries', 'description' => __( "The most recent posts on your site") );
    parent::__construct('better-recent-posts', __('Better Recent Posts'), $widget_ops);
    $this->alt_option_name = 'widget_recent_entries';

    add_action( 'save_post', array($this, 'flush_widget_cache') );
    add_action( 'deleted_post', array($this, 'flush_widget_cache') );
    add_action( 'switch_theme', array($this, 'flush_widget_cache') );
  }

  function widget($args, $instance) {
    $cache = wp_cache_get('widget_better_recent_posts', 'widget');
    if ( !is_array($cache) )
    $cache = array();

    if ( ! isset( $args['widget_id'] ) )
    $args['widget_id'] = $this->id;

    if ( isset( $cache[ $args['widget_id'] ] ) ) {
      echo $cache[ $args['widget_id'] ];
      return;
    }

    ob_start();
    extract($args);
    $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
    $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
    $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
    if ( ! $number )
    $number = 10;
    $show_excerpt = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

    $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
    if ($r->have_posts()) :
      ?>
      <?php echo $before_widget; ?>
      <?php if ( $title ) echo $before_title . $title . $after_title; ?>
      <ul class="tgb-better-recent-posts">
        <?php while ( $r->have_posts() ) : $r->the_post(); ?>
          <li>
            <span class="tgb-image-container"><?php echo get_the_post_thumbnail( $page->ID, array( 350, 230) ); ?></span>
            <h3><a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></h3>
            <?php if ( $show_excerpt ) : ?>
              <span class="excerpt-date"><?php echo wp_trim_words( get_the_excerpt(), 20, '...');?><a href="<?php the_permalink() ?>"> Continue Reading</a></span>
            <?php endif; ?>
          </li>
        <?php endwhile; ?>
      </ul>
      <?php echo $after_widget; ?>
      <?php
      wp_reset_postdata();
    endif;

    $cache[$args['widget_id']] = ob_get_flush();
    wp_cache_set('widget_better_recent_posts', $cache, 'widget');
  }

  function update( $new_instance, $old_instance ) {
      $instance = $old_instance;
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['number'] = (int) $new_instance['number'];
      $instance['show_date'] = (bool) $new_instance['show_date'];
      $this->flush_widget_cache();

      $alloptions = wp_cache_get( 'alloptions', 'options' );
      if ( isset($alloptions['widget_recent_entries']) )
      delete_option('widget_recent_entries');

      return $instance;
    }

    function flush_widget_cache() {
      wp_cache_delete('widget_better_recent_posts', 'widget');
     }

     function form( $instance ) {
       $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
       $number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;
       $show_excerpt = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
       ?>
       <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
       <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

       <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show: (Max 3)' ); ?></label>
       <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

       <p><input class="checkbox" type="checkbox" <?php checked( $show_excerpt ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
       <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post Excerpt?' ); ?></label></p>
       <?php
       }
     }

 function tgb_register_custom_widgets() {
    register_widget( 'tgb_Widget_Recent_Posts' );
  }
add_action( 'widgets_init', 'tgb_register_custom_widgets' );

/**
 * Paypal Sidebar Widget
 */
function wpb_load_widget() {
   register_widget( 'tgb_paypal_widget' );
 }
   add_action( 'widgets_init', 'wpb_load_widget' );

   class tgb_paypal_widget extends WP_Widget {
function __construct() {
  parent::__construct(
    'tgb_paypal_widget',
    __('Paypal Button', 'tgb_paypal_widget_domain'),
    array( 'description' => __( 'Paypal Button Widget', 'tgb_paypal_widget_domain' ), )
    );
 }

 public function widget( $args, $instance ) {
   $title = apply_filters( 'widget_title', $instance['title'] );
   $link = apply_filters( 'widget_link', $instance['paypal-link']);
   echo $args['before_widget'];
   if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];
    echo __( '<a href="' . $link . '"><img src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" alt="" /></a>', 'tgb_paypal_widget_domain' );
    echo $args['after_widget'];
  }
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ], $instance[ 'paypal-link'] ) ) {
      $title = $instance[ 'title' ];
      $link = $instance['paypal-link'];
    }
    else {
      $title = __( 'New title', 'tgb_paypal_widget_domain' );
    }
    ?>
    <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    
    <p><label for="<?php echo $this->get_field_id( 'paypal-link' ); ?>"><?php _e( 'Add your PayPal Link:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'paypal-link' ); ?>" name="<?php echo $this->get_field_name( 'paypal-link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
    </p>
    <?php
  }
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['paypal-link'] = ( ! empty( $new_instance['paypal-link'] ) ) ? strip_tags( $new_instance['paypal-link'] ) : '';
    return $instance;
  }
}
