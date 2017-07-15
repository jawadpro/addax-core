<?php
  add_shortcode( 'addax-slider' , 'addax_slider_html_callback' );

  if ( ! function_exists( 'addax_slider_html_callback' ) ) {

    function addax_slider_html_callback( $atts ) {

      extract( shortcode_atts( array(

				'slider'  => ''

			), $atts ) );

      // WP-Query Arguments
      $args = array(
  	     'post_type' => 'addax-slider',
  	     'tax_query' => array(
    		array(
    			 'taxonomy' => 'adx-slider-category',
    			 'field'    => 'slug',
    			 'terms'    => $slider,
    		   ),
    	  ),
      );

      $query = new WP_Query( $args );

    // Checking if query have data
    if( $query->have_posts() ) :
    ob_start();
    ?>

    <div id="addax-hero-container">
      <div id="addax-hero">

        <?php
        // Loop Start
        while( $query->have_posts() ) : $query->the_post();
        global $post;
        $slide_img_id = get_post_meta( $post->ID , 'slide_image' , true );
        $slide_img_url = wp_get_attachment_image_src( $slide_img_id , 'full' );
        $slide_sub_heading = get_post_meta( $post->ID , 'slide_sub_heading' , true );
        $slide_bg_overlay = get_post_meta( $post->ID , 'slide_bg_overlay' , true );
        $background_parallex = get_post_meta( $post->ID , 'background_parallex' , true );
        $button_one_text = get_post_meta( $post->ID , 'button_one_text' , true );
        $button_one_link = get_post_meta( $post->ID , 'button_one_link' , true );
        $button_two_text = get_post_meta( $post->ID , 'button_two_text' , true );
        $button_two_link = get_post_meta( $post->ID , 'button_two_link' , true );
        $content_position = get_post_meta( $post->ID , 'content_position' , true );
        $main_heading_text_size = get_post_meta( $post->ID , 'main_heading_text_size' , true );
        $sub_heading_text_size = get_post_meta( $post->ID , 'sub_heading_text_size' , true );
        $main_heading_text_color = get_post_meta( $post->ID , 'main_heading_text_color' , true );
        $sub_heading_text_color = get_post_meta( $post->ID , 'sub_heading_text_color' , true );

        if( $slide_img_url == false ) { $slide_img_url = ''; }
        if( $slide_bg_overlay == 'yes' ) { $slide_bg_overlay = 'slide-overlay'; }
        if( $background_parallex == 'yes' ) { $background_parallex = 'parallax'; }
        if( $content_position == 'center' ) { $content_position = 'alignCenter'; }
        if( $content_position == 'left' ) { $content_position = 'half left alignRight'; }
        if( $content_position == 'right' ) { $content_position = 'half right'; }
        if( empty( $main_heading_text_color ) ) { $main_heading_text_color = '#fff'; }
        if( empty( $sub_heading_text_color ) ) { $sub_heading_text_color = '#fff'; }

        ?>

             <div class="ah-content <?php echo $slide_bg_overlay .' '. $background_parallex; ?>" style="background-image:url('<?php echo $slide_img_url[0]; ?>')">
                <div class="ah-holder <?php echo $content_position; ?>">
                  <h1 style="color:<?php echo $main_heading_text_color; ?> !important;"><?php __( the_title() , 'addax' ); ?></h1>

                  <?php if( !empty( $slide_sub_heading )  ) {  ?>
                  <h3 style="color:<?php echo $sub_heading_text_color; ?> !important;"><?php echo esc_html_e( $slide_sub_heading , 'addax' ); ?></h3>
                  <?php } ?>

                  <?php if( !empty( $button_one_text )  ) {  ?>
                   <a href="<?php echo esc_html( $button_one_link ); ?>" class="btn btn-primary btn-round"><?php echo esc_html_e( $button_one_text , 'addax' ); ?></a>
                  <?php } ?>

                  <?php if( !empty( $button_two_text )  ) {  ?>
                   <a href="<?php echo esc_html( $button_two_link ); ?>" class="btn light-btn btn-round btn-right"><?php echo esc_html_e( $button_two_text , 'addax' ); ?></a>
                  <?php } ?>



                </div>
            </div>

        <?php endwhile; wp_reset_postdata(); ?>

      </div>

      <!-- hero section ends here -->
      <!--hero carousel controller-->
      <div class="addax-hero-controller">
        <button class="ah-left-btn">
          <i class="fa fa-angle-left" aria-hidden="true"></i>
          <span>Prev</span>
        </button>
        <button class="ah-right-btn">
          <span>Next</span>
          <i class="fa fa-angle-right" aria-hidden="true"></i>
        </button>
      </div>
      <!--hero carousel controller-->

      <a href="#" class="scrollDown">
              <i class="fa fa-angle-down" aria-hidden="true"></i>

              <svg width="208px" height="50px">
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#0076ff" d="M111.042,0h-0.085C81.962,0.042,50.96,42.999,6,42.999c-6,0-6,0-6,0v1h214v-1v-0.015C169.917,42.349,139.492,0.042,111.042,0z"></path>
                </svg>
      </a>

    </div>

    <?php
    return ob_get_clean();
    endif;
  }
}

?>
