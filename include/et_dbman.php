<?php

/**
*
* Database management 
* for personalization  css
*/


namespace SPEX\inc\style ;
use SPEX\inc\activation ;

class Db_manage {
						
		//	  ____|____|___
		//	 /	 /\  //\   \
		//	|	//\\// \\	|
		//	|  ////\\   \\	|
		//	| //// 	\\	//	|
		//	|// \\	 \\// 	|
		//	|\\  \\  //\//\\|
		//	| \\_//  \\/\\//|
		// 	 \_____________/


		/*option css list commands 
			to customize the items list, add css here;
			add px or % notations at line 655 (and repeat in table_fe file at line 84 also) 
			Alphabetical composed elements instead,  have to be added in $css_map_val.
			Note the lists of css properties is divided in two columns, 
			the number of entries of each column is determined by the variable $divider = "number" defaul 5.
		Reload page to apply changes.*/
		

		//map format 
		public $_type_format = array( 	

			'background-origin' => 'string',
			'background-size'   => 'string',
			'text-align'  		=> 'string',
			'border-style'  	=> 'string',
			'vertical-align'  	=> 'string',
			'box-sizing'  		=> 'string', 
			'margin' 			=> 'int' , 
			'padding-top'		=> 'int' , 
			'padding-left'		=> 'int' ,
			'padding-right' 	=> 'int',
			'padding-bottom'	=> 'int' ,
			'font-size'			=> 'int' ,
			'height'			=> 'int' ,
			'width' 			=> 'int',
			'left' 				=> 'int',
			'top'				=> 'int' ,
			'border-radius'		=> 'int' ,
			'border-width'		=> 'int' ,
			);

		public 	$css_list_prop = array(  

			"background-origin" =>  "border-box" , 
		    "background-size" => "cover",
		    "text-align" => "center" ,
			"border-style" => "outset" ,
			"vertical-align" => "sub" ,
			"box-sizing" => "content-box",

			"margin" => "10" ,
			"padding-top" => "18" ,
			"padding-left"  => "  " ,
			"padding-right"  => "  " ,
			"padding-bottom" => "  " , 

			"background-color" => "#9e9e97" ,
			"background-image" => "  ",

			"font-size" => "15" ,
			"color" => "#f1f810" ,
			"height" => "50" ,
			"width" => "200" ,
			"left" => "30" ,
			"top" => "30" ,	
			"border-radius" => "20" ,
			"border-width" =>   "7" ,
			"border-color" =>   "#e02380" ,  											
			//"overflow" =>  "hidden" , 
			);
	
 	 

		public $css_map_val = array(

		"background-origin" => array(	"content-box"	,"border-box" 	, "inherit" ),
		"background-size" 	=> array(	"contain" 		,"cover" 		, "initial" ,  "inherit" ),
		"text-align" 		=> array(   "center" 		,"left" 		, "right" 	, "start" ,  "end"  ),
		"border-style" 		=> array(   "solid" 		,"ridge" 		, "outset" 	, "inset" ,  "hidden" , "groove", "double" , "dotted",  "dashed" ,  "initial",  "inherit" ,  "none" , ) ,
		"vertical-align" 	=> array(	"baseline" 		,"length" 		, "sub" 	, "super" ,  "top" ,  "text-top" , "middle" ,"bottom" ,  "text-bottom" ,  "initial" , "inherit" , ), 
		"box-sizing" 		=> array(	"border-box"	,"content-box" 	, "initial" , "inherit" , ),
		// "overflow" => array( "auto" , "hidden" , "overlay" , "scroll" , "visible" ,"inherit" , "initial", ) ,
		) ;

		//css specifies which options do not use px
		public $_no_px_ = array( "box-sizing" , "overflow"  , "background-image"  , "color" , "border-color"  , "background-color" , "background-origin" , "background-size" , "text-align" , "border-style" , "vertical-align" , "opacity" ,  );
 


       //Do not change the arrangement or the order of variables in the array structure 
		public 	$_temp_base_tag	= array( "taa" => "css_script_a" , "tab" =>  "css_script_b" , "tac" => "css_script_c" , "tad" => "css_script_d" ,  "tae" => "css_script_e"  , "taf" => "css_script_f" , );
		//references to tag_pannel tabulator 
		public 	$css_control_tab 	= array( '#tabs6' => 'Background' , '#tabs1' =>  'Photo' , '#tabs2' => 'Text area a' , '#tabs3' => 'Text area b' , '#tabs4' => 'Text area c' , '#tabs5'=> 'Text area d'  );

