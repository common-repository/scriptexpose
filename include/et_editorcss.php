<?php


/*
*
*	editor_css 
*	display panel buttons css
*	display template module 
*	load css template 
*	in set style page menu  ( admin page  )
*/
namespace SPEX\inc\style ;

//use  SPEX\inc\activation ;
//oggetto editor css relativo template galleria 

class editor_css{


	


	//display pannell with button spinner for modify css 

    public function editor_form(  $bd_manage ){

 


		global $wpdb;
		$_OPTION_CSS = array();

		//sertart style 
		//$bd_manage->init_load_style();


		echo '<div id="draggable" class="con_con"  style=" visibility : hidden" >' ; //style="display : none "
		echo '<div id="tabs" class="con_con"  >' ;
		echo '<ul>';
		foreach ($bd_manage->get_list_option_css() as $tab_select => $name_selector ) {
			# code..
				echo '<li><a class="input_option"  href="'. $tab_select . '">'. $name_selector . '</a></li>' ;  //<--------print table selector 
		}
		echo '<li><a class="input_option"  href="#Option">Option</a></li>';  //option save rename ..  link 
		echo '</ul>';

		//-------------------------------
		echo '<div>fine tab </div>' ;
		//-------------------------------


			
		if( $bd_manage->current_style != '' ){

			$tab_s = 1 ;
			$indx = 1 ; //indice numerico di riferimento a etichetta spinner ,  proprieta css  

				//                                  		"taa" => 	"css_script_a" 
			foreach(  $bd_manage->get_temp_base_tag() as $_name_tag => $_css_script_x ){

			$_OPTION_CSS = $bd_manage->encoding_arg( $_css_script_x );  //<--- encoding_arg() read table through wp_option()  decode json_array 	

			$indx = self::menu_css(  $bd_manage->pro_box_css(  $_OPTION_CSS ) , $indx  , $tab_s ,  $_name_tag  , true ) ; // get css propriety from  $css_map_val of portion class for display it

			$indx = self::menu_css(  $bd_manage->pro_opt_css( $_OPTION_CSS ) , $indx  , $tab_s++ , $_name_tag ,  false  ) ; // get the remaining propriety css from $_tab_option to display 
			//print_r($_OPTION_CSS);
			//echo "\n ... \n";
		}

		self::load_button_menu( $wpdb , $tab_s );   //load button pannel for : reload and seve style , make new style , in database wp_theme_module_css
		// end table option pannall 
		echo 'display style controls</div>' ;
		echo '</div>' ;
		
		}else{
			//
			echo 'style_table name  not found in table_css look phpmyadmin in wp_theme_module_css  css_table and wp_theme_module '.'</br>';
			echo 'if name is removed  or current_style  has a voice to corresponding css_table name '.'</br>' ;
		}

	}

//a:22:{s:6:"margin";s:2:"10";s:11:"padding-top";s:2:"18";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:16:"background-color";s:37:"rgba(30,152,171,0.017483234405517578)";s:16:"background-image";s:1:"0";s:9:"font-size";s:2:"15";s:5:"color";s:7:"#4d19e8";s:6:"height";s:3:"238";s:5:"width";s:3:"402";s:4:"left";s:2:"-1";s:3:"top";s:2:"88";s:13:"border-radius";s:2:"22";s:12:"border-width";s:1:"3";s:12:"border-color";s:7:"#ee3030";s:17:"background-origin";s:7:"inherit";s:15:"background-size";s:7:"initial";s:10:"text-align";s:6:"center";s:12:"border-style";s:6:"dashed";s:14:"vertical-align";s:3:"sub";s:10:"box-sizing";s:10:"border-box";}
//a:13:{s:6:"margin";s:2:"10";s:11:"padding-top";s:2:"18";s:12:"padding-left";s:1:"0";s:13:"padding-right";s:1:"0";s:14:"padding-bottom";s:1:"0";s:16:"background-image";s:30:"url(http://acew.com/startbit/)";s:9:"font-size";s:2:"15";s:6:"height";s:2:"50";s:5:"width";s:3:"200";s:4:"left";s:2:"30";s:3:"top";s:2:"30";s:13:"border-radius";s:2:"20";s:12:"border-width";s:1:"7";}
	

		// DISPLAY TABLE LIST OPTION CSS 
	/**
	*	$arr  		array contains the css propriety and value to display in  conteiner pannel 
	*	$_idx  		progressive number defines the css element
	*	$mt_col 		progressive number defines table tab 
	*	$css_tag	define name element css to modify 
	*	$bool_ing	controls the passage between reorder_array and pro_opt_css function .
	*
	*	@return int ... progressive number defines the css element
	*/

