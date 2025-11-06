<?php
/**
* Content Single
*/
$prev_post = get_previous_post();
$next_post = get_next_post();


$image_size = 'tonsberg_news_shortcode_1300x700';
$cols = 'col-md-12 col-sm-12';

// BEGIN_WP5
$select_post_layout = get_post_meta( get_the_ID(), 'select_post_layout', true );
$select_post_sidebar = get_post_meta( get_the_ID(), 'select_post_sidebar', true );
$sidebar = 'sidebar-1';
if ( function_exists('modeltheme_framework')) {
    if (isset($select_post_sidebar) && $select_post_sidebar != '') {
        $sidebar = $select_post_sidebar;
    }else{
        $sidebar = tonsberg_redux('mt_single_blog_layout_sidebar');
    }
}
$cols = 'col-md-12 col-sm-12';
$sidebars_lr_meta = array("left-sidebar", "right-sidebar");
if (isset($select_post_layout) && in_array($select_post_layout, $sidebars_lr_meta)) {
    $cols = 'col-md-8 col-sm-8 status-meta-sidebar';
}elseif(isset($select_post_layout) && $select_post_layout == 'no-sidebar'){
    $cols = 'col-md-12 col-sm-12 status-meta-fullwidth';
}else{
    if(class_exists( 'ReduxFrameworkPlugin' )){
        $sidebars_lr_panel = array("mt_single_blog_left_sidebar", "mt_single_blog_right_sidebar");
        if (in_array(tonsberg_redux('mt_single_blog_layout'), $sidebars_lr_panel)) {
            $cols = 'col-md-8 col-sm-8 status-panel-sidebar';
        }else{
            $cols = 'col-md-12 col-sm-12 status-panel-no-sidebar';
        }
    }
}
if (!is_active_sidebar($sidebar)) {
    $cols = "col-md-12";
}
// END_WP5

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
    <div class="container">
       <div class="row">

            <?php // BEGIN_WP5 ?>
            <?php if (isset($select_post_layout) && $select_post_layout == 'left-sidebar') { ?>
                <div class="col-md-4 col-sm-4 sidebar-content sidebar-left">
                    <?php if (is_active_sidebar($sidebar)) { ?>
                        <?php dynamic_sidebar($sidebar); ?>
                    <?php } ?>
                </div>
            <?php }else{ ?>
                <?php if (isset($select_post_layout) && $select_post_layout == 'inherit') { ?>
                    <?php if(class_exists( 'ReduxFrameworkPlugin' )){ ?>
                        <?php if ( tonsberg_redux('mt_single_blog_layout') == 'mt_single_blog_left_sidebar') { ?>
                            <div class="col-md-4 col-sm-4 sidebar-content sidebar-left">
                                <?php if (is_active_sidebar($sidebar)) { ?>
                                    <?php dynamic_sidebar($sidebar); ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <?php // END_WP5 ?>

            <!-- POST CONTENT -->
            <div class="<?php echo esc_attr($cols); ?> main-content">

                <div class="content">

	                <!-- HEADER -->
	                <div class="article-header">
	                    <div class="article-details">

	                        <?php 
                            // MAIN FEATURED IMAGE
                            $feature_image = '';
                            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), esc_html($image_size) ); 
	                        if($thumbnail_src) {
                                echo '<img class="main-featured-image" src="'.esc_url($thumbnail_src[0]).'" alt="'.esc_attr(the_title_attribute( 'echo=0' )).'" /> ';
                            } else {
                                $feature_image = 'no_feature_image';
                            } ?>

	                        <div class="clearfix"></div>
	                    </div>
	                </div>
	                <!-- CONTENT -->
	                <div class="article-content <?php echo esc_attr($feature_image); ?>">

	                	<div class="post-category-comment-date">

                            <?php if (get_the_tags()) { ?>
                                <span class="single-post-tags">
                                    <?php echo wp_kses_post(get_the_term_list( get_the_ID(), 'post_tag', '', '' )); ?>
                                </span>
                            <?php } ?>

                        </div>

                        <h2 class="post-title">
                            <?php echo esc_html(get_the_title()); ?>
                        </h2>
                        <div class="post-content">
	                    <?php the_content(); ?>
                        </div>

                        <div class="clearfix"></div>

                        <div class="post-details-bottom row">

	                        <div class="post-category-comment-date col-md-6">

	                        	<span class="post-author">
                                    <i class="fa fa-user"></i><a class="name" href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) )); ?>"><?php echo get_the_author(); ?></a>
                                </span>

	                            <span class="post-date">
	                                 <i class="fa fa-calendar"></i><span class="post-date-list"><?php echo esc_html(get_the_date()); ?></span>
	                            </span>

	                            <span class="post-categories">
	                                <i class="fa fa-tags"></i><?php echo wp_kses_post(get_the_term_list( get_the_ID(), 'category', '', ' | ' )); ?>
	                            </span> 

	                        </div>

	                        <div class="single-post-share col-md-6">
                                
	                            <?php
	                                if(function_exists('modeltheme_framework')){ ?>

                                        <span class="share-article"><?php echo esc_html__(' Share article ','tonsberg'); ?></span>

	                                    <?php echo do_shortcode('[mt_sharer tooltip_placement="top"]');  ?>
	                                <?php }
	                            ?>
		                    </div>

	                    </div>

	                    <div class="clearfix"></div>

	                    <?php
	                        wp_link_pages( array(
	                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'tonsberg' ),
	                            'after'  => '</div>',
	                        ) );
	                    ?>
	                    <div class="clearfix"></div>


	                    <!-- AUTHOR BIO -->
	                    <?php if ( tonsberg_redux('mt_enable_authorbio') ) { ?>

	                        <?php   
	                        $avatar = get_avatar( get_the_author_meta('email'), '120', get_the_author() );
	                        $has_image = '';
	                        if( $avatar !== false ) {
	                            $has_image .= 'no-author-pic';
	                        }
	                        ?>
	                        
	                        <div class="author-bio relative <?php echo esc_attr($has_image); ?>">
	                            <div class="author-thumbnail">
                                    <div class="pull-left">
                                        <div class="author-avatar"><?php echo wp_kses_post($avatar); ?></div>
                                    </div>
	                                <div class="col-md-10">
	                                    <div class="author-name">
	                                        <span class="author"><?php echo esc_html__('Written by ','tonsberg'); ?></span>
                                            <a class="name" href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) )); ?>"><?php echo get_the_author(); ?></a>
	                                    </div>
                                        <div class="author-description">
                                            <p><?php the_author_meta('description'); ?></p>
                                        </div>
	                                </div>
	                            </div>	                            

	                        </div>
	                    <?php } ?>

                        <div class="clearfix"></div> 
                        <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
                            <?php if ( tonsberg_redux('mt_enable_post_navigation') ) { ?>

                                <?php if(!empty($prev_post->post_title)) { ?>
                                    <?php $prev_post_title = substr($prev_post->post_title,0,30); ?>
                                <?php } ?>
                                <?php if(!empty($next_post->post_title)) { ?>
                                    <?php $next_post_title = substr($next_post->post_title,0,30); ?>
                                <?php } ?>

                                <div class="prev-next-post row">
                                    <?php if(get_previous_post()){ ?>
                                        <div class="prev-post text-left">                                  
                                            <a class="prev-next-text" href="<?php echo esc_url(get_permalink( $prev_post->ID )); ?>">
                                                <span><?php echo esc_html__( 'Previous Article', 'tonsberg' ); ?></span>
                                            </a>
                                            <a class="prev-next-title" href="<?php echo esc_url(get_permalink( $prev_post->ID )); ?>">
                                                <?php echo esc_html($prev_post_title); ?> ...
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <?php if(get_next_post()){ ?>
                                        <div class="next-post text-right">
                                            <a class="prev-next-text" href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>">
                                                <span><?php echo esc_html__( 'Next Article', 'tonsberg' ); ?></span>
                                            </a>
                                            <a class="prev-next-title" href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>">
                                                <?php echo esc_html($next_post_title); ?>...
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>


	                    <div class="clearfix"></div>

	                    <!-- COMMENTS -->
	                    <?php
	                        // If comments are open or we have at least one comment, load up the comment template
	                        if ( comments_open() || get_comments_number() ) {
	                            comments_template();
	                        }
	                    ?>
                        <div class="clearfix"></div>
	                </div>
	            </div>
            </div>

            <?php // BEGIN_WP5 ?>
            <?php if(class_exists( 'ReduxFrameworkPlugin' )){ ?>
                <?php if (isset($select_post_layout) && $select_post_layout == 'right-sidebar') { ?>
                    <div class="col-md-4 sidebar-content sidebar-right">
                        <?php if (is_active_sidebar($sidebar)) { ?>
                            <?php dynamic_sidebar($sidebar); ?>
                        <?php } ?>
                    </div>
                <?php }elseif(isset($select_post_layout) && $select_post_layout == 'inherit') { ?>
                    <?php if ( tonsberg_redux('mt_single_blog_layout') == 'mt_single_blog_right_sidebar') { ?>
                        <div class="col-md-4 sidebar-content sidebar-right">
                            <?php if (is_active_sidebar($sidebar)) { ?>
                                <?php dynamic_sidebar($sidebar); ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <?php // END_WP5 ? ?>

        </div>
    </div>
</article>


<div class="row post-details-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-12 vc_col-sm-12">
                <?php if ( tonsberg_redux('mt_enable_related_posts') ) { ?>

                <div class="clearfix"></div>
                <div class="related-posts sticky-posts">
                    <?php
                    global  $post;  
                    $orig_post = $post;  
                    $tags = wp_get_post_tags($post->ID);  
                    ?>

                    <h2 class="heading-bottom"><?php esc_html_e('You Might Also Like', 'tonsberg'); ?></h2>
                    <div class="row">
                        <?php
                        $args=array(  
                            'post__not_in'          => array($post->ID),  
                            'posts_per_page'        => 3, // Number of related posts to display.  
                            'ignore_sticky_posts'   => 1  
                        );  

                        $my_query = new wp_query( $args );  

                        while( $my_query->have_posts() ) {  
                            $my_query->the_post(); 
                        
                        ?>  
                            <div class="col-md-4 vc_col-sm-4 post">
                                <div class="related_blog_custom">
                                    <?php $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'tonsberg_post_pic700x450' ); ?>
                                    <?php if($thumbnail_src){ ?>
                                    <a href="<?php echo esc_url(get_the_permalink()); ?>" class="relative">
                                        <?php if($thumbnail_src) { ?>
                                            <img src="<?php echo esc_url($thumbnail_src[0]); ?>" class="img-responsive" alt="<?php esc_attr(the_title_attribute()); ?>" />
                                        <?php } ?>
                                    </a>
                                    <?php } ?>
                                    <div class="related_blog_details">
                                        <h4 class="post-name"><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a></h4>
                                        <div class="post-author"><?php echo esc_html__('Posted by ','tonsberg'); ?><a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) )); ?>"><?php echo esc_html(get_the_author()); ?></a> - <?php echo esc_html(get_the_date()); ?></div>
                                    </div>
                                </div>
                            </div>

                        <?php 
                        } ?>
                    </div>
                </div>
                    <?php 
                    wp_reset_postdata();  
                    ?>  

                <?php } ?>

            </div>
        </div>
    </div>
</div>