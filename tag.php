<?php
/**
 * The template for displaying tags results pages.
 *
 */

get_header(); 

$class_row = "col-md-8";
if ( tonsberg_redux('mt_blog_layout') == 'mt_blog_fullwidth' ) {
    $class_row = "col-md-12";
}elseif ( tonsberg_redux('mt_blog_layout') == 'mt_blog_right_sidebar' or tonsberg_redux('mt_blog_layout') == 'mt_blog_left_sidebar') {
    $class_row = "col-md-8";
}
$sidebar = 'sidebar-1';
if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
    $sidebar = tonsberg_redux('mt_blog_layout_sidebar');
    if (!is_active_sidebar($sidebar)) {
        $class_row = "col-md-12";
    }
}

// theme_ini
$theme_init = new tonsberg_init_class;
?>


    <!-- HEADER TITLE BREADCRUBS SECTION -->
    <?php echo wp_kses_post(tonsberg_header_title_breadcrumbs()); ?>


    <!-- Page content -->
    <div class="high-padding">
        <!-- Blog content -->
        <div class="container blog-posts">
            <div class="row">

                <?php if ( tonsberg_redux('mt_blog_layout') != '' && tonsberg_redux('mt_blog_layout') == 'mt_blog_left_sidebar') { ?>
                    <?php if (is_active_sidebar($sidebar)) { ?>
                        <div class="col-md-4 sidebar-content sidebar-left"><?php  dynamic_sidebar( $sidebar ); ?></div>
                    <?php } ?>
                <?php } ?>

                <div class="<?php echo esc_attr($class_row); ?> main-content">
                <?php if ( have_posts() ) : ?>

                    <div class="row">

                        <?php /* Start the Loop */ ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php /* Loop - Variant 1 */ ?>
                            <?php 
                            if(get_post_format() == 'quote'){
                                get_template_part( 'template-parts/content', 'quote' );
                            }elseif(get_post_format() == 'video'){
                                get_template_part( 'template-parts/content', 'video' );
                            }elseif(get_post_format() == 'audio'){
                                get_template_part( 'template-parts/content', 'audio' );
                            }elseif(get_post_format() == 'gallery'){
                                get_template_part( 'template-parts/content', 'gallery' );
                            }else{
                                get_template_part( 'template-parts/content', $theme_init->tonsberg_blogloop_variant() );
                            }
                            ?>
                        <?php endwhile; ?>

                        <div class="modeltheme-pagination-holder col-md-12">             
                            <div class="modeltheme-pagination pagination">             
                                <?php the_posts_pagination(); ?>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <?php get_template_part( 'content', 'none' ); ?>
                <?php endif; ?>
                </div>

                <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
                    <?php if ( tonsberg_redux('mt_blog_layout') != '' && tonsberg_redux('mt_blog_layout') == 'mt_blog_right_sidebar') { ?>
                        <?php if (is_active_sidebar($sidebar)) { ?>
                            <div class="col-md-4 sidebar-content sidebar-right">
                                <?php dynamic_sidebar( $sidebar ); ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php }else{ ?>
                    <div class="col-md-4 sidebar-content sidebar-right">
                        <?php get_sidebar(); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>