<?php /*archive listing when in row
*  mods:
* 10Apr17 - remove hover actions
          - add addres & phone.
* 17Apr17 zig - use logo instead of featured image here (category archive)
* 24Apr17 zig - move title to top of container.
 */ ?>


<?php $featured = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'featured', true ); ?>
<?php $reduced = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'reduced', true ); ?>

<?php /* if ( has_post_thumbnail() ) : ?>
    <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' ); ?>
    <?php $image = $thumbnail[0]; ?> */
    $logo = get_post_meta(  get_the_ID(), INVENTOR_LISTING_PREFIX . 'logo', true );
    if ( ! empty( $logo ) ) :
      $image = $logo; ?>
<?php else: ?>
    <?php $image = get_stylesheet_directory_uri().'/images/default-item.jpg'; /* zig changed default image */ ?>
<?php endif; ?>

<?php $image = apply_filters( 'inventor_listing_featured_image', $image, get_the_ID() ); ?>

<div class="listing-row <?php if ( $featured ) : ?>featured<?php endif; ?>">
    <h2 class="listing-row-title"><a href="<?php the_permalink(); ?>"><?php echo Inventor_Utilities::excerpt( get_the_title(), 50 ); ?></a></h2>
    <div class="listing-row-image" >
        <a href="<?php the_permalink() ?>" class="listing-row-image-link"><img src="<?php echo esc_attr( $image ); ?>"></a>

        <div class="listing-row-actions">
            <?php /*  do_action( 'inventor_listing_actions', get_the_ID(), 'row' ); */ ?>
        </div><!-- /.listing-row-actions -->

        <?php /* if ( $featured ) : ?>
            <div class="listing-row-label-top listing-row-label-top-left"><?php echo esc_attr__( 'Featured', 'inventor' ); ?></div><!-- /.listing-row-label-top-left -->
        <?php endif; */ ?>

        <?php if ( $reduced ) : ?>
            <div class="listing-row-label-top listing-row-label-top-right"><?php echo esc_attr__( 'Reduced', 'inventor' ); ?></div><!-- /.listing-row-label-top-right -->
        <?php endif; ?>

        <?php /*$listing_type_name = Inventor_Post_Types::get_listing_type_name(); ?>
        <?php if ( ! empty( $listing_type_name ) ) : ?>
            <div class="listing-row-label-bottom"><?php echo wp_kses( $listing_type_name, wp_kses_allowed_html( 'post' ) ); ?></div><!-- /.listing-row-label-bottom -->
        <?php endif; */ ?>
    </div><!-- /.listing-row-image -->


    <div class="listing-row-body">
        <?php /* <h2 class="listing-row-title"><a href="<?php the_permalink(); ?>"><?php echo Inventor_Utilities::excerpt( get_the_title(), 50 ); ?></a></h2> */ ?>
        <div class="listing-row-content">
            <?php /* the_excerpt(); */ ?>
            <?php
                $phone = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'phone', true );
                $address = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'address', true );
                 $website = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'website', true );
                if ( ! empty( $phone ) ||  ! empty( $address ) || ! empty($website) )  {
                  echo ' <div class="bbh-listing-detail-contact">';
                    echo '<ul>';
                    if ( ! empty( $address  ) ) {
                       echo '<li class="address">';
                        echo wp_kses( nl2br( $address ), wp_kses_allowed_html( 'post' ) );
                       echo '</li>';
                    }
                      if ( ! empty( $phone ) ) {
                         echo '<li class="phone">';
                          echo '<a href="tel:'.wp_kses( str_replace(' ', '', $phone), wp_kses_allowed_html( 'post' ) ).'">'.wp_kses( $phone, wp_kses_allowed_html( 'post' ) ).'</a>';
                         echo '</li>';
                      }
                      if ( ! empty( $website ) ) {
                        $website_display = preg_replace('#^https?://#', '', $website);
                        if (substr($website_display, 0,4) == 'www.') { // strip off www. if it's there.
                          $website_display = substr($website_display , 4, strlen($website_display));
                        }
                        if (substr($website_display, -1) == '/') { // check for trailing slash
        										$website_display = substr($website_display , 0, -1);
        								}
                        $website_display = "Website";
                         echo '<li class="website">';
                          echo '<a href="'.esc_attr( $website ).'" target="_blank"><button>'.esc_attr($website_display).'</button></a>';
                         echo '</li>';
                      }
                    echo '</ul>';
                  echo '</div> <!-- listing-detail-contact-->';
                }
           ?>
           <p>
               <a class="read-more-link" href="<?php echo esc_attr( get_permalink( get_the_ID() ) ); ?>"><?php echo esc_attr__( 'More Details', 'inventor' ); ?><i class="fa fa-chevron-right"></i></a>
           </p>
        </div><!-- /.listing-row-content -->
    </div><!-- /.listing-row-body -->

    <?php /* zout <div class="listing-row-properties">
        <dl>
            <?php $price = Inventor_Price::get_price( get_the_ID() ); ?>
            <?php if ( ! empty( $price ) ) : ?>
                <dt><?php echo esc_attr__( 'Price', 'inventor' ); ?></dt>
                <dd><?php echo wp_kses( $price, wp_kses_allowed_html( 'post' ) ); ?></dd>
            <?php endif; ?>

            <?php $location = Inventor_Query::get_listing_location_name( get_the_ID(), '/', false ); ?>
            <?php if ( ! empty( $location ) ) : ?>
                <dt><?php echo esc_attr__( 'Location', 'inventor' ); ?></dt>
                <dd><?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?></dd>
            <?php endif; ?>

            <?php do_action( 'inventor_listing_content', get_the_ID(), 'row' ); ?>
        </dl>
    </div><!-- /.listing-row-properties --> */ ?>
</div><!-- /.listing-row -->
