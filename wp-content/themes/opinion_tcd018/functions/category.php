<?php


// 入力欄を出力 -------------------------------------------------------
add_action ( 'edit_category_form_fields', 'extra_category_fields');
function extra_category_fields( $tag ) {
    $t_id = $tag->term_id;
    $cat_meta = get_option( "cat_$t_id");
?>
<tr class="form-field">
 <th><label for="upload_image">色の設定 - メインカラー</label></th>
 <td><input id="category_color1" class="color {required:false}" type="text" size="36" name="Cat_meta[color1]" value="<?php if(isset ( $cat_meta['color1'])) echo esc_html($cat_meta['color1']) ?>" /><br />空欄の場合は、テーマオプションで登録したサイトのメインカラーを使います</td>
</tr>
<tr class="form-field">
 <th><label for="upload_image">色の設定 - サブカラー</label></th>
 <td><input id="category_color2" class="color {required:false}" type="text" size="36" name="Cat_meta[color2]" value="<?php if(isset ( $cat_meta['color2'])) echo esc_html($cat_meta['color2']) ?>" /><br />a:hoverに利用します</td>
</tr>
<?php
}


// データを保存 -------------------------------------------------------
add_action ( 'edited_term', 'save_extra_category_fileds');
function save_extra_category_fileds( $term_id ) {
    if ( isset( $_POST['Cat_meta'] ) ) {
	   $t_id = $term_id;
	   $cat_meta = get_option( "cat_$t_id");
	   $cat_keys = array_keys($_POST['Cat_meta']);
		  foreach ($cat_keys as $key){
		  if (isset($_POST['Cat_meta'][$key])){
			 $cat_meta[$key] = $_POST['Cat_meta'][$key];
		  }
	   }
	   update_option( "cat_$t_id", $cat_meta );
    }
}


?>