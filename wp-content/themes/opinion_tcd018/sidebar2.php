<div id="side_col"<?php if (!has_nav_menu('global-menu')) { echo ' class="no_global_menu"'; }; ?>>

   <?php if(!is_mobile()) { ?>
     <?php if(is_active_sidebar('right_side_widget')) { ?>
      <?php dynamic_sidebar('right_side_widget'); ?>
     <?php }; ?>
   <?php } else { ?>
     <?php if(is_active_sidebar('mobile_widget_right')) { ?>
      <?php dynamic_sidebar('mobile_widget_right'); ?>
     <?php }; ?>
   <?php }; ?>

</div>
