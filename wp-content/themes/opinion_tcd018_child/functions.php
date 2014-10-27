<?php

require_once ( dirname(__FILE__) . '/function/custom_screen.php' );

function init_session_start(){
  session_start();
}
add_action('init', 'init_session_start');
//URLの設定 --------------------------------------------------------------------------------
//GETパラメータに任意の文字列を追加
function add_meta_query_vars( $public_query_vars ) {
    $public_query_vars[] = 'para1';
    $public_query_vars[] = 'para2';
    $public_query_vars[] = 'para3';
    return $public_query_vars;
}
add_filter( 'query_vars', 'add_meta_query_vars' );

//プロフィールの設定 --------------------------------------------------------------------------------
//プロフィールに任意の項目を追加
function my_user_meta2($contactmethods) {   
    //項目の追加
    $contactmethods['user_name_kana'] = 'フリガナ';
    $contactmethods['user_addr_zip'] = '郵便番号';
    $contactmethods['user_addr'] = '住所';
    $contactmethods['user_confirm'] = '会員規約に同意';
    $contactmethods['user_course_period'] = '講座期間';
    $contactmethods['user_tuition_fee_online'] = '通信コース受講料（月額）';
    $contactmethods['user_tuition_fee_commute'] = '通学コース受講料（月額）';
    return $contactmethods;
}
add_filter('user_contactmethods', 'my_user_meta2', 10, 1);

//プロフィールに追加した項目の書き込み処理
function tml_user_register( $user_id ) {
    if ( !empty( $_POST['last_name'     ] ) ) update_user_meta( $user_id, 'last_name',      $_POST['last_name'     ] );
    if ( !empty( $_POST['user_name_kana'] ) ) update_user_meta( $user_id, 'user_name_kana', $_POST['user_name_kana'] );
    if ( !empty( $_POST['user_addr_zip' ] ) ) update_user_meta( $user_id, 'user_addr_zip',  $_POST['user_addr_zip' ] );
    if ( !empty( $_POST['user_addr'     ] ) ) update_user_meta( $user_id, 'user_addr',      $_POST['user_addr'     ] );
    if ( !empty( $_POST['user_confirm'  ] ) ) update_user_meta( $user_id, 'user_confirm',   $_POST['user_confirm'  ] );
}
add_action( 'user_register', 'tml_user_register' );

//フォームにおける、プロフィールに追加した項目のエラー処理
function tml_registration_errors( $errors ) {
    if ( empty( $_POST['last_name'     ] ) ) $errors->add( 'empty_last_name',      '<strong>エラー</strong>: お名前を入力してください');
    if ( empty( $_POST['user_name_kana'] ) ) $errors->add( 'empty_user_name_kana', '<strong>エラー</strong>: お名前フリガナを入力してください' );
    if ( empty( $_POST['user_confirm'  ] ) ) $errors->add( 'empty_user_confirm',   '<strong>エラー</strong>: 会員規約に同意をチェックしてください' );
 
     // tml_registration_errors に追記部分
    $rep1 = array();
    $rep2 = array();
    array_push($rep1, "<strong>ERROR</strong>");
    array_push($rep2, "<strong>エラー</strong>");
    array_push($rep1, "Please enter your password twice.");
    array_push($rep2, "パスワードを2回入力してください。");
    array_push($rep1, "Please enter the same password in the two password fields.");
    array_push($rep2, "パスワードは同じものを2回入力してください。");
    array_push($rep1, "This username is already registered, please choose another one.");
    array_push($rep2, "同じメールアドレスがすでに登録されています。");
    $custom_error = new WP_Error();
    foreach ( $errors -> errors as $key => $val ) {
        $tmp = str_replace($rep1,$rep2,$val[0]);
        $custom_error -> add($key, $tmp);
    }
    return $custom_error;
    //  return $errors;
}
add_filter( 'registration_errors', 'tml_registration_errors' );


// カスタムメニューの設定 --------------------------------------------------------------------------------
//任意のカスタムメニュー位置を追加
if(function_exists('register_nav_menu')) {
 register_nav_menu( 'community-menu', __( 'コミュニティーメニュー', 'tcd-w' ) );
}
if(function_exists('register_nav_menu')) {
 register_nav_menu( 'detailed_information_menu', __( '講師詳細ページメニュー', 'tcd-w' ) );
}

