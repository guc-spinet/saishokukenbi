<div id="right_col">

 <?php if(!is_page()&&is_home()) { ?>

   <?php if(!is_mobile()) { ?>
     <?php if(is_active_sidebar('index_side_widget')) { ?>
      <?php dynamic_sidebar('index_side_widget'); ?>
     <?php }; ?>
   <?php } else { ?>
     <?php if(is_active_sidebar('mobile_widget_index')) { ?>
      <?php dynamic_sidebar('mobile_widget_index'); ?>
     <?php }; ?>
   <?php }; ?>

 <?php } elseif(is_single()) { ?>

   <?php if(!is_mobile()) { ?>
     <?php if(is_active_sidebar('single_side_widget')) { ?>
      <?php dynamic_sidebar('single_side_widget'); ?>
     <?php }; ?>
   <?php } else { ?>
     <?php if(is_active_sidebar('mobile_widget_single')) { ?>
      <?php dynamic_sidebar('mobile_widget_single'); ?>
     <?php }; ?>
   <?php }; ?>

 <?php } else { ?>

   <?php if(!is_mobile()) { ?>
     <?php if(is_active_sidebar('archive_side_widget')) { ?>
      <?php dynamic_sidebar('archive_side_widget'); ?>
     <?php }; ?>
   <?php } else { ?>
     <?php if(is_active_sidebar('mobile_widget_archive')) { ?>
      <?php dynamic_sidebar('mobile_widget_archive'); ?>
     <?php }; ?>
   <?php }; ?>

 <?php }; ?>

</div>