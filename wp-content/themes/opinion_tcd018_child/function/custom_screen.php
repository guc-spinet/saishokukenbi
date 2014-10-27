<?php

/* 
 * 管理画面のデザインをカスタマイズするファイル
 */

//共通設定 ----------------------------------------------------------------
//管理画面のアドミンバーを編集
add_action( 'wp_before_admin_bar_render', 'hide_before_admin_bar_render' );
function hide_before_admin_bar_render() {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu( 'wp-logo' );
  $wp_admin_bar->remove_menu( 'updates' );
  $wp_admin_bar->remove_menu( 'comments' );
  $wp_admin_bar->remove_menu( 'new-content' );
}
remove_action('admin_head', 'my_custom_logo');

//フッターの文字変更
function remove_footer_admin () {
    echo 'ここに表示したい文字列を入力する。 <a href="URL">リンクも設定できます。</a>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

//アップデート通知を削除
add_filter( 'pre_site_transient_update_core', '__return_zero' );
remove_action( 'wp_version_check', 'wp_version_check' );
remove_action( 'admin_init', '_maybe_update_core' );

//管理画面のファビコンを変更
function admin_favicon() {
  echo '<link rel="shortcut icon" type="image/x-icon" href="'.get_bloginfo('template_url').'/images/favicon.ico" />';
}
add_action('admin_head', 'admin_favicon');

//プラグインのアップデート通知を削除
add_action('admin_menu', 'remove_counts');
function remove_counts(){
	global $menu,$submenu;
	$menu[65][0] = 'プラグイン';
	$submenu['index.php'][10][0] = '更新';
}

//ダッシュボードにウィジェットを追加
function dashboard_widget_function() {
?>
<div>
<?php
$user = wp_get_current_user();
$my_user_name = $user->get('user_login');
$my_user_application = $user->get('application');
$applications = explode(",", $my_user_application);
if($applications){
    foreach ($applications as $application){
        $pickup_user = get_user_by('login', $application);
        $query = array (
        'para1' => $pickup_user->ID ,
        'para2' => $my_user_name
        );
        echo '<div>'.get_avatar($pickup_user->ID, 100).'<div><span>'.$pickup_user->display_name.'</span><span>'.$pickup_user->user_sex.'</span><span>'.$pickup_user->user_email.'</span><span>'.$pickup_user->author_twitter.'</span><span>'.$pickup_user->author_facebook.'</span><a href="'.add_query_arg( $query, 'http://saishokukenbi.jp/private_massages/').'">メッセージ</a></div></div>';
    }
}
?>
</div>
<?php
}
function add_dashboard_widgets() {
	wp_add_dashboard_widget('dashboard_widget', '受講生一覧', 'dashboard_widget_function');
}
add_action('wp_dashboard_setup', 'add_dashboard_widgets' );

function db_recent_posts() {
?>
<ol>
	<?php
		global $post;
		$args = array( 'numberposts' => 10, 'post_type' => 'connect_thread' );
		$myposts = get_posts( $args );
			foreach( $myposts as $post ) :  setup_postdata($post); ?>
				<li> (<?php the_date('Y年n月d日'); ?>) <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		<?php endforeach; ?>
</ol>
<?php
}
function add_db_recent_posts() {
	wp_add_dashboard_widget( 'db_recent_posts', __( 'Recent Posts' ), 'db_recent_posts' );
}
add_action( 'wp_dashboard_setup', 'add_db_recent_posts' );


//ダッシュボードのウィジェットを非表示
function remove_dashboard_widgets() {
  global $wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);        // 現在の状況
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);  // 最近のコメント
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);   // 被リンク
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);          // プラグイン
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);        // クイック投稿
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);      // 最近の下書き
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);            // WordPressブログ
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);          // WordPressフォーラム
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);          // アクティビティ
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

/*---------------------------------------------ログイン画面------------------------------------------------------*/
//ログイン画面のロゴを変更
function custom_login_logo() {
	echo '<style type="text/css">h1 a { background: url('.get_bloginfo('template_directory').'/images/login-logo.png) no-repeat center center !important; }</style>';
}
add_action('login_head', 'custom_login_logo');

//ログイン画面のデザインを変更
function custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/login.css" />';
}
add_action('login_head', 'custom_login');

/*---------------------------------------------管理画面------------------------------------------------------*/


//管理画面でCSSやJavaScriptを使う
// CSS
function admin_css() {
	echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo("template_directory").'/css/admin.css">';
}
add_action('admin_head', 'admin_css');

// JavaScript
function admin_js() {
	echo '<script type="text/javascript" src="'.get_bloginfo("template_directory").'/js/admin.js"></script>';
}
add_action('admin_head', 'admin_js');

//管理画面を権限ごとにデザイン変更する
function admin_css_custom() {
	if (!current_user_can('edit_users')) {
		echo '<style>
                     #menu-posts-press,
                     #menu-posts-news,
                     #menu-pages,
                     #menu-appearance,
                     #menu-plugins,
                     #menu-tools,
                     #menu-posts-connect_thread,
                     #toplevel_page_theme_my_login{display: none;}      
                    </style>';
	}
}
add_action('admin_print_styles', 'admin_css_custom');

//管理画面カラーパレットの削除
add_filter( 'get_user_option_admin_color', 'set_default_admin_color' );
	function set_default_admin_color($result) {
	return 'coffee';
}
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
?>