//カスタム投稿の設定 --------------------------------------------------------------------------------
//カスタム投稿タイプの公開時に自動で投稿IDをスラッグにセットする
function add_slug_for_posts($post_id) {
global $wpdb;
$posts_data = get_post($post_id, ARRAY_A);
$slug = $posts_data['post_name'];
if ($post_id != $slug){
  $my_post = array();
  $my_post['ID'] = $post_id;
  $my_post['post_name'] = $post_id;
wp_update_post($my_post);
}
}
add_action('publish_custom_post_name', 'add_slug_for_posts');
//custom_post_nameを自分のカスタム投稿タイプ名に変更

//カスタム投稿「スレッド投稿」を追加 ----------------------------------------------------------------
if ( function_exists('register_post_type') ) {
 $labels = array(
  'name' => __('スレッド'),
  'singular_name' => __('スレッド'),
  'add_new' => __('新しく追加', 'tcd-w'),
  'add_new_item' => __('新しく追加', 'tcd-w'),
  'edit_item' => __('編集', 'tcd-w'),
  'new_item' => __('New item', 'tcd-w'),
  'view_item' => __('記事を見る', 'tcd-w'),
  'search_items' => __('Search Items', 'tcd-w'),
  'not_found' => __('Not Found', 'tcd-w'),
  'not_found_in_trash' => __('Not found in trash', 'tcd-w'), 
  'parent_item_colon' => ''
 );

 register_post_type('thread', array(
  'label' => __('スレッド'),
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'menu_position' =>7,
  'show_ui' => true,
  'query_var' => true,
  'rewrite' => array('slug' => 'thread'),
  'capability_type' => 'post',
  'has_archive' => true,
  'supports' => array('title','comments','trackbacks','editor','author')
 ));
};

//カスタム投稿「イベントスレッド投稿」を追加 ----------------------------------------------------------------

if ( function_exists('register_post_type') ) {
 $labels = array(
  'name' => __('イベントスレッド', 'tcd-w'),
  'singular_name' => __('イベントスレッド', 'tcd-w'),
  'add_new' => __('新しく追加', 'tcd-w'),
  'add_new_item' => __('新しく追加', 'tcd-w'),
  'edit_item' => __('編集', 'tcd-w'),
  'new_item' => __('New item', 'tcd-w'),
  'view_item' => __('記事を見る', 'tcd-w'),
  'search_items' => __('Search Items', 'tcd-w'),
  'not_found' => __('Not Found', 'tcd-w'),
  'not_found_in_trash' => __('Not found in trash', 'tcd-w'), 
  'parent_item_colon' => ''
 );

 register_post_type('event_thread', array(
  'label' => __('イベントスレッド', 'tcd-w'),
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'menu_position' => 8,
  'show_ui' => true,
  'query_var' => true,
  'rewrite' => array('slug' => 'event_thread'),
  'capability_type' => 'post',
  'has_archive' => true,
  'supports' => array('title','comments','trackbacks','editor','author')
 ));
};

//カスタム投稿「講座詳細投稿」を追加 ----------------------------------------------------------------

if ( function_exists('register_post_type') ) {
 $labels = array(
  'name' => __('講座紹介'),
  'singular_name' => __('講座紹介'),
  'add_new' => __('新しく追加', 'tcd-w'),
  'add_new_item' => __('新しく追加', 'tcd-w'),
  'edit_item' => __('編集', 'tcd-w'),
  'new_item' => __('New item', 'tcd-w'),
  'view_item' => __('記事を見る', 'tcd-w'),
  'search_items' => __('Search Items', 'tcd-w'),
  'not_found' => __('Not Found', 'tcd-w'),
  'not_found_in_trash' => __('Not found in trash', 'tcd-w'), 
  'parent_item_colon' => ''
 );

 register_post_type('detailed_information', array(
  'label' => __('講座紹介'),
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'menu_position' =>9,
  'show_ui' => true,
  'query_var' => true,
  'rewrite' => array('slug' => 'detailed_information'),
  'capability_type' => 'post',
  'has_archive' => true,
  'supports' => array('title','editor','thumbnail','author')
 ));
};
//カスタム投稿「カリキュラム投稿」を追加 ----------------------------------------------------------------

if ( function_exists('register_post_type') ) {
 $labels = array(
  'name' => __('カリキュラム'),
  'singular_name' => __('カリキュラム'),
  'add_new' => __('新しく追加', 'tcd-w'),
  'add_new_item' => __('新しく追加', 'tcd-w'),
  'edit_item' => __('編集', 'tcd-w'),
  'new_item' => __('New item', 'tcd-w'),
  'view_item' => __('記事を見る', 'tcd-w'),
  'search_items' => __('Search Items', 'tcd-w'),
  'not_found' => __('Not Found', 'tcd-w'),
  'not_found_in_trash' => __('Not found in trash', 'tcd-w'), 
  'parent_item_colon' => ''
 );

 register_post_type('curriculum', array(
  'label' => __('カリキュラム'),
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'menu_position' =>11,
  'show_ui' => true,
  'query_var' => true,
  'rewrite' => array('slug' => 'curriculum'),
  'capability_type' => 'post',
  'has_archive' => true,
  'supports' => array('title','editor','author')
 ));
};
//カスタム投稿「プロフィール投稿」を追加 ----------------------------------------------------------------

