<?php
/**
 * ロゴ画像を取り扱うファイル 
 */


/**
 * フロントページにロゴを表示する
 */
function the_dp_footer_logo(){
  $logo = dp_footer_logo_to_display();
  $option = get_desing_plus_option();
  $title = get_bloginfo('name');
  $tagline = get_bloginfo('description');
  $url = home_url();
  if($logo){
    echo '<div id="footer_logo_area" style="top:' . $option['logotop2'] . 'px; left:' . $option['logoleft2'] . 'px;">' . "\n";
    echo '<h3 id="footer_logo">' . "\n";
    echo '<a href="' . $url . '/" title="' . $title . '"><img src="' . $logo['url'] . '" alt="'. $title . '" title="' . $title .'" /></a>' . "\n";
    echo "</h3>\n";
    echo "</div>\n";
  } else {
    echo "<div id='footer_logo_text_area'>\n";
    echo '<h3 id="footer_logo_text"><a href="' . $url . '/">' . $title . "</a></h3>\n";
    echo '<h4 id="footer_description">' . $tagline . "</h4>\n";
    echo "</div>\n";
  }
}



/**
 * ロゴが存在するか否かを返す
 * @param boolean $only_resized 初期値はfalse。trueにした場合はリサイズされたロゴが存在する場合だけtrueを返す。
 * @return string|false 存在する場合はファイル名を返す
 */
function dp_footer_logo_exists($only_resized = false){
	$dir = dp_logo_basedir();
	//ディレクトリが存在しない
	if(!file_exists($dir) || !is_dir($dir)){
		return false;
	}
	//リサイズが指定されている場合はリサイズされたものがあるか検索
	if($only_resized){
		foreach(scandir($dir) as $file){
			if(preg_match("/footer-image-resized\.(jpe?g|png|gif)$/i", $file)){
				return $dir.DIRECTORY_SEPARATOR.$file;
			}	
		}
		return false;
	}
	//オリジナルのファイルが存在するか否かを返す
	foreach(scandir($dir) as $file){
		if(preg_match("/footer-image\.(jpe?g|png|gif)$/i", $file)){
			return $dir.DIRECTORY_SEPARATOR.$file;
		}
	}
	//ここまで来たということはロゴはない
	return false;
}

/**
 * ロゴのパスや縦横サイズを返す
 * @param boolean $only_resized 
 * @uses dp_logo_exits
 * @return array name(string), url(string), path(string), width(int)およびheight(int)からなる配列
 */
function dp_footer_logo_info($only_resized = false){
	$file = dp_footer_logo_exists($only_resized);
	if($file){
		$size = @getimagesize($file);
		if($size){
			return array(
				'name' => basename($file),
				'url' => dp_logo_baseurl().'/'.basename($file),
				'path' => $file,
				'width' => $size[0],
				'height' => $size[1],
				'mime' => $size[2]
			);
		}else{
			return false;
		}
		return $size;
	}else{
		false;
	}
}

/**
 * ロゴ画像のimageタグを返す
 * @param boolean $resized 初期値はfalse。trueにするとリサイズされた画像を出力
 * @param string $alt
 * @param string $aditional_class
 * @param int $max_width 指定した場合はそのサイズに縮小して表示
 */
function dp_footer_logo_img_tag($resized = false, $alt = '', $aditional_class = '', $max_width = 0){
	$class = 'tcd-w-footer-logo ';
	$class .= $resized ? 'tcd-w-logo-resized2' : 'tcd-w-logo-original2';
	if(!empty($aditional_class)){
		$class .= ' '.$aditional_class;
	}
	$info = dp_footer_logo_info($resized);
	if($info){
		if($max_width > 0 && $info['width'] > $max_width){
			$height = round($info['height'] / $info['width'] * $max_width);
			$width = $max_width;
		}else{
			$width = $info['width'];
			$height = $info['height'];
		}
		echo '<img src="' . $info['url'] . '?' . time() . '" alt="' . esc_attr($alt) . '" class="' . esc_attr($class) . '" width="' . intval($width) . '" height="' . intval($height) . '" />';
	}
}

/**
 * 表示すべきロゴの情報を返す
 * @return array
 */
function dp_footer_logo_to_display(){
	$file = dp_footer_logo_info(true);
	if($file){
		return $file;
	}else{
		return dp_footer_logo_info();
	}
}

/**
 * ロゴの位置調整用のタグを書き出す
 * @param int $wrapper_original_size
 * @param int $wrapper_display_size 
 * @return boolean
 */
function dp_footer_logo_resize_tag($wrapper_original_size, $wrapper_display_size, $top = 0, $left = 0){
	$ratio = $wrapper_display_size / $wrapper_original_size;
	$info = dp_footer_logo_to_display();
	$width = round($info['width'] * $ratio);
	$height = round($info['height'] * $ratio);
	if($width > $wrapper_display_size){
		return false;
	}
	$top = round(intval($top) * $ratio);
	$left = round(intval($left) * $ratio);
	echo '<img src="' . $info['url'] . '?' . time() . '" alt="" width="' . intval($width) . '" height="' . intval($height) . '" style="top: ' . $top . 'px; left: ' . $left . 'px;" />';
	return true;
}

