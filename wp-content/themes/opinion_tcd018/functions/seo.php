<?php

$prefix = 'tcd-w_';

$meta_box = array(
 'id' => 'my-meta-box',
 'title' => __('Meta title and description', 'tcd-w'),
 'context' => 'normal',
 'priority' => 'high',
 'fields' => array(
    array(
      'name' => __('Meta title', 'tcd-w'),
      'desc' => __('Enter meta title here.', 'tcd-w'),
      'id' => $prefix . 'meta_title',
      'type' => 'text',
      'std' => ''
    ),
    array(
      'name' => __('Meta description', 'tcd-w'),
      'desc' => __('Enter meta description here.', 'tcd-w'),
      'id' => $prefix . 'meta_description',
      'type' => 'textarea',
      'std' => ''
    ),
  )
);



add_action('admin_menu', 'mytheme_add_box');
// Add meta box
function mytheme_add_box() {
  global $meta_box;
  add_meta_box($meta_box['id'], $meta_box['title'], 'mytheme_show_box', 'post', $meta_box['context'], $meta_box['priority']);
  add_meta_box($meta_box['id'], $meta_box['title'], 'mytheme_show_box', 'page', $meta_box['context'], $meta_box['priority']);
}



// Callback function to show fields in meta box
function mytheme_show_box() {
  global $meta_box, $post;

?>
<script type="text/javascript">
jQuery(document).ready(function($){
  countField("#tcd-w_meta_description");
});
 
function countField(target) {
  jQuery(target).after("<span class=\"word_counter\" style='display:block; margin:0 15px 0 0; font-weight:bold;'></span>");
  jQuery(target).bind({
    keyup: function() {
      setCounter();
    },
    change: function() {
      setCounter();
    }
  });
  setCounter();
  function setCounter(){
    jQuery("span.word_counter").text("<?php _e('word count:', 'tcd-w'); ?>"+jQuery(target).val().length);
  };
}
</script>
<?php
  // Use nonce for verification
  echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
  echo '<table class="form-table">';

  foreach ($meta_box['fields'] as $field) {

    // get current post meta data
    $meta = get_post_meta($post->ID, $field['id'], true);

    echo '<tr>',
      '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
      '<td>';
    switch ($field['type']) {
      case 'text':
        echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<p>', $field['desc'], '</p>';
        break;
      case 'textarea':
        echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<p>', $field['desc'] , '</p>';
        break;
    }
    echo '</td><td>',
      '</td></tr>';
  }

  echo '</table>';

}



add_action('save_post', 'mytheme_save_data');
// Save data from meta box

function mytheme_save_data($post_id) {
  global $meta_box;

  // verify nonce
  if (!isset($_POST['mytheme_meta_box_nonce']) || !wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
    return $post_id;
  }

  // check autosave
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post_id;
  }

  // check permissions
  if ('page' == $_POST['post_type']) {
    if (!current_user_can('edit_page', $post_id)) {
      return $post_id;
    }
  } elseif (!current_user_can('edit_post', $post_id)) {
      return $post_id;
  }

  foreach ($meta_box['fields'] as $field) {
    $old = get_post_meta($post_id, $field['id'], true);
    $new = $_POST[$field['id']];

    if ($new && $new != $old) {
      update_post_meta($post_id, $field['id'], $new);
    } elseif ('' == $new && $old) {
      delete_post_meta($post_id, $field['id'], $old);
    }
  }

}


// titleタグ --------------------------------------------------------------------------------
function seo_title() {

 global $post;

 if(is_single()&&get_post_meta($post->ID,'tcd-w_meta_title',true) or is_page()&&get_post_meta($post->ID,'tcd-w_meta_title',true)){ 
  echo post_custom('tcd-w_meta_title'); }

 //上記以外
 else {
  global $page, $paged; wp_title( '|', true, 'right' ); bloginfo( 'name' );
  $site_description = get_bloginfo( 'description', 'display' ); if ( $site_description && ( is_home() || is_front_page() ) ) echo " | $site_description";
  if ( $paged >= 2 || $page >= 2 ) echo ' | ' . sprintf( __( 'Page %s', 'tcd-w' ), max( $paged, $page ) );
 };

};



// meta descriptionタグ --------------------------------------------------------------------------------
function seo_description() {

 global $post;

 //カスタムフィールドがある場合
 if(is_single()&&get_post_meta($post->ID,'tcd-w_meta_description',true) or is_page()&&get_post_meta($post->ID,'tcd-w_meta_description',true)){
  $trim_content = post_custom('tcd-w_meta_description');
  $trim_content = str_replace(array("\r\n", "\r", "\n"), "", $trim_content);
  $trim_content = htmlspecialchars($trim_content);
  echo $trim_content;
 }

 //抜粋記事が登録されている場合は出力
 elseif(is_single()&&has_excerpt() or is_page()&&has_excerpt()) { 
  $trim_content = get_the_excerpt();
  $trim_content = str_replace(array("\r\n", "\r", "\n"), "", $trim_content);
  echo $trim_content;
 }

 //上記が無い場合は本文から120文字を抜粋
 elseif(is_single() or is_page()) {

   $base_content = $post->post_content;
   $base_content = preg_replace('!<style.*?>.*?</style.*?>!is', '', $base_content);
   $base_content = preg_replace('!<script.*?>.*?</script.*?>!is', '', $base_content);
   $base_content = preg_replace('/\[.+\]/','', $base_content);
   $base_content = strip_tags($base_content);
   $trim_content = mb_substr($base_content, 0, 120 ,"utf-8");
   $trim_content = str_replace(']]>', ']]&gt;', $trim_content);
   $trim_content = str_replace(array("\r\n", "\r", "\n"), "", $trim_content);
   $trim_content = htmlspecialchars($trim_content);

   if(preg_match("/。/", $trim_content)) { //指定した文字数内にある、最後の「。」以降をカットして表示
     mb_regex_encoding("UTF-8"); 
     $trim_content = mb_ereg_replace('。[^。]*$', '。', $trim_content);
     echo $trim_content;
   }else{ //指定した文字数内に「。」が無い場合は、指定した文字数の文章を表示し、末尾に「…」を表示
     echo $trim_content . '...';
   };

 //シングルページと固定ページ以外はサイトのディスクリプションを表示
 } else {
    echo get_bloginfo('description');
 };

};


?>