<?php
/**
 * Plugin Name: アクセスコントロール
 * Plugin URI: http://brandonwamboldt.ca/plugins/members-only-menu-plugin/
 * Author: Brandon Wamboldt (日本語訳：wp365)
 * Version: 3.1.4J
 * Description: This plugin is a powerful tool which gives you fine grained control over your pages and posts (and custom post types), allowing you to restrict a page, post, or custom post type to members, non-members, or even specific roles. You can customize how these pages and posts show up in search results, where users are directed when they visit them, and much more. <strong>You can even make your entire blog members only!</strong>.
 */

add_action( 'after_setup_theme', array( 'WordPressAccessControl', 'load_custom_widgets' ) );
add_action( 'wp', array( 'WordPressAccessControl', 'check_for_members_only' ) );
add_action( 'wp', array( 'WordPressAccessControl', 'check_for_nonmembers_only' ) );
add_action( 'init', array( 'WordPressAccessControl', 'add_wpac_nav_menus' ) );
add_action( 'admin_init', array( 'WordPressAccessControl', 'admin_init' ) );
add_action( 'admin_menu', array( 'WordPressAccessControl', 'admin_menu' ) );
add_action( 'add_meta_boxes', array( 'WordPressAccessControl', 'add_wp_access_meta_boxes' ) );
add_action( 'save_post', array( 'WordPressAccessControl', 'save_postdata' ) );
add_action( 'manage_pages_custom_column', array( 'WordPressAccessControl', 'show_column' ) );

add_filter( 'get_pages', array( 'WordPressAccessControl', 'get_pages' ) );
add_filter( 'manage_edit-page_columns', array( 'WordPressAccessControl', 'add_column' ) );
add_filter( 'the_excerpt', array( 'WordPressAccessControl', 'remove_excerpt' ) );
add_filter( 'the_content', array( 'WordPressAccessControl', 'remove_excerpt' ) );
add_filter( 'plugin_row_meta', array( 'WordPressAccessControl', 'plugin_row_meta' ), 10, 5 );
add_filter( 'posts_join_paged', array( 'WordPressAccessControl', 'posts_join_paged' ), 10, 2 );
add_filter( 'posts_where_paged', array( 'WordPressAccessControl', 'posts_where_paged' ), 10, 2 );
add_filter( 'wp_nav_menu_args', array( 'WordPressAccessControl', 'wp_nav_menu_members_only' ) );

add_shortcode( 'member', array( 'WordPressAccessControl', 'shortcode_members' ) );
add_shortcode( 'members', array( 'WordPressAccessControl', 'shortcode_members' ) );
add_shortcode( 'non-members', array( 'WordPressAccessControl', 'shortcode_nonmembers' ) );
add_shortcode( 'nonmembers', array( 'WordPressAccessControl', 'shortcode_nonmembers' ) );
add_shortcode( 'non-member', array( 'WordPressAccessControl', 'shortcode_nonmembers' ) );
add_shortcode( 'nonmember', array( 'WordPressAccessControl', 'shortcode_nonmembers' ) );

// We check to see if the class exists because it isn't part of pre WordPress 3 systems
if ( class_exists( 'Walker_Nav_Menu' ) ) {
	add_filter( 'wp_nav_menu_args', array( 'WordPressAccessControl', 'wp_nav_menu_args' ) );

	/**
	 * A custom walker that checks our conditions to make sure the user has
	 * permission to view the page linked to from the menu item
	 *
	 * @author Brandon Wamboldt
	 * @package WordPress
	 * @subpackage WordPressAccessControl
	 */
	class WPAC_Nav_Menu_Walker extends Walker_Nav_Menu
	{
		var $in_private = false;
		var $private_lvl = 0;

		function start_lvl( & $output, $depth )
		{
			if ( ! $this->in_private ) {
				$indent = str_repeat( '    ', $depth );
				$output .= "\n$indent<ul class=\"sub-menu\"><li style='display:none;'></li>\n";
			}
		}

		function end_lvl( & $output, $depth )
		{
			if ( ! $this->in_private ) {
				$indent = str_repeat( '    ', $depth );
				$output .= "$indent</ul>\n";
			}
		}

		function start_el( & $output, $item, $depth, $args )
		{
			global $wp_query;

			if ( WordPressAccessControl::check_conditions( $item->object_id ) || get_option( 'wpac_show_in_menus', 'with_access' ) == 'always' ) {
				if ( ! $this->in_private ) {
					$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

					$class_names = $value = '';

					$classes = empty( $item->classes ) ? array() : (array) $item->classes;

					$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
					$class_names = ' class="' . esc_attr( $class_names ) . '"';

					$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

					$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
					$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
					$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
					$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

					$item_output = $args->before;
					$item_output .= '<a'. $attributes .'>';
					$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
					$item_output .= '</a>';
					$item_output .= $args->after;

					$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
				}
			} else {
				$this->in_private = true;
				$this->private_lvl++;
			}
		}

		function end_el( & $output, $item, $depth )
		{
			if ( WordPressAccessControl::check_conditions( $item->object_id ) || get_option( 'wpac_show_in_menus', 'with_access' ) == 'always' ) {
				if ( ! $this->in_private ) {
					$output .= "</li>\n";
				}
			} else {
				$this->private_lvl--;

				if ( $this->private_lvl == 0 ) {
					$this->in_private = false;
				}
			}
		}
	}
}

