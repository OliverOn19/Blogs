<?php
// Add backend styles for Gutenberg.
add_action( 'enqueue_block_editor_assets', 'tonsberg_add_gutenberg_assets' );
/**
 * Load Gutenberg stylesheet.
 */
function tonsberg_add_gutenberg_assets() {
	// Load the theme styles within Gutenberg.
	wp_enqueue_style( 'tonsberg-gutenberg-style', get_theme_file_uri( '/css/gutenberg-editor-style.css' ), false );
    wp_enqueue_style( 
        'tonsberg-gutenberg-fonts', 
        '//fonts.googleapis.com/css?family=Montserrat%3A200%2C200i%2C300%2C300i%2C400%2C400i%2C500%2C500i%2C600%2C600i%2C700%2C700i%2C800%2C800i%2C900%2C900i%7CLibre+Baskerville%3Aregular%2Citalic%2C700%2Clatin-ext%2Clatin' 
    ); 
}
?>