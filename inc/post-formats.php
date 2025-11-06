<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');


class TonsbergPostFormats {


	public static function gallery($content = '') {
		if(empty($content)) {
			$content = get_the_content();
		}

		// Get the first [gallery] shortcode and if found it...
		if (preg_match("!\[gallery.*?\]!", $content, $match_gallery)) {

			echo do_shortcode($match_gallery[0]);

			// Removes gallery shortcode from original content
			$content = str_replace($match_gallery[0], "", $content);
		}

		return self::esc($content);
	}


	public static function link($content = '') {
		if(empty($content)) {
			$content = get_the_content('');
		}

		// Try find URL at start of content and extract it
		if (preg_match('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $content, $match_link)) {
			// Define title URL as being the extracted URL
			// $content['title_href'] = $link[0];
			// Remove link from content
			$content = str_replace($match_link[0], "", $content);
		}

		$return = array(
			'content' => self::esc($content),
			'link' => isset($match_link[0]) ? $match_link[0] : esc_url(get_permalink()),
		);

		return $return;
	}


	public static function image($img_class = '') {
		if (has_post_thumbnail()) {
			?><a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>" class="<?php echo esc_attr($img_class); ?>-lk">
				<?php the_post_thumbnail( self::get_option('posts--img_size'), array('title' => get_the_title(), 'class' => $img_class) ); ?>
			</a><?php
		}
	}


	public static function video($content = '') {
		if(empty($content)) {
			$content = get_the_content();
		}

		// Wraps video URLs in [embed] tags
		$content = preg_replace('|^\s*(https?://[^\s"]+)\s*$|im', "[embed]$1[/embed]", get_the_content(''));

		// Find a [embed] or [video] shortcode in the content and extract it. If found a video inside content, take the first and extract
		if (preg_match("!\[embed.+?\]|\[video.+?\]\[\/video\]|\[playlist.+?\]!", $content, $match_video)) {

			global $wp_embed;

			// Display Video
			echo '<div class="post-video">'. do_shortcode($wp_embed->run_shortcode($match_video[0])) . '</div>';

			// Removes video from content
			$content = str_replace($match_video[0], "", $content);
		}

		return self::esc($content);
	}


	public static function audio($content = '') {
		if(empty($content)) {
			$content = get_the_content();
		}

		// Wraps audio URLs in [embed] tags
		$content = preg_replace('|^\s*(https?://[^\s"]+)\s*$|im', "[embed]$1[/embed]", get_the_content(''));

		// Find a [embed] or [audio] shortcode in the content and extract it. If found a audio inside content, take the first and extract
		if (preg_match("!\[embed.+?\]|\[audio.+?\](?:\[\/audio\])?|\[playlist.+?\]!", $content, $match_audio)) {

			global $wp_embed;

			// Display audio
			echo '<div class="post-audio">'. do_shortcode($wp_embed->run_shortcode($match_audio[0])) . '</div>';

			// Removes audio from content
			$content = str_replace($match_audio[0], "", $content);
		}

		return self::esc($content);
	}

	public static function esc($content = '') {
		if(empty($content)) {
			$content = get_the_content();
		}

		$content = strip_shortcodes($content);

		// Try find URL at start of content and extract it
		if (preg_match('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $content, $match_link)) {
			// Define title URL as being the extracted URL
			// $content['title_href'] = $link[0];
			// Remove link from content
			$content = str_replace($match_link[0], "", $content);
		}

		return wp_kses($content, array());
	}

}
