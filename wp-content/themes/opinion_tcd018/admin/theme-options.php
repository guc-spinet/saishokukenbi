<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * オプション初期値
 * @var array 
 */
global $dp_default_options;
$dp_default_options = array(
	'pickedcolor1' => '0077B3',
	'pickedcolor2' => '57BDCC',
	'logotop' => 0,
	'logoleft' => 0,
	'logotop2' => 0,
	'logoleft2' => 0,
	'content_font_size' => '14',
	'show_date' => 1,
	'show_category' => 1,
	'show_tag' => 1,
	'show_comment' => 1,
	'show_author' => 1,
	'show_trackback' => 1,
	'show_related_post' => 1,
	'show_next_post' => 1,
	'show_thumbnail' => 1,
	'show_bookmark' => 1,
	'show_rss' => 1,
	'twitter_url' => '',
	'facebook_url' => '',
	'custom_search_id' => '',
	'index_featured'  => 'pickup_post',
	'show_pr' => 0,
	'index_pr_num' => '3',
	'pr_headline' => __( 'PR post', 'tcd-w' ),
	'pr_url1' => '',
	'pr_url2' => '',
	'pr_url3' => '',
	'pr_url4' => '',
	'pr_url5' => '',
	'pr_name1' => '',
	'pr_name2' => '',
	'pr_name3' => '',
	'pr_name4' => '',
	'pr_name5' => '',
	'show_ranking' => 0,
	'index_ranking_num' => '3',
	'ranking_headline' => __( 'Ranking', 'tcd-w' ),
	'ranking_url1' => '',
	'ranking_url2' => '',
	'ranking_url3' => '',
	'ranking_url4' => '',
	'ranking_url5' => '',
	'ranking_url6' => '',
	'ranking_url7' => '',
	'ranking_url8' => '',
	'ranking_url9' => '',
	'ranking_url10' => '',
	'ranking_name1' => '',
	'ranking_name2' => '',
	'ranking_name3' => '',
	'ranking_name4' => '',
	'ranking_name5' => '',
	'ranking_name6' => '',
	'ranking_name7' => '',
	'ranking_name8' => '',
	'ranking_name9' => '',
	'ranking_name10' => '',
	'news_archive_num' => '10',
	'press_archive_num' => '10',
	'index_category1'  => '',
	'index_category2'  => '',
	'index_category3'  => '',
	'header_ad_code1' => '',
	'header_ad_url1' => '',
	'header_ad_image1' => false,
	'single_ad_code1' => '',
	'single_ad_url1' => '',
	'single_ad_image1' => false,
	'single_ad_code2' => '',
	'single_ad_url2' => '',
	'single_ad_image2' => false,
	'mobile_ad_code1' => '',
	'mobile_ad_url1' => '',
	'mobile_ad_image1' => false,
	'mobile_ad_code2' => '',
	'mobile_ad_url2' => '',
	'mobile_ad_image2' => false,
	'use_ogp' => 0,
	'fb_admin_id' => '',
	'use_twitter_card' => 0,
	'twitter_account_name' => '',
	'top_large_ad_code1' => '',
	'top_large_ad_url1' => '',
	'top_large_ad_image1' => false,
	'top_large_ad_code2' => '',
	'top_large_ad_url2' => '',
	'top_large_ad_image2' => false,
	'top_small_ad_code1' => '',
	'top_small_ad_url1' => '',
	'top_small_ad_image1' => false,
	'top_small_ad_code2' => '',
	'top_small_ad_url2' => '',
	'top_small_ad_image2' => false,
	'top_small_ad_code3' => '',
	'top_small_ad_url3' => '',
	'top_small_ad_image3' => false,
	'top_small_ad_code4' => '',
	'top_small_ad_url4' => '',
	'top_small_ad_image4' => false,
	'top_banner_type'  => 'type1'
);

/**
 * Design Plusのオプションを返す
 * @global array $dp_default_options
 * @return array 
 */
function get_desing_plus_option(){
	global $dp_default_options;
	return shortcode_atts($dp_default_options, get_option('dp_options', array()));
}



// カラーピッカーの準備 その他javascriptの読み込み
add_action('admin_print_scripts', 'my_admin_print_scripts');
function my_admin_print_scripts() {
  wp_enqueue_script('jscolor', get_template_directory_uri().'/admin/jscolor.js');
  wp_enqueue_script('jquery.cookieTab', get_template_directory_uri().'/admin/jquery.cookieTab.js');
}



// 画像アップロードの準備
function wp_gear_manager_admin_scripts() {
wp_enqueue_script('dp-image-manager', get_template_directory_uri().'/admin/image-manager.js', array('jquery', 'jquery-ui-draggable', 'imgareaselect'));
wp_enqueue_script('dp-image-manager2', get_template_directory_uri().'/admin/image-manager2.js', array('jquery', 'jquery-ui-draggable', 'imgareaselect'));
}
function wp_gear_manager_admin_styles() {
wp_enqueue_style('imgareaselect');
}
add_action('admin_print_scripts', 'wp_gear_manager_admin_scripts');
add_action('admin_print_styles', 'wp_gear_manager_admin_styles');



// 登録
function theme_options_init(){
 register_setting( 'design_plus_options', 'dp_options', 'theme_options_validate' );
}