		public 	$css_ordered_compounds ;  //copy of $css_map_val  tidy
		public 	$ret_css ;

		public $current_style ;
		

		public function __construct(){
				//global $wpdb;
				$this->init_load_style();		
		}


		/**
		*@return array
		* 
		*/
		public  function  get_temp_base_tag(){
				//return list css &  wp_option table_name contein json_array css 
				return $this->_temp_base_tag ;
		}

		/**
		*@return array
		* 
		*/

		public function get_list_option_css(){
				//return tabs option controll for contenute ---> list input label 
				return $this->css_control_tab ;
		}

		public function get_css_list_prop(){

			$return = $this->css_list_prop ;

				return $return ;
		}

		public function get_css_map_val(){

			$return = $this->css_map_val ;

			return $return ;

		}

		/**
		* NOTE .. 
		* get option css compounds moving at the top voice of css
		* registred from db in $css_map_val (array)  
		* search in $_tab_css the value and muve it at top 
		* @return array copy of $css_map_val reordered .
		*/
		public function  pro_box_css( $_tab_css ){

			$_temp_return = array();  	//array temp return 
			$_temp_array = array();		//array temp sub_array copy  
			$before = '' ;				//value to move at top position of array temp 
			$hip = 0;
			$_hip = 1 ;

			foreach( $this->css_map_val as $_css_prop => $sub_css_array ){

				if(is_array($sub_css_array)){		
					foreach ( $sub_css_array as $_key => $_css_prop_value ) {

						if( $_css_prop_value == $_tab_css[$_css_prop] ){

								$_temp_array[ $hip ] =  $_css_prop_value ;	
							}else{
								$_temp_array[ $_hip++ ] = $_css_prop_value ;
							}
					}
				}
				ksort($_temp_array)  ;
				$_hip = 1 ;
				$_temp_return[$_css_prop] =  $_temp_array ;
				unset($_temp_array);
			}
		
				// save a copy for $pro_opt_css 
				$this->css_ordered_compounds =  $_temp_return ;
				return $_temp_return ;
		}

		/**
		*recompose values of elements obtained from the database css 
		*remove element of $css_ordered_compound  by  $_tab_css e.e. ( $_tab_css - css_ordered_compounds ($key)  ) 
		*@return array 
		*/ 

		public function pro_opt_css( $_tab_css ){

			foreach ( $this->css_ordered_compounds as $key => $val  ){
				$tmp_arr[$key] = $key ;        
			}

			foreach($_tab_css as $_css_key => $_css_val ){
				if( isset($tmp_arr[$_css_key]) != $_css_key ){
					$ret_css[$_css_key] = $_css_val ;
				}
			}
			return $ret_css ;
		}


		/** 
		* convert json data from database 
		* @return array  
		*
		*/
		public function encoding_arg( $_tab_css ){

			if( is_array( $_tab_css ) ){
				//update_option( $GLOBALS['tab_index'] , json_decode(json_encode($_tab_css)) , 'yes' );
				$this->update_table_css( $GLOBALS['tab_index'] , json_decode(json_encode($_tab_css)) );
				return ;
			}else{

				$GLOBALS['tab_index'] = $_tab_css ;
				$string_temp_ = unserialize( $this->get_table_css( $_tab_css ) );
				
				//check_update
				$string_temp_ = $this->check_update( $string_temp_ );

				while( empty($string_temp_ ) ){
					self::encoding_arg(  $this->css_list_prop );
					$string_temp_ = unserialize( $this->get_table_css( $_tab_css ) );
				}
					return $string_temp_  ;
			}			
		}

		/**
		*@return array
		*reading if new entries are added in css_list_prop
		*/

		public function check_update( $json_arr ){

			$roo = $this->css_list_prop ;
			//$string_temp_ = unserialize( $this->get_table_css( $_tab_css ) );
			foreach($roo as $key => $val){
				if( isset($json_arr[$key])){
					$out_array[$key] =   $json_arr[$key] == '' ? $val  :   $json_arr[$key] ;
				}else{
				$out_array[$key] = $val;
				}
			}
			return $out_array ;
		}


