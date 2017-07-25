<?php
  add_shortcode( 'addax_accordion' , 'addax_accordion_html_callback' );

  if ( ! function_exists( 'addax_accordion_html_callback' ) ) {

    function addax_accordion_html_callback( $atts , $content = NULL ) {


    ob_start();
    ?>

    <div class="panel-group wrap" id="addax-accordion">

      <?php echo do_shortcode( $content ); ?>

    </div>
    <?php
    return ob_get_clean();
  }
}

// Panel Shortcode
add_shortcode( 'accordion_panel' , 'accordion_panel_html_callback' );

if ( ! function_exists( 'accordion_panel_html_callback' ) ) {

  function accordion_panel_html_callback( $atts , $content = NULL ) {

    extract( shortcode_atts( array(

      'panel_title' => '',
      'panel_content' => '',

    ), $atts ) );

    if( !empty( $panel_title ) )
    {
       $panel_title = __( $panel_title , 'addax' );
    }
    else {
      $panel_title = __( 'Accordion Title' , 'addax' );
    }

    if( !empty( $panel_content ) )
    {
       $panel_content = __( $panel_content , 'addax' );
    }
    else {
      $panel_content = __( 'Please add accordion content here.' , 'addax' );
    }

    $panel_id = strtolower( str_replace(" ","-", $panel_title ) );
  ob_start();
  ?>

      <div class="panel">
        <div class="panel-heading">
          <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#" href="#<?php echo $panel_id; ?>">
          <?php echo $panel_title; ?>
        </a>
      </h4>
        </div>
        <div id="<?php echo $panel_id; ?>" class="panel-collapse collapse">
          <div class="panel-body">
            <?php echo $panel_content; ?>
          </div>
        </div>

      </div>



  <?php
  return ob_get_clean();
}
}


// Visual Composer Map
function addax_vc_map_accordion()
{

  vc_map( array(

			'name'										=> esc_html__( 'Addax Accordions', 'addax' ),
			'base' 				      		  => 'addax_accordion',
			'category'				  			=> esc_html__( 'Addax', 'addax' ),
			'icon'                    => get_template_directory_uri().'/assets/img/adx-fav.png',
      'as_parent' 								=> array('only' => 'accordion_panel'),
			'show_settings_on_create' => false,
			'content_element' 		  	=> true,
	    'is_container' 			  		=> false,
			'js_view' 				  			=> 'VcColumnView',

			)
	);

	vc_map( array(

      'name'										=> esc_html__( 'Accordion', 'addax' ),
      'base' 				      		  => 'accordion_panel',
      'icon'                    => get_template_directory_uri().'/assets/img/adx-fav.png',
      'as_child' 								=> array('only' => 'addax_accordion'),
      'show_settings_on_create' => true,
      'content_element' 		  	=> true,
      'is_container' 			  		=> true,
	    'params' => array(

        array(
            "type"					=> "textfield",
            "heading" 			=> __("Title", "addax"),
            "param_name"    => "panel_title",
            "description"   => __("Enter title for accordiong tab here.", "addax")
        ),

        array(
            "type"					=> "textarea",
            "heading" 			=> __("Content", "addax"),
            "param_name"    => "panel_content",
            "description"   => __("Add content for accordion here.", "addax")
        ),
      )
			)

	);

  if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
      class WPBakeryShortCode_addax_accordion extends WPBakeryShortCodesContainer {
      }
  }
  if ( class_exists( 'WPBakeryShortCode' ) ) {
      class WPBakeryShortCode_accordion_panel extends WPBakeryShortCode {
      }
  }


}

add_action( 'vc_before_init', 'addax_vc_map_accordion' );

?>