    public function menu_css( $arr , $_idx , $ntab , $tag_name , $box_opt_sw ){

    	//$_idx , $ntab , $tag_name  references to label objects spinner and css

    	$divider = 5 ;	//	divider close left box and open right box when it's count arrives to 0 
    					//	this parameter  not be greater than the number of voice css .. . e.e background-color text-allign ecc ecc 
       			
		if($box_opt_sw){  //	controls the start and end of the list css options

				echo '<div id="tabs' . $ntab . '" class="box_inn"  >'  ;  	//$ntab Reference page Option tab JQuery
		        echo '<ul class="find" >'  ;								
		        echo '<div class ="left_box">';
    	}
        foreach($arr as $pcss => $value ){
			
		//********************  PRINT / INPUT / LABEL / SPINNER / in table ul - li  included in tab option jquery **********************
		
			if ( !is_array($value)  ){

			//************************      css for numeric value  ****************************
				if( $divider == 0 ) echo '</div><div class ="right_box"><li><div id="colorpicker'. $tag_name .'"></div></li>' ; 	
					//label + input spinner tag utili , ( name reftab , class ta_lab 
				// rimosso id="lab_id' . $tag_name . $pcss . '"
				// riosso id="lab_id' . $_idx++ . '"	priga css riga 127
							
				echo '<li class="combox">' ;

					echo '<div class="rib"><label  name="ref_sp' . $ntab . '"
							 			 css=".' . $tag_name .'"   
				  			     			class="nox" for="' . $pcss . '"  value="'. $pcss  .'">' . $pcss . '</label>

						  	<input  name ="targ"  type="text"';
						  	if( strpos($pcss , 'lor') == true || strpos($pcss , 'ima') == true  ) 
						  		echo ' for ="enp' .  $_idx . '"';
						  			else
						  		echo 'for ="inp' .  $_idx . '"';

									echo ' id ="inp' . $tag_name . $pcss . '"
												pcss = "' . $pcss . '"
												value ="' . $value . '" 
													css="' . $tag_name . '"
														ttp="ag' .  $_idx . '" >


													<div id="slider' . $_idx++ . '"></div></div></li>' ; 
	
										 $divider -- ;
										//}
                        }else{ 

					//************************     tool for string value  ****************************
					//  
                    /*i rif -> css , sel_name , data , riferimenti utili per modifica css */

				echo '<li class="combox" > ' ;

				  	echo '<div class="rib"><label name="ref_op' . $ntab . '"
				  					   
				  						 class="nox" for="'. $pcss .'"  value="'. $pcss  .'">' . $pcss  . '</label>';

						echo '<select sel_name ="'. $pcss . '" class="option_ta"  css=".' . $tag_name .'"  id="data' . $ntab . '">';

			 foreach( $value as $key => $val ){  

						echo '<option  for="'. $val .'" name ="targ" id="tag-val" value="' . $val . '" >' . $val . '</option>';               
					}
		echo "</select></div></li>" ;
					}
       	}					
		if(!$box_opt_sw){
				echo '</div>';
				echo '</ul>' ;
				echo '</div>' ;

				
		}       
       return $_idx ;   
    }


    //load tempalete base in editor ScriptEt 
	public function disp_temp_base($tool){	//
		
		
		global $wpdb; 
			$list_cat = array();
			$temp_dir = get_option('current_style') ;
			$warning_log = '' ;
			$_enable_style = false ;

			if(isset($temp_dir) && $temp_dir != '' ){
			
				$list_cat = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'theme_module WHERE style_table = "'. $temp_dir .'" LIMIT 1'  );
				$_enable_style = true ;

			}