		/**
		*updates the contents of css
		*@return null 
		*/

		public function update_table_css( $__css_script_field , $__css_post ){

			global $wpdb;
			if( !isset($this->current_style ) ){
					$this->current_style = get_option( 'current_style' );

			} 
			$_css_serialized = serialize( $__css_post );
			//global $wpdb;
			$_record_css = array( $__css_script_field  => $_css_serialized );
			$wpdb->update( $wpdb->prefix . 'theme_module_css' , $_record_css , array('style_table' => $this->current_style ) , array( '%s') , array('%s')  );
			//$wpdb->flush();
			//update_option( 'temp_array' , $_record_css , 'yes' );
		}

		




		/**
		*@return array 
		*reading of each specific tag element saved in DB
		*/
		public function get_table_css( $__css_script_field  ){

			global $wpdb;

			if( !isset($this->current_style ) ){
				$this->current_style = get_option( 'current_style' );
			} 
			$row = $__css_script_field ;	
			
			$list_style = $wpdb->get_results( " SELECT  $row  FROM {$wpdb->prefix}theme_module_css  WHERE style_table = '$this->current_style'  " ); 
		
			foreach ($list_style as $db_script_x ) {
				# code...
			$row = $db_script_x->$__css_script_field ; 
			}
			return $row ;
		}


		/**
		*@return null
		*/
		//add a new css voice  in module_css
		public function new_css( $css_name  ){

			global $wpdb;
			
			$wpdb->insert( $wpdb->prefix . 'theme_module_css' , array( 'style_table' => $css_name ) );
			update_option( 'current_style' , $css_name  , 'yes' );
		}


		/**
		*@return null
		*/
		//delete css voice in module_css
		public function delete_css( $css_name  ){

			global $wpdb;

			$wpdb->delete( $wpdb->prefix . 'theme_module_css' , array( 'style_table'=> $css_name  ) , array('%s')  );
			$wp_t_css = $wpdb->get_results( " SELECT  style_table  FROM {$wpdb->prefix}theme_module_css LIMIT 1 " );
			$wpdb->update($wpdb->prefix . 'theme_module' , array( 'style_table' => $wp_t_css[0]->style_table ) , array('style_table' => $css_name  ) , array('%s') , array('%s')  );
			update_option( 'current_style' , $wp_t_css[0]->style_table  , 'yes' );
			
		}

		/**
		*@return null
		*/
		//rename css voice in module_css
		public function rename_css( $css_name , $new_css_name ){

			global $wpdb;
			$wpdb->update( $wpdb->prefix . 'theme_module_css' , array( 'style_table' => $new_css_name ) , array('style_table' => $css_name  ) , array('%s') , array('%s')  );
			$wpdb->update( $wpdb->prefix . 'theme_module' , array( 'style_table' => $new_css_name ) , array('style_table' => $css_name  ) , array('%s') , array('%s')  );
			update_option( 'current_style' , $new_css_name  , 'yes' );
			//$wpdb->flush();
		}

		          	
		/**
		*@return null
		*/

		public function init_load_style(){

			global $wpdb;
			//legge contenuto del  registro css caricato 
			$this->current_style = get_option( 'current_style' );


			//se vuoto seleziona il database di stili carica il primo della lista 
			if( $this->current_style == '' ){

				$wp_t_css = $wpdb->get_results( " SELECT  style_table  FROM {$wpdb->prefix}theme_module_css LIMIT 1 " );
		
				// find in database wp theme_module css if set css 
				// if not set any table.. it reload activation_plugin() end css default ;

				 
				if( isset($wp_t_css[0]->style_table) && $wp_t_css[0]->style_table != ''){

					update_option( 'current_style' , $wp_t_css[0]->style_table  , 'yes' );
					$this->current_style = get_option( 'current_style' );

				}else{

					include_once( STE_PATH . 'include/et_init_db.php');
					$load_style_default = new activation\activation_plugin();
					$this->init_load_style();
					unset ($load_style_default) ;
					echo "init db staly run";
					return ;
				}
			}
		}

		public function __destruct() {				
		}
	

  }