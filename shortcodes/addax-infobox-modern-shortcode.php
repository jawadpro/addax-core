<?php
  add_shortcode( 'addax_infobox_modern' , 'addax_infobox_modern_html_callback' );

  if ( ! function_exists( 'addax_infobox_modern_html_callback' ) ) {

    function addax_infobox_modern_html_callback( $atts ) {

      extract( shortcode_atts( array(

				'box_icon'  => '',
        'heading' => '',
        'info_text' => '',

			), $atts ) );

    ob_start();
    ?>

    <div class="addax-info-box2">
       <a href="services/land-freight/index.html">
          <span class="icon_wrapper"><i class="fa fa-globe" aria-hidden="true"></i></span>

           <div class="category_block">
               <h6>Land Freight</h6>
               <p><p>Provides air freight services to meet up with your transportation needs, professional services to deliver your air freight fast and safe to its final destination.</p>
              </p>
           </div>
       </a>
   </div>

    <?php
    return ob_get_clean();
  }
}


// Visual Composer Map
function addax_vc_map_infobox_modern()
{


	vc_map( array(

      'name'										=> esc_html__( 'Addax Infobox', 'addax' ),
      'base' 				      		  => 'addax_infobox_modern',
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

add_action( 'vc_before_init', 'addax_vc_map_infobox_modern' );

?>
