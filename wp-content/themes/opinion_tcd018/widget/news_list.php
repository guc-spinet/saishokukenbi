<?php

 // Start class widget //
 class tcdw_news_list_widget extends WP_Widget {

 // Constructor //
 function tcdw_news_list_widget() {
  $widget_ops = array( 'classname' => 'tcdw_news_list_widget', 'description' => __('Displays news list.', 'tcd-w') ); // Widget Settings
  $control_ops = array( 'id_base' => 'tcdw_news_list_widget' ); // Widget Control Settings
  $this->WP_Widget( 'tcdw_news_list_widget', __('News list (tcd ver)', 'tcd-w'), $widget_ops, $control_ops ); // Create the widget
 }

 // Extract Args //
 function widget($args, $instance) {
  extract( $args );
   $title = apply_filters('widget_title', $instance['title']); // the widget title
   $post_num = $instance['post_num'];

   // Before widget //
   echo $before_widget;

   // Title of widget //
   if ( $title ) { echo $before_title . $title . $after_title; }

   // Widget output //
   $args = array('post_type' => 'news', 'posts_per_page' => $post_num);
   $news_list = new WP_Query($args);
   if ($news_list -> have_posts()) {
?>
<ol class="news_widget_list">
 <?php
       while ($news_list -> have_posts()) : $news_list -> the_post();
 ?>
 <li class="clearfix">
  <p class="news_date"><?php the_time('Y/n/j'); ?></p>
  <a class="news_title" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
 </li>
 <?php endwhile; ?>
</ol>
<a class="news_widget_list_link" href="<?php echo get_post_type_archive_link('news'); ?>"><?php _e("Archives","tcd-w"); ?></a>
<?php } else { ?>
 <p><?php _e("There is no registered news.","tcd-w"); ?></p>
<?php }; wp_reset_query(); ?>
<?php

   // After widget //
   echo $after_widget;

} // end function widget


 // Update Settings //
 function update($new_instance, $old_instance) {
  $instance['title'] = strip_tags($new_instance['title']);
  $instance['post_num'] = $new_instance['post_num'];
  return $instance;
 }

 // Widget Control Panel //
 function form($instance) {
  $defaults = array( 'title' => __('News', 'tcd-w'), 'post_num' => '5');
  $instance = wp_parse_args( (array) $instance, $defaults );
?>
<p>
 <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'tcd-w'); ?></label>
 <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
</p>
<p>
 <label for="<?php echo $this->get_field_id('post_num'); ?>"><?php _e('Number of news:', 'tcd-w'); ?></label>
 <select id="<?php echo $this->get_field_id('post_num'); ?>" name="<?php echo $this->get_field_name('post_num'); ?>" class="widefat" style="width:100%;">
  <option value="1" <?php selected('1', $instance['post_num']); ?>>1</option>
  <option value="3" <?php selected('3', $instance['post_num']); ?>>3</option>
  <option value="5" <?php selected('5', $instance['post_num']); ?>>5</option>
  <option value="10" <?php selected('10', $instance['post_num']); ?>>10</option>
  <option value="-1" <?php selected('-1', $instance['post_num']); ?>><?php _e('All', 'tcd-w'); ?></option>
 </select>
</p>
<?php
 } // end function form
}

// End class widget
add_action('widgets_init', create_function('', 'return register_widget("tcdw_news_list_widget");'));
?>