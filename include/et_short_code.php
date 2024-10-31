<?php

// Display form 
// modify module name and shortcode and assign style 


namespace SPEX\inc;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



class shortcode_update{

	

	public function add_role(){

		$role = get_role( 'administrator' );
		// Add the capability
		$role->add_cap( 'Script_et_set_shortcode' );
		
	}

	public function remove_role(){

		$role = get_role( 'administrator' );
		// remove the capability
		$role->remove_cap('Script_et_set_shortcode' );


	}

	public function load_sub_menu(){


		$hook = add_submenu_page( 'Script_et_module_view_table', 'Shortcode modules', 'Shortcode modules', __('Script_et_set_shortcode', 'ScriptEt') , __('Script_et_set_shortcode','ScriptEt'), array( $this , 'print_table_catalog' ) ); 
		add_action( "admin_print_scripts-{$hook}",  array( $this, 'short_enq_script' ) );
		add_action( "admin_print_styles-{$hook}",  array( $this, 'short_enq_style' ) );
	}



	public  function short_enq_style(){

		//'Script_et_shortcode_style'
		
		$path_css =  plugins_url() . '/' .  STE_ABS  . '/css' ;
		$path_js = plugins_url() . '/' .  STE_ABS  . '/js' ;
	 	wp_enqueue_style('module_view_short',  $path_css . '/module_view_short.css' );
	 	wp_enqueue_style('jquery.classypaypal.min.css',  $path_js . '/script_js/j_pp/css/jquery.classypaypal.min.css'  );
	}


	public  function short_enq_script(){
				
		//'Script_et shortcode _script'
		
		$path_js = plugins_url() . '/' .  STE_ABS  . '/js' ;
		wp_enqueue_script('jquery.classypaypal.min.js', $path_js .  '/script_js/j_pp/js/jquery.classypaypal.min.js'  , false  );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script('catalogo_sel', $path_js . '/script_js/catalogo_sel.js' , false );
		wp_enqueue_script('load_js_call', $path_js . '/script_js/load_js_call.js' , false );
		include_once( STE_PATH . 'include/et_register_script.php');	
		et_register_ajax::register_ajax( 'table' );
	}


 function print_table_catalog(){

 		get_template_directory();
		
		global $wpdb;
 		$list_tab = array();
 		$pre_list = array();
 		$style_table = array();

 		//get name module recorded 
		$list_table = $wpdb->get_results( " SELECT theme_module   FROM   {$wpdb->prefix}theme_module " );
		$index = 0;
		
		foreach($list_table as $val => $ind ){
			
	 		if(!is_array($ind)){

	 			foreach($ind as $j => $k){

	 				$list_tab[ $k ] = $k ; 
	 			}
	 		}
		}


		//read style table
		foreach($list_tab as $tab_index => $vir){
		 
		  	$catalog_list = $wpdb->get_results( "SELECT theme_module , style_table  FROM {$wpdb->prefix}theme_module  WHERE theme_module = '{$vir}' LIMIT 1 " );
		  	$pre_list = array_merge($pre_list ,  $catalog_list );
		}
		 
			$catalog_list = $pre_list;


		//read style table
 		$_style_list = $wpdb->get_results( "SELECT style_table FROM  {$wpdb->prefix}theme_module_css " );

	        foreach($_style_list as $read){

	        	//list table css
 				
	        	$style_table[ $read->style_table ] = $read->style_table ; 
	        }	


		
	echo '<div class="rib" style="width : 400px;"><label class="title" class="rib" id="choose_style"> ASSIGN STYLE TO MODULE MODIFY NAME AND SHORTCODE MODULES </div><td class="rib">';
				$v = 0 ;

				echo '<table class="orr"><tbody class="orr_body">';
				?>
				    			<tr>
				    				 <td class="rib"><label class="text_cat" type="text" >MODULE NAME</lable></td> 
				    				 <td class="rib"><label class="text_cat" type="text">STYLE ASSIGNED</label></td> 
							   	</tr>
						<?php
					    foreach($catalog_list as $t => $i){ 
					    ?>		        	
			
								<tr>
									<td class="rib"><input class="new_module<?php echo $i->theme_module ?>" type="text" value="<?php echo $i->theme_module ?>"></span></td>
									
									<td class="rib"><select class="style_table<?php echo $i->theme_module ?>">
										<option class="rib" selected ="selected" value="<?php echo $i->style_table . '">' . $i->style_table ?></option>

											<?php foreach($style_table as $_css_tab ){
													echo '<option class="rib" value="' . $_css_tab . '">' . $_css_tab .'</option>';
												}
											?>   
										</select></td>
							        <td class="rib"><label  style="display: block" class="code_scort" type="text" >  schortcode:  [theme_module <?php echo $i->theme_module ?>]</lable></td>			   
									<td class="rib"><button class="que_art_Unt<?php echo $i->theme_module ?>" >Update</button></td>
									<td class="rib"><button class="que_art_Dnt<?php echo $i->theme_module ?>">Detete</button></td>
				<?php
						

	        			echo '</tr>';
					    }

					echo '</tr></tbody></table>'; 
					echo'<div class="tabs"></div>' ; 
					echo '<div class="console"></div>';
					echo '<FORM action="https://www.paypal.com/cgi-bin/webscr" method="post"><button id="paypal6" class="ClassyPaypal-button ClassyPaypal-type-donate
					ClassyPaypal-style-square ClassyPaypal-transit" 
					data-business="binwavelab@gmail.com" 
					data-item_name="Donation to support our work" 
					data-lc="EU" data-no_note="0" 
					data-currency_code="EUR">Donate!
					</button></FORM>';
                    

	}

}
