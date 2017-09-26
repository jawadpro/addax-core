<?php
  add_shortcode( 'addax_counter' , 'addax_counter_html_callback' );

  if ( ! function_exists( 'addax_counter_html_callback' ) ) {

  function addax_counter_html_callback( $atts ) {

    extract( shortcode_atts( array(

      'number' => '',
      'text' => '',
      'font_size' => '',
      'plus_sign' => '',
      'text_color' => ''

    ), $atts ) );

    $pSign = '';
    if( !empty( $plus_sign ) && $plus_sign == true )
    {
      $pSign = '+';
    }

    if( !empty( $text_color ) )
    {
      $text_color = $text_color;
    }

    if( !empty( $font_size ) )
    {
      $font_size = 'style="font-size:'.$font_size.'px !important"';
    }

  ob_start();
  ?>


    <div class="addax-counter-box style1" style="color:<?php echo $text_color; ?> ">

       <?php if( !empty( $number ) ) { ?>
         <h3 <?php echo $font_size; ?>>
           <span class="counter" <?php echo $font_size; ?>><?php echo $number; ?></span>
           <?php echo $pSign; ?>
         </h3>
        <?php } ?>

        <?php if( !empty( $text ) ) { ?>
          <h4><?php echo $text; ?></h4>
         <?php } ?>

    </div>

  <?php
  return ob_get_clean();
}
}


// Visual Composer Map
function addax_vc_map_counter()
{

	vc_map( array(

      'name'										=> esc_html__( 'Addax Counter', 'addax' ),
      'base' 				      		  => 'addax_counter',
      'category'				  			=> esc_html__( 'Addax', 'addax' ),
      'icon'                    => get_template_directory_uri().'/assets/img/adx-fav.png',
      'show_settings_on_create' => true,
      'content_element' 		  	=> true,
      'is_container' 			  		=> false,
      'params' => array(

        array(
            "type" 					=> "textfield",
            "heading" 			=> __("Counter Number", "addax"),
            "param_name"		=> "number",
            "description"		=> __("Enter number for counter. Only numbers allowed.", "addax")
            ),
        array(
            "type" 					=> "checkbox",
            "heading" 			=> __("Add '+' symbol ?", "addax"),
            "param_name"		=> "plus_sign",
            "description"		=> __("This will add '+' sign next to number.", "addax")
          ),
        array(
            "type" 					=> "textfield",
            "heading" 			=> __("Counter Text", "addax"),
            "param_name"		=> "text",
            "description"		=> __("Enter text for counter.", "addax")
          ),
      array(
          "type" 					=> "textfield",
          "heading" 			=> __("Counter Font Size", "addax"),
          "param_name"		=> "font_size",
          "description"		=> __("Only Number Allowed without 'px'.", "addax")
        ),
        array(
            "type" 					=> "colorpicker",
            "heading" 			=> __("Counter Text Color", "addax"),
            "param_name"		=> "text_color",
            "value" => '#555', //Default Red color
            "description"		=> __("Choose counter text color.", "addax")
          ),
			) )

	);

}

add_action( 'vc_before_init', 'addax_vc_map_counter' );

?>
