<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
     $options = get_desing_plus_option();
     if($options['use_ogp']) {
?>
<!--[if lt IE 9]><html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns#" class="ie"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns#"><!--<![endif]-->
<?php } else { ?>
<!--[if lt IE 9]><html xmlns="http://www.w3.org/1999/xhtml" class="ie"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml"><!--<![endif]-->
<?php }; ?>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width" />
<title><?php seo_title(); ?></title>
<meta name="description" content="<?php seo_description(); ?>" />
<?php if($options['use_ogp']) { ogp(); }; ?>

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" /> 
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_enqueue_script( 'jquery' ); ?>
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?> 
<?php wp_head(); ?>

<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css<?php version_num(); ?>" type="text/css" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/comment-style.css<?php version_num(); ?>" type="text/css" />

<link rel="stylesheet" media="screen and (min-width:641px)" href="<?php bloginfo('template_url'); ?>/style_pc.css<?php version_num(); ?>" type="text/css" />
<link rel="stylesheet" media="screen and (max-width:640px)" href="<?php bloginfo('template_url'); ?>/style_sp.css<?php version_num(); ?>" type="text/css" />

<?php if (strtoupper(get_locale()) == 'JA') ://to fix the font-size for japanese font ?>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/japanese.css<?php version_num(); ?>" type="text/css" />
<?php endif; ?>

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jscript.js<?php version_num(); ?>"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/scroll.js<?php version_num(); ?>"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/comment.js<?php version_num(); ?>"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/rollover.js<?php version_num(); ?>"></script>
<!--[if lt IE 9]>
<link id="stylesheet" rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style_pc.css<?php version_num(); ?>" type="text/css" />
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/ie.js<?php version_num(); ?>"></script>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/ie.css" type="text/css" />
<![endif]-->

<!--[if IE 7]>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/ie7.css" type="text/css" />
<![endif]-->

<?php if(is_home()) { ?>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.flexslider-min.js"></script>
<script type="text/javascript">
jQuery(window).on('load',function() {
 jQuery('.flexslider').flexslider({
   slideshowSpeed: 4000,
   directionNav: false,
   manualControls: ".flex-control-nav li"
 });
});
</script>
<?php }; ?>

<style type="text/css">

body { font-size:<?php echo $options['content_font_size']; ?>px; }

a:hover, #index_featured_post .post2 h4.title a:hover, #index_featured_post a, #logo a:hover, #footer_logo_text a:hover
 { color:#<?php echo $options['pickedcolor1']; ?>; }

.pc #global_menu li a, .archive_headline, .page_navi a:hover:hover, #single_title h2, #submit_comment:hover, #author_link:hover, #previous_next_post a:hover, #news_title h2,
 .profile_author_link:hover, #return_top, .author_social_link li.author_link a
 { background-color:#<?php echo $options['pickedcolor1']; ?>; }

#comment_textarea textarea:focus, #guest_info input:focus
 { border-color:#<?php echo $options['pickedcolor1']; ?>; }

#index_featured_post .post2 h4.title a:hover, #index_featured_post a:hover
 { color:#<?php echo $options['pickedcolor2']; ?>; }

.pc #global_menu li a:hover, #return_top:hover, .author_social_link li.author_link a:hover
 { background-color:#<?php echo $options['pickedcolor2']; ?>; }

<?php include('functions/category_style.php'); ?>

</style>

</head>
<body <?php body_class(); ?>>

 <div id="header_wrap">

  <div id="header" class="clearfix">

   <!-- logo -->
   <?php the_dp_logo(); ?>

   <!-- header meu -->
   <div id="header_menu_area">

    <div id="header_menu">
     <?php if (has_nav_menu('header-menu')) { wp_nav_menu( array( 'sort_column' => 'menu_order', 'depth' => '1', 'theme_location' => 'header-menu' , 'container' => '' ) ); };?>
    </div>

    <!-- social button -->
    <?php if ($options['show_rss'] or $options['twitter_url'] or $options['facebook_url']) { ?>
    <ul class="social_link clearfix" id="header_social_link">
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

   </div><!-- END #header_menu_area -->

   <!-- search area -->
   <div class="search_area">
    <?php if ($options['custom_search_id']) { ?>
    <form action="http://www.google.com/cse" method="get" id="searchform">
     <div>
      <input type="hidden" name="cx" value="<?php echo $options['custom_search_id']; ?>" />
      <input type="hidden" name="ie" value="UTF-8" />
     </div>
     <div id="search_button"><input type="submit" value="<?php _e('SEARCH','design-plus'); ?>" /></div>
     <div id="search_input"><input type="text" value="<?php _e('SEARCH','design-plus'); ?>" name="q" onfocus="if (this.value == '<?php _e('SEARCH','design-plus'); ?>') this.value = '';" onblur="if (this.value == '') this.value = '<?php _e('SEARCH','design-plus'); ?>';" /></div>
    </form>
    <?php } else { ?>
    <form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
     <div id="search_button"><input type="submit" value="<?php _e('SEARCH','design-plus'); ?>" /></div>
     <div id="search_input"><input type="text" value="<?php _e('SEARCH','design-plus'); ?>" name="s" onfocus="if (this.value == '<?php _e('SEARCH','design-plus'); ?>') this.value = '';" onblur="if (this.value == '') this.value = '<?php _e('SEARCH','design-plus'); ?>';" /></div>
    </form>
    <?php }; ?>
   </div>

   <!-- banner -->
   <?php if(!is_mobile()) { ?>
   <?php if($options['header_ad_code1']||$options['header_ad_image1']) { ?>
   <div id="header_banner">
    <?php if ($options['header_ad_code1']) { ?>
     <?php echo $options['header_ad_code1']; ?>
    <?php } else { ?>
     <a href="<?php esc_attr_e( $options['header_ad_url1'] ); ?>" class="target_blank"><img src="<?php esc_attr_e( $options['header_ad_image1'] ); ?>" alt="" title="" /></a>
    <?php }; ?>
   </div>
   <?php }; ?>
   <?php }; ?>

   <a href="#" class="menu_button"><?php _e('menu', 'tcd-w'); ?></a>

  </div><!-- END #header -->

 </div><!-- END #header_wrap -->

 <!-- smartphone banner -->
 <?php if(is_mobile() and !is_home()) { ?>
 <?php if($options['mobile_ad_code1']||$options['mobile_ad_image1']) { ?>
 <div id="mobile_banner_top">
  <?php if ($options['mobile_ad_code1']) { ?>
   <?php echo $options['mobile_ad_code1']; ?>
  <?php } else { ?>
   <a href="<?php esc_attr_e( $options['mobile_ad_url1'] ); ?>" class="target_blank"><img src="<?php esc_attr_e( $options['mobile_ad_image1'] ); ?>" alt="" title="" /></a>
  <?php }; ?>
 </div>
 <?php }; ?>
 <?php }; ?>

<!-- + Full width contents header -->
<div id="contents-header"><?php the_post_thumbnail('full'); ?></div>
 <div id="contents" class="clearfix">