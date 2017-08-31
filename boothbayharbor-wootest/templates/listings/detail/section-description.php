<?php global $post; ?>

	<div class="detail-banner-info">
		<?php /* */
			$backp = "";
			//$backp .= '<div class="detail-back-to-type">';
			$backp .= '<a href="'.get_post_type_archive_link( get_post_type() ).'">'.get_post_type_object( get_post_type() )->labels->name.'</a>' ;
			$backp .= " / ";

			//$backp .= '</div>';
		?>
			<?php $listing_category = Inventor_Query::get_listing_category_name( get_the_ID(), ',', true ); ?>

			<?php if ( ! empty( $listing_category ) ) : ?>
					<div class="detail-label"><?php echo $backp.wp_kses( $listing_category, wp_kses_allowed_html( 'post' ) ); ?></div>
			<?php endif; ?>

	</div><!-- /.detail-banner-info -->

	<h1 class="detail-title">
			<?php /* echo apply_filters( 'inventor_listing_title', get_the_title(), get_the_ID() ); */ ?>
			<?php echo get_the_title(); ?>
	</h1>

	<?php $slogan = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'slogan', true ); ?>
	<?php if ( ! empty( $slogan ) ) : ?>
			<h4 class="detail-banner-slogan">
					<?php echo esc_attr( $slogan ); ?>
			</h4>
	<?php endif; ?>

    <?php /* maps vars */ ?>
		<?php $map_latitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_latitude', true );?>
		<?php $map_longitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_longitude', true );?>
		<?php $map_polygon = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_polygon', true );?>
		<?php $map_location_address = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_address', true );?>
		<?php $map_type = get_theme_mod( 'inventor_general_listing_map_type', 'ROADMAP' );?>
		<?php $map = ! empty( $map_latitude ) || ! empty ( $map_longitude ); ?>

    <?php if ( class_exists( 'Inventor_Google_Map' ) && ( ! empty ( $map ) || ! empty ( $street_view ) ) ) { $two_cols = true;  }  else {$two_cols = false; }?>
		<?php if ($two_cols) { ?>
			<div class="row">
					 <div class="col-md-6">
		<?php } ?>

		<?php $logo = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'logo', true );
				if ( ! empty( $logo ) ) {
				$rendered_logo = '<img src="'. $logo .'" class="listing-title-logo" alt="' . get_the_title( $post_id ) . '">';
				echo $rendered_logo;
			}
		?>
	<?php /* vars for contact */ ?>
	<?php $email = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'email', true ); ?>
	<?php $website = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'website', true ); ?>
	<?php $phone = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'phone', true ); ?>
	<?php $address = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'address', true ); ?>
	<?php $allyear = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'yearround', true ); ?>
	<?php $pets = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'petfriendly', true ); ?>
 <?php if ( ! empty( $phone ) || ! empty( $address ) || ! empty( $email ) || ! empty( $website ) || ! empty($pets) || ! empty($allyear) )    {?>
	<div class="listing-detail-contact">
			<ul>
					<?php if ( ! empty( $address ) ): ?>
							<li class="address">
									<?php echo wp_kses( nl2br( $address ), wp_kses_allowed_html( 'post' ) ); ?>
							</li>
					<?php endif; ?>
					<?php if ( ! empty( $phone ) ): ?>
							<li class="phone"><i class="fa fa-phone"></i>
									<a href="tel:<?php echo wp_kses( str_replace(' ', '', $phone), wp_kses_allowed_html( 'post' ) ); ?>"><?php echo wp_kses( $phone, wp_kses_allowed_html( 'post' ) ); ?></a>
							</li>
					<?php endif; ?>
					<?php if ( ! empty( $email ) ): ?>
							<li class="email antispamd"><i class="fa fa-envelope"></i>
											<a target="_blank" href="mailto:<?php echo antispambot(esc_attr( $email ) ); ?>"><?php echo antispambot(esc_attr( $email )); ?></a>
							</li>
					<?php endif; ?>
					<?php if ( ! empty( $website ) ): ?>
							<?php /* if ( strpos( $website, 'http' ) !== 0 ) $website = sprintf( 'http://%s', $website );  zig xout*/
								$website_display = preg_replace('#^https?://#', '', $website) ; // strip off http:  or https
								if(substr($website_display, -1) == '/') { // check for trailing slash
										$website_display = substr($website_display, 0, -1);
								} ?>
							<li class="website"><i class="fa fa-link"></i>
											<a href="<?php echo esc_attr( $website ); ?>" target="_blank"><?php echo esc_attr($website_display); ?></a>
							</li>
					<?php endif; ?>
					<?php if (! empty($allyear)) { ?>
						<li class="yearround"><i class="fa fa-snowflake-o"></i> Open Year Round</li>
					<?php } ?>
					<?php if (! empty($pets)) { ?>
						<li class="petfriendly"><i class="fa fa-paw"></i> Pet Friendly</li>
					<?php } ?>
			</ul>
	</div><!-- /.listing-detail-contact -->
<?php } ?>




