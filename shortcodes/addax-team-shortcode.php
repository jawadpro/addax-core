<?php
  add_shortcode( 'addax_team' , 'addax_team_html_callback' );

  if ( ! function_exists( 'addax_team_html_callback' ) ) {

    function addax_team_html_callback( $atts ) {

      extract( shortcode_atts( array(

				'heading'  => '',
        'order' => 'ASC',
        'btn_text' => '',
        'btn_link' => '',
        'heading_bg_color' => '',
        'heading_txt_color' => '',
        'btn_bg_color' => '',
        'btn_txt_color' => ''

			), $atts ) );


      if( !empty( $btn_link ) )
      {
        $btn_link = $btn_link;
      }

      if( !empty( $heading_bg_color ) )
      {
        $heading_bg_color = 'style="background:' . $heading_bg_color . '!important;"';
      }

      if( !empty( $heading_txt_color ) )
      {
        $heading_txt_color = 'style="color:' . $heading_txt_color . '!important;"';
      }

      if( !empty( $btn_txt_color ) )
      {
        $btn_txt_color = 'style="color:' . $btn_txt_color . '!important;"';
      }

      if( !empty( $btn_txt_color ) )
      {
        $btn_txt_color = 'style="background:' . $btn_txt_color . '!important;"';
      }


      // WP-Query Arguments
      $args = array(
         'post_type' => 'adx-team',
         'order' => $order      );
      $query = new WP_Query( $args );

    // Checking if query have data
    if( $query->have_posts() ) :

    ob_start();
    ?>

    <div id="addax-team-grid" class=" wow fadeIn" data-wow-delay=".2s">

        <div class="container-full">

            <div class="row">

              <?php if( !empty( $heading ) ) : ?>
                <div class="col-sm-6 col-md-3 no-padding">
                    <div class="team-grid team-heading" <?php echo $heading_bg_color; ?>>
                        <div class="text">
                            <h1 class="addax-heading styler1 alignLeft" <?php echo $heading_txt_color; ?>><?php echo esc_html_e( $heading, 'addax' ); ?></h1>
                        </div>
                    </div>
                </div>
              <?php endif; ?>


              <?php
              while( $query->have_posts() ) : $query->the_post();
              global $post;
              $member_position = get_post_meta( $post->ID , 'team_member_positon' , true );
              $member_image = get_post_meta( $post->ID , 'team_member_image' , true );
              $member_image_url = wp_get_attachment_image_src( $member_image , 'addax-team-member-img' );
              ?>

                <div class="col-sm-6 col-md-3 no-padding">
                    <div class="team-grid">
                        <div class="team-img">
                          <?php if( !empty( $member_image_url ) ) { ?>

                            <img src="<?php echo $member_image_url[0]; ?>">

                          <?php } ?>

                        </div>

                        <div class="overlay">
                        </div>

                        <div class="team-info style1">
                            <?php if( !empty( $member_position ) ) { ?>
                             <h3><?php echo _e( get_the_title() , 'addax' ); ?></h3>
                            <?php } ?>

                            <?php if( !empty( $member_position ) ) { ?>
                             <p><?php echo esc_html_e( $member_position , 'addax' ); ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>

              <?php endwhile; wp_reset_postdata(); ?>

                <?php if( !empty( $btn_text ) )  { ?>
                 <div class="col-sm-6 col-md-3 no-padding">
                    <div class="team-grid join-team" <?php echo $btn_bg_color;  ?>>
                        <a href="<?php echo esc_html($btn_link);  ?>"><h3 <?php echo $btn_txt_color;  ?>><?php echo esc_html_e( $btn_text , 'addax' ); ?></h3></a>
                    </div>
                </div>
                <?php } ?>

            </div>


        </div>


    </div>

    <?php
    return ob_get_clean();
  endif;
  }
}


// Visual Composer Map
function addax_vc_map_team()
{


	vc_map( array(

      'name'										=> esc_html__( 'Addax Team', 'addax' ),
      'base' 				      		  => 'addax_team',
      'category'				  			=> esc_html__( 'Addax', 'addax' ),
      'icon'                    => get_template_directory_uri().'/assets/img/adx-fav.png',
      'show_settings_on_create' => true,
      'content_element' 		  	=> true,
      'is_container' 			  		=> true,
	    'params' => array(

					array(
					    "type"					=> "textfield",
					    "heading" 			=> __("Main Heading", "addax"),
					    "param_name"    => "heading",
					    "description"   => __("Enter section heading here.", "addax")
					),

          array(
            "type" => "colorpicker",
            "heading" => __( "Heading text Color", "addax" ),
            "param_name" => "heading_txt_color",
            "value" => '#fff', //Default Red color
            "description" => __( "Choose section heading text color", "addax" )
         ),

         array(
           "type" => "colorpicker",
           "heading" => __( "Heading Background Color", "addax" ),
           "param_name" => "heading_bg_color",
           "value" => '#3E424E', //Default Red color
           "description" => __( "Choose section heading background color", "addax" )
        ),

					array(
							'type'      		=> 'dropdown',
							'heading'   		=> esc_html__( 'Team Member Order', 'addax' ),
							'param_name' 		=> 'order',
							"description" 	=> esc_html__("Select order of team member list from here.", "addax"),
							'value' => array(
									esc_html__( 'Ascending', 'addax' ) 	=> 'ASC',
									esc_html__( 'Descending', 'addax' )  	=> 'DESC',
						   )
					),

          array(
					    "type"					=> "textfield",
					    "heading" 			=> __("Button Text Section", "addax"),
					    "param_name"    => "btn_text",
					    "description"   => __("Enter section button here. Leave empty if you don't want to show button", "addax")
					),

          array(
					    "type"					=> "textfield",
					    "heading" 			=> __("Button Link", "addax"),
					    "param_name"    => "btn_link",
					    "description"   => __("Enter button link here", "addax")
					),


         array(
           "type" => "colorpicker",
           "heading" => __( "Button text color", "addax" ),
           "param_name" => "btn_txt_color",
           "value" => '#fff', //Default Red color
           "description" => __( "Choose button text color from here", "addax" )
        ),

        array(
          "type" => "colorpicker",
          "heading" => __( "Button background color", "addax" ),
          "param_name" => "btn_bg_color",
          "value" => '#0076FF', //Default Red color
          "description" => __( "Choose button background color from here", "addax" )
       ),

			)

	) );


}

add_action( 'vc_before_init', 'addax_vc_map_team' );

?>
