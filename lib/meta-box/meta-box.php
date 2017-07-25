<?php

if ( defined( 'ABSPATH' ) && ! defined( 'RWMB_VER' ) )
{
	require_once plugin_dir_path( __FILE__ ) . 'inc/loader.php';
	$loader = new RWMB_Loader;
	$loader->init();
}