<?php

$default_social_networks = Inventor_Metaboxes::social_networks();
$social_networks = apply_filters( 'inventor_metabox_social_networks', array(), get_post_type() );
$social = '';

foreach( $social_networks as $key => $title ) {
    $field_id = INVENTOR_LISTING_PREFIX . $key;

    if ( apply_filters( 'inventor_metabox_field_enabled', true, INVENTOR_LISTING_PREFIX . get_post_type() . '_social', $field_id, get_post_type() ) ) {
        $social_value = get_post_meta( get_the_ID(), $field_id, true );

        if ( ! empty( $social_value ) ) {
            $class = array_key_exists( $key, $default_social_networks ) ? 'default' : '';
            $social_network_name = $social_networks[ $key ];

            $social_network_url = apply_filters( 'inventor_social_network_url', esc_attr( $social_value ), $key );
            $social .= '<a href="' . $social_network_url . '" target="_blank" class="' . $class . '"><i class="fa fa-'. esc_attr( $key ) .'"></i><span>' . $social_network_name . '</a>';
        }
    }
}
?>

<?php if ( ! empty( $social ) ) : ?>
    <div id="listing-detail-section-social" class="listing-detail-section">
        <div class="listing-detail-section-content-wrapper">
            <?php echo $social; ?>
        </div>
    </div><!-- /.listing-detail-section -->
<?php endif; ?>



