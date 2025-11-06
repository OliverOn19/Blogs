<?php 
//Insert ads after second paragraph of single post content.
 
add_filter( 'the_content', 'tonsberg_insert_post_ads' );
function tonsberg_insert_post_ads( $content ) {
     
$ad_code = '';
    
    if ( function_exists('modeltheme_framework')) {
        if (tonsberg_redux('mt_adplace_blog_post')) {
            if(tonsberg_redux('mt_adplace_blog_post_adsense_code') != '' && tonsberg_redux('mt_adplace_blog_post') == 'on_adsense'){
                $ad_code = tonsberg_redux('mt_adplace_blog_post_adsense_code');
            }elseif(tonsberg_redux('mt_adplace_blog_post') == 'on'){
                $ad_code = '<div class="adplace-blog-post">
                    <a href="'.esc_url(tonsberg_redux('mt_adplace_blog_post_link')).'" target="_blank">
                        <img src="'.esc_url(tonsberg_redux('mt_adplace_blog_post_img','url')).'" alt="mt_adplace_blog_post_img" />
                    </a>
                </div>';
            }elseif (tonsberg_redux('mt_adplace_blog_post') == 'off') {
                $ad_code = '';
            }
        }
    }

    if ( is_single() && ! is_admin() ) {
        return tonsberg_insert_after_paragraph( $ad_code, 3, $content );
    }
     
    return $content;
}
  
// Parent Function that makes the magic happen
function tonsberg_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
    $closing_p = '</p>';
    $paragraphs = explode( $closing_p, $content );
    foreach ($paragraphs as $index => $paragraph) {
 
        if ( trim( $paragraph ) ) {
            $paragraphs[$index] .= $closing_p;
        }
 
        if ( $paragraph_id == $index + 1 ) {
            $paragraphs[$index] .= $insertion;
        }
    }
     
    return implode( '', $paragraphs );
}

?>