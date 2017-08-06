<?php
  add_shortcode( 'addax_progress' , 'addax_progress_html_callback' );

  if ( ! function_exists( 'addax_progress_html_callbackaddax_progress_html_callback' ) ) {

    function addax_progress_html_callback( $atts , $content = NULL ) {
      extract( shortcode_atts( array(

        'progress_style'  => '',

      ), $atts ) );

      if( !empty( $progress_style ) )
      {
        $progress_style = $progress_style;
      }
    ?>

        <ul class="addax-progressbar <?php echo $progress_style; ?>">

          <?php echo do_shortcode($content); ?>

        </ul>


    <?php
    return ob_get_clean();
  }
}


// progress bar items
add_shortcode( 'addax_progress_item' , 'addax_progress_item_html_callback' );

if ( ! function_exists( 'addax_progress_item_html_callback' ) ) {

  function addax_progress_item_html_callback( $atts , $content = NULL ) {

    extract( shortcode_atts( array(

      'progress_text'  => '',
      'progress_percentage' => '',
      'progress_bar_color' => '',
      'progress_text_color' => '',

    ), $atts ) );

    if( !empty( $progress_percentage ) )
    {
      $progress_percentage = $progress_percentage;
    }

    if( !empty( $progress_bar_color ) )
    {
      $progress_bar_color = $progress_bar_color;
    }
    else
    {
      $progress_bar_color = '#000';
    }

  ob_start(); ?>

  <li>

    <div class="ap-bar-title">
      <?php if( !empty( $progress_text ) ) { ?>
      <h4 style="color:<?php echo $progress_text_color; ?> !important;"><?php esc_html_e( $progress_text, 'addax' ); ?></h4>
      <?php } ?>
    </div>

    <div class="ap-bar" data-percent="<?php echo $progress_percentage; ?>%" data-bgcolor="<?php echo $progress_bar_color; ?>">
      <div class="ap-progress">
      </div>
    </div>

  </li>

  <?php
  return ob_get_clean();
}
}


// Visual Composer Map
function addax_vc_map_progress()
{

  vc_map( array(

			'name'										=> esc_html__( 'Addax Progress Bar', 'addax' ),
			'base' 				      		  => 'addax_progress',
			'category'				  			=> esc_html__( 'Addax', 'addax' ),
			'icon'                    => get_template_directory_uri().'/assets/img/adx-fav.png',
      'as_parent' 								=> array('only' => 'addax_progress_item'),
			'show_settings_on_create' => true,
			'content_element' 		  	=> true,
	    'is_container' 			  		=> true,
			'js_view' 				  			=> 'VcColumnView',
      'params' => array(

        array(
            'type'      		=> 'dropdown',
            'heading'   		=> esc_html__( 'Progress Bar Style', 'addax' ),
            'param_name' 		=> 'progress_style',
            "description" 	=> esc_html__("Select style for your progress bar.", "addax"),
            'value' => array(
                esc_html__( 'Style1', 'addax' ) 	=> 'style1',
                esc_html__( 'Style2', 'addax' )  	=> 'style2',
             )
        ),

			) )
	);

	vc_map( array(

      'name'										=> esc_html__( 'Progress Bar', 'addax' ),
      'base' 				      		  => 'addax_progress_item',
      'icon'                    => get_template_directory_uri().'/assets/img/adx-fav.png',
      'as_child' 								=> array('only' => 'addax_progress'),
      'show_settings_on_create' => true,
      'content_element' 		  	=> true,
      'is_container' 			  		=> true,
	    'params' => array(

        array(
            "type" 					=> "textfield",
            "heading" 			=> __("Progress Bar Title", "addax"),
            "param_name"		=> "progress_text",
            "description"		=> __("Add title for current progress here.", "addax")
            ),

        array(
            "type" 					=> "textfield",
            "heading" 			=> __("Progress Bar Percentage", "addax"),
            "param_name"		=> "progress_percentage",
            "description"		=> __("Only number allowed without '%' symbol.", "addax")
            ),
        array(
          "type" => "colorpicker",
          "heading" => __( "Progress Bar Color", "addax" ),
          "param_name" => "progress_bar_color",
          "value" => '#000', //Default Red color
          "description" => __( "Choose color for current progressbar", "addax" )
       ),
       array(
         "type" => "colorpicker",
         "heading" => __( "Progress Bar Text Color", "addax" ),
         "param_name" => "progress_text_color",
         "value" => '#555', //Default Red color
         "description" => __( "Choose color for progressbar text.", "addax" )
      )
			)

	) );

  if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
      class WPBakeryShortCode_addax_progress extends WPBakeryShortCodesContainer {
      }
  }
  if ( class_exists( 'WPBakeryShortCode' ) ) {
      class WPBakeryShortCode_addax_progress_item extends WPBakeryShortCode {
      }
  }


}

add_action( 'vc_before_init', 'addax_vc_map_progress' );


?>
