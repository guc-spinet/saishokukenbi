<?php

 // Start class widget //
 class pr_widget extends WP_Widget {

 // Constructor //
 function pr_widget() {
  $widget_ops = array( 'classname' => 'pr_widget', 'description' => __('Displays your PR list.', 'tcd-w') ); // Widget Settings
  $control_ops = array( 'id_base' => 'pr_widget' ); // Widget Control Settings
  $this->WP_Widget( 'pr_widget', __('PR list (tcd ver)', 'tcd-w'), $widget_ops, $control_ops ); // Create the widget
 }

 // Extract Args //
 function widget($args, $instance) {
  extract( $args );

   // Before widget //
   echo $before_widget;

   // Widget output //
   $options = get_desing_plus_option();

?>
<ul>
 <?php for($i = 1; $i <= 5; $i++): ?>
  <?php if($instance['pr_name'.$i]) { ?><li class="clearfix"><a href="<?php echo $instance['pr_url'.$i]; ?>"><?php echo $instance['pr_name'.$i]; ?></a></li><?php }; ?>
 <?php endfor; ?>
</ul>
<?php

   // After widget //
   echo $after_widget;

} // end function widget


 // Update Settings //
 function update($new_instance, $old_instance) {
  $instance['pr_name1'] = $new_instance['pr_name1'];
  $instance['pr_name2'] = $new_instance['pr_name2'];
  $instance['pr_name3'] = $new_instance['pr_name3'];
  $instance['pr_name4'] = $new_instance['pr_name4'];
  $instance['pr_name5'] = $new_instance['pr_name5'];
  $instance['pr_url1'] = $new_instance['pr_url1'];
  $instance['pr_url2'] = $new_instance['pr_url2'];
  $instance['pr_url3'] = $new_instance['pr_url3'];
  $instance['pr_url4'] = $new_instance['pr_url4'];
  $instance['pr_url5'] = $new_instance['pr_url5'];

  return $instance;
 }

 // Widget Control Panel //
 function form($instance) {
  $instance = wp_parse_args( (array) $instance, $defaults );
?>
 <?php for($i = 1; $i <= 5; $i++): ?>
 <p><?php _e('Name of PR post', 'tcd-w'); echo $i; ?><br />
 <input style="width:100%;" type="text" name="<?php echo $this->get_field_name('pr_name'.$i); ?>" id="<?php echo $this->get_field_id('pr_name'.$i); ?>" value="<?php echo $instance['pr_name'.$i]; ?>" /></p>
 <p><?php _e('Link URL of PR post', 'tcd-w'); echo $i; ?><br />
 <input style="width:100%;" type="text" name="<?php echo $this->get_field_name('pr_url'.$i); ?>" id="<?php echo $this->get_field_id('pr_url'.$i); ?>" value="<?php echo $instance['pr_url'.$i]; ?>" /></p>
 <hr />
 <?php endfor; ?>
<?php
 } // end function form
}

// End class widget
add_action('widgets_init', create_function('', 'return register_widget("pr_widget");'));
?>