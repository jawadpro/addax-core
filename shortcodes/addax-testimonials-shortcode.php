<?php
  add_shortcode( 'addax_testimonials' , 'addax_testimonials_html_callback' );

  if ( ! function_exists( 'addax_testimonials_html_callback' ) ) {

    function addax_testimonials_html_callback( $atts ) {

      extract( shortcode_atts( array(

				'heading'  => '',
        'bg_image' => '',
        'client_info_hide' => 'no',
        'parallax' => 'no',
        'text_color' => '',

			), $atts ) );

      // WP-Query Arguments
      $args = array(
         'post_type' => 'adx-testimonial',
         'posts_per_page ' => -1
      );

      $query = new WP_Query( $args );


      if( !empty( $bg_image ) )
      {
        $bg_image = wp_get_attachment_image_src( $bg_image , 'full' );
      }

      if( !empty( $text_color ) )
      {
        $text_color = $text_color;
      }

      if( !empty( $parallax ) && $parallax == "yes" )
      {
        $parallax = 'parallax';
      }

    ob_start();
    ?>

    <!-- testimonial sectio // style1 -->
  <?php  if( $query->have_posts() ) : ?>

  <div id="addax-testimonial" class="style1 <?php echo $parallax; ?>" style="background:url('<?php echo $bg_image[0]; ?>');">

      <div class="testimonial-container">
      <?php if( !empty( $heading ) ) { ?>
      <h1 class="at-title" style="color:<?php echo $text_color; ?> !important;"><?php echo esc_html_e( $heading, 'addax' ); ?></h1>
      <?php } ?>

      <div class="at-carousel">

        <?php
          while( $query->have_posts() ) : $query->the_post();
          global $post;
          $client_designation = get_post_meta( $post->ID , 'client_desgi' , true );
          $client_image_id = get_post_meta( $post->ID , 'client_image' , true );
          $client_image_url = wp_get_attachment_image_src( $client_image_id , 'addax-testimonial-img' );
          $client_feedback = get_post_meta( $post->ID , 'client_feedback' , true );
        ?>

        <div class="at-review">
            <p style="color:<?php echo $text_color; ?> !important;"><?php echo esc_html_e( $client_feedback , 'addax' ) ?></p>

          <div class="client-info">

            <?php if( !empty( $client_image_id ) ) { ?>
            <div class="ci-img" style="background:url('<?php echo $client_image_url[0]; ?>'); background-repeat:no-repeat;background-size:cover;" >
            </div>
            <?php } ?>

             <?php if( !empty( $client_info_hide ) && $client_info_hide == 'yes' ) { ?>
            <div class="ci-details">
              <h3 style="color:<?php echo $text_color; ?> !important;"><?php echo _e( get_the_title() , 'addax' ) ?></h3>
              <h4 style="color:<?php echo $text_color; ?> !important;"><?php echo esc_html_e( $client_designation , 'addax' ); ?></h4>
            </div>
            <?php } ?>
          </div>
        </div>

      <?php endwhile; wp_reset_postdata(); ?>



      </div>
    </div>

  <div class="at-nav">
      <a href="#0" class="prev"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
      <a href="#0" class="next"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
    </div>

  </div>

<?php endif; ?>

  <!-- testimonial section end -->


    <?php
    return ob_get_clean();
  }
}


// Visual Composer Map
function addax_vc_map_testimonial()
{


	vc_map( array(

      'name'										=> esc_html__( 'Addax Testimonials', 'addax' ),
      'base' 				      		  => 'addax_testimonials',
      'category'				  			=> esc_html__( 'Addax', 'addax' ),
      'icon'                    => get_template_directory_uri().'/assets/img/adx-fav.png',
      'show_settings_on_create' => true,
      'content_element' 		  	=> true,
      'is_container' 			  		=> true,
	    'params' => array(

					array(
					    "type"					=> "textfield",
					    "heading" 			=> __("Section Heading", "addax"),
					    "param_name"    => "heading",
					    "description"   => __("Enter heading for testimonial section here.", "addax")
					),

          array(
              "type" 					=> "attach_image",
              "heading" 			=> __("Section Background Image", "addax"),
              "param_name"		=> "bg_image",
              "description"		=> __("Select background image for section from here.", "addax")
            ),

					array(
							'type'      		=> 'dropdown',
							'heading'   		=> esc_html__( 'Background parallax' , 'addax' ),
							'param_name' 		=> 'parallax',
							"description" 	=> esc_html__("Make backgorund image parallax from here", "addax"),
							'value' => array(
                  '' => '',
									esc_html__( 'Yes', 'addax' ) 	=> 'yes',
									esc_html__( 'No', 'addax' )  	=> 'no',
						   )
					),

          array(
							'type'      		=> 'dropdown',
							'heading'   		=> esc_html__( 'Hide Client\'s Info' , 'addax' ),
							'param_name' 		=> 'client_info_hide',
							"description" 	=> esc_html__("Hide/Show Client\'s Image", "addax"),
							'value' => array(
                  '' => '',
									esc_html__( 'Yes', 'addax' ) 	=> 'yes',
									esc_html__( 'No', 'addax' )  	=> 'no',
						   )
					),

          array(
            "type" => "colorpicker",
            "heading" => __( "Section text color", "addax" ),
            "param_name" => "text_color",
            "value" => '#fff', //Default Red color
            "description" => __( "Choose testimonial section text color", "addax" )
         ),


	) ) );


}

add_action( 'vc_before_init', 'addax_vc_map_testimonial' );

?>
