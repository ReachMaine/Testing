<?php
/**
 * Superlist child functions and definitions
 *
 * @package Superlist Child
 * @since Superlist Child 1.0.0
 */
require_once(get_stylesheet_directory().'/custom/custom.php'); // custom shortcodes, etc
require_once(get_stylesheet_directory().'/custom/branding.php'); // WP back end login screen
require_once(get_stylesheet_directory().'/custom/language.php');
require_once(get_stylesheet_directory().'/custom/woo.php'); // woocommerce

// trying to remove buildin sections we dont want from food, since its a built in type.
 add_action( 'cmb2_init', 'remove_metabox', 11 );
  function remove_metabox() {
    Inventor_Post_Types::remove_metabox( 'food', array(
         'price','opening_hours', 'details', 'banner',
     ) );

 }

// put video at top & gallery down lower.
 add_filter( 'inventor_listing_detail_sections', 'custom_sections_order', 10, 2 );

 function custom_sections_order( $sections, $post_type ) {
         return array(
                 'video' => esc_attr__( 'Video', 'inventor' ),
                 'description' => esc_attr__( 'Description', 'inventor' ),
                 'overview' => esc_attr__( 'Details', 'inventor' ),
                 'gallery' => esc_attr__( 'Gallery', 'inventor' ),
                 'food-menu' => esc_attr__( 'Meals And Drinks', 'inventor' ),
                 'opening-hours' => esc_attr__( 'Opening Hours', 'inventor' ),
                 'location' => esc_attr__( 'Location', 'inventor' ),
                 'contact' => esc_attr__( 'Contact', 'inventor' ),
                 'social' => esc_attr__( 'Social', 'inventor' ),
                 'faq' => esc_attr__( 'FAQ', 'inventor' ),
                 'comments' => null,
                 'report' => null
         );
 }


 /* add_filter( 'get_the_archive_title', function ($title) {

     if ( is_category() ) {
             $title = single_cat_title( '', false );
         } elseif ( is_tag() ) {
             $title = single_tag_title( '', false );
         } elseif ( is_author() ) {
              $title =  get_the_author() ;
         }

     return $title;

 }); */
