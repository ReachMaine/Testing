<?php
	require_once(get_stylesheet_directory().'/custom/woocommerce.php'); 
	require_once(get_stylesheet_directory().'/custom/ea_expand_image.php'); 
	function theme_enqueue_styles() {
	    wp_enqueue_style( 'avada-parent-stylesheet', get_template_directory_uri() . '/style.css' );
	    //wp_register_script('ea_expand_image', get_stylesheet_directory_uri().'/custom/ea_expand_image.js');
	   	//wp_enqueue_script('ea_expand_image');
	    wp_enqueue_script('ea_expand_image', get_stylesheet_directory_uri().'/custom/ea_expand_image.js', array( 'jquery' ) );

	}
	add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
 	

	function avada_lang_setup() {
		$lang = get_stylesheet_directory() . '/languages';
		load_child_theme_textdomain( 'Avada', $lang );
	}
	add_action( 'after_setup_theme', 'avada_lang_setup' );
	/* end of avada child */
	require_once(get_stylesheet_directory().'/custom/job-manager.php');
	add_filter('widget_text', 'do_shortcode'); // make text widget do shortcodes....

	/* image size for facebook */
	add_image_size( 'facebook_share', 470, 246, true );
	add_image_size('facebook_share_vert', 246, 470, true);
	add_filter('wpseo_opengraph_image_size', 'mysite_opengraph_image_size');
	function mysite_opengraph_image_size($val) {
		return 'facebook_share';
	}
	
		// contact form 7 fallback for date field 
	add_filter( 'wpcf7_support_html5_fallback', '__return_true' );
	
	/*****  change the login screen logo ****/
	function my_login_logo() { ?>
		<style type="text/css">
			body.login div#login h1 a {
				background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/mdih-admin-img.png);
				padding-bottom: 30px;
				background-size: contain;
				margin-left: 0px;
				margin-bottom: 0px;
				margin-right: 0px;
				height: 60px;
				width: 100%;
			}
		</style>
	<?php }
	add_action( 'login_enqueue_scripts', 'my_login_logo' );
