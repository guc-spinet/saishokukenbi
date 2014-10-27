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
<div id="Recent_detailed_information">
   <h3 class="side_headline"><?php _e("他の講座","tcd-w"); ?></h3>
   <?php
        $args = array('post_type' => 'detailed_information', 'posts_per_page' => 5);
        $recent_detailed_information = get_posts($args);
        if ($recent_detailed_information) {
   ?>
   <ul id="news_list" class="clearfix">
    <?php foreach ($recent_detailed_information as $post) : setup_postdata ($post); ?>
    <li class="clearfix">
     <p class="news_date"><?php the_time('Y/n/j'); ?></p>
     <h4 class="news_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
    </li>
    <?php endforeach; wp_reset_query(); ?>
   </ul>
   <?php }; ?>
  </div><!-- END #recent_news -->

</div>


