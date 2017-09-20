<?php
  add_shortcode( 'addax_project' , 'addax_project_html_callback' );

  if ( ! function_exists( 'addax_project_html_callback' ) ) {

    function addax_project_html_callback( $atts ) {

      extract( shortcode_atts( array(

          'heading' => '',
          'sub_title' => '',

			), $atts ) );

      // WP-Query Arguments
      $args = array(
  	     'post_type' => 'addax-project',
  	     'post_per_page' => -1
      );

      $query = new WP_Query( $args );

    // Checking if query have data
    if( $query->have_posts() ) :

    ob_start();
    ?>

    <div id="addax-projects" class="style1" style="padding-bottom:50px">

      <div class="container">

        <div class="row ap-heading">

                <?php if( !empty( $heading ) ) { ?>
                  <h1 class="addax-heading alignLeft">
                    <?php echo esc_html_e( $heading , 'addax' ); ?>
                  </h1>
                <?php } ?>

                <?php if( !empty( $sub_title ) ) { ?>
                  <h2 class="addax-subheading alignLeft">
                    <?php echo esc_html_e( $sub_title , 'addax' ); ?>
                  </h2>
                <?php } ?>

          </div>
          <div class="row">

                <div class="addax-filters">
                  <button class="filter selected" data-filter="all">All</button>
                  <?php

                  $taxonomy = 'adx-project-category';
                  $terms = get_terms($taxonomy); // Get all terms of a taxonomy
                  if ( $terms && !is_wp_error( $terms ) ) :?>
                      <?php foreach ( $terms as $term ) { ?>
                          <button class="filter" data-filter=".<?php echo $term->slug; ?>"><?php echo $term->name; ?></button>
                      <?php } ?>
                 <?php endif; ?>

                </div> <!-- addax-filters -->

          </div>

        </div>

        <div class="addax-filter-gallery col4">
        <?php  while( $query->have_posts() ) : $query->the_post();

        // Getting Term Assign to Post
        global $post;
        $term = '';
        $terms = get_the_terms( $post->ID, 'adx-project-category' );
        if ( !empty( $terms ) ){
            $term = array_shift( $terms );
        }
        $post_thumbnail = get_the_post_thumbnail_url( $post->ID , 'large' );
        ?>

            <div class="mix <?php ( !empty( $term ) ) ?  $term->slug : ''; ?>">

              <div class="ap-single col-md-3">


                 <div class="ap-img">
                  <img src="<?php echo $post_thumbnail; ?>">
                </div>

                <div class="ap-content">

                  <h3><?php ( !empty( $term ) ) ?  __( $term->slug , 'addax' ) : ''; ?> </h3>
                  <h1><?php __( the_title() , 'addax' ); ?></h1>
                  <p><?php __( the_excerpt() , 'addax' ); ?></p>

                    <div class="ap-links">
                      <a href="<?php echo $post_thumbnail; ?>" class="addax-lb-trigger"><i class="fa fa-search" aria-hidden="true"></i>
                        <a href="#"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </div>

              </div>

            </div>



      <?php endwhile; wp_reset_postdata(); ?>
        </div>


      </div>

      <div id="addax-lightbox" style="display:none;">
        <a href="#" class="close-lightbox">
          <i class="fa fa-times" aria-hidden="true"></i>
        </a>
        <div id="lightbox-content">

        </div>
      </div>

    </div>

    <?php else: ?>
      <div class="alert alert-info">
        <strong>No Projects Found!</strong> To add projects <a href="<?php echo get_admin_url(); ?>edit.php?post_type=addax-project">Click Here</a>.
     </div>
    <?php
    return ob_get_clean();
  endif;
  }
}


// Visual Composer Map
function addax_vc_map_project()
{


	vc_map( array(

      'name'										=> esc_html__( 'Addax Projects', 'addax' ),
      'base' 				      		  => 'addax_project',
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
							 "type" 				=> "textfield",
							 "heading" 		  => __( "Sub Heading", "addax" ),
							 "param_name" 	=> "sub_title",
							 "description"  => __("Enter sub title here.", "addax")
						 ),

			)

	) );

}

add_action( 'vc_before_init', 'addax_vc_map_project' );

?>
