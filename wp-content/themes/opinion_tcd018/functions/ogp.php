<?php

function og_image() {

 global $post;
 $post_thumbnail_id = get_post_thumbnail_id($post->ID);
 $image = wp_get_attachment_image_src( $post_thumbnail_id, 'size1');
 list($src, $width, $height) = $image;
 if ( has_post_thumbnail()) {
   echo esc_attr($src);
 } else {
   echo get_bloginfo('template_url') . '/img/common/no_image1.jpg';
 };
}

function twitter_image() {

 global $post;
 $post_thumbnail_id = get_post_thumbnail_id($post->ID);
 $image = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail');
 list($src, $width, $height) = $image;
 if ( has_post_thumbnail()) {
   echo esc_attr($src);
 } else {
   echo get_bloginfo('template_url') . '/img/common/no_image5.jpg';
 };
}

?>
<?php

function ogp() {

 $options = get_desing_plus_option();
 global $post;

?>
<?php if(is_home()) { ?>
<meta property="og:type" content="blog" />
<meta property="og:url" content="<?php echo esc_url(home_url('/')); ?>" />
<meta property="og:title" content="<?php echo get_bloginfo('name'); ?>" />
<meta property="og:description" content="<?php echo get_bloginfo('description'); ?>" />
<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" />
<?php if($options['fb_admin_id']) { ?>
<meta property="fb:admins" content="<?php echo $options['fb_admin_id']; ?>" />
<?php }; ?>
<?php if($options['use_twitter_card']) { ?>
<meta name="twitter:card" content="summary" />
<?php if($options['twitter_account_name']) { ?>
<meta name="twitter:site" content="@<?php echo $options['twitter_account_name']; ?>" />
<?php }; ?>
<?php if($options['twitter_account_name']) { ?>
<meta name="twitter:creator" content="@<?php echo $options['twitter_account_name']; ?>" />
<?php }; ?>
<meta name="twitter:title" content="<?php echo get_bloginfo('name'); ?>" />
<meta name="twitter:description" content="<?php echo get_bloginfo('description'); ?>" />
<?php }; ?>
<?php } elseif(is_single()) { ?>
<meta property="og:type" content="article" />
<meta property="og:url" content="<?php echo "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI']; ?>" />
<meta property="og:title" content="<?php the_title(); ?>" />
<meta property="og:description" content="<?php seo_description(); ?>" />
<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" />
<meta property="og:image" content='<?php og_image(); ?>' />
<?php if($options['fb_admin_id']) { ?>
<meta property="fb:admins" content="<?php echo $options['fb_admin_id']; ?>" />
<?php }; ?>
<?php if($options['use_twitter_card']) { ?>
<meta name="twitter:card" content="summary" />
<?php if($options['twitter_account_name']) { ?>
<meta name="twitter:site" content="@<?php echo $options['twitter_account_name']; ?>" />
<?php }; ?>
<?php if($options['twitter_account_name']) { ?>
<meta name="twitter:creator" content="@<?php echo $options['twitter_account_name']; ?>" />
<?php }; ?>
<meta name="twitter:title" content="<?php the_title(); ?>" />
<meta name="twitter:description" content="<?php seo_description(); ?>" />
<meta name="twitter:image:src" content='<?php twitter_image(); ?>' />
<?php }; ?>
<?php }; ?>

<?php }; ?>