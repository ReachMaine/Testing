<?php 
	/* functions for wp-job-manager */

	// adding job location DDL, I hope.

//'type'        => 'term-select',

	// example to change placeholder //
	/* add_filter( 'job_manager_job_listing_data_fields', 'custom_job_manager_job_listing_data_fields' );

	// This is your function which takes the fields, modifies them, and returns them
	// You can see the fields which can be changed here: https://github.com/mikejolley/WP-Job-Manager/blob/master/includes/admin/class-wp-job-manager-writepanels.php
	function custom_job_manager_job_listing_data_fields( $fields ) {

	    // Here we target one of the job fields (location) and change it's placeholder
	    $fields['_job_location']['placeholder'] = "Custom placeholder";

	    // And return the modified fields
	    return $fields;
	} */

	// add company location field...
	add_filter( 'submit_job_form_fields', 'frontend_add_mdih_fields' );
	function frontend_add_mdih_fields( $fields ) {
	  $fields['job']['mdih_location'] = array(
	    'label'       => __( 'MDIH Company', 'job_manager' ),
	    'type'        => 'text',
	    'required'    => true,
	    'placeholder' => 'placeholder',
	    'priority'    => 7
	  );
	    $fields['job']['mdih_select'] = array(
	    'label'       => __( 'MDIH select', 'job_manager' ),
	    'type'        => 'select',
	    'required'    => true,
	    //'options'	  => array('one', 'two', 'three'),
	    'placeholder' => 'placeholder',
	    'priority'    => 8
	  );
	  return $fields;
	}
	// add field in backend....
	add_filter( 'job_manager_job_listing_data_fields', 'admin_add_mdih_field' );
	function admin_add_mdih_field( $fields ) {
	  $fields['_mdih_location'] = array(
	    'label'       => __( 'MDIH Company', 'job_manager' ),
	    'type'        => 'text',
	    'placeholder' => 'test',
	    'description' => 'mdihco descript'
	  );
	    $fields['_mdih_select'] = array(
	    'label'       => __( 'MDIH select', 'job_manager' ),
	    'type'        => 'select',
	    'options'	  => array('none', 'one', 'two', 'three'),
	    'placeholder' => 'testings',
	    'description' => 'select descript'
	  );
	  return $fields;
	}
	// add field to display....
	add_action( 'single_job_listing_meta_end', 'display_mdih_field' );
	function display_mdih_field() {
		global $post;

		$mdhico = get_post_meta( $post->ID, '_mdih_location', true );

		if ( $mdhico ) {
		echo '<li>' . __( 'mdhico:' ) . esc_html( $mdhico ) . '</li>';
		}
		$mdihselect = get_post_meta( $post->ID, '_mdih_select', true );
		$out_select = "nada";
		if ( $mdihselect ) {
			$out_select = "something";
			switch ($mdiselect) {
				case 0: $out_select = "none";
				break;
				case 1: $out_select = "first";
				break;
				case 2: $out_select = "second";
				break;
				case 3: $out_select = "third";
				break;
			}
			echo '<li>' . __( 'select:' ) . esc_html( $mdihselect ) . ' '.$out_select. '</li>';
		}
		//echo '<li>' . __( 'select:' ) . esc_html( $mdihselect ) . ' '.$out_select. '</li>';
	}