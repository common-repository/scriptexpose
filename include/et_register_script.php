<?php

/*
*	register ajax nonce 
*	 for callback function 
*
*/

namespace SPEX\inc ;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class et_register_ajax{

	public  $var;
    const ACTION = 'update_art_';
    const SCYPT_RED = 'et_register_script';
    private $_local_ ;

	public static function register_ajax(  $_file  ){

	    $_local_ = new self();

			add_action('wp_ajax_'. self::ACTION . $_file ,  array($_local_ , 'handle') );
			add_action('wp_ajax_nopriv_'. self::ACTION . $_file , array($_local_ ,'handle') ) ;
			$scriptData = array();
			$scriptData['action'] = self::update_cb( $_file , $_local_ ) ;
			$scriptData['nonce']  = wp_create_nonce( et_register_ajax::SCYPT_RED );
			$path = plugins_url() . '/' .  STE_ABS  . '/js/' ;
			wp_enqueue_script('et_update_' . $_file  , $path . 'et_update_'. $_file . '.js' , array( 'jquery' ) );
			wp_localize_script('et_update_' . $_file  , 'up_js_data', $scriptData );
			wp_enqueue_script('et_update_' . $_file );

	}


		public function handle(){
			check_ajax_referer( self::SCYPT_RED );
			die();
		}

		//selct funtion 

		public static function  update_cb( $arg , $object_ ){

			switch ($arg) {
			case 'style':
				# code...
			return $object_->update_style_module();
				break;
			case 'table':
				# code...
			return $object_->update_module_view();
				break;
			}

		}


	/**
	*
	*	@param 		$_array_ entry $_POST
	*	@return 	array POST SANITIZE
	*
	*	sanitize_entry_table : sanitize data key and value $_POST
	*							remove special character and keys for xss 
	*							called by update_module_view 
	*/

	public static function sanitize_entry_table( $_array_post ){

		$return_post_sanitize = array();
		$array_out 			  = array();

		$args = array(

		'action' 		=> FILTER_SANITIZE_ENCODED , 
		 
		'nonce'   		=> FILTER_SANITIZE_ENCODED , 
		 
		'text_area_a'	=> array( 
						'flags'  => FILTER_FLAG_STRIP_HIGH ,
						'flags'  => FILTER_FLAG_STRIP_LOW
                       ),

		'text_area_b' 	=> array( 
						'flags'  => FILTER_FLAG_STRIP_HIGH ,
						'flags'  => FILTER_FLAG_STRIP_LOW
                       ), 

		'text_area_c' 	=> array(
						'flags' => FILTER_FLAG_STRIP_HIGH , 
						'flags'  => FILTER_FLAG_STRIP_LOW
                       ),

		'text_area_d' 	=> array(
						'flags' => FILTER_FLAG_STRIP_HIGH  , 
						'flags'  => FILTER_FLAG_STRIP_LOW
                       ),

		'url' 			=> FILTER_VALIDATE_URL  ,  
		 
		'cod' 			=> FILTER_FLAG_STRIP_HIGH  , 
		
		'id' 			=> FILTER_FLAG_STRIP_HIGH , 
		 
		'theme_module'	=> FILTER_FLAG_STRIP_HIGH , 
		 
		'sel_que' 		=> FILTER_FLAG_STRIP_HIGH ,

		'style_table'		=> FILTER_FLAG_STRIP_HIGH ,

		'new_module'	=> FILTER_FLAG_STRIP_HIGH ,
		
		);

		$return_post_sanitize = filter_var_array( $_array_post , $args );
		$return = array();
		
		foreach($return_post_sanitize  as $key => $val ){ 

			$_tmp_key = (String) stripslashes_deep( sanitize_key( $key ) );

			switch ( $_tmp_key ) {

			case 'url':
				$array_out[$_tmp_key] = $val ;	 
				break;
			case 'theme_module':
				$array_out[$_tmp_key] = $val ;
				break;
			case 'id':
				$array_out[$_tmp_key] = $val ;
				break;
			case 'sel_que':
				$array_out[$_tmp_key] = $val ;
				break;
			case 'text_area_a':
				$array_out[$_tmp_key] = stripslashes_deep( sanitize_text_field( $val )) ;
				break;
			case 'text_area_b':
				$array_out[$_tmp_key] = stripslashes_deep( sanitize_text_field( $val )) ;
				break;
			case 'text_area_c':
				$array_out[$_tmp_key] = stripslashes_deep( sanitize_text_field( $val )) ;
				break;
			case 'text_area_d':
				$array_out[$_tmp_key] = stripslashes_deep( sanitize_text_field( $val )) ;
				break ;
			case 'style_table':
				$array_out[$_tmp_key] = stripslashes_deep( sanitize_key( $val )) ;
				break ;
			case 'nonce':
				$array_out[$_tmp_key] = stripslashes_deep( sanitize_key( $val )) ;
				break ;
			case 'new_module':
				$array_out[$_tmp_key] = stripslashes_deep( sanitize_key( $val )) ;
				break ;
			default:
			break;
			}
		}
		return $array_out;
		
	}
	
