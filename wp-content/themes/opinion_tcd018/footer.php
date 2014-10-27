<?php $options = get_desing_plus_option(); ?>

  <!-- smartphone banner -->
  <?php if(is_mobile() and !is_home()) { ?>
  <?php if($options['mobile_ad_code2']||$options['mobile_ad_image2']) { ?>
  <div id="mobile_banner_bottom">
   <?php if ($options['mobile_ad_code2']) { ?>
    <?php echo $options['mobile_ad_code2']; ?>
   <?php } else { ?>
    <a href="<?php esc_attr_e( $options['mobile_ad_url2'] ); ?>" class="target_blank"><img src="<?php esc_attr_e( $options['mobile_ad_image2'] ); ?>" alt="" title="" /></a>
   <?php }; ?>
  </div>
  <?php }; ?>
  <?php }; ?>

 </div><!-- END #contents -->

 <a id="return_top" href="#header"><?php _e('Return Top', 'tcd-w'); ?></a>

 <?php if(!is_mobile()) { ?>
  <?php if(is_active_sidebar('footer_widget')){ ?>
  <div id="footer_widget_wrap">
   <div id="footer_widget" class="clearfix">
    <?php dynamic_sidebar('footer_widget'); ?>
   </div><!-- END #footer_widget -->
  </div><!-- END #footer_widget_wrap -->
  <?php }; ?>
 <?php } else { ?>
  <?php if(is_active_sidebar('mobile_widget_footer')){ ?>
  <div id="footer_widget_wrap">
   <div id="footer_widget" class="clearfix">
    <?php dynamic_sidebar('mobile_widget_footer'); ?>
   </div><!-- END #footer_widget -->
  </div><!-- END #footer_widget_wrap -->
  <?php }; ?>
 <?php }; ?>

 <div id="footer_wrap">
  <div id="footer" class="clearfix">

   <!-- logo -->
   <?php the_dp_footer_logo(); ?>

   <div id="footer_menu_area">

    <div id="footer_menu">
     <?php if (has_nav_menu('footer-menu')) { wp_nav_menu( array( 'sort_column' => 'menu_order', 'depth' => '1', 'theme_location' => 'footer-menu' , 'container' => '' ) ); };?>
    </div>

    <!-- social button -->
    <?php if ($options['show_rss'] or $options['twitter_url'] or $options['facebook_url']) { ?>
    <ul class="social_link clearfix" id="footer_social_link">
     <?php if ($options['show_rss']) : ?>
     <li class="rss"><a class="target_blank" href="<?php bloginfo('rss2_url'); ?>">rss</a></li>
     <?php endif; ?>
     <?php if ($options['twitter_url']) : ?>
     <li class="twitter"><a class="target_blank" href="<?php echo $options['twitter_url']; ?>">twitter</a></li>
     <?php endif; ?>
     <?php if ($options['facebook_url']) : ?>
     <li class="facebook"><a class="target_blank" href="<?php echo $options['facebook_url']; ?>">facebook</a></li>
     <?php endif; ?>
    </ul>
    <?php }; ?>

   </div>

  </div><!-- END #footer_widget -->
 </div><!-- END #footer_widget_wrap -->

 <p id="copyright"><?php _e('Copyright &copy;&nbsp; ', 'tcd-w'); ?><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a> All rights reserved.</p>

 <?php if(!is_home()) { ?>
 <!-- facebook share button code -->
 <div id="fb-root"></div>
 <script>(function(d, s, id) {
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) return;
   js = d.createElement(s); js.id = id;
   js.src = "//connect.facebook.net/<?php if (strtoupper(get_locale()) == 'JA') { echo "ja_JP"; } else { echo "en_US"; }; ?>/all.js#xfbml=1";
   fjs.parentNode.insertBefore(js, fjs);
 }(document, 'script', 'facebook-jssdk'));</script>
 <?php }; ?>

<?php wp_footer(); ?>
</body>
</html>