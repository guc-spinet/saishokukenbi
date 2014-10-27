<div id="side_col"<?php if (!has_nav_menu('global-menu')) { echo ' class="no_global_menu"'; }; ?>>

   <h2>人気講師ランキング</h2>
        <?php $args = array('post_type' => 'detailed_information', 'posts_per_page' => 10);
           $detailed_information = new WP_Query($args);
           if ($detailed_information -> have_posts()) : while ($detailed_information -> have_posts()) : $detailed_information -> the_post();
        ?>
         <div class="teacher_ranking">
             <?php 
             $user_top_id = get_the_ID(); 
             $post = get_post($user_top_id);
            if ($post){
            $author = get_userdata($post->post_author);
            $post_user_id = $author->ID;
            $post_user_name = $author->user_login;
            $url = get_permalink( $post->ID);
            $link = mb_substr($url, 0, -1, "UTF-8");
            }
             ?>
             <a href="<?php echo $link.'?para1='.$post_user_id.'&para2='.$post_user_name; ?>">
             <?php if ( has_post_thumbnail()) { echo the_post_thumbnail(); } else { echo '<img src="'; bloginfo('template_url'); echo '/img/common/no_image2.jpg" alt="" title="" />'; }; ?>
             <p><?php  echo $author->display_name ;?></p>
             </a>
         </div>
      <?php  endwhile; endif; wp_reset_query;?>

</div>