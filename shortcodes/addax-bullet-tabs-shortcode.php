<?php
if ( ! function_exists( 'addax_tabs_html_callback' ) ) {

	function addax_tabs_html_callback( $atts , $content = NULL ){

		extract( shortcode_atts( array(

				'tabs'   		=> '',

			), $atts ) );

			ob_start(); ?>


	     <div id="addax-tab" class="bullet-tab" >

			<?php
			if( !empty( $tabs ) ) {

				if( function_exists( 'vc_param_group_parse_atts' ) ) {

					$tabs = vc_param_group_parse_atts( $tabs );
					$i = 0;

					?>
							<ul class="nav nav-tabs">

							<?php
              foreach( $tabs as $single_tab ) {
                $split_words = str_replace( ' ' , '<br>' , $single_tab['tab_title'] );
                ?>
                <li class="<?php	if( $i == 0 ) { echo 'active'; } ?>"><a data-toggle="tab" href="#<?php echo 'tab-' . $i; ?>"><?php echo $split_words; ?>
                  <span class="circle"></span>
                </a>
                </li>

								<?php $i++; ?>

							<?php } ?>

						 	</ul>

              <div class="tab-content">

							<?php
							$i = 0;

							foreach( $tabs as $single_tab ) { ?>

              <div id="<?php echo 'tab-' . $i; ?>" class="tab-pane fade <?php	if( $i == 0 ) { echo 'active in'; } ?>">
                  <?php
                  $image_url = '';
                  $image_id = ( isset( $single_tab['tab_image'] ) ) ? $single_tab['tab_image'] : '';
                  if( !empty( $image_id ) ) :
                    $get_image = wp_get_attachment_image_src( $image_id , 'addax-tab-image' );
                    $image_url = $get_image[0];
                  endif;
                  ?>
                <p class="alignright"><img src="<?php echo $image_url; ?>"><p>
								<p><?php _e( $single_tab['tab_text'] , 'addax' ); ?></p>

							</div>

							<?php $i++; ?>


						 <?php } ?>

						</div>

					<?php }
         } ?>
</div>
          <?php

		 return ob_get_clean();
	}
}
add_shortcode('addax_tabs', 'addax_tabs_html_callback');

// Visual Composer Map
function addax_vc_map_bullet_tabs()
{

		vc_map(
    array(
			'name'										=> esc_html__( 'Addax Bullet Tabs', 'addax' ),
			'base' 				      		  => 'addax_tabs',
			'category'				  			=> esc_html__( 'Addax', 'addax' ),
			//'icon'                    => get_template_directory_uri().'/images/addax-icon-vc.png',
			'show_settings_on_create' => true,
			'content_element' 		  	=> true,
			'is_container' 			  		=> false,
        'params' => array(
					array(
            "param_name"		=> "info",
							"description"		=> esc_html__("User Down Arrow on each tabs to toggle.", "addax")
					),

            // params group
            array(

                'type' => 'param_group',
								"heading" 			=> __("Add Tabs", "addax"),
								"param_name"		=> "text",
								"description"		=> __("Add tab from + icon", "addax"),
                'param_name' 		=> 'tabs',
                'params' => array(
                    array(
                        'type' 				=> 'textfield',
                        'value' 			=> '',
                        'heading' 		=> esc_html__("Tab Title", "addax"),
                        'param_name' 	=> 'tab_title',
                    ),
                    array(
                        'type' 				=> 'attach_image',
                        'value' 			=> '',
                        'heading' 		=> esc_html__("Tab Image", "addax"),
                        'param_name' 	=> 'tab_image',
                    ),
										array(
                        'type' 				=> 'textarea',
                        'value' 			=> '',
                        'heading' 		=> esc_html__("Tab Text", "addax"),
                        'param_name' 	=> 'tab_text',
                    ),

                )
            )
        )
    )
);
}

add_action( 'vc_before_init', 'addax_vc_map_bullet_tabs' );
////https//wpbakery.atlassian.net/wiki/display/VC/Use+Param+Group+in+Elements
?>
