<?php


/*
*  module_view display Module Page 
* 
*/

namespace SPEX\inc ;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class module_view  {


	public function add_role(){

		$role = get_role( 'administrator' );
		// Add the capability
		$role->add_cap( 'Script_et_module_view' );
	}


	public function remove_role(){

		$role = get_role( 'administrator' );
		// remove the capability
		$role->remove_cap('Script_et_module_view' );
	}


	public function load_sub_menu(){


		$hook = add_menu_page('ScriptEt', 'ScriptEt', __('Script_et_module_view','ScriptEt') , __('Script_et_module_view_table','ScriptEt'), array($this , 'load_page_module_view') );  
		
		add_action( "admin_print_scripts-{$hook}",  array( $this, 'table_enq_script' ) );
		add_action( "admin_print_styles-{$hook}",  array( $this, 'table_enq_style' ) );
	}

	public  function table_enq_style(){

			//load module_view style
		 
		$path_css = plugins_url() . '/' .  STE_ABS  . '/css' ;
		$path_js =  plugins_url() . '/' .  STE_ABS  . '/js' ;
		wp_enqueue_style('module_view_short',  $path_css . '/module_view_short.css' );
		wp_enqueue_style('jquery.classypaypal.min.css',  $path_js . '/script_js/j_pp/css/jquery.classypaypal.min.css'  );
	
	}


	public  function table_enq_script(){
				//load module view script
		
		$path_js = plugins_url() . '/' .  STE_ABS  . '/js' ;
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery.classypaypal.min.js', $path_js .  '/script_js/j_pp/js/jquery.classypaypal.min.js'  , true  );
		wp_enqueue_script('catalogo_sel', $path_js . '/script_js/catalogo_sel.js' ,  true );
		wp_enqueue_script('load_js_call', $path_js . '/script_js/load_js_call.js' ,  true );	
		wp_enqueue_media();	
		//include ajax_call_beck nonce 
		include_once( STE_PATH . 'include/et_register_script.php');	
		//ajax callback register nonce for module_view PAGE
		et_register_ajax::register_ajax( 'table' );
	}



	//avvia paginazione moduli di inserimento oggetti
	public function load_page_module_view(){


		global $wpdb;
		$path_logo 	= plugins_url() . '/' .  STE_ABS  . '/image/photo_art.png' ;
		$catalog_list = $wpdb->get_results( "SELECT theme_module FROM {$wpdb->prefix}theme_module " );   
		$loaded_table = get_option('catalog_load');
		$cat_list = Array();

		foreach($catalog_list as $read){

		   $cat_list[$read->theme_module] = $read->theme_module ; 
		}

	//-----------------------------------------------------------------------------------------------

	//     	FORM PANNEL PISPLAY NEW MODULE
			?>
	        <td class="rib"></td>
			<div class="pannel_module" style="display:none">
			<div  class="taba">
			<table class="orr"><tbody class="orr_body">

				<tr>			
			       	<td class="rib"><input  type="submit" value="New Modules" class="select_new_button_module" for="off"></td>
			        <td class="rib"><select class="new_mod_select">
			            <?php 
			                        foreach($cat_list as $read => $key){
			                            
			                            echo '<option class="rib" value="' . $key . '">' . $key .'</option>';
			                        }
			            ?>
		            				</select><input id="new_mod_name" class="new_mod_name" type="text" value="" ></td> 
		            <td class="rib"><input type="submit" value="load photo" class="load_art"></td>
					<td class="rib_url"><input  class="url_photo_mod" type="text"  value="" ></td>
					<td class="rib"><img style="position : relative ; backgroud-size : initial" class="photo_art" src="<?php echo $path_logo ?>" width=100px  height=100px alt=""></td>
				</tr>
				<tr>	        
					<td class="rib"><label>Text area A</td>
					<td class="rib"><label>Text area B</td>
					<td class="rib"><span >Text area C</span></td>
					<td class="rib"><span >Text area D</span></td>
				</tr>
				
				<tr>  
					<td class="rib" ><textarea class="mod_text_a" rows="5" cols="20" type="text" value=""></textarea></td>
					<td class="rib" ><textarea class="mod_text_b" rows="5" cols="20" type="text" value=""></textarea></td>
					<td class="rib" ><textarea class="mod_text_c" rows="5" cols="20" type="text" value=""></textarea></td>
					<td class="rib" ><textarea class="mod_text_d" rows="5" cols="20" type="text" value=""></textarea></td>
					<td class="rib" ><span id="but" class="que_art_sav" >save</span></td>
				</tr>

			</tbody></table>
			</div>
			</div>
			</br><button  id="myBtn" value="myvalue"  class="new_mod_button rib" style="width : 200px ; border-width : 2px ; border-style : solid ; border-color: rgba(27, 96, 177, 0.16);" >open new module</button>
			
			<?php

				// DISPLAY SELECTOR MODULE  
			?>
				<table><tbody>
					<tr>
						<td class="rib"><span class="et_label">Select Module</span></td>
						<td class="rib"><select class="module_select">
							<?php foreach($cat_list as $read => $key){

									if( $loaded_table === $read )
										echo '<option class="rib"  value="' . $key . '">' . $key .'</option>';
								}
							?>   
							<?php foreach($cat_list as $read => $key){

									if( $loaded_table !== $key )
										echo '<option class="rib" value="' . $key . '">' . $key .'</option>';
								}
							?>   
						</select></td>
					</tr>
			</tbody></table>

			<?php

			        self::load_list_table();
	
	}




//----------------------------------------------------------------------------------------------------------------------------------

// DISPLAY MODULE LIST OF MODULE  