// ロード
function theme_options_add_page() {
 add_theme_page( __( 'Theme Options', 'tcd-w' ), __( 'Theme Options', 'tcd-w' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}


//トップページのおすすめ記事の初期設定
global $index_featured_options;
$index_featured_options = array(
 'pickup_post' => array(
  'value' => 'pickup_post',
  'label' => __( 'Pickup post', 'tcd-w' )
 ),
 'recommend_post' => array(
  'value' => 'recommend_post',
  'label' => __( 'Recommend post', 'tcd-w' )
 ),
 'recommend_post2' => array(
  'value' => 'recommend_post2',
  'label' => __( 'Recommend post2', 'tcd-w' )
 ),
 'recommend_post3' => array(
  'value' => 'recommend_post3',
  'label' => __( 'Recommend post3', 'tcd-w' )
 )
);


//トップページのカテゴリー1の初期設定
global $index_category1_options;
$index_category1_options[0] = array(
    'value' => 0,
    'label' => ''
);
$dp_cats = get_categories();
foreach( $dp_cats as $dp_cat ) :
 $index_category1_options[$dp_cat->cat_ID] = array(
  'value' => $dp_cat->cat_ID,
  'label' => $dp_cat->cat_name
 );
endforeach;


//トップページのカテゴリー2の初期設定
global $index_category2_options;
$index_category2_options[0] = array(
    'value' => 0,
    'label' => ''
);
$dp_cats2 = get_categories();
foreach( $dp_cats2 as $dp_cat2 ) :
 $index_category2_options[$dp_cat2->cat_ID] = array(
  'value' => $dp_cat2->cat_ID,
  'label' => $dp_cat2->cat_name
 );
endforeach;


//トップページのカテゴリー3の初期設定
global $index_category3_options;
$index_category3_options[0] = array(
    'value' => 0,
    'label' => ''
);
$dp_cats3 = get_categories();
foreach( $dp_cats3 as $dp_cat3 ) :
 $index_category3_options[$dp_cat3->cat_ID] = array(
  'value' => $dp_cat3->cat_ID,
  'label' => $dp_cat3->cat_name
 );
endforeach;


//トップページのバナータイプの初期設定
global $top_banner_type_options;
$top_banner_type_options = array(
 'type1' => array(
  'value' => 'type1',
  'label' => __( 'Width 300px, Height 250px', 'tcd-w' )
 ),
 'type2' => array(
  'value' => 'type2',
  'label' => __( 'Width 300px, Height 60px', 'tcd-w' )
 )
);


// テーマオプション画面の作成
function theme_options_do_page() {
 global $index_featured_options, $index_category1_options, $index_category2_options, $index_category3_options, $top_banner_type_options, $dp_upload_error;
 $options = get_desing_plus_option(); 

 if ( ! isset( $_REQUEST['settings-updated'] ) )
  $_REQUEST['settings-updated'] = false;

?>

<div class="wrap">
 <?php screen_icon(); echo "<h2>" . __( 'Theme Options', 'tcd-w' ) . "</h2>"; ?>

 <?php // 更新時のメッセージ
       if ( false !== $_REQUEST['settings-updated'] ) :
 ?>
 <div class="updated fade"><p><strong><?php _e('Updated', 'tcd-w');  ?></strong></p></div>
 <?php endif; ?>

 <?php /* ファイルアップロード時のメッセージ */ if(!empty($dp_upload_error['message'])): ?>
  <?php if($dp_upload_error['error']): ?>
   <div id="error" class="error"><p><?php echo $dp_upload_error['message']; ?></p></div>
  <?php else: ?>
   <div id="message" class="updated fade"><p><?php echo $dp_upload_error['message']; ?></p></div>
  <?php endif; ?>
 <?php endif; ?>
 
 <script type="text/javascript">
  jQuery(document).ready(function($){
   $('#my_theme_option').cookieTab({
    tabMenuElm: '#theme_tab',
    tabPanelElm: '#tab-panel'
   });
  });
 </script>

 <div id="my_theme_option">

 <div id="theme_tab_wrap">
  <ul id="theme_tab" class="cf">
   <li><a href="#tab-content1"><?php _e('Basic', 'tcd-w');  ?></a></li>
   <li><a href="#tab-content2"><?php _e('Advance', 'tcd-w');  ?></a></li>
   <li><a href="#tab-content3"><?php _e('Index page', 'tcd-w');  ?></a></li>
   <li><a href="#tab-content4"><?php _e('Logo', 'tcd-w');  ?></a></li>
   <li><a href="#tab-content5"><?php _e('Footer logo', 'tcd-w');  ?></a></li>
   <li><a href="#tab-content6"><?php _e('Header Banner', 'tcd-w');  ?></a></li>
   <li><a href="#tab-content7"><?php _e('Single Page Banner', 'tcd-w');  ?></a></li>
   <li><a href="#tab-content8"><?php _e('Smartphone Banner', 'tcd-w');  ?></a></li>
  </ul>
 </div>

<form method="post" action="options.php" enctype="multipart/form-data">
 <?php settings_fields( 'design_plus_options' ); ?>

 <div id="tab-panel">

  <!-- #tab-content1 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
  <div id="tab-content1">

   <?php // サイトカラー ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Site main color', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
     <input type="text" class="color" name="dp_options[pickedcolor1]" value="<?php esc_attr_e( $options['pickedcolor1'] ); ?>" />
     <input type="submit" class="button-primary" value="<?php echo __( 'Save Color', 'tcd-w' ); ?>" />
    </div>
    <p color="color_scheme" id="default_color1"><?php _e('Default color', 'tcd-w');  ?> ：0077B3</p>
   </div>

   <?php // サイトカラー２ ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Site secondary color', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
     <input type="text" class="color" name="dp_options[pickedcolor2]" value="<?php esc_attr_e( $options['pickedcolor2'] ); ?>" />
     <input type="submit" class="button-primary" value="<?php echo __( 'Save Color', 'tcd-w' ); ?>" />
    </div>
    <p color="color_scheme" id="default_color2"><?php _e('Default color', 'tcd-w');  ?> ：57BDCC</p>
   </div>

   <?php // フォントサイズ ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Font size', 'tcd-w');  ?></h3>
    <p><?php _e('Font size of single page and wp-page.', 'tcd-w');  ?></p>
    <div class="theme_option_input">
     <input id="dp_options[content_font_size]" class="font_size" type="text" name="dp_options[content_font_size]" value="<?php esc_attr_e( $options['content_font_size'] ); ?>" /><span>px</span>
    </div>
   </div>

   <?php // 投稿者名・タグ・コメント ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Display Setup', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
     <ul>
      <li><label><input id="dp_options[show_date]" name="dp_options[show_date]" type="checkbox" value="1" <?php checked( '1', $options['show_date'] ); ?> /> <?php _e('Display date', 'tcd-w');  ?></label></li>
      <li><label><input id="dp_options[show_category]" name="dp_options[show_category]" type="checkbox" value="1" <?php checked( '1', $options['show_category'] ); ?> /> <?php _e('Display category', 'tcd-w');  ?></label></li>
      <li><label><input id="dp_options[show_tag]" name="dp_options[show_tag]" type="checkbox" value="1" <?php checked( '1', $options['show_tag'] ); ?> /> <?php _e('Display tags', 'tcd-w');  ?></label></li>
      <li><label><input id="dp_options[show_author]" name="dp_options[show_author]" type="checkbox" value="1" <?php checked( '1', $options['show_author'] ); ?> /> <?php _e('Display author', 'tcd-w');  ?></label></li>
      <li><label><input id="dp_options[show_comment]" name="dp_options[show_comment]" type="checkbox" value="1" <?php checked( '1', $options['show_comment'] ); ?> /> <?php _e('Display comment', 'tcd-w');  ?></label></li>
      <li><label><input id="dp_options[show_thumbnail]" name="dp_options[show_thumbnail]" type="checkbox" value="1" <?php checked( '1', $options['show_thumbnail'] ); ?> /> <?php _e('Display thumbnail at single post page', 'tcd-w');  ?></label></li>
      <li><label><input id="dp_options[show_bookmark]" name="dp_options[show_bookmark]" type="checkbox" value="1" <?php checked( '1', $options['show_bookmark'] ); ?> /> <?php _e('Display bookmark at single post page', 'tcd-w');  ?></label></li>
      <li><label><input id="dp_options[show_trackback]" name="dp_options[show_trackback]" type="checkbox" value="1" <?php checked( '1', $options['show_trackback'] ); ?> /> <?php _e('Display trackbacks at single post page', 'tcd-w');  ?></label></li>
      <li><label><input id="dp_options[show_related_post]" name="dp_options[show_related_post]" type="checkbox" value="1" <?php checked( '1', $options['show_related_post'] ); ?> /> <?php _e('Display related post at single post page', 'tcd-w');  ?></label></li>
      <li><label><input id="dp_options[show_next_post]" name="dp_options[show_next_post]" type="checkbox" value="1" <?php checked( '1', $options['show_next_post'] ); ?> /> <?php _e('Display next previous post link at single post page', 'tcd-w');  ?></label></li>
      <li><label><input id="dp_options[show_rss]" name="dp_options[show_rss]" type="checkbox" value="1" <?php checked( '1', $options['show_rss'] ); ?> /> <?php _e('Display RSS at header', 'tcd-w');  ?></label></li>
     </ul>
    </div>
   </div>

   <?php // facebook twitter ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('twitter and facebook setup', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
     <p><?php _e('When it is blank, twitter and facebook icon will not displayed on a site.', 'tcd-w');  ?></p>
     <ul>
      <li>
       <label style="display:inline-block; min-width:140px;"><?php _e('your twitter URL', 'tcd-w');  ?></label>
       <input id="dp_options[twitter_url]" class="regular-text" type="text" name="dp_options[twitter_url]" value="<?php esc_attr_e( $options['twitter_url'] ); ?>" />
      </li>
      <li>
       <label style="display:inline-block; min-width:140px;"><?php _e('your facebook URL', 'tcd-w');  ?></label>
       <input id="dp_options[facebook_url]" class="regular-text" type="text" name="dp_options[facebook_url]" value="<?php esc_attr_e( $options['facebook_url'] ); ?>" />
      </li>
     </ul>
    </div>
   </div>

   <?php // 検索の設定 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Using Google custom search', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
     <p><?php _e('If you wan\'t to use google custom search for your wordpress, enter your google custom search ID.<br /><a href="http://www.google.com/cse/" target="_blank">Read more about Google custom search page.</a>', 'tcd-w');  ?></p>
     <label style="display:inline-block; margin:0 20px 0 0;"><?php _e('Google custom search ID', 'tcd-w');  ?></label>
     <input id="dp_options[custom_search_id]" class="regular-text" type="text" name="dp_options[custom_search_id]" value="<?php esc_attr_e( $options['custom_search_id'] ); ?>" />
    </div>
   </div>

   <p class="submit"><input type="submit" class="button-primary" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" /></p>

  </div><!-- END #tab-content1 -->




  <!-- #tab-content1 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
  <div id="tab-content1">

   <?php // PR記事 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('PR list setting', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
     <p><label><input id="dp_options[show_pr]" name="dp_options[show_pr]" type="checkbox" value="1" <?php checked( '1', $options['show_pr'] ); ?> /> <?php _e('Show PR list at Index page', 'tcd-w');  ?></label></p>
     <p class="index_post_list_num"><label><?php _e('Number of PR list at Index page', 'tcd-w');  ?></label><input id="dp_options[index_pr_num]" class="font_size" type="text" name="dp_options[index_pr_num]" value="<?php esc_attr_e( $options['index_pr_num'] ); ?>" /></p>
     <p class="index_post_list_headline"><label><?php _e('PR list headline', 'tcd-w');  ?></label><input id="dp_options[pr_headline]" class="regular-text" type="text" name="dp_options[pr_headline]" value="<?php esc_attr_e( $options['pr_headline'] ); ?>" /></p>
     <ul class="index_post_list" id="pr_post_list">
      <?php for($i = 1; $i <= 5; $i++): ?>
      <li class="cf">
       <label><?php _e('PR title', 'tcd-w');  ?><?php echo $i; ?></label><input id="dp_options[pr_name<?php echo $i; ?>]" class="regular-text" type="text" name="dp_options[pr_name<?php echo $i; ?>]" value="<?php esc_attr_e( $options['pr_name'.$i] ); ?>" /><br />
       <label><?php _e('PR url', 'tcd-w');  ?><?php echo $i; ?></label><input id="dp_options[pr_url<?php echo $i; ?>]" class="regular-text" type="text" name="dp_options[pr_url<?php echo $i; ?>]" value="<?php esc_attr_e( $options['pr_url'.$i] ); ?>" />
      </li>
      <?php endfor; ?>
     </ul>
    </div>
   </div>

   <?php // ランキング記事 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Ranking list setting', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
     <p><label><input id="dp_options[show_ranking]" name="dp_options[show_ranking]" type="checkbox" value="1" <?php checked( '1', $options['show_ranking'] ); ?> /> <?php _e('Show Ranking list at Index page', 'tcd-w');  ?></label></p>
     <p class="index_post_list_num"><label><?php _e('Number of Ranking list at Index page', 'tcd-w');  ?></label><input id="dp_options[index_ranking_num]" class="font_size" type="text" name="dp_options[index_ranking_num]" value="<?php esc_attr_e( $options['index_ranking_num'] ); ?>" /></p>
     <p class="index_post_list_headline"><label><?php _e('Ranking list headline', 'tcd-w');  ?></label><input id="dp_options[ranking_headline]" class="regular-text" type="text" name="dp_options[ranking_headline]" value="<?php esc_attr_e( $options['ranking_headline'] ); ?>" /></p>
     <ul class="index_post_list" id="ranking_post_list">
      <?php for($i = 1; $i <= 10; $i++): ?>
      <li class="cf">
       <label><?php _e('Ranking title', 'tcd-w');  ?><?php echo $i; ?></label><input id="dp_options[ranking_name<?php echo $i; ?>]" class="regular-text" type="text" name="dp_options[ranking_name<?php echo $i; ?>]" value="<?php esc_attr_e( $options['ranking_name'.$i] ); ?>" /><br />
       <label><?php _e('Ranking url', 'tcd-w');  ?><?php echo $i; ?></label><input id="dp_options[ranking_url<?php echo $i; ?>]" class="regular-text" type="text" name="dp_options[ranking_url<?php echo $i; ?>]" value="<?php esc_attr_e( $options['ranking_url'.$i] ); ?>" />
      </li>
      <?php endfor; ?>
     </ul>
    </div>
   </div>

   <?php // お知らせの設定 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('News setting', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
    <p>
     <label style="display:inline-block; margin:0 20px 0 0;"><?php _e('Number of News to show on News archive page', 'tcd-w');  ?></label>
     <input id="dp_options[news_archive_num]" class="font_size" type="text" name="dp_options[news_archive_num]" value="<?php esc_attr_e( $options['news_archive_num'] ); ?>" />
    </p>
    </div>
   </div>

   <?php // プレスリリースの設定 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Press Release setting', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
    <p>
     <label style="display:inline-block; margin:0 20px 0 0;"><?php _e('Number of Press Release to show on Press Release archive page', 'tcd-w');  ?></label>
     <input id="dp_options[press_archive_num]" class="font_size" type="text" name="dp_options[press_archive_num]" value="<?php esc_attr_e( $options['press_archive_num'] ); ?>" />
    </p>
    </div>
   </div>

   <?php // Use OGP tag ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Facebook OGP setting', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
     <p><label><input id="dp_options[use_ogp]" name="dp_options[use_ogp]" type="checkbox" value="1" <?php checked( '1', $options['use_ogp'] ); ?> /> <?php _e('Use OGP', 'tcd-w');  ?></label></p>
     <p><?php _e('Your fb:admins ID', 'tcd-w');  ?> <input id="dp_options[fb_admin_id]" class="regular-text" type="text" name="dp_options[fb_admin_id]" value="<?php esc_attr_e( $options['fb_admin_id'] ); ?>" /></p>
    </div>
   </div>

   <?php // Use twitter card ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Twitter Cards setting', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
     <p><label><input id="dp_options[use_twitter_card]" name="dp_options[use_twitter_card]" type="checkbox" value="1" <?php checked( '1', $options['use_twitter_card'] ); ?> /> <?php _e('Use Twitter Cards', 'tcd-w');  ?></label></p>
     <p><?php _e('Your Twitter account name (exclude @ mark)', 'tcd-w');  ?> <input id="dp_options[twitter_account_name]" class="regular-text" type="text" name="dp_options[twitter_account_name]" value="<?php esc_attr_e( $options['twitter_account_name'] ); ?>" /></p>
     <p><?php _e('Register Twitter Cards from <a href="https://dev.twitter.com/docs/cards/validation/validator" target="_blank">Twitter Developer page</a>.<br /><a href="https://dev.twitter.com/docs/cards" target="_blank">Information about Twitter Cards</a>.', 'tcd-w'); ?></p>
    </div>
   </div>

   <p class="submit"><input type="submit" class="button-primary" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" /></p>

  </div><!-- END #tab-content2 -->




  <!-- #tab-content3 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
  <div id="tab-content3">

   <?php // トップページのおすすめ記事 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Slider setting', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
     <p><?php _e('Select post type to use in Slider', 'tcd-w'); ?></a></p>
     <fieldset class="cf"><legend class="screen-reader-text"><span><?php _e('Select post type to use in Slider', 'tcd-w');  ?></span></legend>
     <ul class="cf">
     <?php
          if ( ! isset( $checked ) )
          $checked = '';
          foreach ( $index_featured_options as $option ) {
          $index_featured_setting = $options['index_featured'];
           if ( '' != $index_featured_setting ) {
            if ( $options['index_featured'] == $option['value'] ) {
             $checked = "checked=\"checked\"";
            } else {
             $checked = '';
            }
           }
     ?>
      <li><label class="description">
       <input type="radio" name="dp_options[index_featured]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> />
       <?php echo $option['label']; ?>
      </label></li>
     <?php
          }
     ?>
     </ul>
     </fieldset>
    </div>
   </div>

   <?php // 注目のカテゴリー記事1 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Featured category post1 setting', 'tcd-w');  ?></h3>
    <p><?php _e('Select category to use for featured category post1.<br />Leave this field blank if you don\'t want to use featured category post1.', 'tcd-w');  ?></p>
    <div class="theme_option_input">
     <select id="index_category1" name="dp_options[index_category1]">
      <?php
           foreach ( $index_category1_options as $option1 ) :
            $label = $option1['label'];
            $selected = '';
            if ( $options['index_category1'] == $option1['value']) {
             $selected = 'selected="selected"';
            } else {
             $selected = '';
            }
            echo '<option style="padding-right: 10px;" value="' . esc_attr( $option1['value'] ) . '" ' . $selected . '>' . $label . '</option>' ."\n";
           endforeach;
      ?>
    </select>
    </div>
   </div>

   <?php // 注目のカテゴリー記事2 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Featured category post2 setting', 'tcd-w');  ?></h3>
    <p><?php _e('Select category to use for featured category post2.<br />Leave this field blank if you don\'t want to use featured category post2.', 'tcd-w');  ?></p>
    <div class="theme_option_input">
     <select id="index_category2" name="dp_options[index_category2]">
      <?php
           foreach ( $index_category2_options as $option2 ) :
            $label = $option2['label'];
            $selected = '';
            if ( $options['index_category2'] == $option2['value']) {
             $selected = 'selected="selected"';
            } else {
             $selected = '';
            }
            echo '<option style="padding-right: 10px;" value="' . esc_attr( $option2['value'] ) . '" ' . $selected . '>' . $label . '</option>' ."\n";
           endforeach;
      ?>
    </select>
    </div>
   </div>

   <?php // 注目のカテゴリー記事3 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Featured category post3 setting', 'tcd-w');  ?></h3>
    <p><?php _e('Select category to use for featured category post3.<br />Leave this field blank if you don\'t want to use featured category post3.', 'tcd-w');  ?></p>
    <div class="theme_option_input">
     <select id="index_category3" name="dp_options[index_category3]">
      <?php
           foreach ( $index_category3_options as $option3 ) :
            $label = $option3['label'];
            $selected = '';
            if ( $options['index_category3'] == $option3['value']) {
             $selected = 'selected="selected"';
            } else {
             $selected = '';
            }
            echo '<option style="padding-right: 10px;" value="' . esc_attr( $option3['value'] ) . '" ' . $selected . '>' . $label . '</option>' ."\n";
           endforeach;
      ?>
    </select>
    </div>
   </div>

   <?php // バナーのタイプを選択 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Adsense banner type setting', 'tcd-w');  ?></h3>
    <p><?php _e('Select the type of Adsense banner.', 'tcd-w');  ?></p>
    <div class="theme_option_input">
     <fieldset class="cf"><legend class="screen-reader-text"><span><?php _e('Select the type of Adsense banner.', 'tcd-w');  ?></span></legend>
<script type="text/javascript">
jQuery(document).ready(function($){
  $('#top_banner_type_select_type1').click(function(){
     $('.top_banner_type_type1').show();
     $('.top_banner_type_type2').hide();
  });
  $('#top_banner_type_select_type2').click(function(){
     $('.top_banner_type_type2').show();
     $('.top_banner_type_type1').hide();
  });
});
</script>
     <ul class="cf" id="top_banner_type_select">
     <?php
          if ( ! isset( $checked ) )
          $checked = '';
          foreach ( $top_banner_type_options as $option ) {
          $top_banner_type_setting = $options['top_banner_type'];
           if ( '' != $top_banner_type_setting ) {
            if ( $options['top_banner_type'] == $option['value'] ) {
             $checked = "checked=\"checked\"";
            } else {
             $checked = '';
            }
           }
     ?>
      <li id="top_banner_type_select_<?php esc_attr_e( $option['value'] ); ?>"><label class="description">
       <input type="radio" name="dp_options[top_banner_type]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> />
       <?php echo $option['label']; ?>
      </label></li>
     <?php
          }
     ?>
     </ul>
     </fieldset>
    </div>
   </div>

  <?php // バナー（大）?>
  <?php for($i = 1; $i <= 2; $i++): ?>
  <div class="banner_wrapper top_banner_type_type1" style="margin:0px 15px 20px; <?php if($options['top_banner_type'] == 'type2') { echo 'display:none'; }; ?>">
   <h3 class="banner_headline"><?php _e('Top page Adsense banner setup', 'tcd-w');  ?><?php echo $i; ?></h3>
   <div class="theme_option_field cf">
    <div class="theme_option_input">
     <div class="sub_box">
      <h4><?php _e('Banner code', 'tcd-w');  ?></h4>
      <p><?php _e('If you are using google adsense, enter all code below.', 'tcd-w');  ?></p>
      <div class="theme_option_input">
       <textarea id="dp_options[top_large_ad_code<?php echo $i; ?>]" class="large-text" cols="50" rows="10" name="dp_options[top_large_ad_code<?php echo $i; ?>]"><?php echo esc_textarea( $options['top_large_ad_code'.$i] ); ?></textarea>
      </div>
     </div>
     <p><?php _e('If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w');  ?></p>
     <div class="sub_box cf" style="margin:0 0 10px 0;">
      <h4><?php _e('Register banner image (width:300px height:250px)', 'tcd-w');  ?></h4>
      <div class="image_box cf">
       <div class="upload_banner_button_area">
        <div class="hide"><input type="text" size="36" name="dp_options[top_large_ad_image<?php echo $i; ?>]" value="<?php esc_attr_e( $options['top_large_ad_image'.$i] ); ?>" /></div>
        <input type="file" name="top_large_ad_image_file_<?php echo $i?>" id="top_large_ad_image_file_<?php echo $i?>" />
        <input type="submit" class="button-primary" value="<?php echo __( 'Save Image', 'tcd-w' ); ?>" />
       </div>
       <?php if($options['top_large_ad_image'.$i]) { ?>
        <div class="uploaded_banner_image">
         <img src="<?php esc_attr_e( $options['top_large_ad_image'.$i] ); ?>" alt="" title="" />
        </div>
        <?php if(dp_is_uploaded_img($options['top_large_ad_image'.$i])): ?>
        <div class="delete_uploaded_banner_image">
         <a href="<?php echo wp_nonce_url(admin_url('themes.php?page=theme_options'), 'dp_delete_top_large_ad_'.$i) ?>" class="button" onclick="if(!confirm('<?php _e('Are you sure to delete this image?', 'tcd-w'); ?>')) return false;"><?php _e('Delete Image', 'tcd-w'); ?></a>
        </div>
       <?php endif; ?>
       <?php }; ?>
      </div>
     </div>
     <div class="sub_box">
      <h4><?php _e('Register affiliate code', 'tcd-w');  ?></h4>
      <div class="theme_option_input">
       <input id="dp_options[top_large_ad_url<?php echo $i; ?>]" class="regular-text" type="text" name="dp_options[top_large_ad_url<?php echo $i; ?>]" value="<?php esc_attr_e( $options['top_large_ad_url'.$i] ); ?>" />
      </div>
     </div>
    </div>
   </div>
  </div>
  <?php endfor; ?>

  <?php // バナー（小）?>
  <?php for($i = 1; $i <= 4; $i++): ?>
  <div class="banner_wrapper top_banner_type_type2" style="margin:0px 15px 20px; <?php if($options['top_banner_type'] == 'type1') { echo 'display:none'; }; ?>">
   <h3 class="banner_headline"><?php _e('Top page Adsense banner setup', 'tcd-w');  ?><?php echo $i; ?></h3>
   <div class="theme_option_field cf">
    <div class="theme_option_input">
     <div class="sub_box">
      <h4><?php _e('Banner code', 'tcd-w');  ?></h4>
      <p><?php _e('If you are using google adsense, enter all code below.', 'tcd-w');  ?></p>
      <div class="theme_option_input">
       <textarea id="dp_options[top_small_ad_code<?php echo $i; ?>]" class="large-text" cols="50" rows="10" name="dp_options[top_small_ad_code<?php echo $i; ?>]"><?php echo esc_textarea( $options['top_small_ad_code'.$i] ); ?></textarea>
      </div>
     </div>
     <p><?php _e('If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w');  ?></p>
     <div class="sub_box cf" style="margin:0 0 10px 0;">
      <h4><?php _e('Register banner image (width:300px height:60px)', 'tcd-w');  ?></h4>
      <div class="image_box cf">
       <div class="upload_banner_button_area">
        <div class="hide"><input type="text" size="36" name="dp_options[top_small_ad_image<?php echo $i; ?>]" value="<?php esc_attr_e( $options['top_small_ad_image'.$i] ); ?>" /></div>
        <input type="file" name="top_small_ad_image_file_<?php echo $i?>" id="top_small_ad_image_file_<?php echo $i?>" />
        <input type="submit" class="button-primary" value="<?php echo __( 'Save Image', 'tcd-w' ); ?>" />
       </div>
       <?php if($options['top_small_ad_image'.$i]) { ?>
        <div class="uploaded_banner_image">
         <img src="<?php esc_attr_e( $options['top_small_ad_image'.$i] ); ?>" alt="" title="" />
        </div>
        <?php if(dp_is_uploaded_img($options['top_small_ad_image'.$i])): ?>
        <div class="delete_uploaded_banner_image">
         <a href="<?php echo wp_nonce_url(admin_url('themes.php?page=theme_options'), 'dp_delete_top_small_ad_'.$i) ?>" class="button" onclick="if(!confirm('<?php _e('Are you sure to delete this image?', 'tcd-w'); ?>')) return false;"><?php _e('Delete Image', 'tcd-w'); ?></a>
        </div>
       <?php endif; ?>
       <?php }; ?>
      </div>
     </div>
     <div class="sub_box">
      <h4><?php _e('Register affiliate code', 'tcd-w');  ?></h4>
      <div class="theme_option_input">
       <input id="dp_options[top_small_ad_url<?php echo $i; ?>]" class="regular-text" type="text" name="dp_options[top_small_ad_url<?php echo $i; ?>]" value="<?php esc_attr_e( $options['top_small_ad_url'.$i] ); ?>" />
      </div>
     </div>
    </div>
   </div>
  </div>
  <?php endfor; ?>

   <p class="submit"><input type="submit" class="button-primary" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" /></p>

  </div><!-- END #tab-content3 -->




  <!-- #tab-content4 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
  <div id="tab-content4">

   <?php // ステップ１ ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Step 1 : Upload image to use for logo.', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
     <p><?php _e('Upload image to use for logo from your computer.<br />You can resize your logo image in step 2 and adjust position in step 3.', 'tcd-w');  ?></p>
     <div class="button_area">
      <label for="dp_image"><?php _e('Select image to use for logo from your computer.', 'tcd-w');  ?></label>
      <input type="file" name="dp_image" id="dp_image" value="" />
      <input type="submit" class="button" value="<?php _e('Upload', 'tcd-w');  ?>" />
     </div>
     <?php if(dp_logo_exists()): $info = dp_logo_info(); ?>
     <div class="uploaded_logo">
      <h4><?php _e('Uploaded image.', 'tcd-w');  ?></h4>
      <div class="uploaded_logo_image" id="original_logo_size">
       <?php dp_logo_img_tag(false, '', '', 9999); ?>
      </div>
      <p><?php printf(__('Original image size : width %1$dpx, height %2$dpx', 'tcd-w'), $info['width'], $info['height']); ?></p>
     </div>
     <?php else: ?>
     <div class="uploaded_logo">
      <h4><?php _e('The image has not been uploaded yet.<br />A normal text will be used for a site logo.', 'tcd-w');  ?></h4>
     </div>
     <?php endif; ?>
    </div>
   </div>

   <?php // ステップ２ ?>
   <?php if(dp_logo_exists()): ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Step 2 : Resize uploaded image.', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
    <?php if(dp_logo_exists()): ?>
     <p><?php _e('You can resize uploaded image.<br />If you don\'t need to resize, go to step 3.', 'tcd-w');  ?></p>
     <div class="uploaded_logo">
      <h4><?php _e('Please drag the range to cut off.', 'tcd-w');  ?></h4>
      <div class="uploaded_logo_image">
       <?php dp_logo_resize_base(9999); ?>
      </div>
      <div class="resize_amount">
       <label><?php _e('Ratio', 'tcd-w');  ?>: <input type="text" name="dp_resize_ratio" id="dp_resize_ratio" value="100" />%</label>
       <label><?php _e('Width', 'tcd-w');  ?>: <input type="text" name="dp_resized_width" id="dp_resized_width" />px</label>
       <label><?php _e('Height', 'tcd-w');  ?>: <input type="text" name="dp_resized_height" id="dp_resized_height" />px</label>
      </div>
      <div id="resize_button_area">
       <input type="submit" class="button-primary" value="<?php _e('Resize', 'tcd-w'); ?>" />
      </div>
     </div>
     <?php if($info = dp_logo_info(true)): ?>
     <div class="uploaded_logo">
      <h4><?php printf(__('Resized image : width %1$dpx, height %2$dpx', 'tcd-w'), $info['width'], $info['height']); ?></h4>
      <div class="uploaded_logo_image">
       <?php dp_logo_img_tag(true, '', '', 9999); ?>
      </div>
     </div>
     <?php endif; ?>
    <?php endif; ?>
    </div>
   </div>
   <?php endif; ?>

   <?php // ステップ３ ?>
   <?php if(dp_logo_exists()): ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Step 3 : Adjust position of logo.', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
    <?php if(dp_logo_exists()): ?>
     <p><?php _e('Drag the logo image and adjust the position.', 'tcd-w');  ?></p>
     <div id="tcd-w-logo-adjuster" class="ratio-<?php echo '760-760'; ?>">
      <?php if(dp_logo_resize_tag(760, 760, $options['logotop'], $options['logoleft'])): ?>
      <?php else: ?>
      <span><?php _e('Logo size is too big. Please resize your logo image.', 'tcd-w');  ?></span>
      <?php endif; ?>
     </div>
     <div class="hide">
      <label><?php _e('Top', 'tcd-w');  ?>: <input type="text" name="dp_options[logotop]" id="dp-options-logotop" value="<?php esc_attr_e( $options['logotop'] ); ?>" />px </label>
      <label><?php _e('Left', 'tcd-w');  ?>: <input type="text" name="dp_options[logoleft]" id="dp-options-logoleft" value="<?php esc_attr_e( $options['logoleft'] ); ?>" />px </label>
      <input type="button" class="button" id="dp-adjust-realvalue" value="adjust" />
     </div>
     <p><input type="submit" class="button" value="<?php _e('Save the position', 'tcd-w');  ?>" /></p>
    <?php endif; ?>
    </div>
   </div>
   <?php endif; ?>

   <?php // 画像の削除 ?>
   <?php if(dp_logo_exists()): ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Delete logo image.', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
     <p><?php _e('If you delete the logo image, normal text will be used for a site logo.', 'tcd-w');  ?></p>
     <p><a class="button" href="<?php echo wp_nonce_url(admin_url('themes.php?page=theme_options'), 'dp_delete_image_'.  get_current_user_id()); ?>" onclick="if(!confirm('<?php _e('Are you sure to delete logo image?', 'tcd-w'); ?>')) return false;"><?php _e('Delete Image', 'tcd-w');  ?></a></p>
    </div>
   </div>
   <?php endif; ?>

  </div><!-- END #tab-content4 -->




  <!-- #tab-content5 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
  <div id="tab-content5">

   <?php // ステップ１ ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Step 1 : Upload image to use for logo.', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
     <p><?php _e('Upload image to use for logo from your computer.<br />You can resize your logo image in step 2 and adjust position in step 3.', 'tcd-w');  ?></p>
     <div class="button_area">
      <label for="dp_image2"><?php _e('Select image to use for logo from your computer.', 'tcd-w');  ?></label>
      <input type="file" name="dp_image2" id="dp_image2" value="" />
      <input type="submit" class="button" value="<?php _e('Upload', 'tcd-w');  ?>" />
     </div>
     <?php if(dp_footer_logo_exists()): $info = dp_footer_logo_info(); ?>
     <div class="uploaded_logo">
      <h4><?php _e('Uploaded image.', 'tcd-w');  ?></h4>
      <div class="uploaded_logo_image" id="original_logo_size">
       <?php dp_footer_logo_img_tag(false, '', '', 9999); ?>
      </div>
      <p><?php printf(__('Original image size : width %1$dpx, height %2$dpx', 'tcd-w'), $info['width'], $info['height']); ?></p>
     </div>
     <?php else: ?>
     <div class="uploaded_logo">
      <h4><?php _e('The image has not been uploaded yet.<br />A normal text will be used for a site logo.', 'tcd-w');  ?></h4>
     </div>
     <?php endif; ?>
    </div>
   </div>

   <?php // ステップ２ ?>
   <?php if(dp_footer_logo_exists()): ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Step 2 : Resize uploaded image.', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
    <?php if(dp_footer_logo_exists()): ?>
     <p><?php _e('You can resize uploaded image.<br />If you don\'t need to resize, go to step 3.', 'tcd-w');  ?></p>
     <div class="uploaded_logo">
      <h4><?php _e('Please drag the range to cut off.', 'tcd-w');  ?></h4>
      <div class="uploaded_logo_image">
       <?php dp_footer_logo_resize_base(9999); ?>
      </div>
      <div class="resize_amount">
       <label><?php _e('Ratio', 'tcd-w');  ?>: <input type="text" name="dp_resize_ratio2" id="dp_resize_ratio2" value="100" />%</label>
       <label><?php _e('Width', 'tcd-w');  ?>: <input type="text" name="dp_resized_width2" id="dp_resized_width2" />px</label>
       <label><?php _e('Height', 'tcd-w');  ?>: <input type="text" name="dp_resized_height2" id="dp_resized_height2" />px</label>
      </div>
      <div id="resize_button_area">
       <input type="submit" class="button-primary" value="<?php _e('Resize', 'tcd-w'); ?>" />
      </div>
     </div>
     <?php if($info = dp_footer_logo_info(true)): ?>
     <div class="uploaded_logo">
      <h4><?php printf(__('Resized image : width %1$dpx, height %2$dpx', 'tcd-w'), $info['width'], $info['height']); ?></h4>
      <div class="uploaded_logo_image">
       <?php dp_footer_logo_img_tag(true, '', '', 9999); ?>
      </div>
     </div>
     <?php endif; ?>
    <?php endif; ?>
    </div>
   </div>
   <?php endif; ?>

   <?php // ステップ３ ?>
   <?php if(dp_footer_logo_exists()): ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Step 3 : Adjust position of logo.', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
    <?php if(dp_footer_logo_exists()): ?>
     <p><?php _e('Drag the logo image and adjust the position.', 'tcd-w');  ?></p>
     <div id="tcd-w-logo-adjuster2" class="ratio-<?php echo '760-760'; ?>">
      <?php if(dp_footer_logo_resize_tag(760, 760, $options['logotop2'], $options['logoleft2'])): ?>
      <?php else: ?>
      <span><?php _e('Logo size is too big. Please resize your logo image.', 'tcd-w');  ?></span>
      <?php endif; ?>
     </div>
     <div class="hide">
      <label><?php _e('Top', 'tcd-w');  ?>: <input type="text" name="dp_options[logotop2]" id="dp-options-logotop2" value="<?php esc_attr_e( $options['logotop2'] ); ?>" />px </label>
      <label><?php _e('Left', 'tcd-w');  ?>: <input type="text" name="dp_options[logoleft2]" id="dp-options-logoleft2" value="<?php esc_attr_e( $options['logoleft2'] ); ?>" />px </label>
      <input type="button" class="button" id="dp-adjust-realvalue2" value="adjust" />
     </div>
     <p><input type="submit" class="button" value="<?php _e('Save the position', 'tcd-w');  ?>" /></p>
    <?php endif; ?>
    </div>
   </div>
   <?php endif; ?>

   <?php // 画像の削除 ?>
   <?php if(dp_footer_logo_exists()): ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Delete logo image.', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
     <p><?php _e('If you delete the logo image, normal text will be used for a site logo.', 'tcd-w');  ?></p>
     <p><a class="button" href="<?php echo wp_nonce_url(admin_url('themes.php?page=theme_options'), 'dp_delete_footer_image_'.  get_current_user_id()); ?>" onclick="if(!confirm('<?php _e('Are you sure to delete logo image?', 'tcd-w'); ?>')) return false;"><?php _e('Delete Image', 'tcd-w');  ?></a></p>
    </div>
   </div>
   <?php endif; ?>

  </div><!-- END #tab-content5 -->




  <!-- #tab-content6 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
  <div id="tab-content6">


  <?php // ヘッダー広告の登録 -------------------------------------------------------------------------------------------- ?>
  <div class="banner_wrapper">
   <h3 class="banner_headline"><?php _e('Header banner setup.', 'tcd-w');  ?></h3>
   <div class="theme_option_field cf">
    <div class="theme_option_input">

     <div class="sub_box">
      <h4><?php _e('Banner code', 'tcd-w');  ?></h4>
      <p><?php _e('If you are using google adsense, enter all code below.', 'tcd-w');  ?></p>
      <div class="theme_option_input">
       <textarea id="dp_options[header_ad_code1]" class="large-text" cols="50" rows="10" name="dp_options[header_ad_code1]"><?php echo esc_textarea( $options['header_ad_code1'] ); ?></textarea>
      </div>
     </div>
     <p><?php _e('If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w');  ?></p>

     <div class="sub_box cf" style="margin:0 0 10px 0;">
      <h4><?php _e('Register banner image.(Recommend size. Width:468px Height:60px;)', 'tcd-w');  ?></h4>
      <div class="image_box cf">
       <div class="upload_banner_button_area">
        <div class="hide"><input type="text" size="36" name="dp_options[header_ad_image1]" value="<?php esc_attr_e( $options['header_ad_image1'] ); ?>" /></div>
        <input type="file" name="header_ad_image_file1" id="header_ad_image_file1" />
        <input type="submit" class="button-primary" value="<?php echo __( 'Save Image', 'tcd-w' ); ?>" />
       </div>
       <?php if($options['header_ad_image1']) { ?>
        <div class="uploaded_banner_image">
         <img src="<?php esc_attr_e( $options['header_ad_image1'] ); ?>" alt="" title="" />
        </div>
        <?php if(dp_is_uploaded_img($options['header_ad_image1'])): ?>
        <div class="delete_uploaded_banner_image">
         <a href="<?php echo wp_nonce_url(admin_url('themes.php?page=theme_options'), 'dp_delete_header_ad_image1') ?>" class="button" onclick="if(!confirm('<?php _e('Are you sure to delete this image?', 'tcd-w'); ?>')) return false;"><?php _e('Delete Image', 'tcd-w'); ?></a>
        </div>
       <?php endif; ?>
       <?php }; ?>
      </div>
     </div>

     <div class="sub_box">
      <h4><?php _e('Register affiliate code', 'tcd-w');  ?></h4>
      <div class="theme_option_input">
       <input id="dp_options[header_ad_url1]" class="regular-text" type="text" name="dp_options[header_ad_url1]" value="<?php esc_attr_e( $options['header_ad_url1'] ); ?>" />
      </div>
     </div>

    </div>
   </div>
  </div>

  <p class="submit"><input type="submit" class="button-primary" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" /></p>

  </div><!-- END #tab-content6 -->




  <!-- #tab-content7 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
  <div id="tab-content7">


  <?php // 詳細ページの広告１ -------------------------------------------------------------------------------------------- ?>
  <div class="banner_wrapper">
   <h3 class="banner_headline"><?php _e('Single post page banner setup1.(Show on top of the post.)', 'tcd-w');  ?></h3>
   <div class="theme_option_field cf">
    <div class="theme_option_input">

     <div class="sub_box">
      <h4><?php _e('Banner code', 'tcd-w');  ?></h4>
      <p><?php _e('If you are using google adsense, enter all code below.', 'tcd-w');  ?></p>
      <div class="theme_option_input">
       <textarea id="dp_options[single_ad_code1]" class="large-text" cols="50" rows="10" name="dp_options[single_ad_code1]"><?php echo esc_textarea( $options['single_ad_code1'] ); ?></textarea>
      </div>
     </div>
     <p><?php _e('If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w');  ?></p>

     <div class="sub_box cf" style="margin:0 0 10px 0;">
      <h4><?php _e('Register banner image.', 'tcd-w');  ?></h4>
      <div class="image_box cf">
       <div class="upload_banner_button_area">
        <div class="hide"><input type="text" size="36" name="dp_options[single_ad_image1]" value="<?php esc_attr_e( $options['single_ad_image1'] ); ?>" /></div>
        <input type="file" name="single_ad_image_file1" id="single_ad_image_file1" />
        <input type="submit" class="button-primary" value="<?php echo __( 'Save Image', 'tcd-w' ); ?>" />
       </div>
       <?php if($options['single_ad_image1']) { ?>
        <div class="uploaded_banner_image">
         <img src="<?php esc_attr_e( $options['single_ad_image1'] ); ?>" alt="" title="" />
        </div>
        <?php if(dp_is_uploaded_img($options['single_ad_image1'])): ?>
        <div class="delete_uploaded_banner_image">
         <a href="<?php echo wp_nonce_url(admin_url('themes.php?page=theme_options'), 'dp_delete_single_ad_image1') ?>" class="button" onclick="if(!confirm('<?php _e('Are you sure to delete this image?', 'tcd-w'); ?>')) return false;"><?php _e('Delete Image', 'tcd-w'); ?></a>
        </div>
       <?php endif; ?>
       <?php }; ?>
      </div>
     </div>

     <div class="sub_box">
      <h4><?php _e('Register affiliate code', 'tcd-w');  ?></h4>
      <div class="theme_option_input">
       <input id="dp_options[single_ad_url1]" class="regular-text" type="text" name="dp_options[single_ad_url1]" value="<?php esc_attr_e( $options['single_ad_url1'] ); ?>" />
      </div>
     </div>

    </div>
   </div>
  </div>


  <?php // 詳細ページの広告2 -------------------------------------------------------------------------------------------- ?>
  <div class="banner_wrapper">
   <h3 class="banner_headline"><?php _e('Single post page banner setup2.(Show on bottom of the post.)', 'tcd-w');  ?></h3>
   <div class="theme_option_field cf">
    <div class="theme_option_input">

     <div class="sub_box">
      <h4><?php _e('Banner code', 'tcd-w');  ?></h4>
      <p><?php _e('If you are using google adsense, enter all code below.', 'tcd-w');  ?></p>
      <div class="theme_option_input">
       <textarea id="dp_options[single_ad_code2]" class="large-text" cols="50" rows="10" name="dp_options[single_ad_code2]"><?php echo esc_textarea( $options['single_ad_code2'] ); ?></textarea>
      </div>
     </div>
     <p><?php _e('If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w');  ?></p>

     <div class="sub_box cf" style="margin:0 0 10px 0;">
      <h4><?php _e('Register banner image.', 'tcd-w');  ?></h4>
      <div class="image_box cf">
       <div class="upload_banner_button_area">
        <div class="hide"><input type="text" size="36" name="dp_options[single_ad_image2]" value="<?php esc_attr_e( $options['single_ad_image2'] ); ?>" /></div>
        <input type="file" name="single_ad_image_file2" id="single_ad_image_file2" />
        <input type="submit" class="button-primary" value="<?php echo __( 'Save Image', 'tcd-w' ); ?>" />
       </div>
       <?php if($options['single_ad_image2']) { ?>
        <div class="uploaded_banner_image">
         <img src="<?php esc_attr_e( $options['single_ad_image2'] ); ?>" alt="" title="" />
        </div>
        <?php if(dp_is_uploaded_img($options['single_ad_image2'])): ?>
        <div class="delete_uploaded_banner_image">
         <a href="<?php echo wp_nonce_url(admin_url('themes.php?page=theme_options'), 'dp_delete_single_ad_image2') ?>" class="button" onclick="if(!confirm('<?php _e('Are you sure to delete this image?', 'tcd-w'); ?>')) return false;"><?php _e('Delete Image', 'tcd-w'); ?></a>
        </div>
       <?php endif; ?>
       <?php }; ?>
      </div>
     </div>

     <div class="sub_box">
      <h4><?php _e('Register affiliate code', 'tcd-w');  ?></h4>
      <div class="theme_option_input">
       <input id="dp_options[single_ad_url2]" class="regular-text" type="text" name="dp_options[single_ad_url2]" value="<?php esc_attr_e( $options['single_ad_url2'] ); ?>" />
      </div>
     </div>

    </div>
   </div>
  </div>

  <p class="submit"><input type="submit" class="button-primary" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" /></p>

  </div><!-- END #tab-content7 -->



  <!-- #tab-content8 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
  <div id="tab-content8">

  <p class="tab_desc"><?php _e('This Adsense is displayed only on the user who accessed the site with the smartphone.', 'tcd-w');  ?></p>

  <?php // モバイル広告の登録（ページ上部） -------------------------------------------------------------------------------------------- ?>
  <div class="banner_wrapper">
   <h3 class="banner_headline"><?php _e('Smartphone banner setup1. (Display on the top of a page)', 'tcd-w');  ?></h3>
   <div class="theme_option_field cf">
    <div class="theme_option_input">

     <div class="sub_box">
      <h4><?php _e('Banner code', 'tcd-w');  ?></h4>
      <p><?php _e('If you are using google adsense, enter all code below.', 'tcd-w');  ?></p>
      <div class="theme_option_input">
       <textarea id="dp_options[mobile_ad_code1]" class="large-text" cols="50" rows="10" name="dp_options[mobile_ad_code1]"><?php echo esc_textarea( $options['mobile_ad_code1'] ); ?></textarea>
      </div>
     </div>
     <p><?php _e('If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w');  ?></p>

     <div class="sub_box cf" style="margin:0 0 10px 0;">
      <h4><?php _e('Register banner image.', 'tcd-w');  ?></h4>
      <div class="image_box cf">
       <div class="upload_banner_button_area">
        <div class="hide"><input type="text" size="36" name="dp_options[mobile_ad_image1]" value="<?php esc_attr_e( $options['mobile_ad_image1'] ); ?>" /></div>
        <input type="file" name="mobile_ad_image_file1" id="mobile_ad_image_file1" />
        <input type="submit" class="button-primary" value="<?php echo __( 'Save Image', 'tcd-w' ); ?>" />
       </div>
       <?php if($options['mobile_ad_image1']) { ?>
        <div class="uploaded_banner_image">
         <img src="<?php esc_attr_e( $options['mobile_ad_image1'] ); ?>" alt="" title="" />
        </div>
        <?php if(dp_is_uploaded_img($options['mobile_ad_image1'])): ?>
        <div class="delete_uploaded_banner_image">
         <a href="<?php echo wp_nonce_url(admin_url('themes.php?page=theme_options'), 'dp_delete_mobile_ad_image1') ?>" class="button" onclick="if(!confirm('<?php _e('Are you sure to delete this image?', 'tcd-w'); ?>')) return false;"><?php _e('Delete Image', 'tcd-w'); ?></a>
        </div>
       <?php endif; ?>
       <?php }; ?>
      </div>
     </div>

     <div class="sub_box">
      <h4><?php _e('Register affiliate code', 'tcd-w');  ?></h4>
      <div class="theme_option_input">
       <input id="dp_options[mobile_ad_url1]" class="regular-text" type="text" name="dp_options[mobile_ad_url1]" value="<?php esc_attr_e( $options['mobile_ad_url1'] ); ?>" />
      </div>
     </div>

    </div>
   </div>
  </div>


  <?php // モバイル広告の登録（ページ下部） -------------------------------------------------------------------------------------------- ?>
  <div class="banner_wrapper">
   <h3 class="banner_headline"><?php _e('Smartphone banner setup2. (Display on the bottom of a page)', 'tcd-w');  ?></h3>
   <div class="theme_option_field cf">
    <div class="theme_option_input">

     <div class="sub_box">
      <h4><?php _e('Banner code', 'tcd-w');  ?></h4>
      <p><?php _e('If you are using google adsense, enter all code below.', 'tcd-w');  ?></p>
      <div class="theme_option_input">
       <textarea id="dp_options[mobile_ad_code2]" class="large-text" cols="50" rows="10" name="dp_options[mobile_ad_code2]"><?php echo esc_textarea( $options['mobile_ad_code2'] ); ?></textarea>
      </div>
     </div>
     <p><?php _e('If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w');  ?></p>

     <div class="sub_box cf" style="margin:0 0 10px 0;">
      <h4><?php _e('Register banner image.', 'tcd-w');  ?></h4>
      <div class="image_box cf">
       <div class="upload_banner_button_area">
        <div class="hide"><input type="text" size="36" name="dp_options[mobile_ad_image2]" value="<?php esc_attr_e( $options['mobile_ad_image2'] ); ?>" /></div>
        <input type="file" name="mobile_ad_image_file2" id="mobile_ad_image_file2" />
        <input type="submit" class="button-primary" value="<?php echo __( 'Save Image', 'tcd-w' ); ?>" />
       </div>
       <?php if($options['mobile_ad_image2']) { ?>
        <div class="uploaded_banner_image">
         <img src="<?php esc_attr_e( $options['mobile_ad_image2'] ); ?>" alt="" title="" />
        </div>
        <?php if(dp_is_uploaded_img($options['mobile_ad_image2'])): ?>
        <div class="delete_uploaded_banner_image">
         <a href="<?php echo wp_nonce_url(admin_url('themes.php?page=theme_options'), 'dp_delete_mobile_ad_image2') ?>" class="button" onclick="if(!confirm('<?php _e('Are you sure to delete this image?', 'tcd-w'); ?>')) return false;"><?php _e('Delete Image', 'tcd-w'); ?></a>
        </div>
       <?php endif; ?>
       <?php }; ?>
      </div>
     </div>

     <div class="sub_box">
      <h4><?php _e('Register affiliate code', 'tcd-w');  ?></h4>
      <div class="theme_option_input">
       <input id="dp_options[mobile_ad_url2]" class="regular-text" type="text" name="dp_options[mobile_ad_url2]" value="<?php esc_attr_e( $options['mobile_ad_url2'] ); ?>" />
      </div>
     </div>

    </div>
   </div>
  </div>

  <p class="submit"><input type="submit" class="button-primary" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" /></p>

  </div><!-- END #tab-content8 -->



  </div><!-- END #tab-panel -->

 </form>

</div>

</div>

<?php

 }


/**
 * チェック
 */
function theme_options_validate( $input ) {
 global $index_featured_options, $index_category1_options, $index_category2_options, $index_category3_options, $top_banner_type_options;

 // 色の設定
 $input['pickedcolor1'] = wp_filter_nohtml_kses( $input['pickedcolor1'] );
 $input['pickedcolor2'] = wp_filter_nohtml_kses( $input['pickedcolor2'] );

 // フォントサイズ
 $input['content_font_size'] = wp_filter_nohtml_kses( $input['content_font_size'] );

 // 投稿者・タグ・コメント
 if ( ! isset( $input['show_date'] ) )
  $input['show_date'] = null;
  $input['show_date'] = ( $input['show_date'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_category'] ) )
  $input['show_category'] = null;
  $input['show_category'] = ( $input['show_category'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_tag'] ) )
  $input['show_tag'] = null;
  $input['show_tag'] = ( $input['show_tag'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_comment'] ) )
  $input['show_comment'] = null;
  $input['show_comment'] = ( $input['show_comment'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_trackback'] ) )
  $input['show_trackback'] = null;
  $input['show_trackback'] = ( $input['show_trackback'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_related_post'] ) )
  $input['show_related_post'] = null;
  $input['show_related_post'] = ( $input['show_related_post'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_next_post'] ) )
  $input['show_next_post'] = null;
  $input['show_next_post'] = ( $input['show_next_post'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_thumbnail'] ) )
  $input['show_thumbnail'] = null;
  $input['show_thumbnail'] = ( $input['show_thumbnail'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_rss'] ) )
  $input['show_rss'] = null;
  $input['show_rss'] = ( $input['show_rss'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_bookmark'] ) )
  $input['show_bookmark'] = null;
  $input['show_bookmark'] = ( $input['show_bookmark'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_author'] ) )
  $input['show_author'] = null;
  $input['show_author'] = ( $input['show_author'] == 1 ? 1 : 0 );

 // twitter,facebook URL
 $input['twitter_url'] = wp_filter_nohtml_kses( $input['twitter_url'] );
 $input['facebook_url'] = wp_filter_nohtml_kses( $input['facebook_url'] );

 // 検索の設定
 $input['custom_search_id'] = wp_filter_nohtml_kses( $input['custom_search_id'] );

 // PR記事
 if ( ! isset( $input['show_pr'] ) )
  $input['show_pr'] = null;
  $input['show_pr'] = ( $input['show_pr'] == 1 ? 1 : 0 );
 $input['index_pr_num'] = wp_filter_nohtml_kses( $input['index_pr_num'] );
 $input['pr_headline'] = wp_filter_nohtml_kses( $input['pr_headline'] );
 $input['pr_url1'] = wp_filter_nohtml_kses( $input['pr_url1'] );
 $input['pr_url2'] = wp_filter_nohtml_kses( $input['pr_url2'] );
 $input['pr_url3'] = wp_filter_nohtml_kses( $input['pr_url3'] );
 $input['pr_url4'] = wp_filter_nohtml_kses( $input['pr_url4'] );
 $input['pr_url5'] = wp_filter_nohtml_kses( $input['pr_url5'] );
 $input['pr_name1'] = wp_filter_nohtml_kses( $input['pr_name1'] );
 $input['pr_name2'] = wp_filter_nohtml_kses( $input['pr_name2'] );
 $input['pr_name3'] = wp_filter_nohtml_kses( $input['pr_name3'] );
 $input['pr_name4'] = wp_filter_nohtml_kses( $input['pr_name4'] );
 $input['pr_name5'] = wp_filter_nohtml_kses( $input['pr_name5'] );

 // ランキング記事
 if ( ! isset( $input['show_ranking'] ) )
  $input['show_ranking'] = null;
  $input['show_ranking'] = ( $input['show_ranking'] == 1 ? 1 : 0 );
 $input['index_ranking_num'] = wp_filter_nohtml_kses( $input['index_ranking_num'] );
 $input['ranking_headline'] = wp_filter_nohtml_kses( $input['ranking_headline'] );
 $input['ranking_url1'] = wp_filter_nohtml_kses( $input['ranking_url1'] );
 $input['ranking_url2'] = wp_filter_nohtml_kses( $input['ranking_url2'] );
 $input['ranking_url3'] = wp_filter_nohtml_kses( $input['ranking_url3'] );
 $input['ranking_url4'] = wp_filter_nohtml_kses( $input['ranking_url4'] );
 $input['ranking_url5'] = wp_filter_nohtml_kses( $input['ranking_url5'] );
 $input['ranking_url6'] = wp_filter_nohtml_kses( $input['ranking_url6'] );
 $input['ranking_url7'] = wp_filter_nohtml_kses( $input['ranking_url7'] );
 $input['ranking_url8'] = wp_filter_nohtml_kses( $input['ranking_url8'] );
 $input['ranking_url9'] = wp_filter_nohtml_kses( $input['ranking_url9'] );
 $input['ranking_url10'] = wp_filter_nohtml_kses( $input['ranking_url10'] );
 $input['ranking_name1'] = wp_filter_nohtml_kses( $input['ranking_name1'] );
 $input['ranking_name2'] = wp_filter_nohtml_kses( $input['ranking_name2'] );
 $input['ranking_name3'] = wp_filter_nohtml_kses( $input['ranking_name3'] );
 $input['ranking_name4'] = wp_filter_nohtml_kses( $input['ranking_name4'] );
 $input['ranking_name5'] = wp_filter_nohtml_kses( $input['ranking_name5'] );
 $input['ranking_name6'] = wp_filter_nohtml_kses( $input['ranking_name6'] );
 $input['ranking_name7'] = wp_filter_nohtml_kses( $input['ranking_name7'] );
 $input['ranking_name8'] = wp_filter_nohtml_kses( $input['ranking_name8'] );
 $input['ranking_name9'] = wp_filter_nohtml_kses( $input['ranking_name9'] );
 $input['ranking_name10'] = wp_filter_nohtml_kses( $input['ranking_name10'] );

 // お知らせの設定
 $input['news_archive_num'] = wp_filter_nohtml_kses( $input['news_archive_num'] );
 $input['press_archive_num'] = wp_filter_nohtml_kses( $input['press_archive_num'] );

 // トップページの注目記事の設定
 if ( ! isset( $input['index_featured'] ) )
  $input['index_featured'] = null;
 if ( ! array_key_exists( $input['index_featured'], $index_featured_options ) )
  $input['index_featured'] = null;

 // トップページのおすすめカテゴリー記事1の設定
 if ( ! isset( $input['index_category1'] ) )
  $input['index_category1'] = null;
 if ( ! array_key_exists( $input['index_category1'], $index_category1_options ) )
  $input['index_category1'] = null;

 // トップページのおすすめカテゴリー記事2の設定
 if ( ! isset( $input['index_category2'] ) )
  $input['index_category2'] = null;
 if ( ! array_key_exists( $input['index_category2'], $index_category2_options ) )
  $input['index_category2'] = null;

 // トップページのおすすめカテゴリー記事3の設定
 if ( ! isset( $input['index_category3'] ) )
  $input['index_category3'] = null;
 if ( ! array_key_exists( $input['index_category3'], $index_category3_options ) )
  $input['index_category3'] = null;

 // トップページのバナータイプの設定
 if ( ! isset( $input['top_banner_type'] ) )
  $input['top_banner_type'] = null;
 if ( ! array_key_exists( $input['top_banner_type'], $top_banner_type_options ) )
  $input['top_banner_type'] = null;

 // ヘッダーの広告バナー
 $input['header_ad_code1'] = $input['header_ad_code1'];
 $input['header_ad_image1'] = wp_filter_nohtml_kses( $input['header_ad_image1'] );
 $input['header_ad_url1'] = wp_filter_nohtml_kses( $input['header_ad_url1'] );

 // 詳細記事上部の広告バナー
 $input['single_ad_code1'] = $input['single_ad_code1'];
 $input['single_ad_image1'] = wp_filter_nohtml_kses( $input['single_ad_image1'] );
 $input['single_ad_url1'] = wp_filter_nohtml_kses( $input['single_ad_url1'] );

 // 詳細記事下部の広告バナー
 $input['single_ad_code2'] = $input['single_ad_code2'];
 $input['single_ad_image2'] = wp_filter_nohtml_kses( $input['single_ad_image2'] );
 $input['single_ad_url2'] = wp_filter_nohtml_kses( $input['single_ad_url2'] );

 // モバイル用の広告バナー（上部）
 $input['mobile_ad_code1'] = $input['mobile_ad_code1'];
 $input['mobile_ad_image1'] = wp_filter_nohtml_kses( $input['mobile_ad_image1'] );
 $input['mobile_ad_url1'] = wp_filter_nohtml_kses( $input['mobile_ad_url1'] );

 // モバイル用の広告バナー（下部）
 $input['mobile_ad_code2'] = $input['mobile_ad_code2'];
 $input['mobile_ad_image2'] = wp_filter_nohtml_kses( $input['mobile_ad_image2'] );
 $input['mobile_ad_url2'] = wp_filter_nohtml_kses( $input['mobile_ad_url2'] );

 //OGPタグ関連
 if ( ! isset( $input['use_ogp'] ) )
  $input['use_ogp'] = null;
  $input['use_ogp'] = ( $input['use_ogp'] == 1 ? 1 : 0 );
 $input['fb_admin_id'] = wp_filter_nohtml_kses( $input['fb_admin_id'] );
 if ( ! isset( $input['use_twitter_card'] ) )
  $input['use_twitter_card'] = null;
  $input['use_twitter_card'] = ( $input['use_twitter_card'] == 1 ? 1 : 0 );
 $input['twitter_account_name'] = wp_filter_nohtml_kses( $input['twitter_account_name'] );

 //ロゴの位置
 if(isset($input['logotop'])){
	 $input['logotop'] = intval($input['logotop']);
 }
 if(isset($input['logoleft'])){
	 $input['logoleft'] = intval($input['logoleft']);
 }

 //ロゴの位置2
 if(isset($input['logotop2'])){
	 $input['logotop2'] = intval($input['logotop2']);
 }
 if(isset($input['logoleft2'])){
	 $input['logoleft2'] = intval($input['logoleft2']);
 }

 //ファイルアップロード
 if(isset($_FILES['dp_image'])){
	$message = _dp_upload_logo();
	add_settings_error('design_plus_options', 'default', $message['message'], ($message['error'] ? 'error' : 'updated'));
 }

 //ファイルアップロード2
 if(isset($_FILES['dp_image2'])){
	$message = _dp_upload_footer_logo();
	add_settings_error('design_plus_options', 'default', $message['message'], ($message['error'] ? 'error' : 'updated'));
 }

 //画像リサイズ
 if(isset($_REQUEST['dp_logo_resize_left'], $_REQUEST['dp_logo_resize_top']) && is_numeric($_REQUEST['dp_logo_resize_left']) && is_numeric($_REQUEST['dp_logo_resize_top'])){
	$message = _dp_resize_logo();
	add_settings_error('design_plus_options', 'default', $message['message'], ($message['error'] ? 'error' : 'updated'));
 }

 //画像リサイズ2
 if(isset($_REQUEST['dp_logo_resize_left2'], $_REQUEST['dp_logo_resize_top2']) && is_numeric($_REQUEST['dp_logo_resize_left2']) && is_numeric($_REQUEST['dp_logo_resize_top2'])){
	$message = _dp_resize_footer_logo();
	add_settings_error('design_plus_options', 'default', $message['message'], ($message['error'] ? 'error' : 'updated'));
 }

 //ヘッダーの広告バナー
	 if(isset($_FILES['header_ad_image_file1'])){
		 //画像のアップロードに問題はないか
		 if($_FILES['header_ad_image_file1']['error'] === 0){
			 $name = sanitize_file_name($_FILES['header_ad_image_file1']['name']);
			 //ファイル形式をチェック
			 if(!preg_match("/\.(png|jpe?g|gif)$/i", $name)){
				 add_settings_error('design_plus_options', 'dp_uploader', sprintf(__('You uploaded %s but allowed file format is PNG, GIF and JPG.', 'tcd-w'), $name), 'error');
			 }else{
				//ディレクトリの存在をチェック
				if(
					(
						(file_exists(dp_logo_basedir()) && is_dir(dp_logo_basedir()) && is_writable(dp_logo_basedir()) )
							||
						@mkdir(dp_logo_basedir())
					)
						&&
					move_uploaded_file($_FILES['header_ad_image_file1']['tmp_name'], dp_logo_basedir().DIRECTORY_SEPARATOR.$name)
				){
					$input['header_ad_image1'] = dp_logo_baseurl().'/'.$name;
				}else{
					add_settings_error('default', 'dp_uploader', sprintf(__('Directory %s is not writable. Please check permission.', 'tcd-w'), dp_logo_basedir()), 'error');
					//break;
				}
			 }
		 }elseif($_FILES['header_ad_image_file1']['error'] !== UPLOAD_ERR_NO_FILE){
			 add_settings_error('default', 'dp_uploader', _dp_get_upload_err_msg($_FILES['header_ad_image_file1']['error']), 'error');
			 //continue;
		 }
	 }

 //詳細記事ページ上部の広告バナー
	 if(isset($_FILES['single_ad_image_file1'])){
		 //画像のアップロードに問題はないか
		 if($_FILES['single_ad_image_file1']['error'] === 0){
			 $name = sanitize_file_name($_FILES['single_ad_image_file1']['name']);
			 //ファイル形式をチェック
			 if(!preg_match("/\.(png|jpe?g|gif)$/i", $name)){
				 add_settings_error('design_plus_options', 'dp_uploader', sprintf(__('You uploaded %s but allowed file format is PNG, GIF and JPG.', 'tcd-w'), $name), 'error');
			 }else{
				//ディレクトリの存在をチェック
				if(
					(
						(file_exists(dp_logo_basedir()) && is_dir(dp_logo_basedir()) && is_writable(dp_logo_basedir()) )
							||
						@mkdir(dp_logo_basedir())
					)
						&&
					move_uploaded_file($_FILES['single_ad_image_file1']['tmp_name'], dp_logo_basedir().DIRECTORY_SEPARATOR.$name)
				){
					$input['single_ad_image1'] = dp_logo_baseurl().'/'.$name;
				}else{
					add_settings_error('default', 'dp_uploader', sprintf(__('Directory %s is not writable. Please check permission.', 'tcd-w'), dp_logo_basedir()), 'error');
					//break;
				}
			 }
		 }elseif($_FILES['single_ad_image_file1']['error'] !== UPLOAD_ERR_NO_FILE){
			 add_settings_error('default', 'dp_uploader', _dp_get_upload_err_msg($_FILES['single_ad_image_file1']['error']), 'error');
			 //continue;
		 }
	 }


 //詳細記事ページ下部の広告バナー
	 if(isset($_FILES['single_ad_image_file2'])){
		 //画像のアップロードに問題はないか
		 if($_FILES['single_ad_image_file2']['error'] === 0){
			 $name = sanitize_file_name($_FILES['single_ad_image_file2']['name']);
			 //ファイル形式をチェック
			 if(!preg_match("/\.(png|jpe?g|gif)$/i", $name)){
				 add_settings_error('design_plus_options', 'dp_uploader', sprintf(__('You uploaded %s but allowed file format is PNG, GIF and JPG.', 'tcd-w'), $name), 'error');
			 }else{
				//ディレクトリの存在をチェック
				if(
					(
						(file_exists(dp_logo_basedir()) && is_dir(dp_logo_basedir()) && is_writable(dp_logo_basedir()) )
							||
						@mkdir(dp_logo_basedir())
					)
						&&
					move_uploaded_file($_FILES['single_ad_image_file2']['tmp_name'], dp_logo_basedir().DIRECTORY_SEPARATOR.$name)
				){
					$input['single_ad_image2'] = dp_logo_baseurl().'/'.$name;
				}else{
					add_settings_error('default', 'dp_uploader', sprintf(__('Directory %s is not writable. Please check permission.', 'tcd-w'), dp_logo_basedir()), 'error');
					//break;
				}
			 }
		 }elseif($_FILES['single_ad_image_file2']['error'] !== UPLOAD_ERR_NO_FILE){
			 add_settings_error('default', 'dp_uploader', _dp_get_upload_err_msg($_FILES['single_ad_image_file2']['error']), 'error');
			 //continue;
		 }
	 }


 //スマホ用の広告バナー
	 if(isset($_FILES['mobile_ad_image_file1'])){
		 //画像のアップロードに問題はないか
		 if($_FILES['mobile_ad_image_file1']['error'] === 0){
			 $name = sanitize_file_name($_FILES['mobile_ad_image_file1']['name']);
			 //ファイル形式をチェック
			 if(!preg_match("/\.(png|jpe?g|gif)$/i", $name)){
				 add_settings_error('design_plus_options', 'dp_uploader', sprintf(__('You uploaded %s but allowed file format is PNG, GIF and JPG.', 'tcd-w'), $name), 'error');
			 }else{
				//ディレクトリの存在をチェック
				if(
					(
						(file_exists(dp_logo_basedir()) && is_dir(dp_logo_basedir()) && is_writable(dp_logo_basedir()) )
							||
						@mkdir(dp_logo_basedir())
					)
						&&
					move_uploaded_file($_FILES['mobile_ad_image_file1']['tmp_name'], dp_logo_basedir().DIRECTORY_SEPARATOR.$name)
				){
					$input['mobile_ad_image1'] = dp_logo_baseurl().'/'.$name;
				}else{
					add_settings_error('default', 'dp_uploader', sprintf(__('Directory %s is not writable. Please check permission.', 'tcd-w'), dp_logo_basedir()), 'error');
					//break;
				}
			 }
		 }elseif($_FILES['mobile_ad_image_file1']['error'] !== UPLOAD_ERR_NO_FILE){
			 add_settings_error('default', 'dp_uploader', _dp_get_upload_err_msg($_FILES['mobile_ad_image_file1']['error']), 'error');
			 //continue;
		 }
	 }


 //スマホ用の広告バナー
	 if(isset($_FILES['mobile_ad_image_file2'])){
		 //画像のアップロードに問題はないか
		 if($_FILES['mobile_ad_image_file2']['error'] === 0){
			 $name = sanitize_file_name($_FILES['mobile_ad_image_file2']['name']);
			 //ファイル形式をチェック
			 if(!preg_match("/\.(png|jpe?g|gif)$/i", $name)){
				 add_settings_error('design_plus_options', 'dp_uploader', sprintf(__('You uploaded %s but allowed file format is PNG, GIF and JPG.', 'tcd-w'), $name), 'error');
			 }else{
				//ディレクトリの存在をチェック
				if(
					(
						(file_exists(dp_logo_basedir()) && is_dir(dp_logo_basedir()) && is_writable(dp_logo_basedir()) )
							||
						@mkdir(dp_logo_basedir())
					)
						&&
					move_uploaded_file($_FILES['mobile_ad_image_file2']['tmp_name'], dp_logo_basedir().DIRECTORY_SEPARATOR.$name)
				){
					$input['mobile_ad_image2'] = dp_logo_baseurl().'/'.$name;
				}else{
					add_settings_error('default', 'dp_uploader', sprintf(__('Directory %s is not writable. Please check permission.', 'tcd-w'), dp_logo_basedir()), 'error');
					//break;
				}
			 }
		 }elseif($_FILES['mobile_ad_image_file2']['error'] !== UPLOAD_ERR_NO_FILE){
			 add_settings_error('default', 'dp_uploader', _dp_get_upload_err_msg($_FILES['mobile_ad_image_file2']['error']), 'error');
			 //continue;
		 }
	 }

 //トップページの広告う画像の登録（大）
 for($i = 1; $i <= 2; $i++){
	 if(isset($_FILES['top_large_ad_image_file_'.$i])){
		 //画像のアップロードに問題はないか
		 if($_FILES['top_large_ad_image_file_'.$i]['error'] === 0){
			 $name = sanitize_file_name($_FILES['top_large_ad_image_file_'.$i]['name']);
			 //ファイル形式をチェック
			 if(!preg_match("/\.(png|jpe?g|gif)$/i", $name)){
				 add_settings_error('design_plus_options', 'dp_uploader', sprintf(__('You uploaded %s but allowed file format is PNG, GIF and JPG.', 'tcd-w'), $name), 'error');
			 }else{
				//ディレクトリの存在をチェック
				if(
					(
						(file_exists(dp_logo_basedir()) && is_dir(dp_logo_basedir()) && is_writable(dp_logo_basedir()) )
							||
						@mkdir(dp_logo_basedir())
					)
						&&
					move_uploaded_file($_FILES['top_large_ad_image_file_'.$i]['tmp_name'], dp_logo_basedir().DIRECTORY_SEPARATOR.$name)
				){
					$input['top_large_ad_image'.$i] = dp_logo_baseurl().'/'.$name;
				}else{
					add_settings_error('default', 'dp_uploader', sprintf(__('Directory %s is not writable. Please check permission.', 'tcd-w'), dp_logo_basedir()), 'error');
					break;
				}
			 }
		 }elseif($_FILES['top_large_ad_image_file_'.$i]['error'] !== UPLOAD_ERR_NO_FILE){
			 add_settings_error('default', 'dp_uploader', _dp_get_upload_err_msg($_FILES['top_large_ad_image_file_'.$i]['error']), 'error');
			 continue;
		 }
	 }
 }

 //トップページの広告う画像の登録（小）
 for($i = 1; $i <= 4; $i++){
	 if(isset($_FILES['top_small_ad_image_file_'.$i])){
		 //画像のアップロードに問題はないか
		 if($_FILES['top_small_ad_image_file_'.$i]['error'] === 0){
			 $name = sanitize_file_name($_FILES['top_small_ad_image_file_'.$i]['name']);
			 //ファイル形式をチェック
			 if(!preg_match("/\.(png|jpe?g|gif)$/i", $name)){
				 add_settings_error('design_plus_options', 'dp_uploader', sprintf(__('You uploaded %s but allowed file format is PNG, GIF and JPG.', 'tcd-w'), $name), 'error');
			 }else{
				//ディレクトリの存在をチェック
				if(
					(
						(file_exists(dp_logo_basedir()) && is_dir(dp_logo_basedir()) && is_writable(dp_logo_basedir()) )
							||
						@mkdir(dp_logo_basedir())
					)
						&&
					move_uploaded_file($_FILES['top_small_ad_image_file_'.$i]['tmp_name'], dp_logo_basedir().DIRECTORY_SEPARATOR.$name)
				){
					$input['top_small_ad_image'.$i] = dp_logo_baseurl().'/'.$name;
				}else{
					add_settings_error('default', 'dp_uploader', sprintf(__('Directory %s is not writable. Please check permission.', 'tcd-w'), dp_logo_basedir()), 'error');
					break;
				}
			 }
		 }elseif($_FILES['top_small_ad_image_file_'.$i]['error'] !== UPLOAD_ERR_NO_FILE){
			 add_settings_error('default', 'dp_uploader', _dp_get_upload_err_msg($_FILES['top_small_ad_image_file_'.$i]['error']), 'error');
			 continue;
		 }
	 }
 }

 return $input;
}

?>