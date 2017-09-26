<?php
  add_shortcode( 'addax_icons_container' , 'addax_icons_container_html_callback' );

  if ( ! function_exists( 'addax_icons_container_html_callback' ) ) {

    function addax_icons_container_html_callback( $atts , $content = NULL ) {
    ob_start();
    ?>

    
            <ul class="addax-icon-box drop-shadow">
              <?php echo do_shortcode( $content ); ?>
            </ul>
    
    <?php
    return ob_get_clean();
  }
}

// Icon Box
add_shortcode( 'addax_icon_box' , 'addax_icon_box_html_callback' );

if ( ! function_exists( 'addax_icon_box_html_callback' ) ) {

  function addax_icon_box_html_callback( $atts ) {

    extract( shortcode_atts( array(

      'title' => '',
      'sub_title' => '',
      'fa_icon' => '',
      'link' => ''
    ), $atts ) );

  ob_start();
  ?>

  <li>
    <div class="icon-holder">
      <i class="<?php echo $fa_icon; ?>" aria-hidden="true"></i>
    </div>

    <div class="content-holder">

      <?php if( !empty( $title ) ) : ?>
        <h3><?php esc_html_e( $title, 'addax' ); ?></h3>
      <?php endif; ?>

      <?php if( !empty( $sub_title ) ) : ?>
        <p><?php esc_html_e( $sub_title , 'addax' ); ?></p>
      <?php endif; ?>

      <?php if( !empty( $link ) ) : ?>
        <a href="<?php echo esc_url($link); ?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
      <?php endif; ?>

    </div>

  </li>


  <?php
  return ob_get_clean();
}
}


// Visual Composer Map
function addax_vc_map_icon_box()
{

  vc_map( array(

			'name'										=> esc_html__( 'Addax Icon Box', 'addax' ),
			'base' 				      		  => 'addax_icons_container',
			'category'				  			=> esc_html__( 'Addax', 'addax' ),
			'icon'                    => get_template_directory_uri().'/assets/img/adx-fav.png',
      'as_parent' 								=> array('only' => 'addax_icon_box'),
			'show_settings_on_create' => false,
			'content_element' 		  	=> true,
	    'is_container' 			  		=> false,
			'js_view' 				  			=> 'VcColumnView',

			)
	);

	vc_map( array(

      'name'										=> esc_html__( 'Icon Box', 'addax' ),
      'base' 				      		  => 'addax_icon_box',
      'icon'                    => get_template_directory_uri().'/assets/img/adx-fav.png',
      'as_child' 								=> array('only' => 'addax_icons_container'),
      'show_settings_on_create' => true,
      'content_element' 		  	=> true,
      'is_container' 			  		=> true,
	    'params' => array(

        array(
         'type' => 'iconpicker',
         'heading' => __( 'Box Icon', 'addax' ),
         'param_name' => 'fa_icon',
         'value' => 'fa fa-adjust', // default value to backend editor admin_label
         'settings' => array(
           'emptyIcon' => false,
           'iconsPerPage' => 100,
         ),
         'description' => __( 'Select icon from library.', 'js_composer' ),
       ),


        array(
            "type"					=> "textfield",
            "heading" 			=> __("Title", "addax"),
            "param_name"    => "title",
            "description"   => __("Title for icon box.", "addax")
        ),
        array(
             "type" 				=> "textfield",
             "heading" 		  => __("Sub Title", "addax"),
             "param_name" 	=> "sub_title",
             "description"  => __("Sub title for icon box.", "addax")
           ),
      //  array(
      //       "type" 				=> "textfield",
      //       "heading" 		  => __("Icon Code", "addax"),
      //       "param_name" 	=> "icon",
      //       "description"  => __("You can select icon from here <a href=''>Font Awesome</a>. Just paste the icon code here e.g 'fa fa-heart-o'", "addax")
      //     ),
      array(
           "type" 				=> "textfield",
           "heading" 		  => __("Icon Box Link", "addax"),
           "param_name" 	=> "link",
           "description"  => __("Add link to icon box. Leave empty if you don't want to link icon box.", "addax")
         ),


			)

	) );


  if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
      class WPBakeryShortCode_addax_icons_container extends WPBakeryShortCodesContainer {
      }
  }
  if ( class_exists( 'WPBakeryShortCode' ) ) {
      class WPBakeryShortCode_addax_icon_box extends WPBakeryShortCode {
      }
  }
wp_enqueue_style( 'font-awesome' );

}

add_action( 'vc_before_init', 'addax_vc_map_icon_box' );





?>
