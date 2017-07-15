<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "addax_theme_options";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => esc_html__("Addax", "addax"),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'submenu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => false,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__( 'Theme Options', 'addax' ),
        'page_title'           => esc_html__( 'Theme Options', 'addax' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => true,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => 'theme-options',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );


    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

	 /* ================ GENERAL SECTION ============== */

	Redux::setSection( $opt_name, array(
        'title'      => __( 'General', 'addax' ),
        'id'         => 'general-settings',
		'icon'       => 'el el-home',
		'fields'	 => array(


		)
	));

	/* ================ HEADER SECTION ============== */

    Redux::setSection( $opt_name, array(
      'title' => esc_html__( 'Header Options', 'addax' ),
      'id'    => 'header-settings',
      'desc'  => '',
      'icon'  => 'fa fa-bars'
      )
    );

    Redux::setSection( $opt_name, array(
          'title'      => esc_html__( 'Logo', 'addax' ),
          'id'         => 'logo-section',
          'subsection' => true,
      		'icon'       => 'fa fa-bars',
      		'fields'	 => array(
            array(
    				'id'       => 'addax-logo',
    				'type'     => 'media',
    				'url'      => true,
    				'mode'     => false,
    				'title'    => esc_html__('Main Header Logo', 'addax'),
    				),
            array(
    				'id'       => 'addax-sticky-logo',
    				'type'     => 'media',
    				'url'      => true,
    				'mode'     => false,
    				'title'    => esc_html__('Sticky Header Logo', 'addax'),
    				),

  		)
  	));


    Redux::setSection( $opt_name, array(
          'title'      => esc_html__( 'Header Layouts', 'addax' ),
          'id'         => 'header-layout-section',
          'subsection' => true,
      		'icon'       => 'fa fa-bars',
      		'fields'	 => array(

  				array(
  					'id'       => 'header-layout',
  					'type'     => 'image_select',
  					'title'    => esc_html__('Select Layout', 'addax' ),
  					'options'  => array(
  						'style1' => array(
  							'alt'   => 'Header One',
  							'img'   => get_template_directory_uri ().'/images/header-one.png'
  						),
  						'style2'  => array(
  							'alt'   => 'Header Two',
  							'img'   => get_template_directory_uri ().'/images/header-one.png'
  						),
  					),
  					'default' => 'style1'
  				),

          array(
            'id'       => 'transparent-header-checkbox',
            'type'     => 'switch',
            'title'    => __('Transparent Header', 'addax' ),
            'subtitle'     => __('This will make header background transparent', 'addax'),
            'on' => __('Enable', 'addax'),
            'off' => __('Disable', 'addax'),
            'default'  => '0'
          ),

          array(
            'id'       => 'header-search',
            'type'     => 'switch',
            'title'    => __('Header Search', 'addax' ),
            'subtitle'     => __('Enable/Disable header search.', 'addax'),
            'on' => __('Enable', 'addax'),
            'off' => __('Disable', 'addax'),
            'default'  => '0'
          ),

          array(
            'id'       => 'addax-topbar',
            'type'     => 'switch',
            'title'    => __('Header Topbar', 'addax' ),
            'subtitle'     => __('Enable/Disable Topbar', 'addax'),
            'on' => __('Enable', 'addax'),
            'off' => __('Disable', 'addax'),
            'default'  => '0'
          ),

          array(
            'id'       => 'topbar-text',
            'type'     => 'text',
            'title'    => __('Topbar Text', 'addax' ),
            'default'  => 'Call Us Today:',
            'required' => array(
    								array('addax-topbar','equals', true)
    							)
    				),

            array(
              'id'       => 'topbar-phone',
              'type'     => 'text',
              'title'    => __('Topbar Contact Number', 'addax' ),
              'default'  => '123-456-789',
              'required' => array(
      								array('addax-topbar','equals', true)
      							)
      				),

              array(
                'id'       => 'topbar-email',
                'type'     => 'text',
                'title'    => __('Topbar Email', 'addax' ),
                'default'  => 'email@website.com',
                'required' => array(
        								array('addax-topbar','equals', true)
        							)
        				),
                array(
                  'id'       => 'topbar-social',
                  'type'     => 'switch',
                  'title'    => __('Topbar Social Icons', 'addax' ),
                  'on' => __('Enable', 'addax'),
                  'off' => __('Disable', 'addax'),
                  'default' => false,
                  'required' => array(
          								array('addax-topbar','equals', true)
          							),
                  'subtitle'     => __('Enable/Disable social icons.', 'addax'),
          				),

          )

  	));


    Redux::setSection( $opt_name, array(
          'title'      => esc_html__( 'Header Styling', 'addax' ),
          'id'         => 'header-styling',
          'subsection' => true,
      		'icon'       => 'fa fa-bars',
      		'fields'	 => array(

            array(
    					'id'        => 'topbar-background-color',
    					'type'      => 'color',
    					'title'     => esc_html__('Topbar Background color', 'addax'),
    					"validate"   => 'color',
    					"transparent"   => false,

    				),

            array(
    					'id'        => 'topbar-text-color',
    					'type'      => 'color',
    					'title'     => esc_html__('Topbar Text color', 'addax'),
    					"validate"   => 'color',
    					"transparent"   => false,

    				),

            array(
    					'id'        => 'header-background-color',
    					'type'      => 'color',
    					'title'     => esc_html__('Header Background Color', 'addax'),
    					"validate"   => 'color',
    					"transparent"   => false,

    				),

  		)
  	));


	/* ================ FOOTER SECTION ============== */

  Redux::setSection( $opt_name, array(
    'title' => esc_html__( 'Footer Options', 'addax' ),
    'id'    => 'footer-options',
    'desc'  => '',
    'icon'  => 'fa fa-level-down'
    )
  );

	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Footer Layouts', 'addax' ),
        'id'         => 'footer-layout',
        'subsection' => true,
    		'icon'       => 'fa fa-level-down',
    		'fields'	 => array(

                array(
                  'id'       => 'footer-widget-sec',
                  'type'     => 'switch',
                  'title'    => __('Footer Widgets Section', 'addax' ),
                  'subtitle'     => __('Enable/Disable footer widgets section.', 'addax'),
                  'on' => __('Enable', 'addax'),
                  'off' => __('Disable', 'addax'),
                  'default'  => '1'
                ),

        				array(
        					'id'       => 'footer-widgets-layout',
        					'type'     => 'image_select',
        					'title'    => esc_html__('Footer Widget Columns', 'addax' ),
        					'options'  => array(
        						2 => array(
        							'alt'   => 'Footer 2 columns',
        							'img'   => get_template_directory_uri ().'/assets/img/adx-fav.png'
        						),
        						3  => array(
        							'alt'   => 'Footer 3 columns',
        							'img'   => get_template_directory_uri ().'/assets/img/adx-fav.png'
        						),
                    4  => array(
        							'alt'   => 'Footer 4 columns',
        							'img'   => get_template_directory_uri ().'/assets/img/adx-fav.png'
        						),
        					),
        					'default' => 2,
                  'required' => array(
          								array('footer-widget-sec','equals', true)
          							),

        				),

				),

		)
	);

	/* ================ CUSTOM STYLES SECTION ============== */

	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Custom Styles', 'addax' ),
        'id'         => 'styles-settings',
		'icon'       => 'fa fa-eye',
		'fields'	 => array(
				array(
				'id'       	=> 'desktop-css',
				'type'     	=> 'ace_editor',
				'title'    	=> esc_html__('Custom CSS Code for Desktop', 'addax'),
				'subtitle' 	=> esc_html__('This code will work for any device with size equal to or bigger than 768px.', 'addax'),
				"mode"  	=> 'css',
				"theme"   	=> 'chrome',
				),
				array(
				'id'       	=> 'mobile-css',
				'type'     	=> 'ace_editor',
				'title'    	=> esc_html__('Custom CSS Code for Mobile Devices', 'addax'),
				'subtitle' 	=> esc_html__('This code will work for any device with size less than 768px.', 'addax'),
				"mode"  	=> 'css',
				"theme"   	=> 'chrome',
				),
		)
	));

	/* ================ CUSTOM SCRIPTS SECTION ============== */

	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Custom Scripts', 'addax' ),
        'id'         => 'scripts-settings',
		'icon'       => 'fa fa-file-code-o',
		'fields'	 => array(
				array(
				'id'       	=> 'tracking-script',
				'type'     	=> 'ace_editor',
				'title'    	=> esc_html__('Tracking Codes', 'addax'),
				'subtitle' 	=> esc_html__('This code will be placed right before the closing tag of head.', 'addax'),
				"mode"  	=> 'javascript',
				"desc" 		=> esc_html__('Do not use the "$" as selector, you can use the "jQuery" selector. Also do not use any script tags, they are already included.','addax'),
				"theme"   	=> 'chrome',
				),
				array(
				'id'       	=> 'general-script',
				'type'     	=> 'ace_editor',
				'title'    	=> esc_html__('Custom Scripts', 'addax'),
				'subtitle' 	=> esc_html__('This code will be placed right before the closing tag of body.', 'addax'),
				"mode"  	=> 'javascript',
				"desc" 		=> esc_html__('Do not use the "$" as selector, you can use the "jQuery" selector. Also do not use any script tags, they are already included.','addax'),
				"theme"   	=> 'chrome',
				),
		)
	));


	/* ================ TYPOGRAPHY SECTION ============== */

	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Typography', 'addax' ),
        'id'         => 'typography-settings',
		'icon'       => 'fa fa-keyboard-o',
		'fields'	 => array(
				array(
					'id'          => 'menu-typography',
					'type'        => 'typography',
					'title'       => esc_html__('Main & Sticky Menu Typography', 'addax'),
					'google'      => true,
					'font-backup' => true,
					'output'      => array('.header ul li a','.header .navigation .language a','.cd-primary-nav a'),
					'units'       =>'px',
					'color'		  => false,
					'font-size'   => false,
       				'line-height' => false,
					'text-align'  => false,
					'default'     => array(
						'font-family' => 'Montserrat',
						'google'      => true,
						'font-backup' => 'Arial, Helvetica, sans-serif',
					),
				),

				array(
					'id'          => 'body-typography',
					'type'        => 'typography',
					'title'       => esc_html__('Body Typography', 'addax'),
					'google'      => true,
					'font-backup' => true,
					'output'      => array('body span p'),
					'units'       =>'px',
					'color'		  => false,
					'font-size'   => false,
       				'line-height' => false,
					'text-align'  => false,
					'default'     => array(
						'font-family' => 'Roboto Slab',
						'google'      => true,
						'font-backup' => 'Arial, Helvetica, sans-serif',
						'subsets'	  => 'latin'
					),
				),

				array(
					'id'          => 'h1-typography',
					'type'        => 'typography',
					'title'       => esc_html__('H1 Typography', 'addax'),
					'google'      => true,
					'font-backup' => true,
					'output'      => array('h1'),
					'units'       =>'px',
					'font-size'   => false,
       				'line-height' => false,
					'text-align'  => false,
					'default'     => array(
						'font-family' => 'Montserrat',
						'google'      => true,
						'font-backup' => 'Arial, Helvetica, sans-serif',
					),
				),
				array(
					'id'          => 'h2-typography',
					'type'        => 'typography',
					'title'       => esc_html__('H2 Typography', 'addax'),
					'google'      => true,
					'font-backup' => true,
					'output'      => array('h2'),
					'units'       =>'px',
					'font-size'   => false,
       				'line-height' => false,
					'text-align'  => false,
					'default'     => array(
						'font-family' => 'Montserrat',
						'google'      => true,
						'font-backup' => 'Arial, Helvetica, sans-serif',
					),
				),
				array(
					'id'          => 'h3-typography',
					'type'        => 'typography',
					'title'       => esc_html__('H3 Typography', 'addax'),
					'google'      => true,
					'font-backup' => true,
					'output'      => array('h3'),
					'units'       =>'px',
					'font-size'   => false,
       				'line-height' => false,
					'text-align'  => false,
					'default'     => array(
						'font-family' => 'Montserrat',
						'google'      => true,
						'font-backup' => 'Arial, Helvetica, sans-serif',
					),
				),
				array(
					'id'          => 'h4-typography',
					'type'        => 'typography',
					'title'       => esc_html__('H4 Typography', 'addax'),
					'google'      => true,
					'font-backup' => true,
					'output'      => array('h4'),
					'units'       =>'px',
					'font-size'   => false,
       				'line-height' => false,
					'text-align'  => false,
					'default'     => array(
						'font-family' => 'Montserrat',
						'google'      => true,
						'font-backup' => 'Arial, Helvetica, sans-serif',
					),
				),
				array(
					'id'          => 'h5-typography',
					'type'        => 'typography',
					'title'       => esc_html__('H5 Typography', 'addax'),
					'google'      => true,
					'font-backup' => true,
					'output'      => array('h5'),
					'units'       =>'px',
					'font-size'   => false,
       				'line-height' => false,
					'text-align'  => false,
					'default'     => array(
						'font-family' => 'Montserrat',
						'google'      => true,
						'font-backup' => 'Arial, Helvetica, sans-serif',
					),
				),
				array(
					'id'          => 'h6-typography',
					'type'        => 'typography',
					'title'       => esc_html__('H6 Typography', 'addax'),
					'google'      => true,
					'font-backup' => true,
					'output'      => array('h6'),
					'units'       =>'px',
					'font-size'   => false,
       				'line-height' => false,
					'text-align'  => false,
					'default'     => array(
						'font-family' => 'Montserrat',
						'google'      => true,
						'font-backup' => 'Arial, Helvetica, sans-serif',
					),
				),
		)
	));



    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => esc_html__( 'Theme Information 1', 'addax' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'addax' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => esc_html__( 'Theme Information 2', 'addax' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'addax' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>', 'addax' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

	/*
     *
     * ---> END SECTIONS
     *
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => esc_html__( 'Section via hook', 'addax' ),
                'desc'   => esc_html__( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'addax' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }
