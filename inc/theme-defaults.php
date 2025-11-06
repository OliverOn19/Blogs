<?php
/**
||-> Defining Default datas
*/
function tonsberg_init_function( $key = null ){

    $tonsberg_init = array(
        /* Blog Variant
        Choose from: blogloop-v1, blogloop-v2, blogloop-v3, blogloop-v4, blogloop-v5 */
        'blog_variant' => 'blogloop-v2',
        /* Header Variant 
        Choose from: header1, header2, header3, header4, header5, header8, header9 */
        'header_variant' => 'header3',
        /* Footer Variant 
        Choose from: footer1, footer2 */
        'footer_variant' => 'footer1',
        /* Header Navigation Hover
        Choose from: navstyle-v1, navstyle-v2, navstyle-v3, navstyle-v4, navstyle-v5, navstyle-v6, navstyle-v7, navstyle-v8 */
        'header_nav_hover' => 'navstyle-v1',
        /* Header Navigation Submenus Variant
        Choose from: nav-submenu-style1, nav-submenu-style2 */
        'header_nav_submenu_variant' => 'nav-submenu-style1',
        /* Sidebar Widgets Defaults
        Choose from: widgets_v1, widgets_v2 */
        'sidebar_widgets_variant' => 'widgets_v2',
        /* 404 Template Variant
        Choose from: page_404_v1_center, page_404_v2_left */
        'page_404_template_variant' => 'page_404_v2_left',
        /* Default Styling
        Set a HEXA Color Code */
        'fallback_primary_color' => '#222222', // Primary Color
        'fallback_primary_color_hover' => '#ff2222', // Primary Color - Hover
        'fallback_main_texts' => '#454646', // Main Texts Color
        'fallback_semitransparent_blocks' => 'rgba(37,37,37, .7)' // Semitransparent Blocks
    );

    // The Condition
    if ( is_null($key) ){
        return $tonsberg_init;
    } else if ( array_key_exists($key, $tonsberg_init) ) {
        return $tonsberg_init[$key];
    }
}

class Tonsberg_init_class{
    public function tonsberg_get_blog_variant(){
        return tonsberg_init_function('blog_variant');
    }
    public function tonsberg_get_header_variant(){
        return tonsberg_init_function('header_variant');
    }
    public function tonsberg_get_header_nav_hover(){
        return tonsberg_init_function('header_nav_hover');
    }
    public function tonsberg_get_sidebar_widgets_variant(){
        return tonsberg_init_function('sidebar_widgets_variant');
    }
    public function tonsberg_get_page_404_template_variant(){
        return tonsberg_init_function('page_404_template_variant');
    }
    public function tonsberg_get_fallback_primary_color(){
        return tonsberg_init_function('fallback_primary_color');
    }
    public function tonsberg_get_fallback_primary_color_hover(){
        return tonsberg_init_function('fallback_primary_color_hover');
    }
    public function tonsberg_get_fallback_main_texts(){
        return tonsberg_init_function('fallback_main_texts');
    }
    public function tonsberg_get_fallback_semitransparent_blocks(){
        return tonsberg_init_function('fallback_semitransparent_blocks');
    }

    // Blog Loop Variant
    public function tonsberg_blogloop_variant(){
        if ( ! class_exists( 'ReduxFrameworkPlugin' ) ) {
            $theme_init = new tonsberg_init_class;
            return $theme_init->tonsberg_get_blog_variant();
        }else{
            // GET VALUE FROM REDUX - THEME PANEL
            $redux_blogloop = tonsberg_redux('mt_blogloop_variant');
            return $redux_blogloop;
        }
    }

    // Navstyle Variant
    public function tonsberg_navstyle_variant(){
    	if ( ! class_exists( 'ReduxFrameworkPlugin' ) ) {
			$theme_init = new tonsberg_init_class;
    		return $theme_init->tonsberg_get_header_nav_hover();
    	}else{
    		// GET VALUE FROM REDUX - THEME PANEL
            $redux_navstyle = tonsberg_redux('mt_nav_hover_variant');
    		return $redux_navstyle;
    	}
    }
}

?>