/**
 * リサイズ用ロゴのタグを書き出す
 * @param int $max 
 */
function dp_footer_logo_resize_base($max = 600){
	$info = dp_footer_logo_info();
	if(!$info){
		return;
	}
	$ratio = $max < $info['width'] ? $max / $info['width'] : 1;
	$width = round($info['width'] * $ratio);
	$height = round($info['height'] * $ratio);
        $time = time();
	echo <<<EOS
<img id="dp_logo_to_resize2" src="{$info['url']}?{$time}" width="{$width}" height="{$height}" alt="" />
<input type="hidden" name="dp_logo_to_resize_ratio2" value="{$ratio}" />
<input type="hidden" name="dp_logo_resize_height2" value="{$info['height']}" />
<input type="hidden" name="dp_logo_resize_width2" value="{$info['width']}" />
<input type="hidden" name="dp_logo_resize_left2" value="" />
<input type="hidden" name="dp_logo_resize_top2" value="" />
EOS;
}

/**
 * ロゴ画像をアップロードする
 * @global array $dp_upload_error
 * @return array error(boolean)とmessage(string)からなる配列
 */
function _dp_upload_footer_logo(){
	$dp_upload_error = array(
		'error' => false,
		'message' => ''
	);
	$dir = dp_logo_basedir();
	//ファイルのアップロードができるか判定
	if($_FILES['dp_image2']['error'] !== 0){
		$dp_upload_error = array(
			'error' => true,
			'message' => _dp_get_upload_err_msg($_FILES['dp_image2']['error'])
		);
		return $dp_upload_error;
	}
	//ディレクトリの存在を調べる
	if(!file_exists($dir) || !is_dir($dir)){
		//ディレクトリを作成してみる
		if(!@mkdir($dir)){
			$dp_upload_error = array(
				'error' => true,
				'message' => sprintf(
					__('Cannot create upload directory. Please make sure <code>%s</code> is writable.'),
					dirname($dir)
				)
			);
			return $dp_upload_error;
		}
	}
	//ディレクトリが書き込み可能か調べる
	if(!is_writable($dir)){
		$dp_upload_error = array(
			'error' => true,
			'message' => sprintf(
				__('Cannot save uploaded file. Please make sure <code>%s</code> is writable.'),
				$dir
			)
		);
		return $dp_upload_error;
	}
	//拡張子を調べる
	$ext = array();
	if(!preg_match("/(png|gif|jpe?g)$/i", $_FILES['dp_image2']['name'], $ext)){
		$dp_upload_error = array(
			'error' => true,
			'message' => __('Uploaded file type is not allowed. Allowed file types are PNG, JPG and GIF.')
		);
		return $dp_upload_error;
	}
	//既存のファイルを削除する
	$existing_files = scandir($dir);
	foreach($existing_files as $file){
		if(preg_match("/footer-image(-resized)?\.(png|gif|jpe?g)$/i", $file)){
			//ファイルが存在した場合は削除する
			if(!@unlink($dir.DIRECTORY_SEPARATOR.$file)){
				$dp_upload_error = array(
					'error' => true,
					'message' => sprintf(__('Cannot delete existing file <code>%s</code>', 'tcd-w'), $file)
				);
				return $dp_upload_error;
			}
		}
	}
	//ファイルを保存する
	if(!@move_uploaded_file($_FILES['dp_image2']['tmp_name'], $dir.DIRECTORY_SEPARATOR.'footer-image.'.$ext[1])){
		$dp_upload_error = array(
			'error' => true,
			'message' => __('Sorry, but cannot save uploaded file.')
		);
		return $dp_upload_error;
	}
	//ここまで来たということは保存に成功しているので、
	//メッセージを更新する
	$dp_upload_error['message'] = __('Logo file was successfully uploaded.', 'tcd-w');
	return  $dp_upload_error;
}

/**
 * ロゴ画像を削除する
 * @return void
 */
function _dp_delete_footer_image(){
	if(isset($_REQUEST['page'], $_REQUEST['_wpnonce']) && !isset($_REQUEST['settings-updated']) && $_REQUEST['page'] == 'theme_options'){
		if(wp_verify_nonce($_REQUEST['_wpnonce'], 'dp_delete_footer_image_'.get_current_user_id())){
			$dir = dp_logo_basedir();
			foreach(scandir($dir) as $file){
				if(preg_match("/footer-image(-resized)?\.(png|gif|jpe?g)/i", $file)){
					if(!@unlink($dir.DIRECTORY_SEPARATOR.$file)){
						add_action('admin_notices', '_dp_delete_message_error');
						return;
					}
				}
			}
			add_action('admin_notices', '_dp_delete_message_sucess');
		}
	}
	
}
add_action('admin_init', '_dp_delete_footer_image');


