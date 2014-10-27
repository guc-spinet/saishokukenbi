<?php

 // Start class widget //
 class ranking_widget extends WP_Widget {

 // Constructor //
 function ranking_widget() {
  $widget_ops = array( 'classname' => 'ranking_widget', 'description' => __('Displays your Ranking list.', 'tcd-w') ); // Widget Settings
  $control_ops = array( 'id_base' => 'ranking_widget' ); // Widget Control Settings
  $this->WP_Widget( 'ranking_widget', __('Ranking list (tcd ver)', 'tcd-w'), $widget_ops, $control_ops ); // Create the widget
 }

 // Extract Args //
 function widget($args, $instance) {
  extract( $args );
   $title = apply_filters('widget_title', $instance['title']); // the widget title

   // Before widget //
   echo $before_widget;

   // Title of widget //
   if ( $title ) { echo $before_title . $title . $after_title; }

   // Widget output //
   $options = get_desing_plus_option();

?>
<ul>
 <?php for($i = 1; $i <= 10; $i++): ?>
  <?php if($instance['ranking_url'.$i]) { ?><li class="rank<?php echo $i; ?> clearfix"><span><?php echo $i; ?></span><a href="<?php echo $instance['ranking_url'.$i]; ?>"><?php echo $instance['ranking_name'.$i]; ?></a></li><?php }; ?>
 <?php endfor; ?>
</ul>
<?php

   // After widget //
   echo $after_widget;

} // end function widget


 // Update Settings //
 function update($new_instance, $old_instance) {
  $instance['title'] = strip_tags($new_instance['title']);
  $instance['ranking_name1'] = $new_instance['ranking_name1'];
  $instance['ranking_name2'] = $new_instance['ranking_name2'];
  $instance['ranking_name3'] = $new_instance['ranking_name3'];
  $instance['ranking_name4'] = $new_instance['ranking_name4'];
  $instance['ranking_name5'] = $new_instance['ranking_name5'];
  $instance['ranking_name6'] = $new_instance['ranking_name6'];
  $instance['ranking_name7'] = $new_instance['ranking_name7'];
  $instance['ranking_name8'] = $new_instance['ranking_name8'];
  $instance['ranking_name9'] = $new_instance['ranking_name9'];
  $instance['ranking_name10'] = $new_instance['ranking_name10'];
  $instance['ranking_url1'] = $new_instance['ranking_url1'];
  $instance['ranking_url2'] = $new_instance['ranking_url2'];
  $instance['ranking_url3'] = $new_instance['ranking_url3'];
  $instance['ranking_url4'] = $new_instance['ranking_url4'];
  $instance['ranking_url5'] = $new_instance['ranking_url5'];
  $instance['ranking_url6'] = $new_instance['ranking_url6'];
  $instance['ranking_url7'] = $new_instance['ranking_url7'];
  $instance['ranking_url8'] = $new_instance['ranking_url8'];
  $instance['ranking_url9'] = $new_instance['ranking_url9'];
  $instance['ranking_url10'] = $new_instance['ranking_url10'];

  return $instance;
 }

 // Widget Control Panel //
 function form($instance) {
  $defaults = array( 'title' => __('Ranking', 'tcd-w'));
  $instance = wp_parse_args( (array) $instance, $defaults );
?>
<p><?php _e('Please set Ranking in Theme option page first.', 'tcd-w'); ?></p>
<p>
 <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'tcd-w'); ?></label>
 <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
</p>
<hr />
<?php for($i = 1; $i <= 10; $i++): ?>
<p><?php _e('Name of Ranking post', 'tcd-w'); echo $i; ?><br />
<input style="width:100%;" type="text" name="<?php echo $this->get_field_name('ranking_name'.$i); ?>" id="<?php echo $this->get_field_id('ranking_name'.$i); ?>" value="<?php echo $instance['ranking_name'.$i]; ?>" /></p>
<p><?php _e('Link URL of Ranking post', 'tcd-w'); echo $i; ?><br />
<input style="width:100%;" type="text" name="<?php echo $this->get_field_name('ranking_url'.$i); ?>" id="<?php echo $this->get_field_id('ranking_url'.$i); ?>" value="<?php echo $instance['ranking_url'.$i]; ?>" /></p>
<hr />
<?php endfor; ?>

<?php
 } // end function form
}

// End class widget
add_action('widgets_init', create_function('', 'return register_widget("ranking_widget");'));
?>