	public function load_list_table(){
			  
			wp_enqueue_media();
			global $wpdb;
			$all_list = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}theme_module " );
			
			foreach($all_list as $i){
				?>
					<div  class="tabc" >
					<table class="orr_t" id="<?php echo $i->theme_module  ?>"><tbody class="orr_body">
						<tr class="main_info_<?php echo $i->id;?>" style="display : none">
							<td class="rib "><div class="label_text cat_id<?php echo $i->id ;?>" ><?php echo substr($i->theme_module , 0 , 10) ; ?></div></td>
							<td class="rib "><div class="label_text"><?php echo substr($i->text_area_a , 0  , 10);?></div></td>
							<td class="rib "><div class="label_text"><?php echo substr($i->text_area_b , 0  , 10);?></div></td>
							<td class="rib "><div class="label_text"><?php echo substr($i->text_area_c , 0  , 10);?></div></td>
							<td class="rib "><div class="label_text"><?php echo substr($i->text_area_d , 0  , 10);?></div></td>
						</tr>
						<tr class="contein_info_<?php echo $i->id;?>" style="display : none" >
							<td class="rib"><img style="position : relative" class="photo_art<?php echo $i->id ;?>" src="<?php echo $i->url ;?>" width=100px  height=100px alt=""></td>
							<td class="rib" ><textarea class="mod_text_a<?php echo $i->id;?>"  rows="5" cols="20" type="text" value=""><?php echo $i->text_area_a ;?></textarea></td>
							<td class="rib" ><textarea class="mod_text_b<?php echo $i->id;?>"  rows="5" cols="20" type="text" value=""><?php echo $i->text_area_b ;?></textarea></td>
							<td class="rib" ><textarea class="mod_text_c<?php echo $i->id;?>"  rows="5" cols="20" type="text" value=""><?php echo $i->text_area_c ;?></textarea></td>
							<td class="rib" ><textarea class="mod_text_d<?php echo $i->id;?>"  rows="5" cols="20" value="ppp"><?php echo $i->text_area_d ;?></textarea></td>
						</tr>
						<tr class="contein_info_<?php echo $i->id;?>" style="display : none">
							<td class="rib"><input  type="submit" value="load photo" class="load_art<?php echo $i->id ;?>"></td>
							<td class="rib_url"><input class="url_photo_mod<?php echo $i->id ;?>" type="text"  value="<?php echo $i->url ;?>" ></td>
							
					        <td class="rib" ><input type="submit" value="Delete" class="que_art_del<?php echo $i->id ?>"></td>
					        <td class="rib" ><input type="submit" value="Update" class="que_art_upd<?php echo $i->id ?>"></td>		
						</tr>
					</tbody></table>
					</div>
			<?php
		}
				
	}// END PANNEL




} //end class module