	/**
	*@param
	*@return 
	*/

	public  function update_module_view(){

		global $wpdb;
		$_post_sanitized = array() ;
		$read = '' ;
		$function = '';

		

		//filter sanitize  
		if( isset($_POST['sel_que'] ) ){

			$_post_sanitized =  self::sanitize_entry_table( $_POST );
			$function  = $_post_sanitized['sel_que'];


			
		}

		
		//select function 
		switch(  $function ){

		case 'sav' :

			$style_table = $wpdb->get_results( "SELECT  style_table  FROM " .$wpdb->prefix . "theme_module  WHERE theme_module = '" . $_post_sanitized['theme_module'] . "'");
			
			$inn_db =	array(	'url'			=> $_post_sanitized['url'] ,
								'text_area_a'	=> $_post_sanitized['text_area_a'] ,
								'text_area_b' 	=> $_post_sanitized['text_area_b'] ,
								'text_area_c' 	=> $_post_sanitized['text_area_c'] ,
								'text_area_d' 	=> $_post_sanitized['text_area_d'] ,
								'theme_module' 	=> $_post_sanitized['theme_module'] ,
								'shortcode' 	=> $_post_sanitized['theme_module'] ,
								'style_table'		=> $style_table[0]->style_table , );

			$wpdb->replace($wpdb->prefix . 'theme_module' , $inn_db , array( '%s', '%s' , '%s', '%s', '%s',  '%s' , '%s' , '%s' )  );
			$read = $_post_sanitized['theme_module'] ;
			update_option( 'catalog_load' , $read , 'yes' );
	
		break ;
		case 'upd' : 

			$inn_db =  array(	'url' 			=> $_post_sanitized['url'] ,
								'text_area_a' 	=> $_post_sanitized['text_area_a'] ,
								'text_area_b' 	=> $_post_sanitized['text_area_b'] ,
								'text_area_c' 	=> $_post_sanitized['text_area_c'] ,
								'text_area_d' 	=> $_post_sanitized['text_area_d']);

			$whe_db = array(	'id'			=> $_post_sanitized['id'] );

			$wpdb->update($wpdb->prefix . 'theme_module' , $inn_db , $whe_db , array( '%s','%s','%s','%s','%s' )   );
			$read = $_post_sanitized['theme_module'] ;
			update_option( 'catalog_load' , $read , 'yes' );
		
		break ;
		case 'del' :

			global $wpdb;
			$wpdb->delete( $wpdb->prefix .'theme_module' , array( 'id'=>$_post_sanitized['id']  ) , array('%d')   ); 
			$read = $_post_sanitized['theme_module'] ; 
			update_option( 'catalog_load' , $read , 'yes' );

		break ;
		
		//database action to update rename module and shortcode
		case 'Unt' :
			//update shortcode
			$inn_db =  array( 	'theme_module'	=>	$_post_sanitized['new_module'] ,
								'shortcode'		=>	$_post_sanitized['new_module'] ,
								'style_table' 	=> 	$_post_sanitized['style_table'] );

			$wpdb->update($wpdb->prefix .'theme_module' , $inn_db , array( 'theme_module'=>$_post_sanitized['id'] ) , array('%s','%s','%s') ); 																											//'style_table' =>$_post_sanitized['style_table']
			update_option( 'current_style' , $_post_sanitized['style_table']  );											
	
		break ; 
		//remove shortcode and all data of module 
		case 'Dnt' :  
			$wpdb->delete($wpdb->prefix .'theme_module' , array( 'theme_module'=>$_post_sanitized['id']  ) , array('%s')   ); 		
		break ;
		}


		}



