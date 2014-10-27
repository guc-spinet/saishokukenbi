<?php

 // Start class widget //
 class year_archive_widget extends WP_Widget {

 // Constructor //
 function year_archive_widget() {
  $widget_ops = array( 'classname' => 'year_archive_widget', 'description' => __('Displays original Archive list.', 'tcd-w') ); // Widget Settings
  $control_ops = array( 'id_base' => 'year_archive_widget' ); // Widget Control Settings
  $this->WP_Widget( 'year_archive_widget', __('Archive list (tcd ver)', 'tcd-w'), $widget_ops, $control_ops ); // Create the widget
 }

 // Extract Args //
 function widget($args, $instance) {
  extract( $args );
   $title = apply_filters('widget_title', $instance['title']); // the widget title
   $archive_type = $instance['archive_type'];

   // Before widget //
   echo $before_widget;

   // Title of widget //
   if ( $title ) { echo $before_title . $title . $after_title; }

   // Widget output //
   $options = get_desing_plus_option();

?>

<?php
     if($archive_type == 'type1') {

     $archives = get_archives_array(array('period'=>'yearly'));
     if($archives):
?>
<script type="text/javascript">
jQuery(document).ready(function($){
  $('#tcd_archive_list .parent > span').toggle(
    function(){
     $(this).next().next().show();
     $(this).addClass('open');
    },
    function(){
     $(this).next().next().hide();
     $(this).removeClass('open');
  });
});
</script>
<ul id="tcd_archive_list">
 <?php foreach($archives as $archive): ?>

 <?php if (strtoupper(get_locale()) == 'JA') : ?>
 <li class="parent"><span>open</span><a href="<?php echo get_year_link($archive->year); ?>"><?php echo $archive->year; ?>年(<?php echo $archive->posts; ?>)</a>
 <?php else: ?>
 <li class="parent"><a href="<?php echo get_year_link($archive->year); ?>"><?php echo $archive->year; ?>(<?php echo $archive->posts; ?>)</a>
 <?php endif; ?>

 <?php
      $current_year = $archive->year;
      $archives = get_archives_array(array('year'=>$current_year));
      if($archives):
 ?>
  <ul class="child">
   <?php foreach($archives as $archive): ?>
   <?php if (strtoupper(get_locale()) == 'JA') : ?>
   <li><a href="<?php echo get_month_link($archive->year, $archive->month); ?>"><?php echo $archive->year; ?>年<?php echo $archive->month; ?>月(<?php echo $archive->posts; ?>)</a></li>
   <?php else: ?>
   <li><a href="<?php echo get_month_link($archive->year, $archive->month); ?>"><?php echo $archive->year; ?>/<?php echo $archive->month; ?>(<?php echo $archive->posts; ?>)</a></li>
   <?php endif; ?>
   <?php endforeach; ?>
  </ul>
 <?php endif; ?>

 </li>

 <?php endforeach; ?>
</ul>
<?php endif; ?>

<?php
     } else {

     $archives = get_archives_array(array('period'=>'yearly'));
     if($archives):
?>
<ul id="tcd_archive_list2">
 <?php foreach($archives as $archive): ?>

 <li class="parent"><a href="<?php echo get_year_link($archive->year); ?>"><?php echo $archive->year; ?></a>

 <?php
      $current_year = $archive->year;
      $archives = get_archives_array(array('year'=>$current_year));
      if($archives):
 ?>
  <ul class="child clearfix">
   <?php foreach(array_reverse($archives) as $archive): ?>
   <li><a href="<?php echo get_month_link($archive->year, $archive->month); ?>"><?php echo $archive->month; ?></a></li>
   <?php endforeach; ?>
  </ul>
 <?php endif; ?>

 </li>

 <?php endforeach; ?>
</ul>
<?php
     endif;
     };
?>

<?php

   // After widget //
   echo $after_widget;

} // end function widget


 // Update Settings //
 function update($new_instance, $old_instance) {
  $instance['title'] = strip_tags($new_instance['title']);
  $instance['archive_type'] = $new_instance['archive_type'];

  return $instance;
 }

 // Widget Control Panel //
 function form($instance) {
  $defaults = array( 'title' => __('Archive', 'tcd-w') , 'archive_type' => 'type1');
  $instance = wp_parse_args( (array) $instance, $defaults );
?>
<p>
 <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'tcd-w'); ?></label>
 <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
</p>
<p>
 <label for="<?php echo $this->get_field_id('archive_type'); ?>"><?php _e('Archive list type:', 'tcd-w'); ?></label>
 <select id="<?php echo $this->get_field_id('archive_type'); ?>" name="<?php echo $this->get_field_name('archive_type'); ?>" class="widefat" style="width:100%;">
  <option value="type1" <?php selected('type1', $instance['archive_type']); ?>><?php _e('Type1', 'tcd-w'); ?></option>
  <option value="type2" <?php selected('type2', $instance['archive_type']); ?>><?php _e('Type2', 'tcd-w'); ?></option>
 </select>
</p>
<?php
 } // end function form
}

// End class widget
add_action('widgets_init', create_function('', 'return register_widget("year_archive_widget");'));
?>