if ( function_exists('register_post_type') ) {
 $labels = array(
  'name' => __('プロフィール'),
  'singular_name' => __('プロフィール'),
  'add_new' => __('新しく追加', 'tcd-w'),
  'add_new_item' => __('新しく追加', 'tcd-w'),
  'edit_item' => __('編集', 'tcd-w'),
  'new_item' => __('New item', 'tcd-w'),
  'view_item' => __('記事を見る', 'tcd-w'),
  'search_items' => __('Search Items', 'tcd-w'),
  'not_found' => __('Not Found', 'tcd-w'),
  'not_found_in_trash' => __('Not found in trash', 'tcd-w'), 
  'parent_item_colon' => ''
 );

 register_post_type('teacher_profile', array(
  'label' => __('プロフィール'),
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'menu_position' =>12,
  'show_ui' => true,
  'query_var' => true,
  'rewrite' => array('slug' => 'teacher_profile'),
  'capability_type' => 'post',
  'has_archive' => true,
  'supports' => array('title','editor','author')
 ));
};

//カスタム投稿「連絡掲示板」を追加 ----------------------------------------------------------------

if ( function_exists('register_post_type') ) {
 $labels = array(
  'name' => __('連絡用掲示板投稿', 'tcd-w'),
  'singular_name' => __('連絡用掲示板投稿', 'tcd-w'),
  'add_new' => __('新しく追加', 'tcd-w'),
  'add_new_item' => __('新しく追加', 'tcd-w'),
  'edit_item' => __('編集', 'tcd-w'),
  'new_item' => __('New item', 'tcd-w'),
  'view_item' => __('記事を見る', 'tcd-w'),
  'search_items' => __('Search Items', 'tcd-w'),
  'not_found' => __('Not Found', 'tcd-w'),
  'not_found_in_trash' => __('Not found in trash', 'tcd-w'), 
  'parent_item_colon' => ''
 );

 register_post_type('connect_thread', array(
  'label' => __('連絡用掲示板投稿', 'tcd-w'),
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'menu_position' => 10,
  'show_ui' => true,
  'query_var' => true,
  'rewrite' => array('slug' => 'connect_thread'),
  'capability_type' => 'post',
  'has_archive' => true,
  'supports' => array('title','editor','author')
 ));
};
//カスタム投稿「講座用動画投稿」を追加 ----------------------------------------------------------------

if ( function_exists('register_post_type') ) {
 $labels = array(
  'name' => __('講座用動画投稿', 'tcd-w'),
  'singular_name' => __('講座用動画投稿', 'tcd-w'),
  'add_new' => __('新しく追加', 'tcd-w'),
  'add_new_item' => __('新しく追加', 'tcd-w'),
  'edit_item' => __('編集', 'tcd-w'),
  'new_item' => __('New item', 'tcd-w'),
  'view_item' => __('記事を見る', 'tcd-w'),
  'search_items' => __('Search Items', 'tcd-w'),
  'not_found' => __('Not Found', 'tcd-w'),
  'not_found_in_trash' => __('Not found in trash', 'tcd-w'), 
  'parent_item_colon' => ''
 );

 register_post_type('movies', array(
  'label' => __('講座用動画投稿', 'tcd-w'),
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'menu_position' => 11,
  'show_ui' => true,
  'query_var' => true,
  'rewrite' => array('slug' => 'movies'),
  'capability_type' => 'post',
  'has_archive' => true,
  'supports' => array('title','editor','author')
 ));
};
//カスタム投稿「講座用PDF投稿」を追加 ----------------------------------------------------------------