	public function update_style_module(){



			global $wpdb;
			$db_man 	 	= new style\Db_manage();
			$temp_css 		= $db_man->get_css_list_prop();
			$temp_box_css 	= $db_man->get_css_map_val();
			$_post_sanetize = array(); 
			

			if( isset( $_POST ) ){

				if( self::check_data_post( $_POST , $temp_css , $temp_box_css ) ){

						$_post_sanetize =  self::sanitize_entry_post_save_data( $_POST , $db_man  );

						//echo "accept_ok";  
				}else{
						$_post_sanetize = self::sanitize_entry_style_function( $_POST );  

						//echo "no accept_ compare";
				}
			}




			if( isset($_post_sanetize['trigger'] ) &&
					 (($_post_sanetize['trigger'] === 'accept_change') || 
					 ( $_post_sanetize['trigger'] === 'load_style'   ) )) {

				if( isset($_post_sanetize['set_function']) &&
					isset($_post_sanetize['function_args_']) && 
						  $_post_sanetize['trigger'] == 'accept_change' ){

				$function_db = trim( $_post_sanetize['set_function'] , " " );

					switch ( $function_db ) {

						case 'delete_style':
						# code...
						$db_man->delete_css( $_post_sanetize['style_name'] );
						break;

						case 'rename_style' :
						$db_man->rename_css( $_post_sanetize['style_name'] ,  $_post_sanetize['function_args_']  );
						break;

						case 'new_style' :
						$db_man->new_css( $_post_sanetize['function_args_'] );
						break;	

						case 'save_style' :

						self::save_style_manage( $_post_sanetize , $db_man ) ;

						break;
					}
					


				}else if( $_post_sanetize['trigger'] == 'load_style' ){

					update_option( 'current_style' , $_post_sanetize['style_name']  , 'yes' );

				}

			}else{ 		//	otherwise data are records in database style 

			}unset($db_man);
		     
	}


	/**
	*
	*@param $post_sanetize  $POST after sanitize 
	*@param $OBject_p	 style\Db_manage()
	*@return null 
	* save data css in database by recursive post  
	*/

	public static function save_style_manage( $post_sanetize , $db_manage ){

		global $wpdb;
		$temp = '';
		$temp_table = $post_sanetize['style_name'];

		update_option( 'current_style' , $temp_table  , 'yes' );

		foreach ( $db_manage->get_temp_base_tag() as $idx => $temp_tag ) {

					$db_manage->update_table_css( $temp_tag , $post_sanetize[ $temp_tag ]  );
					$temp .= " " . $temp_tag ;

		}	
		
	}





	/**
	*
	*
	* @param $_array_post	array  entry $_POST
	* @param $_main_map		array  It receives the origin matrix of the object, containing ,
	*						css propriety to compare to the  data $_POST
	* @param $_map_val		array  It receives the origin matrix of the object, containing  ,
	*						css element value to compare to the input data ( by $_POST )
	*
	* @return boolean 		if $_POST is == matrix return true otherwise false .
	*/

	public static function check_data_post( $_array_post , $_main_map , $_map_val ){

		$accept_data = false ;
		$count = 0;
		if(	isset($_main_map) && isset($_map_val ) ):

		foreach( $_array_post  as $post_key => $post_content ){			
		foreach( $post_content as $sub_k 	=> $sub_v ){
					//check key 
			if(  array_key_exists( trim( $sub_k , " ") , $_main_map ) ){
				if( in_array( $sub_v , $_map_val[$sub_k] )  ){
						$accept_data = true;
						//$count+=2;
				}else{
						$accept_data = false ;
						//$count+=1000;
				}
			}
		}	
		}
		endif;

		//update_option( 'temp_array' , $count++  , 'yes' );
		return true ;
	}


	/**
	* sanitize_entry_post_save_data : check url , color , key , value , 
	*
	* @return array  $out_post_sanitized  "POST sanitize" ; 
	*/

