<?php
  add_shortcode( 'addax_infobox' , 'addax_infobox_html_callback' );

  if ( ! function_exists( 'addax_infobox_html_callback' ) ) {

    function addax_infobox_html_callback( $atts ) {

      extract( shortcode_atts( array(

				'image'  => '',
        'heading' => '',
        'info_text' => '',

			), $atts ) );

    ob_start();
    ?>

    <div class="addax-info-box">

        <div class="icon-holder wow fadeInUp">
          <?php if( !empty( $image ) ){
            $image = wp_get_attachment_url( $image , 'addax-info-box-img' ); ?>
              <img src="<?php echo $image; ?>">
          <?php } ?>


        </div>

        <div class="info-content wow fadeInDown">

            <?php if( !empty( $heading ) ) { ?>
              <h2><?php _e( $heading , 'addax'); ?></h2>
            <?php } ?>

            <?php if( !empty( $info_text ) ) { ?>
              <p><?php _e( $info_text , 'addax'); ?></p>
            <?php } ?>

        </div>

    </div>


    <?php
    return ob_get_clean();
  }
}


// Visual Composer Map
function addax_vc_map_infobox()
{


	vc_map( array(

      'name'										=> esc_html__( 'Addax Infobox', 'addax' ),
      'base' 				      		  => 'addax_infobox',
      'category'				  			=> esc_html__( 'Addax', 'addax' ),
      'icon'                    => get_template_directory_uri().'/assets/img/adx-fav.png',
      'show_settings_on_create' => true,
      'content_element' 		  	=> true,
      'is_container' 			  		=> true,
	    'params' => array(

            array(
                "type" 					=> "attach_image",
                "heading" 			=> __("Add Icon Image", "addax"),
                "param_name"		=> "image",
                "description"		=> __("Add icon image for infobox here.", "addax")
              ),

					array(
					    "type"					=> "textfield",
					    "heading" 			=> __("Infobox Heading", "addax"),
					    "param_name"    => "heading",
					    "description"   => __("Enter infobox heading here.", "addax")
					),

          array(
					    "type"					=> "textarea",
					    "heading" 			=> __("Infobox Text", "addax"),
					    "param_name"    => "info_text",
					    "description"   => __("Enter infobox text here.", "addax")
					),


       ),


			)

	);


}

add_action( 'vc_before_init', 'addax_vc_map_infobox' );

?>
