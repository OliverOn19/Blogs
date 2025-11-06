<?php
/**
CUSTOM HEADER FUNCTIONS
*/




/**
Function name: 				tonsberg_current_header_template()			
Function description:		Gets the current header variant from theme options. If page has custom options, theme options will be overwritten.
*/
function tonsberg_current_header_template(){

	global  $tonsberg_redux;


    // PAGE METAS
    $custom_header_activated = get_post_meta( get_the_ID(), 'smartowl_custom_header_options_status', true );
    $header_v = get_post_meta( get_the_ID(), 'smartowl_header_custom_variant', true );
	$sidebar_headers = array('header6', 'header7', 'header14', 'header15');

	// THEME INIT
    $theme_init = new tonsberg_init_class;

	$html = '';

    if (is_page() && $header_v) {
        if ($custom_header_activated && $custom_header_activated == 'yes') {
			if (!in_array($header_v, $sidebar_headers)){
            	$html .= get_template_part( 'templates/template-'.esc_html($header_v) ); ?>

        	<?php }else{ ?>

        	<?php }
        }?>
    <?php }else{
    	if (isset($tonsberg_redux['mt_header_layout'])) {
			if (!in_array($header_v, $sidebar_headers)){
    			$html .= get_template_part( 'templates/template-'.esc_html($tonsberg_redux['mt_header_layout']) );
        	}
    	}else{
    		$html .= get_template_part( 'templates/template-'.esc_html($theme_init->tonsberg_get_header_variant()) );
    	}
    }
    return $html;
}



/**
||-> FUNCTION: GET GOOGLE FONTS FROM THEME OPTIONS PANEL
*/
function tonsberg_get_site_fonts(){
    $fonts_string = '';

    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
    	global  $tonsberg_redux;
	    if (isset($tonsberg_redux['mt_google_fonts_select'])) {
	        $i = 0;
	        $len = count($tonsberg_redux['mt_google_fonts_select']);
	        foreach(array_keys($tonsberg_redux['mt_google_fonts_select']) as $key){
	            $font_url = str_replace(' ', '+', $tonsberg_redux['mt_google_fonts_select'][$key]);
	            
	            if ($i == $len - 1) {
	                // last
	                $fonts_string .= $font_url;
	            }else{
	                $fonts_string .= $font_url . '|';
	            }
	            $i++;
	        }

		    // fonts url
		    $fonts_url = add_query_arg( 'family', $fonts_string, "//fonts.googleapis.com/css" );
		    // enqueue fonts
		    wp_enqueue_style( 'tonsberg-fonts', $fonts_url, array(), '1.0.0' );
		    
		}

    } else {

    	$font_url = str_replace(' ', '+', 'Libre+Baskerville:regular,italic,700,latin-ext,latin');
        $fonts_url = add_query_arg( 'family', $font_url, "//fonts.googleapis.com/css" );
        wp_enqueue_style( 'tonsberg-fonts-fallback', $fonts_url, array(), '1.0.0' );

        $font_url_m = str_replace(' ', '+', 'Montserrat:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i');
        $fonts_url_m = add_query_arg( 'family', $font_url_m, "//fonts.googleapis.com/css" );
        wp_enqueue_style( 'tonsberg-fonts-fallback-m', $fonts_url_m, array(), '1.0.0' );
    }

}
add_action('wp_enqueue_scripts', 'tonsberg_get_site_fonts');



