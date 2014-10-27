<?php

function add_custom_meta_boxes3() {
 add_meta_box(
  'wp_recommend_post2',//ID of meta box
  __('Recommend post2', 'tcd-w'),//label
  'recommend_post2',//callback function
  'post',// post type
  'side'
 );
}
add_action('add_meta_boxes', 'add_custom_meta_boxes3');

function recommend_post2(){

    global $post;
    $recommend_post2 = get_post_meta($post->ID,'recommend_post2',true);

    echo '<input type="hidden" name="recommend_post2_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

?>
<p><?php _e('Check if you wan\'t to show this post for recommend post2.', 'tcd-w');  ?></p>
<label><input type="checkbox" name="recommend_post2" value="on" <?php if( $recommend_post2 == 'on' ) { ?>checked="checked"<?php } ?> />  <?php _e('Show this post for recommend post2.', 'tcd-w');  ?></label>
<?php
}


// Save data from meta box
add_action('save_post', 'save_recommend_post2_meta_box');
function save_recommend_post2_meta_box( $post_id ) {

  // verify nonce
  if (!isset($_POST['recommend_post2_meta_box_nonce']) || !wp_verify_nonce($_POST['recommend_post2_meta_box_nonce'], basename(__FILE__))) {
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

  // save or delete
  if (isset($_POST['recommend_post2']) ) {
   update_post_meta($post_id, 'recommend_post2', $_POST['recommend_post2'] );
  } else {
   delete_post_meta( $post_id, 'recommend_post2') ;
  };

}



?>