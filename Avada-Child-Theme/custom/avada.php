<?php 
	// add the tagline next to the logo 
	add_action('avada_logo_append', 'bhi_site_tagline', 10);
	function bhi_site_tagline() {
		$html_out = '';
		$html_out .= '<div class="bhi_site_title_wrapper">';
		$html_out .= 	'<h2 class="bhi_site_title">';
		$html_out .= 		'<a href="'.site_url().'">';
		$html_out .= 			get_bloginfo('name', 'raw');
		$html_out .= 		'</a>';
		$html_out .= 	"</h2>";
		$html_out .= '</div>';
		echo $html_out;
	}