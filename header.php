<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php esc_attr(bloginfo( 'charset' )); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
        <link rel="shortcut icon" href="<?php echo esc_url(tonsberg_redux('mt_favicon', 'url')); ?>">
    <?php } ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php 
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    }
    ?>



    <?php /* VARS */ ?>
    <?php 
    $below_slider_headers = array('header5', 'header6', 'header7', 'header8');
    $normal_headers = array('header1', 'header2', 'header3', 'header4');
    $custom_header_options_status = get_post_meta( get_the_ID(), 'smartowl_custom_header_options_status', true );
    $header_custom_variant = get_post_meta( get_the_ID(), 'smartowl_header_custom_variant', true );
    $header_layout = tonsberg_redux('mt_header_layout');
    if (isset($custom_header_options_status) && $custom_header_options_status == 'yes') {
        $header_layout = $header_custom_variant;
    }
    ?>

    <div class="modeltheme-overlay"></div>
    
    <?php /* SEARCH BLOCK */ ?>
    <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
        <?php if(tonsberg_redux('mt_header_is_search') == true){ ?>
            <!-- Fixed Search Form -->
            <div class="fixed-search-overlay">
                <!-- Close Sidebar Menu + Close Overlay -->
                <i class="icon-close icons"></i>
                <!-- INSIDE SEARCH OVERLAY -->
                <div class="fixed-search-inside">
                    <div class="modeltheme-search container">
                        <form method="GET" action="<?php echo esc_url(home_url('/')); ?>">
                            <input class="search-input" placeholder="<?php echo esc_attr__('Enter search term...', 'tonsberg'); ?>" type="search" value="" name="s" id="search" />
                            <i class="fa fa-search"></i>
                            <input type="hidden" name="post_type" value="post" />
                        </form>
                        <div class="esc-search"><?php esc_html_e('Press ESC key to close search', 'tonsberg') ?></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <!-- Fixed Search Form -->
        <div class="fixed-search-overlay">
            <!-- Close Sidebar Menu + Close Overlay -->
            <i class="icon-close icons"></i>
            <!-- INSIDE SEARCH OVERLAY -->
            <div class="fixed-search-inside">
                <div class="modeltheme-search container">
                    <form method="GET" action="<?php echo esc_url(home_url('/')); ?>">
                        <input class="search-input" placeholder="<?php echo esc_attr__('Enter search term...', 'tonsberg'); ?>" type="search" value="" name="s" id="search" />
                        <i class="fa fa-search"></i>
                        <input type="hidden" name="post_type" value="post" />
                    </form>
                    <div class="esc-search"><?php esc_html_e('Press ESC key to close search', 'tonsberg') ?></div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php /* BURGER MENU */ ?>
    <?php if(tonsberg_redux('mt_header_fixed_sidebar_menu_status') == true){ ?>
        <!-- Fixed Sidebar Overlay -->
        <div class="fixed-sidebar-menu-overlay"></div>
        <!-- Fixed Sidebar Menu -->
        <div class="relative fixed-sidebar-menu-holder header7">
            <div class="fixed-sidebar-menu">
                <!-- Close Sidebar Menu + Close Overlay -->
                <i class="icon-close icons"></i>
                <!-- Sidebar Menu Holder -->
                <div class="header7 sidebar-content">
                    <!-- RIGHT SIDE -->
                    <div class="left-side">
                        <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>

                            <?php if(tonsberg_redux('mt_header_fixed_sidebar_menu_site_title_status') == 'site_logo'){ ?>
                                <?php if(tonsberg_redux('mt_logo','url')){ ?>
                                    <h1 class="logo">
                                        <a href="<?php echo esc_url(get_site_url()); ?>">
                                            <img width="200" src="<?php echo esc_url(tonsberg_redux('mt_logo','url')); ?>" alt="<?php echo esc_attr(get_bloginfo()); ?>" />
                                        </a>
                                    </h1>
                                <?php } ?>
                            <?php }else{ ?>
                                <h1 class="logo no-logo">
                                    <a href="<?php echo esc_url(get_site_url()); ?>">
                                        <?php echo esc_html(get_bloginfo()); ?>
                                    </a>
                                </h1>
                            <?php } ?>

                        <?php } ?>

                        <?php if (is_active_sidebar( tonsberg_redux('mt_header_fixed_sidebar') )) {
                            dynamic_sidebar( tonsberg_redux('mt_header_fixed_sidebar') ); 
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>


    <!-- PAGE #page -->
    <div id="page" class="hfeed site">
        <?php
            $page_slider = get_post_meta( get_the_ID(), 'select_revslider_shortcode', true );
            if (in_array($header_layout, $below_slider_headers)){
                // Revolution slider
                if (!empty($page_slider)) {
                    echo '<div class="theme_header_slider">';
                    echo do_shortcode('[rev_slider '.esc_attr($page_slider).']');
                    echo '</div>';
                }

                // Header template variant
                echo wp_kses_post(tonsberg_current_header_template());
            }elseif (in_array($header_layout, $normal_headers)){
                // Header template variant
                echo wp_kses_post(tonsberg_current_header_template());
                // Revolution slider
                if (!empty($page_slider)) {
                    echo '<div class="theme_header_slider">';
                    echo do_shortcode('[rev_slider '.esc_attr($page_slider).']');
                    echo '</div>';
                }
            }else{
                echo wp_kses_post(tonsberg_current_header_template());
            }
        ?>