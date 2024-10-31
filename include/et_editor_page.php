<?php

/*define customizer style  table */
namespace SPEX\inc ;
use  SPEX\inc\style ;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class page_editor{


// Add the capability for style
	public function add_role(){

		$role = get_role( 'administrator' );
		//Add role for ScriptEt 
		$role->add_cap( 'Script_et_make_style' );

		
	}

	public function remove_role(){

		$role = get_role( 'administrator' );
		// remove the capability for style
		$role->remove_cap('Script_et_make_style' );


	}

		public function load_sub_menu(){
			
			$hook = add_submenu_page( 'Script_et_module_view_table', 'Set style modules', 'Set style modules', __('Script_et_make_style', 'ScriptEt'), __('Script_et_make_style' , 'ScriptEt'), array( $this , 'run_editor_form' ) ); 
			add_action( "admin_print_scripts-{$hook}",  array( $this, 'table_enq_script' ) );
			add_action( "admin_print_styles-{$hook}",  array( $this, 'table_enq_style' ) );
		
	}



	public  function table_enq_style(){

			//load style script
			
			$path_css =  plugins_url() . '/' .  STE_ABS  . '/css' ;
			$path_js =  plugins_url() . '/' .  STE_ABS  . '/js' ;
		 	wp_enqueue_style('style_page', $path_css . '/style_page.css' );
			wp_enqueue_style('jquery-ui', $path_js . '/jquery-ui/jquery-ui.css' );
			wp_enqueue_style('jquery.colorpicker',  $path_js . '/color_js/colorpicker-master/jquery.colorpicker.css' );
	}


	public  function table_enq_script(){

				//load jquery script
		
		$path_js = plugins_url() . '/' .  STE_ABS  . '/js' ;

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-spinner' );
			wp_enqueue_script( 'jquery-ui-selectmenu' );
			wp_enqueue_script( 'jquery-ui-resizable' );
			wp_enqueue_script( 'jquery-ui-draggable' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'admin-gallery' ); //	ui-widget	important
			wp_enqueue_script( 'jquery-ui-position' );
			wp_enqueue_script( 'jquery-ui-selectable' );
			
		wp_enqueue_script( 'jquery.colorpicker', $path_js . '/color_js/colorpicker-master/jquery.colorpicker.js' , array() , '',  false );
		wp_enqueue_script( 'jquery.ui.colorpicker-rgbslider', $path_js . '/color_js/colorpicker-master/parts/jquery.ui.colorpicker-rgbslider.js' , array() , '',  false );
		
	}

		//main function run style table and button pannel for custum css 

		public function run_editor_form(){	
				
				global $wpdb;
				wp_enqueue_media();
				$this->inport_script();
				
					$manag_data =  new style\Db_manage();
					$drops_controll = new style\editor_css();
					
						$drops_controll->load_base_tem_css(  $manag_data );	
				    	$drops_controll->disp_temp_base( $manag_data );  
						$drops_controll->editor_form(  $manag_data ); 
		}
 

		public function inport_script(){
			
				//inport file editor_css for display button pannel css custumizer 
				//template  
				include_once( STE_PATH . 'include/et_editorcss.php');	
				//inport file et_portion for manag database data 	
				include_once( STE_PATH . 'include/et_dbman.php');	
				//
				include_once( STE_PATH . 'include/et_register_script.php');	
				et_register_ajax::register_ajax('style');
				
		      //<---- runs  , reload  callbeck  setting_style	
				
			
		}


}