// Add specific CSS class by filter
add_filter( 'body_class', 'tonsberg_body_classes' );
function tonsberg_body_classes( $classes ) {

	global  $tonsberg_redux;
	$theme_init = new tonsberg_init_class;

    $plugin_redux_status = '';
    if ( ! class_exists( 'ReduxFrameworkPlugin' ) ) {
        $plugin_redux_status = 'missing-redux-framework';
    }else{
    	$plugin_redux_status = 'active-redux-framework';
    }
    $plugin_modeltheme_status = '';
    if ( ! function_exists('modeltheme_framework')) {
        $plugin_modeltheme_status = 'missing-modeltheme-framework';
    }else{
        $plugin_modeltheme_status = 'active-modeltheme-framework';
    }

	// POST META FOOTER STATUS
    $row1_status = get_post_meta( get_the_ID(), 'mt_footer_row1_status', true );
    $row2_status = get_post_meta( get_the_ID(), 'mt_footer_row2_status', true );
    $row3_status = get_post_meta( get_the_ID(), 'mt_footer_row3_status', true );
    $footer_bottom_bar = get_post_meta( get_the_ID(), 'mt_footer_bottom_bar', true );
    $mt_page_preloader_status = get_post_meta( get_the_ID(), 'mt_page_preloader_status', true );

	$footers_row1_status = '';
	$footers_row2_status = '';
	$footers_row3_status = '';
	$footers_status = '';
	$page_preloader_status = '';

	if (is_single() || is_page()) {
		# code...
		if ($row1_status == 'on') {
			$footers_row1_status = 'footer_row1_off';
		}
		if ($row2_status == 'on') {
			$footers_row2_status = 'footer_row2_off';
		}
		if ($row3_status == 'on') {
			$footers_row3_status = 'footer_row3_off';
		}
		if ($footer_bottom_bar == 'on') {
			$footers_status = 'footer_bottom_bar_off';
		}
		if ($mt_page_preloader_status == 'on') {
			$page_preloader_status = 'page_preloader_off';
		}
	}
	

    // CHECK IF FEATURED IMAGE IS FALSE(Disabled)
    $post_featured_image = '';
    if (tonsberg_redux('mt_post_featured_image') != '') {
	    if (is_singular('post')) {
	        if ($tonsberg_redux['mt_post_featured_image'] == false) {
	            $post_featured_image = 'hide_post_featured_image';
	        }else{
	            $post_featured_image = '';
	        }
	    }
	}

    // CHECK IF THE NAV IS STICKY
    $is_nav_sticky = '';
    if (tonsberg_redux('mt_is_nav_sticky') != '') {
	    if ($tonsberg_redux['mt_is_nav_sticky'] == true) {
	        // If is sticky
	        $is_nav_sticky = 'is_nav_sticky';
	    }else{
	        // If is not sticky
	        $is_nav_sticky = '';
	    }
	}

    // CHECK IF HEADER IS SEMITRANSPARENT
    $semitransparent_header_meta = get_post_meta( get_the_ID(), 'mt_header_semitransparent', true );
    $semitransparent_header = '';
    if ($semitransparent_header_meta == 'enabled') {
        // If is semitransparent
        $semitransparent_header = 'is_header_semitransparent';
    }

    // DIFFERENT HEADER LAYOUT TEMPLATES
    $header_status = get_post_meta( get_the_ID(), 'smartowl_custom_header_options_status', true );
    $header_v = get_post_meta( get_the_ID(), 'smartowl_header_custom_variant', true );

    
    $header_version = $theme_init->tonsberg_get_header_variant();
    if (!is_null(tonsberg_redux('mt_header_layout'))) {
	    if (isset($header_status) && $header_status == 'yes') {
	    	$header_version = $header_v;
	    }else{
		    if ($tonsberg_redux['mt_header_layout']) {
		        // Header Layout #1
		        $header_version = $tonsberg_redux['mt_header_layout'];
		    }
	    }
	}


    // HEADER NAVIGATION HOVER STYLE
	$header_nav_hover = $theme_init->tonsberg_navstyle_variant();
	$sidebar_widgets_variant = $theme_init->tonsberg_get_sidebar_widgets_variant();

    $classes[] = esc_attr($sidebar_widgets_variant) . ' ' . esc_attr($plugin_modeltheme_status) . ' ' . esc_attr($plugin_redux_status) . ' ' . esc_attr($header_nav_hover) . ' ' . esc_attr($page_preloader_status) . ' ' . esc_attr($footers_status) . ' ' . esc_attr($footers_row1_status) . ' ' . esc_attr($footers_row2_status) . ' ' . esc_attr($footers_row3_status) . ' ' . esc_attr($post_featured_image) . ' ' . esc_attr($is_nav_sticky) . ' ' . esc_attr($header_version) . ' ' . esc_attr($semitransparent_header) . ' ';

    return $classes;

}

