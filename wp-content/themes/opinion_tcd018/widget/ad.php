<?php

class ml_ad_widget extends WP_Widget {

  function ml_ad_widget() {
    $widget_ops = array( 'classname' => 'ml_ad_widget', 'description' => __('Show AdSense at random in front page.','tcd-w') );
    $control_ops = array( 'id_base' => 'ml_ad_widget' );
    $this->WP_Widget( 'ml_ad_widget', __('AdSense (tcd ver)','tcd-w'), $widget_ops, $control_ops );
  }

  function widget($args, $instance) {

    extract($args);

   // Before widget //
   echo $before_widget;

      $banner_code1 = $instance['banner_code1'];
      $banner_image1 = esc_attr($instance['banner_image1']);
      $banner_url1 = $instance['banner_url1'];
      $banner_code2 = $instance['banner_code2'];
      $banner_image2 = esc_attr($instance['banner_image2']);
      $banner_url2 = $instance['banner_url2'];
      $banner_code3 = $instance['banner_code3'];
      $banner_image3 = esc_attr($instance['banner_image3']);
      $banner_url3 = $instance['banner_url3'];

      if ($banner_code3 || $banner_image3) { 
        $random = rand(0,2);
      } elseif ($banner_code2 || $banner_image2) {
        $random = rand(0,1);
      } elseif ($banner_code1 || $banner_image1) {
        $random = rand(0,0);
      } else {
        $random = '';
      };

      if($random==0){
        if ($banner_code1) { echo $banner_code1; } else { echo '<a href="' . $banner_url1 . '" target="_blank"><img src="' . $banner_image1 . '" alt="" /></a>' . "\n"; };
      } elseif($random==1){
        if ($banner_code2) { echo $banner_code2; } else { echo '<a href="' . $banner_url2 . '" target="_blank"><img src="' . $banner_image2 . '" alt="" /></a>' . "\n"; };
      } elseif($random==2){
        if ($banner_code3) { echo $banner_code3; } else { echo '<a href="' . $banner_url3 . '" target="_blank"><img src="' . $banner_image3 . '" alt="" /></a>' . "\n"; };
      };

   // After widget //
   echo $after_widget;

  }

  // Update Settings //
  function update($new_instance, $old_instance) {
    $instance['banner_code1'] = $new_instance['banner_code1'];
    $instance['banner_image1'] = strip_tags($new_instance['banner_image1']);
    $instance['banner_url1'] = $new_instance['banner_url1'];
    $instance['banner_code2'] = $new_instance['banner_code2'];
    $instance['banner_image2'] = strip_tags($new_instance['banner_image2']);
    $instance['banner_url2'] = $new_instance['banner_url2'];
    $instance['banner_code3'] = $new_instance['banner_code3'];
    $instance['banner_image3'] = strip_tags($new_instance['banner_image3']);
    $instance['banner_url3'] = $new_instance['banner_url3'];
    return $instance;
  }

  // Widget Control Panel //
  function form($instance) {
    $defaults = array( 'banner_code1' => '', 'banner_image1' => '', 'banner_url1' => '', 'banner_code2' => '', 'banner_image2' => '', 'banner_url2' => '', 'banner_code3' => '', 'banner_image3' => '', 'banner_url3' => '' );
    $instance = wp_parse_args( (array) $instance, $defaults );
?>

<p><?php _e('One out of three AdSense will be displayed at random in front page.','tcd-w'); ?></p>

<div class="ml_ad_widget_box_wrap">

<?php for($i = 1; $i <= 3; $i++): ?>
<h3 class="ml_ad_widget_headline"><?php _e('AdSense','tcd-w'); ?><?php echo $i; ?></h3>
<div class="ml_ad_widget_box">
  <div class="ml_ad_widget_box_inner">
    <h5><?php _e('Register AdSense code','tcd-w'); ?></h5>
    <p><?php _e('If you are using Google AdSense or similar kind of AdSense, enter all code below.', 'tcd-w');  ?></p>
    <p><textarea style="width:100%; height:150px;" id="<?php echo $this->get_field_id('banner_code'.$i); ?>" name="<?php echo $this->get_field_name('banner_code'.$i); ?>"><?php echo $instance['banner_code'.$i]; ?></textarea></p>
  </div>
  <p class="notice"><?php _e('If you want to register banner image and affiliate code individually, leave the field above blank and use the field below.', 'tcd-w');  ?></p>
  <div class="ml_ad_widget_box_inner">
    <h5><?php _e('Register AdSense image','tcd-w'); ?></h5>
    <?php if(empty($instance['banner_image'.$i])) { ?>
      <input type="hidden" class="img" name="<?php echo $this->get_field_name('banner_image'.$i); ?>" id="<?php echo $this->get_field_id('banner_image'.$i); ?>" value="<?php echo $instance['banner_image'.$i]; ?>" />
      <input type="button" class="select-img button" value="<?php _e('Select Image', 'tcd-w'); ?>" />
      <div class="preview_field" id="preview_<?php echo $this->get_field_id('banner_image'.$i); ?>"></div>
    <?php } else { ?>
      <div class="preview_field"><img src="<?php echo $instance['banner_image'.$i]; ?>" /></div>
      <input style="width:100%;" type="text" class="img" name="<?php echo $this->get_field_name('banner_image'.$i); ?>" id="<?php echo $this->get_field_id('banner_image'.$i); ?>" value="<?php echo $instance['banner_image'.$i]; ?>" />
      <input type="button" class="delete-img button" value="<?php _e('Remove Image', 'tcd-w'); ?>" />
    <?php }; ?>
  </div>
  <div class="ml_ad_widget_box_inner">
    <h5><?php _e('Register affiliate code or link url for registered image','tcd-w'); ?></h5>
    <input style="width:100%;" type="text" class="img" name="<?php echo $this->get_field_name('banner_url'.$i); ?>" id="<?php echo $this->get_field_id('banner_url'.$i); ?>" value="<?php echo $instance['banner_url'.$i]; ?>" />
  </div>
</div>
<?php endfor; ?>

</div>

<?php
  }// end Widget Control Panel
}// end class


// init the widget
add_action('widgets_init', create_function('', 'return register_widget("ml_ad_widget");'));



?>