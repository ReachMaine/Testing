<?php /* ea_expand_image */
/* purpose - to allow a light box type of image expansion with out the light box stuff */

add_filter( 'img_caption_shortcode', 'my_img_caption_shortcode', 10, 3 );

function my_img_caption_shortcode( $empty, $attr, $content ){
	$attr = shortcode_atts( array(
		'id'      => '',
		'align'   => 'alignnone',
		'width'   => '',
		'caption' => ''
	), $attr );

	if ( 1 > (int) $attr['width'] || empty( $attr['caption'] ) ) {
		return '';
	}

	if ( $attr['id'] ) {
		$saved_id = $attr['id'];
		$attr['id'] = 'id="' . esc_attr( $attr['id'] ) . '" ';
	}

	return '<div ' . $attr['id']
	. 'class="wp-caption ' . esc_attr( $attr['align'] ) . '" '
	. 'style="max-width: ' . ( 10 + (int) $attr['width'] ) . 'px;">'
	. do_shortcode( $content )
	. '<p class="wp-caption-text">' . $attr['caption'] . '</p>'
	.'<a id="ea-expand" onclick="eaExpandImage()">HERE!</a>'
	// works. '<a id="ea-expand" onclick="this.innerHTML= Date()" >HERE!</a>'
	// also works. '<a id="ea-expand" onclick="this.style.color= '."'".'red'."'".'"">HERE!</a>'
	//works. '<a id="ea-expand" onclick="document.getElementById('."'".$saved_id."'".').style.color = '."'".'red'."'".'"">HERE!</a>'
	//. '<a id="ea-expand" onclick="document.getElementById('."'".$saved_id."'".').animate({width:'."'".'100px'."'".'})">HERE!</a>'
	// nope . '<a id="ea-expand" onclick="jQuery(this).parent().style.color = '."'".'red'."'".'"">HERE!</a>'
	//. '<script> function eaExpand() { this.style.color = red; } </script>'
	.'<script> function myFunction(elmnt,clr) { elmnt.style.color = clr; } </script> '
	. '</div>';

}