/**
||-> FUNCTION: GET DYNAMIC CSS
*/
add_action('wp_enqueue_scripts', 'tonsberg_dynamic_css' );
function tonsberg_dynamic_css(){

    $html = '';

    // THEME INIT
    $theme_init = new tonsberg_init_class;

	// BEGIN: REVAMP SKIN COLORS ===============================================================================
	$skin_main_bg = $theme_init->tonsberg_get_fallback_primary_color(); //Fallback primary background color
	$skin_main_bg_hover = $theme_init->tonsberg_get_fallback_primary_color_hover(); //Fallback primary background hover color
	$skin_main_texts = $theme_init->tonsberg_get_fallback_main_texts(); //Fallback main text color
	$skin_semitransparent_blocks = $theme_init->tonsberg_get_fallback_semitransparent_blocks(); //Fallback semitransparent blocks


	// CUSTOM PAGE METABOXES
	$custom_header_activated = get_post_meta( get_the_ID(), 'smartowl_custom_header_options_status', true );
    $mt_custom_main_color = get_post_meta( get_the_ID(), 'mt_custom_main_color', true );
    $mt_custom_main_hover_color = get_post_meta( get_the_ID(), 'mt_custom_main_hover_color', true );


    if($custom_header_activated == 'yes' && isset($mt_custom_main_color) && isset($mt_custom_main_hover_color) && !empty($mt_custom_main_color) && !empty($mt_custom_main_hover_color)) {

    	$skin_main_bg = $mt_custom_main_color;
		$skin_main_bg_hover = $mt_custom_main_hover_color;

    } else {
	    if (tonsberg_redux('mt_predefined_skin') != '' && tonsberg_redux('mt_predefined_skin') == 'skin_blue') {
			$skin_main_bg = 				'#3498db';
			$skin_main_bg_hover = 			'#2980b9';
			$skin_main_texts = 				'#454646';
			$skin_semitransparent_blocks = 	'rgba(52, 152, 219, 0.7)';
	    }elseif (tonsberg_redux('mt_predefined_skin') != '' && tonsberg_redux('mt_predefined_skin') == 'skin_turquoise'){
			$skin_main_bg = 				'#1abc9c';
			$skin_main_bg_hover = 			'#16a085';
			$skin_main_texts = 				'#454646';
			$skin_semitransparent_blocks = 	'rgba(26, 188, 156, 0.7)';
	    }elseif (tonsberg_redux('mt_predefined_skin') != '' && tonsberg_redux('mt_predefined_skin') == 'skin_green'){
			$skin_main_bg = 				'#2ecc71';
			$skin_main_bg_hover = 			'#27ae60';
			$skin_main_texts = 				'#454646';
			$skin_semitransparent_blocks = 	'rgba(46, 204, 113, 0.7)';
	    }elseif (tonsberg_redux('mt_predefined_skin') != '' && tonsberg_redux('mt_predefined_skin') == 'skin_purple'){
			$skin_main_bg = 				'#9b59b6';
			$skin_main_bg_hover = 			'#8e44ad';
			$skin_main_texts = 				'#454646';
			$skin_semitransparent_blocks = 	'rgba(155, 89, 182, 0.7)';
	    }elseif (tonsberg_redux('mt_predefined_skin') != '' && tonsberg_redux('mt_predefined_skin') == 'skin_yellow'){
			$skin_main_bg = 				'#f1c40f';
			$skin_main_bg_hover = 			'#f39c12';
			$skin_main_texts = 				'#454646';
			$skin_semitransparent_blocks = 	'rgba(241, 196, 15, 0.7)';
	    }elseif (tonsberg_redux('mt_predefined_skin') != '' && tonsberg_redux('mt_predefined_skin') == 'skin_yellow2'){
			$skin_main_bg = 				'#ffd600';
			$skin_main_bg_hover = 			'#e5c000';
			$skin_main_texts = 				'#454646';
			$skin_semitransparent_blocks = 	'rgba(255, 214, 0, 0.7)';
	    }elseif (tonsberg_redux('mt_predefined_skin') != '' && tonsberg_redux('mt_predefined_skin') == 'skin_orange'){
			$skin_main_bg = 				'#e67e22';
			$skin_main_bg_hover = 			'#d35400';
			$skin_main_texts = 				'#454646';
			$skin_semitransparent_blocks = 	'rgba(230, 126, 34, 0.7)';
	    }elseif (tonsberg_redux('mt_predefined_skin') != '' && tonsberg_redux('mt_predefined_skin') == 'skin_red'){
			$skin_main_bg = 				'#e74c3c';
			$skin_main_bg_hover = 			'#c0392b';
			$skin_main_texts = 				'#454646';
			$skin_semitransparent_blocks = 	'rgba(231, 76, 60, 0.7)';
	    }elseif (tonsberg_redux('mt_predefined_skin') != '' && tonsberg_redux('mt_predefined_skin') == 'skin_gray'){
			$skin_main_bg = 				'#95a5a6';
			$skin_main_bg_hover = 			'#7f8c8d';
			$skin_main_texts = 				'#454646';
			$skin_semitransparent_blocks = 	'rgba(149, 165, 166, 0.7)';
	    }elseif (tonsberg_redux('mt_predefined_skin') != '' && tonsberg_redux('mt_predefined_skin') == 'skin_blue2'){
			$skin_main_bg = 				'#483ca8';
			$skin_main_bg_hover = 			'#3e3492';
			$skin_main_texts = 				'#454646';
			$skin_semitransparent_blocks = 	'rgba(72,60,168, .7)';
	    }elseif (tonsberg_redux('mt_predefined_skin') != '' && tonsberg_redux('mt_predefined_skin') == 'skin_black'){
			$skin_main_bg = 				'#222222';
			$skin_main_bg_hover = 			'#222222';
			$skin_main_texts = 				'#454646';
			$skin_semitransparent_blocks = 	'rgba(37,37,37, .7)';
	    }elseif (tonsberg_redux('mt_predefined_skin') != '' && tonsberg_redux('mt_predefined_skin') == 'skin_black_blue'){
			$skin_main_bg = 				'#374b9f';
			$skin_main_bg_hover = 			'#2d2d2d';
			$skin_main_texts = 				'#454646';
			$skin_semitransparent_blocks = 	'rgba(37,37,37, .7)';
	    }
	}
	// END: REVAMP SKIN COLORS ===============================================================================

    //PAGE PRELOADER BACKGROUND COLOR
    $mt_page_preloader = get_post_meta( get_the_ID(), 'mt_page_preloader', true );
    $mt_page_preloader_bg_color = get_post_meta( get_the_ID(), 'mt_page_preloader_bg_color', true );
    if (isset($mt_page_preloader) && $mt_page_preloader == 'enabled' && isset($mt_page_preloader_bg_color)) {
        $html .= 'body .tonsberg_preloader_holder{
					background-color: '.esc_html($mt_page_preloader_bg_color).';
        		}';
    }elseif ( class_exists( 'ReduxFrameworkPlugin' ) && tonsberg_redux('mt_preloader_status') ) {
        $html .= 'body .tonsberg_preloader_holder{
					background-color: '.tonsberg_redux('mt_preloader_bg_color','background-color').';
        		}
        		body .tonsberg_preloader_holder .globe-loader {
        			color: '.tonsberg_redux('mt_preloader_color').' !important; 
        		}
        		';
    }

	// HEADER SEMITRANSPARENT - METABOX
	$custom_header_activated = get_post_meta( get_the_ID(), 'smartowl_custom_header_options_status', true );
	$mt_header_custom_bg_color = get_post_meta( get_the_ID(), 'mt_header_custom_bg_color', true );
	$mt_header_semitransparent = get_post_meta( get_the_ID(), 'mt_header_semitransparent', true );
    if (isset($mt_header_semitransparent) == 'enabled') {
		$mt_header_semitransparentr_rgba_value = get_post_meta( get_the_ID(), 'mt_header_semitransparentr_rgba_value', true );
		$mt_header_semitransparentr_rgba_value_scroll = get_post_meta( get_the_ID(), 'mt_header_semitransparentr_rgba_value_scroll', true );
		
		if (isset($mt_header_custom_bg_color)) {
			list($r, $g, $b) = sscanf($mt_header_custom_bg_color, "#%02x%02x%02x");
		}else{
			$hexa = '#04ABE9'; //Theme Options Color
			list($r, $g, $b) = sscanf($hexa, "#%02x%02x%02x");
		}

		$html .= '
			.is_header_semitransparent .navbar-default {
			    background: rgba('.esc_html($r).', '.esc_html($g).', '.esc_html($b).', '.esc_html($mt_header_semitransparentr_rgba_value).') none repeat scroll 0 0;
			}
			.is_header_semitransparent .sticky-wrapper.is-sticky .navbar-default {
			    background: rgba('.esc_html($r).', '.esc_html($g).', '.esc_html($b).', '.esc_html($mt_header_semitransparentr_rgba_value_scroll).') none repeat scroll 0 0;
			}';
    }

    // THEME OPTIONS STYLESHEET

    // BACK TO TOP - CUSTOM STYLING
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
		if (tonsberg_redux('mt_backtotop_status') == true) {

			 $html .= '.back-to-top {
						color: '.tonsberg_redux('mt_backtotop_text_color') .' !important;
					}
					.back-to-top:hover {
						color: '.tonsberg_redux('mt_backtotop_text_color_hover') .' !important;
					}';
		}
	}

	if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
	// SEARCH ICON - CUSTOM STYLING
		if (tonsberg_redux('mt_header_is_search_custom_styling') == true) {
			 $html .= 'body header .right-side-social-actions .mt-search-icon i {
						color: '.tonsberg_redux('mt_header_search_color').' !important;
					}
					body header .right-side-social-actions .mt-search-icon:hover i {
						color: '.tonsberg_redux('mt_header_search_color_hover').' !important;
					}';
		}
	}

	// BURGER SIDEBAR MENU - CUSTOM STYLING
	if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
		if (tonsberg_redux('mt_header_fixed_sidebar_menu_custom_styling') == true) {
			 $html .= 'body #mt-nav-burger span {
						background: '.tonsberg_redux('mt_header_fixed_sidebar_menu_color').' !important;
					}
					body #mt-nav-burger:hover span {
						background: '.tonsberg_redux('mt_header_fixed_sidebar_menu_color_hover').' !important;
					}';
		}
	}


	// FALLBACKS for REDUX FRAMEWORK
	$breadcrumbs_delimitator = '/';
	$logo_max_width = '200';
	$text_selection_color = '#ffffff';
	$body_global_bg = '#ffffff';
	// REDUX FRAMEWORK CONDITIONS
	if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
		$breadcrumbs_delimitator = tonsberg_redux('mt_breadcrumbs_delimitator');
		$logo_max_width = tonsberg_redux('mt_logo_max_width');
		$text_selection_color = tonsberg_redux('mt_text_selection_color');
		$body_global_bg = tonsberg_redux('mt_body_global_bg');
	}


	// THEME OPTIONS STYLESHEET - Responsive SmartPhones
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
    $html .= '.single article .article-content p,
               p,
               .post-excerpt,
               ul,
               ul.tonsberg-list,
               ol,
               th,
               td,
               dt,
               dd,
               address{
                    font-size: '.tonsberg_redux('mt_single_post_typography','font-size').';
                    line-height: '.tonsberg_redux('mt_single_post_typography','line-height').';
                    font-family: '.tonsberg_redux('mt_single_post_typography','font-family').';
                    color: '.tonsberg_redux('mt_single_post_typography','color').';
               }
               .header3 #navbar .menu .menu-item a {
               		font-family: '.tonsberg_redux('mt_main_menu_typography','font-family').';
               }
               body{
                    font-family: '.tonsberg_redux('mt_body_typography','font-family').';
               }
               h1,
               h1 span {
                    font-family: "'.tonsberg_redux('mt_heading_h1','font-family').'";
                    font-size: '.tonsberg_redux('mt_heading_h1','font-size').';
               }
               h2 {
                    font-family: "'.tonsberg_redux('mt_heading_h2','font-family').'";
                    font-size: '.tonsberg_redux('mt_heading_h2','font-size').';
               }
               h3 {
                    font-family: "'.tonsberg_redux('mt_heading_h3','font-family').'";
                    font-size: '.tonsberg_redux('mt_heading_h3','font-size').';
               }
               h4 {
                    font-family: "'.tonsberg_redux('mt_heading_h4','font-family').'";
                    font-size: '.tonsberg_redux('mt_heading_h4','font-size').';
               } 
               h5 {
                    font-family: "'.tonsberg_redux('mt_heading_h5','font-family').'";
                    font-size: '.tonsberg_redux('mt_heading_h5','font-size').';
               } 
               h6 {
                    font-family: "'.tonsberg_redux('mt_heading_h6','font-family').'";
                    font-size: '.tonsberg_redux('mt_heading_h6','font-size').';
               } 
               input,
               textarea {
                    font-family: '.tonsberg_redux('mt_inputs_typography','font-family').';
               }  
               input[type="submit"] {
                    font-family: '.tonsberg_redux('mt_buttons_typography','font-family').';
               }
               ';

    // THEME OPTIONS STYLESHEET - Responsive SmartPhones
    $html .= '
    			@media only screen and (max-width: 767px) {
    				body h1,
    				body h1 span{
    					font-size: '.tonsberg_redux('mt_heading_h1_smartphones', 'font-size').' !important;
    					line-height: '.tonsberg_redux('mt_heading_h1_smartphones', 'line-height').' !important;
    				}
    				body h2{
    					font-size: '.tonsberg_redux('mt_heading_h2_smartphones', 'font-size').' !important;
    					line-height: '.tonsberg_redux('mt_heading_h2_smartphones', 'line-height').' !important;
    				}
    				body h3{
    					font-size: '.tonsberg_redux('mt_heading_h3_smartphones', 'font-size').' !important;
    					line-height: '.tonsberg_redux('mt_heading_h3_smartphones', 'line-height').' !important;
    				}
    				body h4{
    					font-size: '.tonsberg_redux('mt_heading_h4_smartphones', 'font-size').' !important;
    					line-height: '.tonsberg_redux('mt_heading_h4_smartphones', 'line-height').' !important;
    				}
    				body h5{
    					font-size: '.tonsberg_redux('mt_heading_h5_smartphones', 'font-size').' !important;
    					line-height: '.tonsberg_redux('mt_heading_h5_smartphones', 'line-height').' !important;
    				}
    				body h6{
    					font-size: '.tonsberg_redux('mt_heading_h6_smartphones', 'font-size').' !important;
    					line-height: '.tonsberg_redux('mt_heading_h6_smartphones', 'line-height').' !important;
    				}
    			}';

    $html .= '
    			@media only screen and (max-width: 767px) {
    				#navbar .sub-menu .menu-item > a:hover {
    					color: '.tonsberg_redux('mt_nav_menu_hover_color').' !important;
    				}
    			}';

    // THEME OPTIONS STYLESHEET - Responsive Tablets
    $html .= '
    			@media only screen and (min-width: 768px) and (max-width: 1024px) {
    				body h1,
    				body h1 span{
    					font-size: '.tonsberg_redux('mt_heading_h1_tablets', 'font-size').' !important;
    					line-height: '.tonsberg_redux('mt_heading_h1_tablets', 'line-height').' !important;
    				}
    				body h2{
    					font-size: '.tonsberg_redux('mt_heading_h2_tablets', 'font-size').' !important;
    					line-height: '.tonsberg_redux('mt_heading_h2_tablets', 'line-height').' !important;
    				}
    				body h3{
    					font-size: '.tonsberg_redux('mt_heading_h3_tablets', 'font-size').' !important;
    					line-height: '.tonsberg_redux('mt_heading_h3_tablets', 'line-height').' !important;
    				}
    				body h4{
    					font-size: '.tonsberg_redux('mt_heading_h4_tablets', 'font-size').' !important;
    					line-height: '.tonsberg_redux('mt_heading_h4_tablets', 'line-height').' !important;
    				}
    				body h5{
    					font-size: '.tonsberg_redux('mt_heading_h5_tablets', 'font-size').' !important;
    					line-height: '.tonsberg_redux('mt_heading_h5_tablets', 'line-height').' !important;
    				}
    				body h6{
    					font-size: '.tonsberg_redux('mt_heading_h6_tablets', 'font-size').' !important;
    					line-height: '.tonsberg_redux('mt_heading_h6_tablets', 'line-height').' !important;
    				}
    			}';
   	}


    // THEME OPTIONS STYLESHEET
    $html .= '.breadcrumb a::after {
	        	  content: "'.esc_html($breadcrumbs_delimitator).'";
	    	}
	    	body{
		        background: '.esc_html($body_global_bg).';
	    	}
    		.logo img,
			.navbar-header .logo img {
				max-width: '.esc_html($logo_max_width).'px;
			}
		    ::selection{
		        color: '.esc_html($text_selection_color).';
		        background: '.esc_html($skin_main_bg).';
		    }
		    ::-moz-selection { /* Code for Firefox */
		        color: '.esc_html($text_selection_color).';
		        background: '.esc_html($skin_main_bg).';
		    }

		    a{
		        color: '.esc_html($skin_main_bg).';
		    }
		    a:focus,
		    a:hover{
		        color: '.esc_html($skin_main_bg_hover).';
		    }

		    /*------------------------------------------------------------------
		        COLOR
		    ------------------------------------------------------------------*/
		    a, 
		    a:hover, 
		    a:focus,
		    .mt_car--tax-type,
		    span.amount,
		    .widget_popular_recent_tabs .nav-tabs li.active a,
		    .widget_archive li:hover a,
		    .pricing-table.recomended .button.solid-button, 
		    .pricing-table .table-content:hover .button.solid-button,
		    .pricing-table.Recommended .button.solid-button, 
		    .pricing-table.recommended .button.solid-button, 
		    #sync2 .owl-item.synced .post_slider_title,
		    #sync2 .owl-item:hover .post_slider_title,
		    #sync2 .owl-item:active .post_slider_title,
		    .pricing-table.recomended .button.solid-button, 
		    .pricing-table .table-content:hover .button.solid-button,
		    .testimonial-author,
		    .testimonials-container blockquote::before,
		    .testimonials-container blockquote::after,
		    .post-author > a,
		    h2 span,
		    label.error,
		    .author-name,
		    .prev-next-post a:hover,
		    .prev-text,
		    .wpb_button.btn-filled:hover,
		    .next-text,
		    .social ul li a:hover i,
		    .wpcf7-form span.wpcf7-not-valid-tip,
		    .text-dark .statistics .stats-head *,
		    .wpb_button.btn-filled,
		    footer ul.menu li.menu-item a:hover,
		    .widget_meta li:hover,
		    .widget_meta li:hover a,
		    .widget_meta a:hover,
		    .widget_pages li a:hover,
		    .widget_pages li .children li a:hover,
		    .blogloop-v1 .post-name a:hover,
		    .blogloop-v2 .post-name a:hover,
		    .blogloop-v3 .post-name a:hover,
		    .blogloop-v4 .post-name a:hover,
		    .blogloop-v5 .post-name a:hover,
			.post-category-comment-date span a:hover,
			.list-view .post-details .post-category-comment-date a:hover,
		    .simple_sermon_content_top h4,
		    .page_404_v1 h1,
		    .mt_cars--single-main-pic .post-name > a,
		    .widget_recent_comments li:hover a,
		    .sidebar-content .widget-title a:hover,
		    .widget_rss li a:hover,
		    .list-view .post-details .post-name a:hover,
		    .blogloop-v5 .post-details .post-sticky-label i,
		    header.header2 .header-info-group .header_text_title strong,
		    .widget_recent_entries li:hover a,
		    .blogloop-v1 .post-details .post-sticky-label i,
		    .blogloop-v2 .post-details .post-sticky-label i,
		    .blogloop-v3 .post-details .post-sticky-label i,
		    .blogloop-v4 .post-details .post-sticky-label i,
		    .blogloop-v5 .post-details .post-sticky-label i,
		    .mt_listing--price-day.mt_listing--price .mt_listing_price,
            .mt_listing--price-day.mt_listing--price .mt_listing_currency,
            .mt_listing--price-day.mt_listing--price .mt_listing_per,
		    .error-404.not-found h1,
		    .header-info-group i,
            .related.products ul.products li.product .button,         
		    .error-404.not-found h1,
		    .header-info-group i,
		    body .lms-course-infos i,
		    h4.testimonial02_title,
		    .action-expand::after,
		    .single-icondrops-content .skill,
		    .tonsberg-single-list-item i.cc,
		    .single .single-icondrops-related-listings i.cc,
		    .list-view .post-details .post-excerpt .more-link:hover,
		    .header4 header .right-side-social-actions .social-links a:hover i,
		    .single-icondrops-content h5 strong,
		    .modeltheme-countdown .days-digit, 
		    .modeltheme-countdown .hours-digit, 
		    .modeltheme-countdown .minutes-digit, 
		    .modeltheme-countdown .seconds-digit,
		    .widget_tonsberg_recent_entries_with_thumbnail li:hover a,
			#mt_posts_carousel_small .group-meta a:hover,
			#mt_posts_carousel_big_centered .group-meta a:hover,
		    .blog-posts-shortcode-v2 .post-details .post-category,
		    .mtlistings-ico-style-v2.iconfilter-shortcode .blog_custom_listings .post-name-listings a:hover,
		    .mtlistings-events-style-v2 .events-title-subtitle h4 a:hover,
		    .mtlistings-events-style-v2 .mt-single-event .mt-event-cat a:hover  {
		        color: '.esc_html($skin_main_bg).';
		    }

		    .widget_popular_recent_tabs .nav-tabs li.active a,
		    .widget_product_categories .cat-item:hover,
		    .widget_product_categories .cat-item a:hover,
		    .widget_archive li:hover,
		    .widget_archive li:hover a,
		    .widget_archive li a:hover,
		    .widget_categories li a:hover,
		    .widget_meta li:hover,
		    .widget_meta li:hover a,
		    .widget_meta a:hover,
		    .widget_pages li a:hover,
		    .widget_pages li .children li a:hover,
		    .widget_recent_entries_with_thumbnail li:hover a,
		    .widget_recent_entries li:hover,
		    .widget_recent_entries li:hover a,
		    .widget_recent_entries li a:hover,
		    .widget_recent_comments li a:hover,
		    .widget_rss li a:hover,
		    .widget_nav_menu li a:hover
		    {
		        color: '.esc_html($skin_main_bg_hover).';
		    }


		    /* NAVIGATION */
		    .navstyle-v8.header3 #navbar .menu > .menu-item.current-menu-item > a, 
		    .navstyle-v8.header3 #navbar .menu > .menu-item:hover > a,
		    .navstyle-v1.header2 #navbar .menu > .menu-item:hover > a,
		    .navstyle-v4 #navbar .menu > .menu-item.current-menu-item > a,
		    .navstyle-v4 #navbar .menu > .menu-item:hover > a,
		    .navstyle-v3 #navbar .menu > .menu-item.current-menu-item > a, 
		    .navstyle-v3 #navbar .menu > .menu-item:hover > a,
		    .navstyle-v3 #navbar .menu > .menu-item > a::before, 
			.navstyle-v3 #navbar .menu > .menu-item > a::after,
			.navstyle-v2 #navbar .menu > .menu-item.current-menu-item > a,
			.navstyle-v2 #navbar .menu > .menu-item:hover > a{
		        color: '.esc_html($skin_main_bg).';
			}
			.navstyle-v2.header3 #navbar .menu > .menu-item > a::before,
			.navstyle-v2.header3 #navbar .menu > .menu-item > a::after,
			.navstyle-v8 #navbar .menu > .menu-item > a::before,
			.navstyle-v7 #navbar .menu > .menu-item .sub-menu > .menu-item > a:hover,
			.navstyle-v7 #navbar .menu > .menu-item.current_page_item > a,
			.navstyle-v7 #navbar .menu > .menu-item.current-menu-item > a,
			.navstyle-v7 #navbar .menu > .menu-item:hover > a,
			.navstyle-v6 #navbar .menu > .menu-item.current_page_item > a,
			.navstyle-v6 #navbar .menu > .menu-item.current-menu-item > a,
			.navstyle-v6 #navbar .menu > .menu-item:hover > a,
			.navstyle-v5 #navbar .menu > .menu-item.current_page_item > a, 
			.navstyle-v5 #navbar .menu > .menu-item.current-menu-item > a,
			.navstyle-v5 #navbar .menu > .menu-item:hover > a,
			.navstyle-v2 #navbar .menu > .menu-item > a::before, 
			.navstyle-v2 #navbar .menu > .menu-item > a::after{
				background: '.esc_html($skin_main_bg).';
			}


			/* Color Dark / Hovers */
		    .tonsberg-single-list-item i.cc:hover,
		    .single .single-icondrops-related-listings i.cc:hover,
			.related-posts .post-name:hover a{
				color: '.esc_html($skin_main_bg_hover).' !important;
			}

		    /*------------------------------------------------------------------
		        BACKGROUND + BACKGROUND-COLOR
		    ------------------------------------------------------------------*/
		    .tagcloud > a:hover,
		    .modeltheme-icon-search,
		    .wpb_button::after,
		    .rotate45,
		    .latest-posts .post-date-day,
		    .latest-posts h3, 
		    .latest-tweets h3, 
		    .latest-videos h3,
		    .button.solid-button, 
		    button.vc_btn,
		    .pricing-table.recomended .table-content, 
		    .pricing-table .table-content:hover,
		    .pricing-table.Recommended .table-content, 
		    .pricing-table.recommended .table-content, 
		    .pricing-table.recomended .table-content, 
		    .pricing-table .table-content:hover,
		    .block-triangle,
		    .owl-theme .owl-controls .owl-page span,
		    body .vc_btn.vc_btn-blue, 
		    body a.vc_btn.vc_btn-blue, 
		    body button.vc_btn.vc_btn-blue,
		    .pagination .page-numbers.current,
		    .pagination .page-numbers:hover,
		    #subscribe > button[type=\'submit\'],
		    .prev-next-post a:hover .rotate45,
		    .masonry_banner.default-skin,
		    .form-submit input,
		    .member-header::after,
		    .member-footer .social::before, 
		    .member-footer .social::after,
		    .subscribe > button[type=\'submit\'],
		    .no-results input[type=\'submit\'],
		    h3#reply-title::after,
		    .newspaper-info,
		    header.header1 .header-nav-actions .shop_cart,
		    .categories_shortcode .owl-controls .owl-buttons i:hover,
		    .widget-title:after,
		    h2.heading-bottom:after,
		    .single .content-car-heading:after,
		    .wpb_content_element .wpb_accordion_wrapper .wpb_accordion_header.ui-state-active,
		    #primary .main-content ul li:not(.rotate45)::before,
		    .wpcf7-form .wpcf7-submit,
		    ul.ecs-event-list li span,
		    #contact_form2 .solid-button.button,
		    .navbar-default .navbar-toggle .icon-bar,
		    .modeltheme-search .search-submit,
		    .pricing-table.recommended .table-content .title-pricing,
		    .pricing-table .table-content:hover .title-pricing,
		    .pricing-table.recommended .button.solid-button,
		    .blogloop-v5 .absolute-date-badge span,
		    .post-category-date a[rel="tag"],
		    #navbar .mt-icon-list-item:hover,
		    .mt_car--single-gallery.mt_car--featured-single-gallery:hover,
		    footer .mc4wp-form-fields input[type="submit"],
		    .modeltheme-pagination.pagination .page-numbers.current,
		    .pricing-table .table-content:hover .button.solid-button,
		    footer .footer-top .menu .menu-item a::before,
		    .mt-car-search .submit .form-control,
		    .blogloop-v4.list-view .post-date,
		    header .top-header,
		    .navbar-toggle .icon-bar,
            .hover-components .component a:hover,
            .related.products span.onsale,
            table.compare-list .add-to-cart td a,
            .shop_cart,
		    .panel-single-icondrops,
		    .single-mt_listing .single-icondrops,
		    #listings_metaboxs input[type="submit"],
            .mt_listing--single-price-inner,
            input.wpcf7-form-control.wpcf7-submit,
            .mt-single-event-head,
            .mt_listing .single-icondrops-content .progress,
		    .post-password-form input[type="submit"],
		    .widget.widget_product_search button,
		    .search-form input[type="submit"],
		    .slider_navigation .btn,
		    .pagination .page-numbers,
		    .modeltheme-content > div,
		    .single-mt_listing .mt_listing_website_button:hover,
			.single-mt_listing .mt_listing_website_button:hover, 
			.single-mt_listing .mt_listing_whitepaper_button:hover,
			.single-mt_listing .mt_listing_purchase_button:hover,
			.single-mt_listing .mt_listing_video_button:hover,
		    #listings_metaboxs .cmb-type-title,
		    .wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header a,
		    .post-password-form input[type=\'submit\'] {
		        background: '.esc_html($skin_main_bg).';
		    }
			.um-login input[type=submit].um-button,
		    body .courses-list .featured_image_courses .course_badge i,
		    body .courses-list .shortcode_course_content,
            .blog-posts-shortcode .time-n-date {
                    background-color: '.esc_html($skin_main_bg).' !important;
            }
		    .modeltheme-search.modeltheme-search-open .modeltheme-icon-search, 
		    .no-js .modeltheme-search .modeltheme-icon-search,
		    .modeltheme-icon-search:hover,
		    .latest-posts .post-date-month,
		    .button.solid-button:hover,
		    body .vc_btn.vc_btn-blue:hover, 
		    body a.vc_btn.vc_btn-blue:hover, 
		    .post-category-date a[rel="tag"]:hover,
		    body button.vc_btn.vc_btn-blue:hover,
		    .blogloop-v5 .absolute-date-badge span:hover,
		    .mt-car-search .submit .form-control:hover,
		    #contact_form2 .solid-button.button:hover,
		    .subscribe > button[type=\'submit\']:hover,
		    footer .mc4wp-form-fields input[type="submit"]:hover,
		    .no-results.not-found .search-submit:hover,
		    .no-results input[type=\'submit\']:hover,
		    ul.ecs-event-list li span:hover,
		    .pricing-table.recommended .table-content .price_circle,
		    .pricing-table .table-content:hover .price_circle,
		    #modal-search-form .modal-content input.search-input,
		    .wpcf7-form .wpcf7-submit:hover,
		    .form-submit input:hover,
			.wpcf7-form .wpcf7-submit,
		    .mt_listing_end_date_pick,
		    .mt_listing_start_date_pick,
		    .blogloop-v4.list-view .post-date a:hover,
		    .pricing-table.recommended .button.solid-button:hover,
		    .search-form input[type="submit"]:hover,
		    .modeltheme-pagination.pagination .page-numbers.current:hover,
		    .error-return-home.text-center > a:hover,
		    .pricing-table .table-content:hover .button.solid-button:hover,
		    .post-password-form input[type="submit"]:hover,
		    .navbar-toggle .navbar-toggle:hover .icon-bar,
		    .widget.widget_product_search button:hover,
		    .slider_navigation .btn:hover,
		    .post-password-form input[type=\'submit\']:hover,
		    .tonsberg-filters .filter:hover {
		        background: '.esc_html($skin_main_bg_hover).';
		    }
			.um-login input[type=submit].um-button:hover{
		        background: '.esc_html($skin_main_bg_hover).' !important;
		    }

            .hover-components .component a,
		    .flickr_badge_image a::after,
		    .thumbnail-overlay,
		    .portfolio-hover,
		    .mt_listing--single-gallery .ico-screenshot:hover .flex-zone,
		    .pastor-image-content .details-holder,
		    .item-description .holder-top,
		    blockquote::before {
		        background: '.esc_html($skin_semitransparent_blocks).';
		    }

		    /*------------------------------------------------------------------
		        BORDER-COLOR
		    ------------------------------------------------------------------*/
		    .comment-form input:focus, 
		    .comment-form textarea:focus,
		    blockquote,
		    .widget_popular_recent_tabs .nav-tabs > li.active,
		    body .left-border, 
		    body .right-border,
		    body .member-header,
		    body .member-footer .social,
		    body .button[type=\'submit\'],
		    .navbar ul li ul.sub-menu,
		    .wpb_content_element .wpb_tabs_nav li.ui-tabs-active,
		    #contact-us .form-control:focus,
		    .sale_banner_holder:hover,
		    .testimonial-img,
		    .wpcf7-form input:focus, 
		    .wpcf7-form textarea:focus,
		    .navbar-default .navbar-toggle:hover, 
		    .header_search_form,
		    body .course-review-head, body .course-content > h3:first-child, body .course-curriculum-title,
		    .list-view .post-details .post-excerpt .more-link:hover{
		        border-color: '.esc_html($skin_main_bg).';
		    }

		    header .navbar-toggle,
		    .navbar-default .navbar-toggle{
		        border: 3px solid '.esc_html($skin_main_bg).';
		    }';

    wp_add_inline_style( 'tonsberg-mt-style', $html );
}
?>