<?php
  add_shortcode( 'addax_button' , 'addax_button_html_callback' );

  if ( ! function_exists( 'addax_button_html_callback' ) ) {

    function addax_button_html_callback( $atts ) {

      extract( shortcode_atts( array(

				'button_text'  => 'Button',
        'button_link' => '',
        'button_size' => '',
        'button_color' => '',
        'button_text_color'=> '#fff',
        'button_color_type' => '',
        'to' => '',
        'from' => '',
        'button_border_color' => '',
        'button_border_weight' => '',
        'button_align' => ''

			), $atts ) );

      if( !empty( $button_text_color ) )
      {
        $button_text_color = 'color:' . $button_text_color . ' !important;';
      }

      if( $button_color_type == 'solid' )
      {

          $btn_bg = '
                  background: '. $button_color .' !important;
                ';
      }
      elseif( $button_color_type == 'gradient' )
      {
          $btn_bg = '
          background: '. $to .' !important;
          background: -webkit-linear-gradient( left , '. $to .', '. $from .') !important;
          background: -o-linear-gradient( right, '. $to .', '. $from .') !important;
          background: -moz-linear-gradient( right , '. $to .', '. $from .') !important;
          background: linear-gradient( to right , '. $to .', '. $from .') !important;
          ';

      }
      elseif( $button_color_type == 'transparent' )
      {
            $btn_bg = '
              background: none !important;
              border-width: '. $button_border_weight .'px !important;
              border-color: '. $button_border_color .' !important;
            ';
      }

      switch( $button_align )
      {
        case 'left':
          $button_align = 'float:left !important;';
        break;
        case 'right':
          $button_align = 'float:right !important;';
        break;
      }

    ob_start();
    if( $button_align == 'center' ) echo '<center>';  // Add opening <center> tag
    ?>

      <a href="<?php echo esc_html( $button_link ); ?>" class="btn btn-primary btn-round <?php echo $button_size;  ?>" style="<?php echo $button_text_color . $btn_bg . $button_align;  ?>"><?php echo esc_html_e( $button_text , 'addax' ); ?></a>

    <?php if( $button_align == 'center' )  echo '</center>';// Add closing </center> tag  ?>

      <div class="clearfix"></div>
    <?php
    return ob_get_clean();
  }
}


// Visual Composer Map
function addax_vc_map_button()
{


	vc_map( array(

      'name'										=> esc_html__( 'Addax Button', 'addax' ),
      'base' 				      		  => 'addax_button',
      'category'				  			=> esc_html__( 'Addax', 'addax' ),
      'icon'                    => get_template_directory_uri().'/assets/img/adx-fav.png',
      'show_settings_on_create' => true,
      'content_element' 		  	=> true,
      'is_container' 			  		=> false,
	    'params' => array(

					array(
					    "type"					=> "textfield",
					    "heading" 			=> __("Button Text", "addax"),
					    "param_name"    => "button_text",
              "default"       => "Button"
					),
					array(
							 "type" 				=> "textfield",
							 "heading" 		  => __("Button URL Link", "addax"),
							 "param_name" 	=> "button_link",
							 "description"  => __("Enter sub heading here. This will shown below main heading.", "addax")
						 ),

					array(
							'type'      		=> 'dropdown',
							'heading'   		=> esc_html__( 'Button Size', 'addax' ),
							'param_name' 		=> 'button_size',
							'value' => array(
									esc_html__( 'Default', 'addax' ) 	=> 'btn-lg',
                  esc_html__( 'Full Width Button', 'addax' )  => 'btn-block',
						   )
					),

        array(
           "type" => "colorpicker",
           "heading" => __( "Button Text Color", "addax" ),
           "param_name" => "button_text_color",
           "value" => '#fff', //Default Red color
           "description" => __( "Choose sub heading color", "addax" )
        ),

        array(
            'type'      		=> 'dropdown',
            'heading'   		=> esc_html__( 'Button Background Color Type', 'addax' ),
            'param_name' 		=> 'button_color_type',
            'value' => array(
                esc_html__( 'Solid', 'addax' ) 	=> 'solid',
                esc_html__( 'Gradient', 'addax' )  	=> 'gradient',
                esc_html__( 'Transparent', 'addax' )  	=> 'transparent'
             )
        ),

        array(
          "type" => "colorpicker",
          "heading" => __( "Button Background Solid Color", "addax" ),
          "param_name" => "button_color",
          "value" => '#0077E5',
          'dependency' => array(
            'element' => 'button_color_type',
            'value' => 'solid',
          ),
       ),


       array(
         "type" => "colorpicker",
         "heading" => __( "Gradient Color 1", "addax" ),
         "param_name" => "to",
         "value" => '#0077E5',
         'dependency' => array(
           'element' => 'button_color_type',
           'value' => 'gradient',
         ),
      ),

      array(
        "type" => "colorpicker",
        "heading" => __( "Gradient Color 2", "addax" ),
        "param_name" => "from",
        "value" => '#4dacff',
        'dependency' => array(
          'element' => 'button_color_type',
          'value' => 'gradient',
          ),
      ),

      array(
        "type" => "colorpicker",
        "heading" => __( "Button Border Color", "addax" ),
        "param_name" => "button_border_color",
        "value" => '#0077E5',
        'dependency' => array(
          'element' => 'button_color_type',
          'value' => 'transparent',
          ),
      ),

      array(
           "type" 				=> "textfield",
           "heading" 		  => __("Button Border Weight", "addax"),
           "param_name" 	=> "button_border_weight",
           "description"  => __("Only Numbers Allowed without 'px'", "addax"),
           'dependency' => array(
             'element' => 'button_color_type',
             'value' => 'transparent',
             ),
      ),

      array(
          'type'      		=> 'dropdown',
          'heading'   		=> esc_html__( 'Button Align', 'addax' ),
          'param_name' 		=> 'button_align',
          'value' => array(
              esc_html__( 'Left', 'addax' ) 	=> 'left',
              esc_html__( 'Center', 'addax' )  	=> 'center',
              esc_html__( 'Right', 'addax' )  	=> 'right'
           )
      ),


			)

	) );


}

add_action( 'vc_before_init', 'addax_vc_map_button' );

?>