function _dp_resize_footer_logo(){
	$dp_resize_message = array(
		'error' => true,
		'message' => ''
	);
	//値をチェック
	$ratio = intval($_REQUEST['dp_resize_ratio2']);
	if(!($ratio > 0 && $ratio <= 100)){
		$ratio = 100;
	}
	$orignal_to_display_ratio = (float)$_REQUEST['dp_logo_to_resize_ratio2'];
	$width = round($_REQUEST['dp_logo_resize_width2'] / $orignal_to_display_ratio);
	$height = round($_REQUEST['dp_logo_resize_height2'] / $orignal_to_display_ratio);
	$top = round($_REQUEST['dp_logo_resize_top2'] / $orignal_to_display_ratio);
	$left = round($_REQUEST['dp_logo_resize_left2'] / $orignal_to_display_ratio);
	$new_width = round($width * $ratio / 100);
	$new_height = round($height * $ratio / 100);
	//画像を読み込んでみる
	$info = dp_footer_logo_info();
	if(!$info){
		$dp_resize_message['message'] = __('Logo file not exists.', 'tcd-w');
		return $dp_resize_message;
	}
	// 保存ファイル名を決める
	$path = preg_replace("/footer-image\.(png|gif|jpe?g)$/i", "footer-image-resized.$1", $info['path']);
	// 3.5以前と以降で処理を分岐
	try{
		// 3.5以降はwp_get_image_editorが存在する
		if(function_exists('wp_get_image_editor')){
			// 新APIを利用
			$orig_image = wp_get_image_editor($info['path']);
			// 読み込み失敗ならエラー
			if(is_wp_error($orig_image)){
				throw new Exception(__('Logo file not exists.', 'tcd-w'));
			}
			// リサイズしてダメだったらエラー
			$size = $orig_image->get_size();
			$resize_result = $orig_image->resize(
				round($size['width'] * $ratio / 100), // 幅
				round($size['height'] * $ratio / 100) // 高さ
			);
			if(is_wp_error($resize_result)){
				// WordPressが返すエラーメッセージを利用
				// 適宜変更してください。
				throw new Exception($resize_result->get_error_message());
			}
			// 切り抜きしてダメだったらエラー
			$crop_result = $orig_image->crop(
				round( $left * $ratio / 100 ),
				round( $top * $ratio / 100),
				$new_width, $new_height
			);
			if(is_wp_error($crop_result)){
				// WordPressが返すエラーメッセージを利用
				// 適宜変更してください。
				throw new Exception( $crop_result->get_error_message() );
			}
			// 保存してダメだったらエラー
			// 基本は上書きOK.
			$save_result = $orig_image->save($path);
			if(is_wp_error($save_result)){
				// WordPressが返すエラーメッセージを利用
				// 適宜変更してください。
				throw new Exception($save_result->get_error_message());
			}
		}else{
			// それ以前は昔の方法で行う
			$orig_image = wp_load_image($info['path']);
			// 画像を読み込めなかったらエラー
			if(!is_resource($orig_image)){
				throw new Exception(__('Logo file not exists.', 'tcd-w'));
			}
			$newimage = wp_imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled(
				$newimage, $orig_image,
				0, 0,
				$left, $top,
				$new_width, $new_height,
				$width, $height
			);
			if(IMAGETYPE_PNG == $info['mime'] && function_exists('imageistruecolor')){
				@imagetruecolortopalette($newimage, false, imagecolorstotal($orig_image));
			}
			imagedestroy($orig_image);
			//ファイルを保存する前に削除
			$dest_path = dp_logo_exists(true);
			if($dest_path && !@unlink($dest_path)){
				throw new Exception('Cannot delete existing resized logo.', 'tcd-w');
			}
			//名前を決めて保存
			$result = null;
			if ( IMAGETYPE_GIF == $info['mime'] ) {
				$result = imagegif( $newimage, $path );
			} elseif ( IMAGETYPE_PNG == $info['mime'] ) {
				$result = imagepng( $newimage, $path );
			} else {
				$result = imagejpeg( $newimage, $path, 100);
			}
			imagedestroy( $newimage );
			if(!$result){
				throw new Exception(sprintf(__('Failed to save resized logo. Please check permission of <code>%s</code>', 'tcd-w'), dp_logo_basedir()));
			}
		}
	}catch(Exception $e){
		// 上記処理中で一回でも例外が発生したら、エラーを返す
		$dp_resize_message['message'] = $e->getMessage();
		return $dp_resize_message;
	}
	// ここまで来たということはエラーなし
	$dp_resize_message['error'] = false;
	$dp_resize_message['message'] = __('Logo image is successfully resized.', 'tcd-w');
	return $dp_resize_message;
}