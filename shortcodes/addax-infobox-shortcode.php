<?php
  add_shortcode( 'addax_infobox' , 'addax_infobox_html_callback' );

  if ( ! function_exists( 'addax_infobox_html_callback' ) ) {

    function addax_infobox_html_callback( $atts ) {

      extract( shortcode_atts( array(

				'image'  => '',
        'heading' => '',
        'info_text' => '',
        'show_button'=> 'show',
        'btn_text' => '',
        'btn_link' => '',
        'btn_bg_color' => '',
        'btn_hover_color' => '',
        'btn_border_color' => '',
        'btn_txt_color' => '',

			), $atts ) );

      if( !empty( $btn_text ) ) {
        $btn_text = $btn_text;
      }

      if( !empty( $btn_text ) ) {
        $btn_link = $btn_link;
      }

      if( !empty( $btn_bg_color ) ) {
        $btn_bg_color = $btn_bg_color;
      }

      if( !empty( $btn_border_color ) ) {
        $btn_border_color = $btn_border_color;
      }

      if( !empty( $btn_txt_color ) ) {
        $btn_txt_color = $btn_txt_color;
      }

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

            <?php if( !empty( $show_button ) && $show_button == 'show' ) { ?>
            <a style="color:<?php echo $btn_txt_color; ?> !important;background-color:<?php echo $btn_bg_color; ?> !important; border:2px solid <?php echo $btn_border_color; ?> !important; " href="<?php echo $btn_link; ?>" class="btn btn-primary btn-round">
              <?php _e( $btn_text , 'addax'); ?></a>
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

					array(
							'type'      		=> 'dropdown',
							'heading'   		=> esc_html__( 'Show/Hide Button', 'addax' ),
							'param_name' 		=> 'show_button',
							"description" 	=> esc_html__("Show/Hide button for infobox from here.", "addax"),
							'value' => array(
									esc_html__( 'Show', 'addax' ) 	=> 'show',
									esc_html__( 'Hide', 'addax' )  	=> 'hide',
						   )
					),

          array(
					    "type"					=> "textfield",
					    "heading" 			=> __("Button Text", "addax"),
					    "param_name"    => "btn_text",
					    "description"   => __("Enter infobox button text here.", "addax"),
              "dependency" => array(
    						"element" => "show_button",
    						"value"   => array('show'),
    					),
					),

          array(
					    "type"					=> "textfield",
					    "heading" 			=> __("Button Link", "addax"),
					    "param_name"    => "btn_link",
					    "description"   => __("Enter link for button here.", "addax"),
              "dependency" => array(
    						"element" => "show_button",
    						"value"   => array('show'),
    					),
					),

          array(
            "type" => "colorpicker",
            "heading" => __( "Button background color", "addax" ),
            "param_name" => "btn_bg_color",
            "value" => '#0077E5', //Default Red color
            "description" => __( "Choose button background", "addax" ),
            "transparent" => true,
            "dependency" => array(
  						"element" => "show_button",
  						"value"   => array('show'),
  					),
         ),

         array(
           "type" => "colorpicker",
           "heading" => __( "Button text color", "addax" ),
           "param_name" => "btn_txt_color",
           "value" => '#ffffff', //Default Red color
           "description" => __( "Choose button text color", "addax" ),
           "dependency" => array(
             "element" => "show_button",
             "value"   => array('show'),
           ),
        ),

        array(
          "type" => "colorpicker",
          "heading" => __( "Button border color", "addax" ),
          "param_name" => "btn_border_color",
          "value" => '#914CC8', //Default Red color
          "description" => __( "Choose button border color", "addax" ),
          "dependency" => array(
            "element" => "show_button",
            "value"   => array('show'),
          ),
       ),


			)

	) );


}

add_action( 'vc_before_init', 'addax_vc_map_infobox' );

?>