// We check to see if the class exists because it may get removed in the future
if ( class_exists( 'Walker_Page' ) ) {
	add_filter( 'wp_page_menu_args', array( 'WordPressAccessControl' , 'wp_page_menu_args' ) );

	/**
	 * A custom walker that checks our conditions to make sure the user has
	 * permission to view the page linked to from the menu item
	 *
	 * @author Brandon Wamboldt
 	 * @package WordPress
	 * @subpackage WordPressAccessControl
	 */
	class WPAC_Page_Walker extends Walker_Page
	{
		var $in_private = false;
		var $private_lvl = 0;

		function start_lvl( & $output, $depth )
		{
			if ( ! $this->in_private ) {
				$indent = str_repeat( '    ', $depth );
				$output .= "\n$indent<ul class=\"sub-menu\"><li style='display:none;'></li>\n";
			}
		}

		function end_lvl( & $output, $depth )
		{
			if ( ! $this->in_private ) {
				$indent = str_repeat( '    ', $depth );
				$output .= "$indent</ul>\n";
			}
		}

		function start_el( & $output, $page, $depth, $args, $current_page )
		{
			global $wp_query;

			if ( WordPressAccessControl::check_conditions( $page->ID ) ) {
				if ( ! $this->in_private ) {
					$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

					extract( $args, EXTR_SKIP );

					$css_class = array( 'page_item', 'page-item-' . $page->ID );

					if ( $current_page != '' ) {
						$_current_page = get_page( $current_page );

						if ( isset( $_current_page->ancestors ) && in_array( $page->ID, (array) $_current_page->ancestors ) ) {
							$css_class[] = 'current_page_ancestor';
						}

						if ( $page->ID == $current_page ) {
                            $css_class[] = 'current_page_item';
						} elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {
							$css_class[] = 'current_page_parent';
						}
					} elseif ( $page->ID == get_option('page_for_posts') ) {
						$css_class[] = 'current_page_parent';
					}

					$css_class = implode( ' ', apply_filters( 'page_css_class', $css_class, $page ) );

					$output .= $indent . '<li class="' . $css_class . '"><a href="' . get_page_link( $page->ID ) . '" title="' . esc_attr( wp_strip_all_tags( apply_filters( 'the_title', $page->post_title, $page->ID ) ) ) . '">' . $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a>';

					if ( ! empty( $show_date ) ) {
						if ( 'modified' == $show_date ) {
							$time = $page->post_modified;
						} else {
							$time = $page->post_date;
						}

						$output .= ' ' . mysql2date( $date_format, $time );
					}
				}
			} else {
				$this->in_private = true;
				$this->private_lvl++;
            }
		}

		function end_el( & $output, $page, $depth )
		{
			if ( WordPressAccessControl::check_conditions( $page->ID ) ) {
				if ( ! $this->in_private ) {
					$output .= "</li>\n";
				}
			} else {
				$this->private_lvl--;

				if ( $this->private_lvl == 0 ) {
					$this->in_private = false;
				}
			}
		}
	}
}

/**
 * The main plugin
 *
 * @author Brandon Wamboldt
 * @package WordPress
 * @subpackage WordPressAccessControl
 */
class WordPressAccessControl
{
	function admin_init()
	{
		wp_enqueue_style( 'wpac-style', plugin_dir_url( __FILE__ ) . 'public/css/wpac.css' );

		// Load translation files
		if ( ! load_plugin_textdomain( 'wpac' ) ) {
			load_plugin_textdomain( 'wpac', false, 'wordpress-access-control/languages/' );
		}
	}

	function admin_menu()
	{
		add_options_page( 'WordPress Access Control Settings', 'アクセスコントロール', 'manage_options', 'wpac-options', array( 'WordPressAccessControl', 'options_page' ) );
	}

