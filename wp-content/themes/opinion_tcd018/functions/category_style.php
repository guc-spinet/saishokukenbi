<?php
     $categories = get_categories();
     foreach($categories as $category) {
       $category_id = $category->term_id;
       $cat_data = get_option("cat_$category_id");
       if (!empty($cat_data['color1'])){
         echo '.pc #global_menu ul li.menu-category-' . $category_id . ' a { background:#' . $cat_data['color1'] . "; } ";
         echo '.pc #global_menu ul li.menu-category-' . $category_id . ' a:hover { background:#' . $cat_data['color2'] . "; } ";
         echo '.flex-control-nav p span.category-link-' . $category_id . ' { color:#' . $cat_data['color1'] . "; } ";
         echo '#index-category-post-' . $category_id . ' .headline1 { border-left:5px solid #' . $cat_data['color1'] . "; } ";
         echo '#index-category-post-' . $category_id . ' a:hover { color:#' . $cat_data['color1'] . "; } ";
         echo '.category-' . $category_id . ' a:hover { color:#' . $cat_data['color1'] . "; } ";
         echo '.category-' . $category_id . ' .archive_headline { background:#' . $cat_data['color1'] . "; } ";
         echo '.category-' . $category_id . ' #post_list a:hover { color:#' . $cat_data['color1'] . "; } ";
         echo '.category-' . $category_id . ' .post a { color:#' . $cat_data['color1'] . "; } ";
         echo '.category-' . $category_id . ' .post a:hover { color:#' . $cat_data['color2'] . "; } ";
         echo '.category-' . $category_id . ' .page_navi a:hover { color:#fff; background:#' . $cat_data['color1'] . "; } ";
         echo '.category-' . $category_id . ' #guest_info input:focus { border:1px solid #' . $cat_data['color1'] . "; } ";
         echo '.category-' . $category_id . ' #comment_textarea textarea:focus { border:1px solid #' . $cat_data['color1'] . "; } ";
         echo '.category-' . $category_id . ' #submit_comment:hover { background:#' . $cat_data['color1'] . "; } ";
         echo '.category-' . $category_id . ' #previous_next_post a:hover { background-color:#' . $cat_data['color1'] . "; } ";
         echo '.category-' . $category_id . ' #single_author_link:hover { background-color:#' . $cat_data['color1'] . "; } ";
         echo '.category-' . $category_id . ' #single_author_post li li a:hover { color:#' . $cat_data['color1'] . "; } ";
         echo '.category-' . $category_id . ' #post_pagination a:hover { background-color:#' . $cat_data['color1'] . "; } ";
         echo '.category-' . $category_id . ' #single_title h2 { background:#' . $cat_data['color1'] . "; } \n";
         echo '.category-' . $category_id . ' .author_social_link li.author_link a { background-color:#' . $cat_data['color1'] . "; } ";
         echo '.category-' . $category_id . ' .author_social_link li.author_link a:hover { background-color:#' . $cat_data['color2'] . "; } ";
       };
     };
?>