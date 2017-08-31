<?php
/* languages customizations
* 'Username', 'inventor'
*/
	if ( !function_exists('eai_change_theme_text') ){
		function eai_change_theme_text( $translated_text, $text, $domain ) {
				switch ($domain) {
					case  'inventor':
						switch ($translated_text) {
							   case 'Username':
								 	$translated_text = 'Username or Email';
								 break;
						}
				}
	    	return $translated_text;
		}
		add_filter( 'gettext', 'eai_change_theme_text', 20, 3 );
	}

?>
