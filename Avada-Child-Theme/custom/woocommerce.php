<?php 
/* woocommerce */
	/* add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

	function woo_remove_product_tabs( $tabs ) {

		// unset( $tabs['description'] );      	// Remove the description tab
		// unset( $tabs['reviews'] ); 			// Remove the reviews tab
		unset( $tabs['additional_information'] );  	// Remove the additional information tab

		return $tabs;

	}*/


	// remove sku from product details.
	add_filter( 'wc_product_sku_enabled', '__return_false' );
	
	add_action('woocommerce_before_order_notes', 'zig_shipping_gift_msg', 30, 1);
	function zig_shipping_gift_msg($checkout) {
	 	echo '<p class="bhi-gift-shipping">If you would like this gift certificate sent to its recipient, please use the shipping address.</p>';
	}
