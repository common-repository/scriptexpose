<?php
/*
Plugin Name: ScriptEt
Plugin URI:  http://www.scriptet.net
Description: ScriptEt and style
Version: 1.0
Author: ALessandro binwavelab@gmail.com
Author URI:   http://www.scriptet.net
 */


namespace SPEX ;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if(!class_exists('ScriptEt') ) :

class ScriptEt{


	public  static $dir_plugin ;

	public function __construct(){

		//check wp version 
		
	self::inport_file();
	register_activation_hook( __FILE__ , array( $this, 'activate_plugin') ); 
	register_deactivation_hook( __FILE__ , array( $this, 'deregister_script') ); 
	self::script_et_init();
		
	}

	public static  function activate_plugin(){

	include_once( STE_PATH . 'include/et_init_db.php');
    $activate_table = new inc\activation\activation_plugin() ;
    //add_action('admin_init' , array($activate_table , 'make_option' ));
    do_action('scriptet_activate');		
    //unset($activate_table);
   
	}

	public static  function deregister_script(){

    delete_option( 'table_css_loaded'  );
    delete_option( 'catalog_load' );
    update_option( 'catalog_active' , 'off', '' , 'yes' );
    //delete_option( 'catalog_active'  );	
    do_action('scriptet_deactivate');

	   
	}
	
	public function script_et_init(){

		
	$scode_update = new inc\shortcode_update(); 
	$load_module  = new inc\module_view();
	$display_style = new inc\page_editor();
	$shor_code_init = new inc\ScriptEt();

	add_action('scriptet_activate', 	array(	$load_module 	, 'add_role'		));
	add_action('scriptet_activate', 	array(	$scode_update 	, 'add_role'		));
	add_action('scriptet_activate', 	array(	$display_style 	, 'add_role'		));
	
	add_action('admin_menu', 			array(	$load_module 	, 'load_sub_menu'	), 999 );	
	add_action('admin_menu',   			array(	$scode_update 	, 'load_sub_menu' 	), 999 );
	add_action('admin_menu',  			array(	$display_style 	, 'load_sub_menu' 	), 999 );	

	add_shortcode( 'theme_module' , 	array(	$shor_code_init , 'start_plugin'	));
	
	add_action('scriptet_deactivate', 	array(	$scode_update 	, 'remove_role'		));
	add_action('scriptet_deactivate',	array(	$load_module 	, 'remove_role'		));
	add_action('scriptet_deactivate', 	array(	$display_style 	, 'remove_role'		));
	}

		
	public function inport_file(){

	define( 'STE_PATH' , plugin_dir_path(__FILE__));
	define( 'STE_ABS' ,  dirname( plugin_basename( __FILE__ ) )  );

	include_once( STE_PATH . 'include/et_module_view.php');
	include_once( STE_PATH . 'include/et_editor_page.php');
	include_once( STE_PATH . 'include/et_table_fe.php');
	include_once( STE_PATH . 'include/et_short_code.php');
	include_once( STE_PATH . 'include/et_register_script.php');	

	}

	 
}

 function ScriptEt_init(){

	   	global $_scriptet;

	   	if( !isset($_scriptet) )
	   	{
	   		$_scriptet = new ScriptEt();	
	   	}
	   	return $_scriptet;
	   }
   ScriptEt_init();

   endif ;
   // initialize
   	
   
?>