<?php if ($two_cols) { ?>
			</div><!-- /.col-* -->
			<div class="col-md-6">
<?php } ?>

	<?php $street_view = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'street_view', true );?>
	<?php $inside_view = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view', true );?>
	<?php if ( class_exists( 'Inventor_Google_Map' ) && ( ! empty ( $map ) || ! empty ( $street_view ) ) ) { ?>
		<div class="listing-detail-section"  id="listing-detail-section-location">
			<div class="listing-detail-location-wrapper">
				<!-- Nav tabs -->
				<ul id="listing-detail-location" class="nav nav-tabs" role="tablist">

						<?php if ( ! empty( $map ) ) : ?>
								<li role="presentation" class="nav-item active">
										<a href="#simple-map-panel" aria-controls="simple-map-panel" role="tab" data-toggle="tab" class="nav-link">
												<i class="fa fa-map"></i><?php echo __( 'Map', 'inventor' ); ?>
										</a>
								</li>
						<?php endif; ?>

						<?php if ( ! empty( $street_view ) ) : ?>
								<li role="presentation" class="nav-item <?php echo empty( $map ) ? 'active' : ''; ?>">
										<a href="#street-view-panel" aria-controls="street-view-panel" role="tab" data-toggle="tab" class="nav-link">
												<i class="fa fa-street-view"></i><?php echo __( 'Street View', 'inventor' ); ?>
										</a>
								</li>
						<?php endif; ?>

						<?php if ( ! empty( $inside_view ) ) : ?>
								<li role="presentation" class="nav-item <?php echo ( empty( $map ) && empty( $street_view ) ) ? 'active' : ''; ?>">
										<a href="#inside-view-panel" aria-controls="inside-view-panel" role="tab" data-toggle="tab" class="nav-link">
												<i class="fa fa-home"></i><?php echo __( 'See Inside', 'inventor' ); ?>
										</a>
								</li>
						<?php endif; ?>

						<li class="nav-item directions">
								<a href="https://maps.google.com?daddr=<?php echo esc_attr( $map_latitude ); ?>,<?php echo esc_attr( $map_longitude ); ?>" class="nav-link" target="_blank">
										<i class="fa fa-level-down"></i><?php echo __( 'Directions', 'inventor' ) ?>
								</a>
						</li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
						<?php if ( ! empty( $map ) ) : ?>
								<div role="tabpanel" class="tab-pane fade in active" id="simple-map-panel">
										<div class="detail-map">
												<div class="map-position">
														<div id="listing-detail-map"
																 data-transparent-marker-image="<?php echo get_template_directory_uri(); ?>/assets/img/transparent-marker-image.png"
																 data-latitude="<?php echo esc_attr( $map_latitude ); ?>"
																 data-longitude="<?php echo esc_attr( $map_longitude ); ?>"
																 data-polygon-path="<?php echo esc_attr( $map_polygon ); ?>"
																 data-zoom="15"
																 data-fit-bounds="false"
																 data-marker-style="simple"
																 <?php if ( ! empty( $map_location_address ) ): ?>data-marker-content='<span class="marker-content"><?php echo $map_location_address; ?></span>'<?php endif; ?>
																 data-map-type="<?php echo esc_attr( $map_type ); ?>">
														</div><!-- /#map-property -->
												</div><!-- /.map-property -->
										</div><!-- /.detail-map -->
								</div>
						<?php endif; ?>

						<?php if ( ! empty( $street_view ) ) : ?>
								<?php $street_view_latitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'street_view_location_latitude', true );?>
								<?php $street_view_longitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'street_view_location_longitude', true );?>
								<?php $street_view_heading = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'street_view_location_heading', true );?>
								<?php $street_view_pitch = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'street_view_location_pitch', true );?>
								<?php $street_view_zoom = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'street_view_location_zoom', true );?>

								<div role="tabpanel" class="tab-pane fade<?php echo empty( $map ) ? ' in active' : ''; ?>" id="street-view-panel">
										<div id="listing-detail-street-view"
												 data-latitude="<?php echo esc_attr( $street_view_latitude ); ?>"
												 data-longitude="<?php echo esc_attr( $street_view_longitude ); ?>"
												 data-heading="<?php echo esc_attr( $street_view_heading ); ?>"
												 data-pitch="<?php echo esc_attr( $street_view_pitch ); ?>"
												 data-zoom="<?php echo esc_attr( $street_view_zoom ); ?>">
										</div>
								</div>
						<?php endif; ?>

						<?php if ( ! empty( $inside_view ) ) : ?>
								<?php $inside_view_latitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_latitude', true );?>
								<?php $inside_view_longitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_longitude', true );?>
								<?php $inside_view_heading = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_heading', true );?>
								<?php $inside_view_pitch = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_pitch', true );?>
								<?php $inside_view_zoom = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_zoom', true );?>

								<div role="tabpanel" class="tab-pane fade<?php echo ( empty( $map ) && empty( $street_view ) ) ? ' in active' : ''; ?>" id="inside-view-panel">
										<div id="listing-detail-inside-view"
												 data-latitude="<?php echo esc_attr( $inside_view_latitude ); ?>"
												 data-longitude="<?php echo esc_attr( $inside_view_longitude ); ?>"
												 data-heading="<?php echo esc_attr( $inside_view_heading ); ?>"
												 data-pitch="<?php echo esc_attr( $inside_view_pitch ); ?>"
												 data-zoom="<?php echo esc_attr( $inside_view_zoom ); ?>">
										</div>
								</div>
						<?php endif; ?>

				</div>
		</div>
</div><!-- /.listing-detail-section -->
<?php } ?>
<?php if ($two_cols) { ?>
			</div><!-- /.col-* -->
		</div><!-- /.row -->
<?php } ?>
		<?php if ( ! empty( $post->post_content ) ) : ?>
			<div class="listing-detail-section" id="listing-detail-section-description">
					<div class="listing-detail-description-wrapper">
			    	<?php the_content(); ?>
				</div>
			</div><!-- /.listing-detail-section -->

		<?php endif; ?>
