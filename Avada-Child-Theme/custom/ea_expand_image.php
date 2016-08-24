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

	. '</div>';

}
/* This will add a field in the attachment edit screen for applying a class to the img tag. */

function IMGattachment_fields($form_fields, $post) {
    $form_fields["imageClass"]["label"] = __("Image Class");
    $form_fields["imageClass"]["value"] = get_post_meta($post->ID, "_imageClass", true);
    return $form_fields;
}

add_filter("attachment_fields_to_edit", "IMGattachment_fields", null, 2);
function my_image_attachment_fields_save($post, $attachment) {
    if ( isset($attachment['imageClass']) )
    update_post_meta($post['ID'], '_imageClass', $attachment['imageClass']);
    return $post;
}
add_filter("attachment_fields_to_save", "my_image_attachment_fields_save", null, 2);


/* this works, but not quite what we want.  
function filter_image_send_to_editor($html, $id, $caption, $title, $align, $url, $size, $alt) {
  $html = str_replace('<img ', '<img id="my-super-special-id" ', $html);

  return $html;
}
add_filter('image_send_to_editor', 'filter_image_send_to_editor', 10, 8); */
function add_image_class($class, $id, $align, $size){
    $class .= ' ea-expandable';
    return $class;
}
add_filter('get_image_tag_class','add_image_class');
