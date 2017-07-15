<?php
  add_shortcode( 'addax_clients' , 'addax_clients_html_callback' );

  if ( ! function_exists( 'addax_clients_html_callback' ) ) {

    function addax_clients_html_callback( $atts , $content = NULL ) {

      extract( shortcode_atts( array(

				'heading'  => '',
        'sub_heading' => '',
        'halign' => 'alignCenter'

			), $atts ) );

    if( !empty( $halign ) ){
      $halign = $halign;
    }

    ob_start();
    ?>

    <div class="container">

      <div class="addax-client-carousel wow fadeInUp" data-client-quantity="4">

          <?php echo do_shortcode($content); ?>

      </div>

    </div>


    <?php
    return ob_get_clean();
  }
}

// Client Image Shortcode
add_shortcode( 'addax_client_image' , 'addax_client_image_html_callback' );

if ( ! function_exists( 'addax_client_image_html_callback' ) ) {

  function addax_client_image_html_callback( $atts , $content = NULL ) {

    extract( shortcode_atts( array(

      'image' => ''

    ), $atts ) );

  if( !empty( $image ) ){
    $image = wp_get_attachment_url( $image , 'large' );
  }

  ob_start();
  ?>

  <div class="ac-client">
      <img src="<?php echo $image; ?>">
  </div>


  <?php
  return ob_get_clean();
}
}


// Visual Composer Map
function addax_vc_map_clients()
{

  vc_map( array(

			'name'										=> esc_html__( 'Addax Clients', 'addax' ),
			'base' 				      		  => 'addax_clients',
			'category'				  			=> esc_html__( 'Addax', 'addax' ),
			'icon'                    => get_template_directory_uri().'/assets/img/adx-fav.png',
      'as_parent' 								=> array('only' => 'addax_client_image'),
			'show_settings_on_create' => false,
			'content_element' 		  	=> true,
	    'is_container' 			  		=> false,
			'js_view' 				  			=> 'VcColumnView',

			)
	);

	vc_map( array(

      'name'										=> esc_html__( 'Addax Heading', 'addax' ),
      'base' 				      		  => 'addax_client_image',
      'icon'                    => get_template_directory_uri().'/assets/img/adx-fav.png',
      'as_child' 								=> array('only' => 'addax_clients'),
      'show_settings_on_create' => true,
      'content_element' 		  	=> true,
      'is_container' 			  		=> true,
	    'params' => array(

        array(
            "type" 					=> "attach_image",
            "heading" 			=> __("Add Image/Logo", "addax"),
            "param_name"		=> "image",
            "description"		=> __("Add image logo for your client.", "addax")
            ),
			)

	) );

  if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
      class WPBakeryShortCode_addax_clients extends WPBakeryShortCodesContainer {
      }
  }
  if ( class_exists( 'WPBakeryShortCode' ) ) {
      class WPBakeryShortCode_addax_client_image extends WPBakeryShortCode {
      }
  }


}

add_action( 'vc_before_init', 'addax_vc_map_clients' );

?>
