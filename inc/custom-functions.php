<?php
//GET HEADER TITLE/BREADCRUMBS AREA
function tonsberg_header_title_breadcrumbs(){

    $html = '';
    $html .= '<div class="header-title-breadcrumb relative">';
        $html .= '<div class="header-title-breadcrumb-overlay text-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 text-center">';
                                    if (class_exists( 'WooCommerce' ) && is_product()) {
                                        $html .= '<h1>'.esc_html__( 'Shop', 'tonsberg' ) . get_search_query().'</h1>';
                                    }elseif (class_exists( 'WooCommerce' ) && is_shop()) {
                                        $html .= '<h1>'.esc_html__( 'Shop', 'tonsberg' ) . get_search_query().'</h1>';
                                    }elseif (is_singular('post')) {
                                        $html .= '<h1>'.esc_html__( 'Blog', 'tonsberg' ) . get_search_query().'</h1>';
                                    }elseif (is_page()) {
                                        $html .= '<h1>'.get_the_title().'</h1>';
                                    }elseif (is_search()) {
                                        $html .= '<h1>'.esc_html__( 'Search Results for: ', 'tonsberg' ) . get_search_query().'</h1>';
                                    }elseif (is_category()) {
                                        $html .= '<h1>'.esc_html__( 'Category: ', 'tonsberg' ).' <span>'.single_cat_title( '', false ).'</span></h1>';
                                    }elseif (is_tag()) {
                                        $html .= '<h1>'.esc_html__( 'Tag Archives: ', 'tonsberg' ) . single_tag_title( '', false ).'</h1>';
                                    }elseif (is_author() || is_archive()) {
                                        $html .= '<h1>'.get_the_archive_title().'</h1>';
                                    }elseif (is_home()) {
                                        $html .= '<h1>'.esc_html__( 'From the Blog', 'tonsberg' ).'</h1>';
                                    }else {
                                        $html .= '<h1>'.get_the_title().'</h1>';
                                    }
                            $html .= '<ol class="breadcrumb text-center">'.tonsberg_breadcrumb().'</ol>                    
                                </div>
                            </div>
                        </div>
                    </div>';

    $html .= '</div>';
    $html .= '<div class="clearfix"></div>';

    return $html;
}



//GET Social Floating button
if (!function_exists('tonsberg_floating_social_button')) {
    function tonsberg_floating_social_button(){

        $html = '';
        $link = '';
        $fa_class = '';

        if (tonsberg_redux('mt_fixed_social_btn_status') == true) {
            if (tonsberg_redux('mt_fixed_social_btn_social_select') == 'telegram') {
                $link = tonsberg_redux('mt_social_telegram');
                $fa_class = 'fa fa-telegram';
            }elseif (tonsberg_redux('mt_fixed_social_btn_social_select') == 'facebook') {
                $link = tonsberg_redux('mt_social_fb');
                $fa_class = 'fa fa-facebook';
            }elseif (tonsberg_redux('mt_fixed_social_btn_social_select') == 'twitter') {
                $link = tonsberg_redux('mt_social_tw');
                $fa_class = 'fa fa-twitter';
            }elseif (tonsberg_redux('mt_fixed_social_btn_social_select') == 'youtube') {
                $link = tonsberg_redux('mt_social_youtube');
                $fa_class = 'fa fa-youtube-play';
            }elseif (tonsberg_redux('mt_fixed_social_btn_social_select') == 'pinterest') {
                $link = tonsberg_redux('mt_social_pinterest');
                $fa_class = 'fa fa-pinterest-p';
            }elseif (tonsberg_redux('mt_fixed_social_btn_social_select') == 'pinterest') {
                $link = tonsberg_redux('mt_social_pinterest');
                $fa_class = 'fa fa-pinterest-p';
            }elseif (tonsberg_redux('mt_fixed_social_btn_social_select') == 'linkedin') {
                $link = tonsberg_redux('mt_social_linkedin');
                $fa_class = 'fa fa-linkedin';
            }elseif (tonsberg_redux('mt_fixed_social_btn_social_select') == 'skype') {
                $link = tonsberg_redux('mt_social_skype');
                $fa_class = 'fa fa-skype';
            }elseif (tonsberg_redux('mt_fixed_social_btn_social_select') == 'instagram') {
                $link = tonsberg_redux('mt_social_instagram');
                $fa_class = 'fa fa-instagram';
            }elseif (tonsberg_redux('mt_fixed_social_btn_social_select') == 'dribbble') {
                $link = tonsberg_redux('mt_social_dribbble');
                $fa_class = 'fa fa-dribbble';
            }elseif (tonsberg_redux('mt_fixed_social_btn_social_select') == 'deviantart') {
                $link = tonsberg_redux('mt_social_deviantart');
                $fa_class = 'fa fa-deviantart';
            }elseif (tonsberg_redux('mt_fixed_social_btn_social_select') == 'digg') {
                $link = tonsberg_redux('mt_social_digg');
                $fa_class = 'fa fa-digg';
            }elseif (tonsberg_redux('mt_fixed_social_btn_social_select') == 'flickr') {
                $link = tonsberg_redux('mt_social_flickr');
                $fa_class = 'fa fa-flickr';
            }elseif (tonsberg_redux('mt_fixed_social_btn_social_select') == 'stumbleupon') {
                $link = tonsberg_redux('mt_social_stumbleupon');
                $fa_class = 'fa fa-stumbleupon';
            }elseif (tonsberg_redux('mt_fixed_social_btn_social_select') == 'tumblr') {
                $link = tonsberg_redux('mt_social_tumblr');
                $fa_class = 'fa fa-tumblr';
            }elseif (tonsberg_redux('mt_fixed_social_btn_social_select') == 'vimeo') {
                $link = tonsberg_redux('mt_social_vimeo');
                $fa_class = 'fa fa-vimeo';
            }


            $html .= '<a data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Connect on Telegram','tonsberg').'" class="floating-social-btn" target="_blank" href="'.esc_url($link).'">';
                $html .= '<i class="'.esc_attr($fa_class).'"></i>';
            $html .= '</a>';
        }

        return $html;
    }
}

if ( function_exists( 'modeltheme_framework' ) ) {
    function tonsberg_dfi_ids($postID){
        global  $dynamic_featured_image;
        $featured_images = $dynamic_featured_image->get_featured_images( $postID );
        //Loop through the image to display your image
        if( !is_null($featured_images) ){
            $medias = array();
            foreach($featured_images as $images){
                $attachment_id = $images['attachment_id'];
                $medias[] = $attachment_id;
            }
            $ids = '';
            $len = count($medias);
            $i = 0;
            foreach($medias as $media){
                if ($i == $len - 1) {
                    $ids .= $media;
                }else{
                    $ids .= $media . ',';
                }
                $i++;
            }
        } 
        return $ids;
    }
}