	function options_page()
	{
		// Save options?
		if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'update' ) {
			if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'wpac_options_save' ) ) {
				$admin_error = __( 'セキュリティチェックが失敗しました。もう一度トライしてください。', 'wpac' );
			} else {

				// Make the blog members only
				if ( isset( $_REQUEST['wpac_members_only_blog'] ) && $_REQUEST['wpac_members_only_blog'] == 'yes' ) {
					update_option( 'wpac_members_only_blog', true );
				} else {
					update_option( 'wpac_members_only_blog', false );
				}

				// Members blog redirect link
				if ( isset( $_REQUEST['wpac_members_blog_redirect'] ) ) {
					update_option( 'wpac_members_blog_redirect', esc_url( $_REQUEST['wpac_members_blog_redirect'] ) );
				} else {
					delete_option( 'wpac_members_blog_redirect' );
				}

				// Support custom post types
				if ( isset( $_REQUEST['wpac_custom_post_types'] ) && is_array( $_REQUEST['wpac_custom_post_types'] ) ) {
					update_option( 'wpac_custom_post_types', $_REQUEST['wpac_custom_post_types'] );
				} else {
					delete_option( 'wpac_custom_post_types' );
				}

				// Override per-page permissions
				if ( isset( $_REQUEST['wpac_always_accessible_by'] ) && is_array( $_REQUEST['wpac_always_accessible_by'] ) ) {
					$wpac_always_accessible_by = array();

					foreach ( $_REQUEST['wpac_always_accessible_by'] as $role ) {
						$wpac_always_accessible_by[] = $role;
					}

					update_option( 'wpac_always_accessible_by', $wpac_always_accessible_by );
				} else {
					update_option( 'wpac_always_accessible_by', array() );
				}

				// Show in the menu settings
				if ( isset( $_REQUEST['wpac_show_in_menus'] ) && $_REQUEST['wpac_show_in_menus'] == 'always' ) {
					update_option( 'wpac_show_in_menus', 'always' );
				} else {
					update_option( 'wpac_show_in_menus', 'with_access' );
				}

				// Default post state setting
				if ( isset( $_REQUEST['default_post_state'] ) && in_array( $_REQUEST['default_post_state'], array( 'public', 'members', 'nonmembers' ) ) ) {
					update_option( 'wpac_default_post_state', $_REQUEST['default_post_state'] );
				} else {
					update_option( 'wpac_default_post_state', 'public' );
				}

				// Default post roles
				if ( isset( $_REQUEST['wpac_posts_default_restricted_to'] ) && is_array( $_REQUEST['wpac_posts_default_restricted_to'] ) ) {
					update_option( 'wpac_posts_default_restricted_to', $_REQUEST['wpac_posts_default_restricted_to'] );
				} else {
					update_option( 'wpac_posts_default_restricted_to', array() );
				}

				// Default page state setting
				if ( isset( $_REQUEST['default_page_state'] ) && in_array( $_REQUEST['default_page_state'], array( 'public', 'members', 'nonmembers' ) ) ) {
					update_option( 'wpac_default_page_state', $_REQUEST['default_page_state'] );
				} else {
					update_option( 'wpac_default_page_state', 'public' );
				}

				// Default page roles
				if ( isset( $_REQUEST['wpac_pages_default_restricted_to'] ) && is_array( $_REQUEST['wpac_pages_default_restricted_to'] ) ) {
					update_option( 'wpac_pages_default_restricted_to', $_REQUEST['wpac_pages_default_restricted_to'] );
				} else {
					update_option( 'wpac_pages_default_restricted_to', array() );
				}

				// Default redirect
				if ( isset( $_REQUEST['wpac_default_members_redirect'] ) && ! empty( $_REQUEST['wpac_default_members_redirect'] ) ) {
					update_option( 'wpac_default_members_redirect', $_REQUEST['wpac_default_members_redirect'] );
				} else {
					update_option( 'wpac_default_members_redirect', '' );
				}

				// Search Options
				if ( isset( $_REQUEST['show_posts_in_search'] ) && $_REQUEST['show_posts_in_search'] == 'yes' ) {
					update_option( 'wpac_show_posts_in_search', true );
				} else {
					update_option( 'wpac_show_posts_in_search', false );
				}

				if ( isset( $_REQUEST['show_post_excerpts_in_search'] ) && $_REQUEST['show_post_excerpts_in_search'] == 'yes' ) {
					update_option( 'wpac_show_post_excerpts_in_search', true );
				} else {
					update_option( 'wpac_show_post_excerpts_in_search', false );
				}

				if ( isset( $_REQUEST['show_pages_in_search'] ) && $_REQUEST['show_pages_in_search'] == 'yes' ) {
					update_option( 'wpac_show_pages_in_search', true );
				} else {
					update_option( 'wpac_show_pages_in_search', false );
				}

				if ( isset( $_REQUEST['show_page_excerpts_in_search'] ) && $_REQUEST['show_page_excerpts_in_search'] == 'yes' ) {
					update_option( 'wpac_show_page_excerpts_in_search', true );
				} else {
					update_option( 'wpac_show_page_excerpts_in_search', false );
				}

				// Custom excerpts
				if ( isset( $_REQUEST['page_excerpt_text'] ) ) {
					update_option( 'wpac_page_excerpt_text', $_REQUEST['page_excerpt_text'] );
				}

				if ( isset( $_REQUEST['post_excerpt_text'] ) ) {
					update_option( 'wpac_post_excerpt_text', $_REQUEST['post_excerpt_text'] );
				}

				$admin_message = '<strong>' . __( '設定が保存されました。') . '</strong>';
			}
		}

		include( dirname( __FILE__ ) . '/templates/options.php' );
	}

	function add_column( $columns )
	{
		$columns['wpac'] = '<img src="' . plugin_dir_url( __FILE__ ) . 'public/images/lock.png" alt="Access" />';
		return $columns;
	}

	function show_column( $name )
	{
		global $post;

		switch ( $name ) {
			case 'wpac':
				if ( get_post_meta( $post->ID, '_wpac_is_members_only', true ) ) {
					echo '<img src="' . plugin_dir_url( __FILE__ ) . 'public/images/lock.png" alt="Members Only" title="Members Only" />';
				} else if ( get_post_meta( $post->ID, '_wpac_is_nonmembers_only', true ) ) {
					echo '<img src="' . plugin_dir_url( __FILE__ ) . 'public/images/unlock.png" alt="Non-members Only" title="Non-members Only" />';
				}

				break;
		}
	}

	function check_conditions( $page_id )
	{
		global $wp_roles, $current_user;

		if ( is_user_logged_in() ) {
			get_currentuserinfo();

			$allowed_roles  = maybe_unserialize( get_post_meta( $page_id, '_wpac_restricted_to', true ) );
			$override_roles = maybe_unserialize( get_option( 'wpac_always_accessible_by', array( 0 => 'administrator' ) ) );

			if ( empty( $allowed_roles ) ) {
				$allowed_roles_tmp = $wp_roles->get_names();
				$allowed_roles = array();

				foreach ( $allowed_roles_tmp as $role => $garbage ) {
					$allowed_roles[] = $role;
				}
			}

			$intersections = array_intersect( $current_user->roles, $allowed_roles );
			$override_intersections = array_intersect( $current_user->roles, $override_roles );

			if ( empty( $intersections ) && empty( $override_intersections ) ) {
				$role = false;
			} else {
				$role = true;
			}
		} else {
			$role = true;
		}

		$is_members_only = get_post_meta( $page_id, '_wpac_is_members_only', true );
		$is_nonmembers_only = get_post_meta( $page_id, '_wpac_is_nonmembers_only', true );

		if ( ( is_user_logged_in() && $is_members_only && $role ) || ( ! is_user_logged_in() && $is_nonmembers_only ) || ( ! $is_members_only && ! $is_nonmembers_only ) ) {
			return true;
		} else {
			return false;
		}
	}

	function check_for_members_only()
	{
		global $post;

		if ( is_admin() ) return;

		// Check for a members only blog
		$blog_is_members_only = get_option( 'wpac_members_only_blog', false );

		if ( $blog_is_members_only && ! is_user_logged_in() ) {
			$redirect_to = get_option( 'wpac_members_blog_redirect', wp_login_url( $_SERVER['REQUEST_URI'] ) );

			if ( empty( $redirect_to ) ) {
				$redirect_to = wp_login_url( $_SERVER['REQUEST_URI'] );
			}

			header( 'Location: ' . add_query_arg( 'redirect_to', $_SERVER['REQUEST_URI'], $redirect_to ) );
			exit();
		}

		if ( get_post_meta( $post->ID, '_wpac_is_members_only', true ) && ! WordPressAccessControl::check_conditions( $post->ID ) ) {
			if ( is_singular() ) {
				$redirect_to = get_post_meta( $post->ID, '_wpac_members_redirect_to', true );

				if ( empty( $redirect_to ) ) {
					header( 'Location: ' . get_bloginfo( 'wpurl' ) . '/wp-login.php?redirect_to=' . $_SERVER['REQUEST_URI'] );
				} else {
					header( 'Location: ' . add_query_arg( 'redirect_to', $_SERVER['REQUEST_URI'], $redirect_to ) );
				}

				exit();
			}
		}
	}

	function check_for_nonmembers_only()
	{
		if ( is_admin() ) return;

		global $post;

		if ( get_post_meta( $post->ID, '_wpac_is_nonmembers_only', true ) && ! WordPressAccessControl::check_conditions( $post->ID ) ) {
			$redirect_to = get_post_meta( $post->ID, '_wpac_nonmembers_redirect_to', true );

			if ( empty( $redirect_to ) ) {
				header( 'Location: ' . get_bloginfo( 'wpurl' ) . '/index.php' );
			} else {
				header( 'Location: ' . $redirect_to );
			}

			exit();
		}
	}

	function remove_excerpt( $excerpt )
	{
		if ( is_admin() || is_single() ) return $excerpt;

		global $post;

		if ( get_post_meta( $post->ID, '_wpac_is_members_only', true ) && ! WordPressAccessControl::check_conditions( $post->ID ) ) {
			$show_excerpt = get_post_meta( $post->ID, '_wpac_show_excerpt_in_search', true );

			if ( ! is_singular() && $show_excerpt != 'yes' ) {
				if ( $post->post_type == 'post' ) {
					$excerpt = get_option( 'wpac_post_excerpt_text', __( 'この投稿のコンテンツを見るには、認証されたアクセス権が必要です。', 'wpac' ) );
				} else {
					$excerpt = get_option( 'wpac_page_excerpt_text', __( 'このページのコンテンツを見るには、認証されたアクセス権が必要です。', 'wpac' ) );
				}

				return wpautop( $excerpt );
			} else {
				return $excerpt;
			}
		}

		return $excerpt;
	}

	function posts_join_paged( $join, $query )
	{
		global $wpdb;

		if ( is_admin() ) return $join;

		if ( ! is_singular() && ! is_admin() ) {
			$join .= " LEFT JOIN {$wpdb->postmeta} PMWPAC3 ON PMWPAC3.post_id = {$wpdb->posts}.ID AND PMWPAC3.meta_key = '_wpac_show_in_search' LEFT JOIN {$wpdb->postmeta} PMWPAC ON PMWPAC.post_id = {$wpdb->posts}.ID AND PMWPAC.meta_key = '_wpac_is_members_only' LEFT JOIN {$wpdb->postmeta} PMWPAC2 ON PMWPAC2.post_id = {$wpdb->posts}.ID AND PMWPAC2.meta_key = '_wpac_is_nonmembers_only' ";
		}

		return $join;
	}

	function posts_where_paged( $where, $query )
	{
		global $wpdb;

		if ( is_admin() ) return $where;

		if ( ! is_singular() && ! is_admin() ) {
			if ( ! is_user_logged_in() ) {
				$where .= " AND ( PMWPAC.meta_value IS NULL OR PMWPAC3.meta_value = '1' OR PMWPAC.meta_value != 'true' ) ";
			} else {
				$where .= " AND ( PMWPAC2.meta_value IS NULL OR PMWPAC2.meta_value != 'true' ) ";
			}
		}

		return $where;
	}

	function remove_restricted_posts( $posts, $query = false )
	{
		return $posts;
		echo $query->request;exit();

		if ( ! is_singular() && ! is_admin() ) {
			$new_posts = array();

			foreach ( $posts as $post ) {
				// The page is members only and we do NOT have access to it
				if ( get_post_meta( $post->ID, '_wpac_is_members_only', true ) && ! WordPressAccessControl::check_conditions( $post->ID ) ) {
					if ( get_post_meta( $post->ID, '_wpac_show_in_search', true ) != 1 ) {
						continue;
					}
				}

				// The page is non-members only and we do NOT have access to it
				if ( get_post_meta( $post->ID, '_wpac_is_nonmembers_only', true ) && ! WordPressAccessControl::check_conditions( $post->ID ) ) {
					if ( get_post_meta( $post->ID, '_wpac_show_in_search', true ) != 1 ) {
						continue;
					}
				}

				// Remove results where the search term is in a [member] or [nonmember] tag and we don't have access
				$st = get_search_query();
				$content = do_shortcode( $post->post_content );


				if ( ! empty( $st ) && is_search() && ! stristr( $content, $st ) ) {
					continue;
				}

				$new_posts[] = $post;
			}

			$query->found_posts   = count( $new_posts );
			$query->max_num_pages = ceil( count( $new_posts ) / $query->query_vars['posts_per_page'] );
			$query->posts         = $new_posts;
			$query->post_count    = count( $new_posts );

			return $new_posts;
		}

		return $posts;
	}

	/**
	 * Add our custom meta box to all support post types
	 *
	 * @since WordPress Access Control 2.0
	 * @author Brandon Wamboldt <brandon.wamboldt@gmail.com>
	 */
	function add_wp_access_meta_boxes()
	{
		$enabled_post_types = get_option( 'wpac_custom_post_types', array() );
		$supported_pages = apply_filters( 'wp_access_supported_pages', array_merge( array( 'page', 'post' ), $enabled_post_types ) );

		foreach ( $supported_pages as $page_type ) {
			add_meta_box( 'wpac_controls_meta', 'アクセスコントロール', array( 'WordPressAccessControl', 'add_wpac_meta_box' ), $page_type, 'side', 'high' );
		}
	}

	/**
	 * Display the various per-page/per-post options in the sidebar
	 *
	 * @since WordPress Access Control 2.0
	 * @author Brandon Wamboldt <brandon.wamboldt@gmail.com>
	 */
	function add_wpac_meta_box()
	{
		global $post;

		$is_members_only = get_post_meta( $post->ID, '_wpac_is_members_only', true );
		$is_nonmembers_only = get_post_meta( $post->ID, '_wpac_is_nonmembers_only', true );

		if ( $post->post_type == 'post' ) {
			$wpac_default_post_state = get_option( 'wpac_default_post_state', 'public' );
		} else {
			$wpac_default_post_state = get_option( 'wpac_default_page_state', 'public' );
		}

		if ( $is_members_only == 'true' || ( $post->post_status == 'auto-draft' && $wpac_default_post_state == 'members' ) ) {
			$is_members_only = 'checked="checked"';
		}

		if ( $is_nonmembers_only == 'true' || ( $post->post_status == 'auto-draft' && $wpac_default_post_state == 'nonmembers' ) ) {
			$is_nonmembers_only = 'checked="checked"';
		}

		$wpac_show_in_search = get_post_meta( $post->ID, '_wpac_show_in_search', true );
		$wpac_show_excerpt_in_search = get_post_meta( $post->ID, '_wpac_show_excerpt_in_search', true );
		$pass_to_children = get_post_meta( $post->ID, '_wpac_pass_to_children', true );

		include( dirname( __FILE__ ) . '/templates/meta_box.php' );
	}

	/**
	 * Saves our custom meta data for the post being saved
	 *
	 * @since WordPress Access Control 2.0
	 * @author Brandon Wamboldt <brandon.wamboldt@gmail.com>
	 */
	function save_postdata( $post_id )
	{
		// Security check
		if ( ! isset( $_POST['members_only_nonce'] ) ) {
			return $post_id;
		}

		if ( ! wp_verify_nonce( $_POST['members_only_nonce'], 'members_only' ) ) {
			return $post_id;
		}

		// Meta data isn't transmitted during autosaves so don't do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if ( isset( $_POST['members_only'] ) && $_POST['members_only'] == 'true' ) {
			update_post_meta( $post_id, '_wpac_is_members_only', 'true' );

			if ( isset( $_POST['wpac_restricted_to'] ) && ! empty( $_POST['wpac_restricted_to'] ) ) {
				update_post_meta( $post_id, '_wpac_restricted_to', serialize( $_POST['wpac_restricted_to'] ) );
			} else {
				delete_post_meta( $post_id, '_wpac_restricted_to' );
			}
		} else {
			delete_post_meta( $post_id, '_wpac_is_members_only' );
		}

		if ( isset( $_POST['nonmembers_only'] ) && $_POST['nonmembers_only'] == 'true' ) {
			update_post_meta( $post_id, '_wpac_is_nonmembers_only', 'true' );
		} else {
			delete_post_meta( $post_id, '_wpac_is_nonmembers_only' );
		}

		if ( isset( $_POST['wpac_members_redirect_to'] ) ) {
			update_post_meta( $post_id, '_wpac_members_redirect_to', $_POST['wpac_members_redirect_to'] );
		}

		if ( isset( $_POST['wpac_show_in_search'] ) ) {
			update_post_meta( $post_id, '_wpac_show_in_search', 1 );
		} else {
			update_post_meta( $post_id, '_wpac_show_in_search', 0 );
		}

		if ( isset( $_POST['wpac_show_excerpt_in_search'] ) ) {
			update_post_meta( $post_id, '_wpac_show_excerpt_in_search', 1 );
		} else {
			update_post_meta( $post_id, '_wpac_show_excerpt_in_search', 0 );
		}

		if ( isset( $_POST['wpac_nonmembers_redirect_to'] ) ) {
			update_post_meta( $post_id, '_wpac_nonmembers_redirect_to', $_POST['wpac_nonmembers_redirect_to'] );
		}

		if ( isset( $_POST['pass_to_children'] ) && $_POST['pass_to_children'] == 'true' ) {
			update_post_meta( $post_id, '_wpac_pass_to_children', 'true' );

			$original_id = $post_id;
			$is_revision = wp_is_post_revision( $original_id );

			if ( $is_revision ) {
				$original_id = $is_revision;
			}

			$children = get_pages( array( 'child_of' => $original_id ) );

			foreach ( $children as $child ) {
				WordPressAccessControl::save_postdata( $child->ID );
			}
		} else {
			delete_post_meta( $post_id, '_wpac_pass_to_children' );
		}

		return $post_id;
	}

	/**
	 * Replaces the default WordPress nav menu walker with our own version
	 *
	 * @param array $args The arguments passed to the wp_nav_menu function
	 *
	 * @return array The original arguments, with our custom walker instead of the default
	 *
	 * @since WordPress Access Control 1.1
	 * @author Brandon Wamboldt <brandon.wamboldt@gmail.com>
	 */
	function wp_nav_menu_args( $args )
	{
		$args['walker'] = new WPAC_Nav_Menu_Walker();
		return $args;
	}

	/**
 	 * Prevents the code from degrading terribly when no nav menu is available
	 *
	 * @param array $args The arguments passed to the wp_nav_menu function
	 *
	 * @return array The original arguments, possible with our custom walker instead of the default
	 *
	 * @since WordPress Access Control 1.2
	 * @author Brandon Wamboldt <brandon.wamboldt@gmail.com>
	 */
	function wp_page_menu_args( $args )
	{
		// Only remove the walker if it is ours
		if ( isset( $args['walker'] ) && get_class( $args['walker']) == 'WPAC_Nav_Menu_Walker' ) {
			$args['walker'] = new WPAC_Page_Walker();
		}

		return $args;
	}

	/**
	 * This hooks in at a higher level to make sure functions like wp_list_pages
	 * won't return members only pages.
	 *
	 * @param array $pages
	 * @return array
	 *
	 * @since WordPress Access Control 1.6.4
	 * @author Brandon Wamboldt <brandon.wamboldt@gmail.com>
	 */
	function get_pages( $pages )
	{
		// Don't affect the display of pages when viewing the list in the admin
		if ( is_admin() ) {
			return $pages;
		}

		// Whether or not the user is logged in
		$auth = is_user_logged_in();

		// Go through each page, remove ones we can't see
		foreach ( $pages as $key => $page ) {
			$is_members_only = get_post_meta( $page->ID, '_wpac_is_members_only', true );
			$is_nonmembers_only = get_post_meta( $page->ID, '_wpac_is_nonmembers_only', true );

			if ( $is_members_only && ! $auth ) {
				unset( $pages[$key] );
			}

			if ( $is_nonmembers_only && $auth ) {
				unset( $pages[$key] );
			}
		}

		return $pages;
	}

	/**
	 * Adds links to the plugin row to view the options page or view the plugin
	 * documentation.
	 *
	 * @param array $plugin_meta The links to display in the plugin row
	 * @param string $plugin_file The directory name and filename of the plugin (wordpress-access-control/wordpress-access-control.php)
	 * @param array $plugin_data
	 * @param string $status The status of the plugin (active or inactive)
	 *
	 * @return array The $plugin_meta array of links for this plugin
	 *
	 * @uses plugin_dir_url() to get the URL of the plugin directory since that is where the documentation is
	 *
	 * @since WordPress Access Control 3.0
	 * @author Brandon Wamboldt <brandon.wamboldt@gmail.com>
	 */
	function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status )
	{
		if ( $plugin_file == str_replace( '.php', '/', basename( __FILE__ ) ) . basename( __FILE__ ) ) {
			$plugin_meta[] = '<a href="options-general.php?page=wpac-options">' . __( '設定', 'wpac' ) . '</a>';
			$plugin_meta[] = '<a href="' . plugin_dir_url( __FILE__ ) . 'documentation/index.html">' . __( 'オンラインマニュアル', 'wpac' ) . '</a>';
		}

		return $plugin_meta;
	}


	/**
	 * Hides content for users that are not logged in and displays content for
	 * users who are logged in. Calls do_shortcode on the content to allow
	 * nested shortcodes.
	 *
	 * @uses is_user_logged_in() to determine if the user is logged in or not
	 * @uses wpautop() to format the text in the shortcodes
	 * @uses do_shortcode() to execute nested shortcodes in our shortcode
	 *
	 * @since WordPress Access Control 3.0
	 * @author Brandon Wamboldt <brandon.wamboldt@gmail.com>
	 */
	function shortcode_members( $attributes, $content = NULL )
	{
		global $current_user, $post;

		if ( is_user_logged_in() ) {
            if (isset($attributes['role'])) {

                // Determine the syntax (Singular role, OR syntax or NOT syntax)
                if (substr($attributes['role'], 0, 3) == 'or:') {
                    $roles = explode(',', substr($attributes['role'], 3));

                    $has_a_role = false;

                    foreach ($roles as $role) {
                        if (in_array($role, $current_user->roles)) {
                            $has_a_role = true;
                            break;
                        }
                    }

                    if (!$has_a_role) {
                        return '';
                    }
                } else if (substr($attributes['role'], 0, 4) == 'not:') {
                    $roles = explode(',', substr($attributes['role'], 4));

                    foreach ($roles as $role) {
                        if (in_array($role, $current_user->roles)) {
                            return '';
                        }
                    }
                } else {
                    if (!in_array($attributes['role'], $current_user->roles)) {
                        return '';
                    }
                }
            }

			return wpautop( do_shortcode( $content ) );
		}

		return '';
	}

	/**
	 * Hides content for users that are logged in and displays content for users
	 * who are not logged in. Calls do_shortcode on the content to allow nested
	 * shortcodes.
	 *
	 * @uses is_user_logged_in() to determine if the user is logged in or not
	 * @uses wpautop() to format the text in the shortcodes
	 * @uses do_shortcode() to execute nested shortcodes in our shortcode
	 *
	 * @since WordPress Access Control 3.0
	 * @author Brandon Wamboldt <brandon.wamboldt@gmail.com>
	 */
	function shortcode_nonmembers( $attributes, $content = NULL )
	{
		global $post;

		if ( ! is_user_logged_in() ) {
			return wpautop( do_shortcode( $content ) );
		}

		return '';
	}

	/*
	 * Loads a file that will override certain WordPress default widgets with
	 * a slightly modified version that allows admins to select it's visibility
	 * (Members only or non members only).
	 *
	 * @author Brandon Wamboldt <brandon.wamboldt@gmail.com>
	 * @since WordPress Access Control 3.1
	 */
	function load_custom_widgets()
	{
		require( dirname( __FILE__ ) . '/default-widgets.php' );
	}

	/**
	 * Adds our member only menus for each regular menu
	 *
	 * @author Brandon Wamboldt <brandon.wamboldt@gmail.com>
	 * @since WordPress Access Control 3.1
	 */
	function add_wpac_nav_menus()
	{
		global $_wp_registered_nav_menus;

		$original = (array) $_wp_registered_nav_menus;

		foreach ( $original as $location => $label ) {
			$_wp_registered_nav_menus[$location . '_wpac'] = $label . ' - Members Only';
		}
	}

	/**
	 * Checks to see if a members only version of the current menu is available
	 * and will load that instead of the normal menu.
	 *
	 * @param array $args The arguments passed to the wp_nav_menu function
	 *
	 * @return array The original arguments, possible with a new value for theme_location
	 *
	 * @uses is_user_logged_in() to determine if the user is logged in
	 * @uses get_nav_menu_locations() to get a list of valid theme locations
	 * @uses wp_get_nav_menu_object() to get our custom members only menu
	 *
	 * @author Brandon Wamboldt <brandon.wamboldt@gmail.com>
	 * @since WordPress Access Control 3.1
	 */
	function wp_nav_menu_members_only( $args )
	{
		// Don't do anything if the user isn't logged in
		if ( is_user_logged_in() ) {

			// See if the theme even passed a proper menu ID
			if ( ! empty( $args['theme_location'] ) ) {

				// Member only menus end in _wpac
				$theme_location = $args['theme_location'] . '_wpac';

				// Get the nav menu based on the theme_location
				if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $theme_location ] ) ) {
					$menu = wp_get_nav_menu_object( $locations[ $theme_location ] );

					// Only use the member only menu if it's not empty
					if ( $menu && $menu->count > 0 ) {
						$args['theme_location'] = $theme_location;
					}
				}
			}
		}

		return $args;
	}
}