			if( !isset($list_cat[0]->style_table ) || ( $list_cat[0]->theme_module == " " ) ){

				$list_cat = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'theme_module WHERE theme_module = "presentation" LIMIT 1'  );
				echo '<div class="advise">load text area default ... </div>' ;
				$_enable_style = true ;
			}

			if( !isset($list_cat[0]->style_table ) || ( $list_cat[0]->theme_module == " " ) ){
						echo '<div class="advise">The style  ' . $temp_dir . ' not assign to any module </div>' ;
						$_enable_style = false;
			}
			
			echo ' <div class="tab-r"  >';
				$n_um = 0;  //identify the position of option_tab_pannel relative its div below .. important !!


				//rinonimato t
				if( $_enable_style ){

				    foreach( $list_cat as $i ){
				    
						?>
					<div style='display : none'  id="et_tag" class="taf" for="<?php echo $n_um++; ?>"  name="taf"  style="position :relative ; " >
					<div style="background-image: url(<?php echo $i->url ;?>) ;  background-repeat: no-repeat;" 
						 id="et_tag" class="taa" for="<?php echo $n_um++ ; ?>" name="taa" >Photo</div>  
					<div style='display : none'  id="et_tag" class="tab" for="<?php echo $n_um++ ;?>"  name="tab"  ><?php echo $i->text_area_a ;?></div>
					<div style='display : none'  id="et_tag" class="tac" for="<?php echo $n_um++ ;?>"  name="tac"  ><?php echo $i->text_area_b ;?></div>
					<div style='display : none'  id="et_tag" class="tad" for="<?php echo $n_um++ ;?>"  name="tad"  ><?php echo $i->text_area_c ;?></div>
					<div style='display : none'  id="et_tag"  class="tae" for="<?php echo $n_um ; ?>"  name="tae"  ><?php echo $i->text_area_d ;?></div>		
					</div>

						<?php
					}  					
										echo '</div>';
				}else{				//displays default content
									$image_default = plugin_dir_url('ScriptEt') . 'ScriptEt/image/flower.jpg';
						?>
					<div style='display : none' id="et_tag" class="taf" name="taf" for="<?php echo $n_um++ ; ?>" style="position :relative ; " > 
					<div style="background-image: url(<?php echo $image_default ;?>) ;  background-repeat: no-repeat;" 
						 id="et_tag" class="taa" for="<?php echo $n_um++ ; ?>" name="taa" ></div>  
					<div style='display : none' id="et_tag" class="tab" name="tab" for="<?php echo $n_um++ ;?>"  >text A</div>
					<div style='display : none' id="et_tag" class="tac" name="tac" for="<?php echo $n_um++ ;?>"  >Text B</div>
					<div style='display : none' id="et_tag" class="tad" name="tad" for="<?php echo $n_um++ ;?>"  >Text C</div>
					<div style='display : none' id="et_tag" class="tae" name="tae" for="<?php echo $n_um ; ?>"   >Text D</div>		
					</div>

						<?php
										echo '</div>';



				}

				if(isset($warning_log)){
					//echo " template div ";
				}echo '<div for="act" class="console" >console </div>';
				echo " template div ";

		
	}



	//send the css script to page admin of ScriptEt

    public function load_base_tem_css( $_bd_manage_  ){  


		$_base_element_ = $_bd_manage_->get_temp_base_tag();
		
		$script_css = '';
		$script_fin = '*, *:before, *:after {   box-sizing: initial !important; }';

		$script_css_init =  '<style type="text/css">' ;
		$script_css_end = ' </style>';

		$_px = 'px;' ;
		
		foreach( $_base_element_ as $element => $_idx_ ){

						$script_css .= '.' . $element  . ' { ' ;

							foreach($_bd_manage_->encoding_arg( $_idx_ ) as $tag => $val){

				//----->filter list element dimension px , % , # ...  

								if( ! in_array($tag , $_bd_manage_->_no_px_ )){
										
										$_px = 'px;' ; }else{ $_px = ';' ; }
								
								$script_css .=  trim( $tag , " " ) . " : " . $val  . $_px ;

							}
						$script_css .=  '  }  ' ;

		}
			
		$script_css = $script_css_init . $script_fin . $script_css . $script_css_end ;

       
        echo $script_css ;
        echo "stile script css \n";
     
    }




    public 	function load_button_menu( $lib_  , $tabs ){

				$css_list = $lib_->get_results( "SELECT style_table  FROM " . $lib_->prefix . "theme_module_css " );

				echo '<div style="display : inline-block ; float : left ;" id="tabs' . $tabs . '" class="box_inn" >'  ;  
							
				

				echo '<button class="input_option" id="load_style" >load style</button>';
				echo '<select class="input_option" id="sel_css" class="sel_css" >';
				echo '<option class="tab_css" value="' . get_option( 'current_style' ) . '">' . get_option( 'current_style' ) .'</option>';
										foreach($css_list as  $key){
												echo '<option class="tab_css" value="' . $key->style_table . '">' . $key->style_table .'</option>';
											}
					   
				echo '</select>';
			   
				echo '<div style="display : inline-block ; float : left ;" id="menu">';
				echo '<select class="input_option" style="width: 120px;" id="sel_function" class="sel_func "  >';
				
												echo '<option  selected ="selected" value="RELOAD"> </option>';
												echo '<option  value="new_style">new style</option>';
												echo '<option  value="delete_style">delete style</option>';
												echo '<option  value="rename_style">rename style</option>';
												echo '<option  value="save_style">save style</option>';
				echo '</select>';
				echo '</div>';	   
				echo '<input class="input_option"  type="text" id="new_style_name"  >'; 
				echo '<button style=" border-spacing: 10px;" class="input_option"  id="accept_change" >accept change</button> ';
	            echo '</div>' ;
	            echo "button menu";


		}

}