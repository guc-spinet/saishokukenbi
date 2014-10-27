<?php
global $wp_post_types;

$custom_post_types = array();

foreach ( $wp_post_types as $post_type => $details ) {
	if ( ! in_array( $post_type, array( 'post', 'page', 'attachment', 'revision', 'nav_menu_item' ) ) ) {
		$custom_post_types[$post_type] = $details;
	}
}

$wpac_members_blog_redirect        = get_option( 'wpac_members_blog_redirect', '' );
$wpac_members_only_blog            = get_option( 'wpac_members_only_blog', FALSE );
$wpac_show_in_menus                = get_option( 'wpac_show_in_menus', 'with_access' );
$wpac_default_post_state           = get_option( 'wpac_default_post_state', 'public' );
$wpac_default_page_state           = get_option( 'wpac_default_page_state', 'public' );
$wpac_default_members_redirect     = get_option( 'wpac_default_members_redirect' , '' );
$wpac_show_posts_in_search         = get_option( 'wpac_show_posts_in_search', FALSE );
$wpac_show_post_excerpts_in_search = get_option( 'wpac_show_post_excerpts_in_search', FALSE );
$wpac_show_pages_in_search         = get_option( 'wpac_show_pages_in_search', FALSE );
$wpac_show_page_excerpts_in_search = get_option( 'wpac_show_page_excerpts_in_search', FALSE );
?><div class="wrap">
	<div class="icon32" id="icon-options-general"><br /></div>
	<h2><?php _e( 'アクセスコントロール', 'wpac' ); ?></h2>
	
	<?php if ( isset( $admin_message ) && ! empty( $admin_message ) ) { ?>
	<div class="updated below-h2" id="message"><p><?php echo $admin_message; ?></p></div>
	<?php } ?>
	
	<?php if ( isset( $admin_error ) && ! empty( $admin_error ) ) { ?>
	<div class="error below-h2" id="error"><p><?php echo $admin_error; ?></p></div>
	<?php } ?>
	
	<form action="options-general.php?page=wpac-options" method="post">
		<input type="hidden" value="wpac-options" name="options_page" />
		<input type="hidden" value="update" name="action" />
		<?php wp_nonce_field( 'wpac_options_save' ); ?>
		
		<h3 class="title"><?php _e( 'ショートコード', 'wpac' ); ?></h3>
		
		<p><?php _e( 'ページ全体でなく、コンテンツの一部をメンバー限定にするには、[member] [/member]タグで対象のコンテンツを囲んでください。また、限定しないコンテンツについては、[nonmember] [/nonmember]で囲むことで、対象外とすることが可能です。', 'wpac' ); ?></p>
		
		<h3 class="title"><?php _e( 'サイト設定', 'wpac' ); ?></h3>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="wpac_members_only_blog"><?php _e( 'サイト全体をメンバー限定にする', 'wpac' ); ?></label>
					</th>
					
					<td>
						<label><input type="checkbox" name="wpac_members_only_blog" value="yes" id="wpac_members_only_blog" <?php checked( $wpac_members_only_blog, 1 ); ?>/> <span><?php _e( '有効にする', 'wpac' ); ?></span></label>
					</td>
				</tr>
				
				<tr>
					<th scope="row">
						<label for="wpac_members_blog_redirect"><?php _e( 'リダイレクト先', 'wpac' ); ?></label>
					</th>
					
					<td>
						<input type="text" class="regular-text" value="<?php esc_attr_e( $wpac_members_blog_redirect ); ?>" id="wpac_members_blog_redirect" name="wpac_members_blog_redirect" />
						<span class="description"><?php printf( __( 'メンバー以外がサイトに訪れた場合に転送する先を指定します。%1$sデフォルトでは、サイトのログインページに転送されます。(%2$s)%1$sログインした後はサイトにリダイレクトされます。', 'wpac' ),  '<br />', '<a href="' . wp_login_url() . '">' . wp_login_url() . '</a>' ); ?></span>
					</td>
				</tr>
				
				<?php if ( ! empty( $custom_post_types ) ) { ?>
				<tr>
					<th scope="row">
						<label for="wpac_members_only_blog"><?php _e( 'カスタム投稿タイプ', 'wpac' ); ?></label>
					</th>
					
					<td>
						<p class="description"><?php _e( '以下の設定により、カスタム投稿タイプのアクセス権の設定をおこなうことが可能です。投稿タイプが独自の管理インターフェイスをもっている場合は、うまく動作しない場合があります。', 'wpac' ); ?></p>
						<?php 
						$wpac_custom_post_types = get_option( 'wpac_custom_post_types', array() );
						
						foreach ( $custom_post_types as $post_type => $details ) {
							if ( in_array( $post_type, $wpac_custom_post_types ) ) {
								echo '<label><input type="checkbox" checked="checked" value="' . esc_attr( $post_type ) . '" id="wpac_enable_for_post_type_' . esc_attr( $post_type ) . '" name="wpac_custom_post_types[]" /> <span>' . $post_type . ' &ndash; ' . $details->labels->name . ' - ' . ( ( ! empty( $details->description ) ) ? $details->description : '<em>No Description</em>' ) . '</span></label><br />';
							} else {
								echo '<label><input type="checkbox" value="' . esc_attr( $post_type ) . '" id="wpac_enable_for_post_type_' . esc_attr( $post_type ) . '" name="wpac_custom_post_types[]" /> <span>' . $post_type . ' &ndash; ' . $details->labels->name . ' - ' . ( ( ! empty( $details->description ) ) ? $details->description : '<em>No Description</em>' ) . '</span></label><br />';
							}
						}
						?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		
		<h3 class="title"><?php _e( '優先設定', 'wpac' ); ?></h3>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<?php _e( '常にアクセス可能な権限グループ', 'wpac' ); ?>
					</th>
					<td>
						<?php 
						global $wp_roles;
						$roles = $wp_roles->get_names();
						$checked_roles = (array) maybe_unserialize( get_option( 'wpac_always_accessible_by', array( 0 => 'administrator' ) ) );
						
						foreach ( $roles as $role => $label ) {
							if ( in_array( $role, $checked_roles ) ) {
								echo '<label><input type="checkbox" name="wpac_always_accessible_by[]" checked="checked" value="' . $role . '" /> ' . $label . '<br /></label>';
							} else {
								echo '<label><input type="checkbox" name="wpac_always_accessible_by[]" value="' . $role . '" /> ' . $label . '<br /></label>';
							}
						}
						?>
					</td>
				</tr>
			</tbody>
		</table>
		
		<h3 class="title"><?php _e( 'メニューオプション', 'wpac' ); ?></h3>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<?php _e( 'メニューに表示', 'wpac' ); ?>
					</th>
					<td>
						<p class="description"><?php _e( 'デフォルトで、アクセス権がないページや投稿もメニューに表示しますか？　アクセス権がある場合は常に表示されます。', 'wpac' ); ?></p>
						<label><input <?php checked( $wpac_show_in_menus, 'with_access' ); ?> type="radio" value="with_access" name="wpac_show_in_menus" /> <span><?php _e( 'アクセス権があるメニュー項目のみ表示', 'wpac' ); ?></span></label><br />
						<label><input <?php checked( $wpac_show_in_menus, 'always' ); ?> type="radio" value="always" name="wpac_show_in_menus" /> <span><?php _e( 'アクセス権利がない場合も、常にすべてのメニュー項目を表示', 'wpac' ); ?></span></label>
					</td>
				</tr>
			</tbody>
		</table>
		
		<h3 class="title"><?php _e( '投稿／ページのデフォルトオプション', 'wpac' ); ?></h3>
		
		<p>
			<?php _e( '投稿やページの大半に同様の設定をする場合、デフォルトとして設定しておくことが可能です。なお、個別の投稿やページの設定が優先されます。' ); ?>
		</p>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<?php _e( '投稿のデフォルト設定', 'wpac' ); ?>
					</th>
					<td>
						<label><input <?php checked( $wpac_default_post_state, 'public' ); ?> type="radio" value="public" name="default_post_state" /> <span><?php _e( '一般公開', 'wpac' ); ?></span></label><br />
						<label><input <?php checked( $wpac_default_post_state, 'members' ); ?> type="radio" value="members" name="default_post_state" /> <span><?php _e( 'メンバー限定', 'wpac' ); ?></span></label><br />
						<label><input <?php checked( $wpac_default_post_state, 'nonmembers' ); ?> type="radio" value="nonmembers" name="default_post_state" /> <span><?php _e( 'メンバー以外限定', 'wpac' ); ?></span></label><br />
					</td>
				</tr>
				
				<tr>
					<th scope="row">
						<?php _e( '投稿にアクセス可能な権限グループ', 'wpac' ); ?>
					</th>
					<td>
						<?php 
						global $wp_roles;
						$roles = $wp_roles->get_names();
						$checked_roles = (array) get_option( 'wpac_posts_default_restricted_to', array() );
				
						foreach ( $roles as $role => $label ) {
							if ( in_array( $role, $checked_roles ) ) {
								echo '<input type="checkbox" name="wpac_posts_default_restricted_to[]" checked="checked" value="' . $role . '" /> ' . $label . '<br />';
							} else {
								echo '<input type="checkbox" name="wpac_posts_default_restricted_to[]" value="' . $role . '" /> ' . $label . '<br />';
							}
						}
						?>
						<span class="description"><?php _e( 'デフォルトはすべてアクセス可能', 'wpac' ); ?></span>
					</td>
				</tr>
				
				<tr>
					<th scope="row">
						<?php _e( 'ページのデフォルト設定', 'wpac' ); ?>
					</th>
					<td>
						<label><input <?php checked( $wpac_default_page_state, 'public' ); ?> type="radio" value="public" name="default_page_state" /> <span><?php _e( '一般公開', 'wpac' ); ?></span></label><br />
						<label><input <?php checked( $wpac_default_page_state, 'members' ); ?> type="radio" value="members" name="default_page_state" /> <span><?php _e( 'メンバー限定', 'wpac' ); ?></span></label><br />
						<label><input <?php checked( $wpac_default_page_state, 'nonmembers' ); ?> type="radio" value="nonmembers" name="default_page_state" /> <span><?php _e( 'メンバー以外限定', 'wpac' ); ?></span></label><br />
					</td>
				</tr>
				
				<tr>
					<th scope="row">
						<?php _e( 'ページにアクセス可能な権限グループ', 'wpac' ); ?>
					</th>
					<td>
						<?php 
						global $wp_roles;
						$roles = $wp_roles->get_names();
						$checked_roles = (array) get_option( 'wpac_pages_default_restricted_to', array() );
				
						foreach ( $roles as $role => $label ) {
							if ( in_array( $role, $checked_roles ) ) {
								echo '<input type="checkbox" name="wpac_pages_default_restricted_to[]" checked="checked" value="' . $role . '" /> ' . $label . '<br />';
							} else {
								echo '<input type="checkbox" name="wpac_pages_default_restricted_to[]" value="' . $role . '" /> ' . $label . '<br />';
							}
						}
						?>
						<span class="description"><?php _e( 'デフォルトはすべてアクセス可能', 'wpac' ); ?></span>
					</td>
				</tr>
				
				<tr>
					<th scope="row">
						<label for="wpac_default_members_redirect"><?php _e( 'メンバー限定ページのリダイレクト先デフォルト設定', 'wpac' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php esc_attr_e( $wpac_default_members_redirect ); ?>" id="wpac_default_members_redirect" name="wpac_default_members_redirect" />
						<span class="description">
							<?php /* translators: Text in the brackets (%1$s) is a link to the default login page */ printf( __( 'デフォルトでは、サイトのログインページに転送されます。(%1$s)%2$sログインした後は元のページにリダイレクトされます。', 'wpac' ), '<a href="' . wp_login_url() . '">' . wp_login_url() . '</a>', '<br />' ); ?>
						</span>
					</td>
				</tr>
			</tbody>
		</table>
		
		<h3 class="title"><?php _e( '検索／アーカイブオプション', 'wpac' ); ?></h3>
		
		<p>
			<?php __( 'I use the wording "search" below, but these settings apply to search AND archive pages (Such as the blog page, categories and tags pages, and such). 
<strong>For example</strong>, if you wanted a blog where non-members could see post titles and excerpts but not the actual posts, set the default 
post state to Members Only, then set the Search Options to show restricted posts in search results and show post excerpts.', 'wpac' ); ?>
		</p>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<?php _e( '検索オプション', 'wpac' ); ?>
					</th>
					<td>
						<label><input type="checkbox" <?php checked( $wpac_show_posts_in_search, 1 ); ?> value="yes" name="show_posts_in_search" /> <span><?php _e( '制限された投稿を検索結果に表示', 'wpac' ); ?></span></label><br />
						<label><input type="checkbox" <?php checked( $wpac_show_post_excerpts_in_search, 1 ); ?> value="yes" name="show_post_excerpts_in_search" /> <span><?php _e( '制限された投稿の抜粋を検索結果に表示', 'wpac' ); ?></span></label><br />
						<label><input type="checkbox" <?php checked( $wpac_show_pages_in_search, 1 ); ?> value="yes" name="show_pages_in_search" /> <span><?php _e( '制限されたページを検索結果に表示', 'wpac' ); ?></span></label><br />
						<label><input type="checkbox" <?php checked( $wpac_show_page_excerpts_in_search, 1 ); ?> value="yes" name="show_page_excerpts_in_search" /> <span><?php _e( '制限されたページの抜粋を検索結果に表示', 'wpac' ); ?></span></label><br />
					</td>
				</tr>
				
				<tr>
					<th scope="row">
						<label for="post_excerpt_text"><?php _e( '検索結果の抜粋として表示する内容（投稿）', 'wpac' ); ?></label>
					</th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"><?php _e( '検索結果の抜粋として表示する内容（投稿）', 'wpac' ); ?></legend>
							
							<p>
								<label for="post_excerpt_text"><?php _e( '投稿が抜粋なしで検索結果に表示されるよう設定されている場合は、このテキストが代わりに表示されます。', 'wpac' ); ?></label>
							</p>
							
							<p>
								<textarea id="post_excerpt_text" name="post_excerpt_text" class="large-text" cols="50" rows="5"><?php echo get_option( 'wpac_post_excerpt_text', __( 'この投稿のコンテンツを見るには、認証されたアクセス権が必要です。', 'wpac' ) ); ?></textarea>
							</p>
						</fieldset>
					</td>
				</tr>
				
				<tr>
					<th scope="row">
						<label for="page_excerpt_text"><?php _e( '検索結果の抜粋として表示する内容（ページ）', 'wpac' ); ?></label>
					</th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"><?php _e( '検索結果の抜粋として表示する内容（ページ）', 'wpac' ); ?>)</legend>
							
							<p>
								<label for="page_excerpt_text"><?php _e( 'ページが抜粋なしで検索結果に表示されるよう設定されている場合は、このテキストが代わりに表示されます。', 'wpac' ); ?></label>
							</p>
							
							<p>
								<textarea id="page_excerpt_text" name="page_excerpt_text" class="large-text" cols="50" rows="5"><?php echo get_option( 'wpac_page_excerpt_text', __( 'このページのコンテンツを見るには、認証されたアクセス権が必要です。', 'wpac' ) ); ?></textarea>
							</p>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		
		<p class="submit"><input type="submit" value="<?php _e( '変更を保存', 'wpac' ); ?>" class="button-primary" id="submit" name="submit" /></p>
	</form>
</div>