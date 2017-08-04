<?php
  add_shortcode( 'addax-project' , 'addax_project_html_callback' );

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

          <div class="col-md-4 vcenter">

              <h1 class="addax-heading alignLeft">Our Work</h1>
              <h2 class="addax-subheading alignLeft">Work that makes us proud</h2>

          </div>
          <div class="col-md-8 vcenter">

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

      </div>

      <div class="container-full">
        <div class="addax-filter-gallery col4">
        <?php  while( $query->have_posts() ) : $query->the_post();

        // Getting Term Assign to Post
        global $post;
        $term = '';
        $terms = get_the_terms( $post->ID, 'adx-project-category' );
        if ( !empty( $terms ) ){
            $term = array_shift( $terms );
        }

        ?>

            <div class="mix <?php echo $term->slug; ?>">

              <div class="ap-single">


                <div class="ap-img">
                  <img src="assets/img/port1.jpg">
                </div>

                <div class="ap-content">

                  <h3>Web Design / Development</h3>
                  <h1>Project Title</h1>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque euismod tincidunt odio, vitae suscipit neque tempus ut.</p>

                    <div class="ap-links">
                      <a href="assets/img/port1.jpg" class="addax-lb-trigger"><i class="fa fa-search" aria-hidden="true"></i>
                        <a href="#"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </div>

              </div>

            </div>



      <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <!-- <div class="row">

            <div class="col-sm-12 af-error">
                <p class="alignCenter">Sorry No Matching Item Found !</p>
            </div>


        </div> -->


      </div>

      <!-- <div id="addax-lightbox" >
        <a href="#" class="close-lightbox">
          <i class="fa fa-times" aria-hidden="true"></i>
        </a>
        <div id="lightbox-content">

        </div>
      </div> -->

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

?>