	public function sanitize_entry_post_save_data( $_post_data_to_ck  ,  $BJ_data ){

		//read $_POST  and sanitize all key all value 

		$_temp_array_process = array(); 			// array temp process sanitize   
		$_url_split  		 = array(); 			// temporary array split url and rgba value 
		$out_post_sanitized	 = array();				// return array
		$rr 		 		 = '' ; 				// temporary var to sanitize data  
		$path_url 	 		 = home_url() ."/" ;
		$_array_copy 		 = $_post_data_to_ck ;	

		foreach( $_array_copy as $post_key => $post_content ){			

			foreach( $post_content as $sub_k => $sub_v ){
				//sanitize key array POST
				$_tmp_key = (String) stripslashes_deep( sanitize_key( $sub_k ) );
				//check key background-image 		
				if(   $_tmp_key == "background-image" ) {
					$rr   = str_replace( $path_url  , ''   , $sub_v );
					$rr   = str_replace( "url("  	, ''   , $rr );
					$rr   = str_replace( ")"  		, ''   , $rr );
					$_ext = strstr     ( $rr 		, "."  );
					$rr   = strstr     ( $rr 		, "." , true );
					//sanitize every directory path name segment   
					$_url_split = explode( '/' , $rr );

						for( $i = 0 ;
							 $i <= count( $_url_split )-1 ;
							 $i++  ){
							 $_url_split[$i] = (String) stripslashes_deep( sanitize_key( $_url_split[$i] ) );
						}
						$rr = implode("/", $_url_split );	
						//find is file exist after sanitization if file not exist get empty space .
						if( file_exists ( get_home_path() . $rr . $_ext  )  && ( $_ext !== '' ) )  {
								//recombine element to css 
								$_temp_array_process[ $_tmp_key ]  = "url(" . $path_url . $rr . $_ext . ")"  ;
						}else{
							$_temp_array_process[ $_tmp_key ]  = '' ;
						}
				//check if propriety color contenins int value and sanitize it 
				}else if(  strpos($_tmp_key , 'color') !== false) {

				//check type of color is rgba or hex value 
					if(strpos($sub_v, '#' ) === false ){
						$rr = str_replace("rgba(" , '' , $sub_v);
						$rr = str_replace(")" , '' , $rr);
						$_url_split = explode( ',' ,  $rr );
						//check if data  RGBA if conposed of 4 element 
						if( count( $_url_split ) == 4 ){
							for($i = 0 ;
								$i <= count( $_url_split )-1 ;
								$i++  ){
									//check if value is a number	
									if( (!is_int($_url_split[$i]) ) || ( !is_float($_url_split[$i])) ){
										$_reject = true ;
									}else{
										$_reject = false ;
										 break;
									}	
							}
						}
						if(!$_recject){
							$rr = implode(",", $_url_split );
							$rr = "rgba(" . $rr . ")" ;
							$_temp_array_process[ $_tmp_key ] = $rr ;
						}else{
							//in case data not conforme of type data required 
							// set value of default  
							unset($_url_split);
							$_temp_array_process[ $_tmp_key ] = "rgba(100,100,100,1)" ;
						}
					}else{ // case of  color is hex type	
						$rr =  stripslashes_deep( sanitize_key(  $sub_v )) ;
						if(ctype_xdigit($rr)){
							$_temp_array_process[ $_tmp_key ] = "#" . $rr ; 
						}else{
							//in case data not conforme of type data required 
							// set a value of default 
							$_temp_array_process[ $_tmp_key ]= "#111111" ;
						}
					}
				//for all others type of css propriety check if data is integer or string 
				//run method sanitize key end  stripslashes_deep 
				}else{
							( $BJ_data->_type_format[ $_tmp_key ] == 'string') ? 
		 					$_temp_array_process[ $_tmp_key ] = self::stripslashes_deep_string( $sub_v  )  :
		 					$_temp_array_process[ $_tmp_key ] = self::stripslashes_deep_int( $sub_v  ) ;		
				}
					 	
			}	//sub foreach end 	 
				//check if $post is array 
				if( is_array( $post_content ) ){
					//marge array sanitized   
					$out_post_sanitized[ $post_key ] = $_temp_array_process ;		
				}
				else{
					//marge content post  
					$out_post_sanitized[ $post_key ] = (String)  stripslashes_deep( sanitize_key( $post_content )) ;	
				}
		}		//foreach end 		
		return $out_post_sanitized ;
	}

	public  function map_main_type( $type_val , $object_array ){

		return array_search( $type_val , $object_array->$_type_format[1] );
	}

	public static function stripslashes_deep_string($value)
	{			//filter INT  
					$value = preg_replace('/[^A-Za-z\. -]/', '', $value);
					$value = stripslashes_deep( sanitize_key( $value )) ;
		return $value;
	}

	public static function stripslashes_deep_int($value)
	{			//filter STRING 
					$value = preg_replace('/[^0-9\. -]/', '', $value);
					$value = stripslashes_deep( sanitize_key( $value )) ;
		return $value;
	}


	/**
	*@param 	array  $_entry_post  
	*@return 	array  sanitize 
	*			call sanitize_entry_style_function when callback is , raneme , delate , reload  
	*/
	public static function sanitize_entry_style_function( $_entry_post ){

		$copy_post = $_entry_post ;

		$array_out = array();
		if( isset( $_entry_post) )
		foreach($copy_post as $key => $val ){

			$_temp_key = stripslashes_deep( sanitize_key( $key )) ;

			switch ( $_temp_key  ) {
			case 'action ':
				$array_out[$_tmp_key] = stripslashes_deep( sanitize_key( $val )) ;	 
				break;
			case 'nonce':
				$array_out[$_tmp_key] = stripslashes_deep( sanitize_key( $val )) ;
				break;
			case 'trigger':
				$array_out[$_tmp_key] = stripslashes_deep( sanitize_key( $val )) ;
				break;
			case 'function_args_':
				$array_out[$_tmp_key] = stripslashes_deep( sanitize_key( $val )) ; 
				break;
			case 'set_function':
				$array_out[$_tmp_key] = stripslashes_deep( sanitize_key( $val )) ; 
				break;
			default:
			break;
			}
		}

		return $_entry_post;
		
	}

		

}

