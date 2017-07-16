<?php
  add_shortcode( 'addax_heading' , 'addax_heading_html_callback' );

  if ( ! function_exists( 'addax_heading_html_callback' ) ) {

    function addax_heading_html_callback( $atts ) {

      extract( shortcode_atts( array(

				'heading'  => '',
        'sub_heading' => '',
        'halign' => 'alignCenter',
        'heading_color'=> '#555',
        'sub_heading_color' => '#555',

			), $atts ) );

    if( !empty( $halign ) ){
      $halign = $halign;
    }

    if( !empty( $heading_color ) ){
      $heading_color = $heading_color;
    }

    if( !empty( $sub_heading_color ) ){
      $sub_heading_color = $sub_heading_color;
    }

    ob_start();
    ?>

    <div class="container">


          <?php if( !empty( $heading ) ){ ?>

          <h1 class="addax_heading <?php echo $halign;  ?> wow fadeInUp" style="color:<?php echo $heading_color; ?>; font-weight:300; font-size:2.5em;">

            <?php _e( $heading , 'addax'); ?>

          </h1>

         <?php } ?>

         <?php if( !empty( $sub_heading ) ){ ?>

        <h3 class="addax-subheading <?php echo $halign;  ?> wow fadeInUp" data-wow-delay=".2s" style="color:<?php echo $sub_heading_color;  ?>; font-size:18px;margin-bottom:30px">

          <?php _e( $sub_heading , 'addax'); ?>

        </h3>

        <?php } ?>

    </div>


    <?php
    return ob_get_clean();
  }
}


// Visual Composer Map
function addax_vc_map_heading()
{


	vc_map( array(

      'name'										=> esc_html__( 'Addax Heading', 'addax' ),
      'base' 				      		  => 'addax_heading',
      'category'				  			=> esc_html__( 'Addax', 'addax' ),
      'icon'                    => get_template_directory_uri().'/assets/img/adx-fav.png',
      'show_settings_on_create' => true,
      'content_element' 		  	=> true,
      'is_container' 			  		=> true,
	    'params' => array(

					array(
					    "type"					=> "textfield",
					    "heading" 			=> __("Main Heading", "addax"),
					    "param_name"    => "heading",
					    "description"   => __("Enter section main heading here.", "addax")
					),
					array(
							 "type" 				=> "textfield",
							 "heading" 		  => __("Sub Heading", "addax"),
							 "param_name" 	=> "sub_heading",
							 "description"  => __("Enter sub heading here. This will shown below main heading.", "addax")
						 ),

					array(
							'type'      		=> 'dropdown',
							'heading'   		=> esc_html__( 'Heading Alignment', 'addax' ),
							'param_name' 		=> 'halign',
							"description" 	=> esc_html__("Align you heading text from here.", "addax"),
							'value' => array(

									esc_html__( 'Center', 'addax' ) 	=> 'alignCenter',
									esc_html__( 'Right', 'addax' )  	=> 'alignRight',
									esc_html__( 'Left', 'addax' )  		=> 'alignLeft',
						   )
					),

          array(
            "type" => "colorpicker",
            "heading" => __( "Heading Color", "addax" ),
            "param_name" => "heading_color",
            "value" => '#555', //Default Red color
            "description" => __( "Choose Heading color", "addax" )
         ),

         array(
           "type" => "colorpicker",
           "heading" => __( "Sub Heading Color", "addax" ),
           "param_name" => "sub_heading_color",
           "value" => '#555', //Default Red color
           "description" => __( "Choose sub heading color", "addax" )
        )
			)

	) );


}

add_action( 'vc_before_init', 'addax_vc_map_heading' );

?>