if ( function_exists('register_post_type') ) {
 $labels = array(
  'name' => __('講座用PDF投稿', 'tcd-w'),
  'singular_name' => __('講座用PDF投稿', 'tcd-w'),
  'add_new' => __('新しく追加', 'tcd-w'),
  'add_new_item' => __('新しく追加', 'tcd-w'),
  'edit_item' => __('編集', 'tcd-w'),
  'new_item' => __('New item', 'tcd-w'),
  'view_item' => __('記事を見る', 'tcd-w'),
  'search_items' => __('Search Items', 'tcd-w'),
  'not_found' => __('Not Found', 'tcd-w'),
  'not_found_in_trash' => __('Not found in trash', 'tcd-w'), 
  'parent_item_colon' => ''
 );

 register_post_type('pdfs', array(
  'label' => __('講座用PDF投稿', 'tcd-w'),
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'menu_position' => 12,
  'show_ui' => true,
  'query_var' => true,
  'rewrite' => array('slug' => 'pdfs'),
  'capability_type' => 'post',
  'has_archive' => true,
  'supports' => array('title','editor','author')
 ));
};
//権限についての設定 --------------------------------------------------------------------------------
//寄稿者でも画像をアップロードできるようにする
if ( current_user_can('author') && !current_user_can('upload_files') )
    add_action('admin_init', 'allow_author_uploads');
 
  function allow_author_uploads() {
      $author = get_role('author');
      $author->add_cap('upload_files');
}

//他のメンバーの画像を見れないようにする
//メディアの抽出条件にログインユーザーの絞り込み条件を追加する
function display_only_self_uploaded_medias( $wp_query ) {
    if ( is_admin() && ( $wp_query->is_main_query() || ( defined( 'DOING_QUERY_ATTACHMENT' ) && DOING_QUERY_ATTACHMENT ) ) && $wp_query->get( 'post_type' ) == 'attachment' ) {
        $user = wp_get_current_user();
        $wp_query->set( 'author', $user->ID );
    }
}
function define_doing_query_attachment_const() {
    if ( ! defined( 'DOING_QUERY_ATTACHMENT' ) ) {
        define( 'DOING_QUERY_ATTACHMENT', true );
    }
}

//他の人の投稿を見れないようにする
function exclude_other_posts( $wp_query ) {
    if ( isset( $_REQUEST['post_type'] ) && post_type_exists( $_REQUEST['post_type'] ) ) {
        $post_type = get_post_type_object( $_REQUEST['post_type'] );
        $cap_type = $post_type->cap->edit_other_posts;
    } else {
        $cap_type = 'edit_others_posts';
    }
 
    if ( is_admin() && $wp_query->is_main_query() && ! $wp_query->get( 'author' ) && ! current_user_can( $cap_type ) ) {
        $user = wp_get_current_user();
        $wp_query->set( 'author', $user->ID );
    }
}
get_currentuserinfo();
if($current_user->user_level < 10){
    add_action( 'pre_get_posts', 'display_only_self_uploaded_medias' );
    add_action( 'wp_ajax_query-attachments', 'define_doing_query_attachment_const', 0 );
    add_action( 'pre_get_posts', 'exclude_other_posts' );
}


//ユーザー操作の設定 --------------------------------------------------------------------------------
//記事を公開する前に確認アラートを表示する
$confirm_message = '記事を公開してもいいですか？';
function confirm_publish(){
global $confirm_message;
echo '<script type="text/javascript"><!--
var publish = document.getElementById("publish");
if (publish !== null) publish.onclick = function(){
	return confirm("'.$confirm_message.'");
};
// --></script>';
}
add_action( 'admin_footer', 'confirm_publish' );

//アバター画像のURLを取得 --------------------------------------------------------------------------------
function get_avatar_url($id_or_email, $size = null, $default = null, $alt = null)
{
    $image = get_avatar($id_or_email, $size, $default, $alt);
    if(preg_match("/src='(.*?)'/", $image, $match)) {
        if(isset($match[1])) {
            return $match[1];
        } else {
            return false;
        }
    } else {
        return false;
    }
}
add_filter('deleted_comment', 'redirect_deleted_comment');
function redirect_deleted_comment(){
      wp_redirect('http://saishokukenbi.jp/private_massages/');
      exit();
}
if ( current_user_can('Subscriber') )  {
	add_action( 'admin_init', 'redirect_Subscriber' );
}
function redirect_Subscriber() {
    
	wp_redirect( home_url() );
        exit; 
}
/*
	アーカイブページで現在のカテゴリー・タグ・タームを取得する
*/
function get_current_term(){

	$id;
	$tax_slug;

	if(is_category()){
		$tax_slug = "category";
		$id = get_query_var('cat');	
	}else if(is_tag()){
		$tax_slug = "post_tag";
		$id = get_query_var('tag_id');	
	}else if(is_tax()){
		$tax_slug = get_query_var('taxonomy');	
		$term_slug = get_query_var('term');	
		$term = get_term_by("slug",$term_slug,$tax_slug);
		$id = $term->term_id;
	}

	return get_term($id,$tax_slug);
}

?>