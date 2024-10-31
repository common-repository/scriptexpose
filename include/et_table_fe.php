<?php

/*
*  load front_end 
*  scriptet tables list
*/
namespace SPEX\inc ;


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


//add_shortcode( 'theme_module' , array('ScriptExp' , 'start_plugin')  );
class ScriptEt{

public static  function  start_plugin( $attr ){

    
global $wpdb; 

    $tag =  shortcode_atts(array('theme_module' => '' ,), $attr );
    $css_to_load = '' ;

    $post_part = '' ;

    //filter input attr from page article ...
    if(isset($attr[0]) && isset($tag) ){
            $localize_table = trim( $attr[0] , "-_';:%#@§\/&%$" );
            
    } 
        $page_content = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}theme_module WHERE theme_module = '{$localize_table}' "  );

        if( empty( $page_content ) ){

                echo '<p>something in the shortcode .... has changed  </p>';
               
                echo '<p> Look in menu Shortcode modules ; note if the module has been renamed or deleted  </p>';
                return true; 
                exit ;
        }

    $_top = self::css_load_css(  $page_content[0]->style_table  );  //return to from css module height + max_top 

    //echo $page_content[0]->style_table . "   <<<<---- ";

    foreach($page_content as $i){

        
        
         echo '<div style="margin:auto; height : ' . $_top[0] . 'px " class="front_end_container" >';
            //you can change <div> or <p> tag as you want here below  
            ?>
                    <div class="taf<?php echo $i->style_table ; ?>"style="position :relative ;  " >
                    <div class="taa<?php echo $i->style_table ; ?>"style="background-image: url(<?php echo $i->url ;?>) ;  background-repeat: no-repeat;" ></div>  
                    <div class="tab<?php echo $i->style_table ; ?>" ><?php echo $i->text_area_a ;?></div>
                    <div class="tac<?php echo $i->style_table ; ?>" ><?php echo $i->text_area_b ;?></div>
                    <div class="tad<?php echo $i->style_table ; ?>" ><?php echo $i->text_area_c ;?></div>
                    <div class="tae<?php echo $i->style_table ; ?>" ><?php echo $i->text_area_d ;?></div>
                    <div class="tag<?php echo $i->style_table ; ?>" ></div>
                    </div>

            <?php
    }
        echo '</div>';
}  




public static function css_load_css(  $css_type  ){

    $_px = 'px;' ;
    $_find_top = 0 ;
    $_find_right = 0 ;
    $_find_width = 0;
    $_find_height = 0;
    $_elem_temp_ = array();   //array pemporaneo

    include_once( STE_PATH . 'include/et_dbman.php');  
    $_db_man = new style\Db_manage();
   
    $_db_man->current_style = $css_type ;
    $_base_temp_ = $_db_man->get_temp_base_tag() ;
    // refer to array("taa" => "css_script_a" , "tab" =>  "css_script_b" , "tac" => "css_script_c" , "tad" => "css_script_d" ,  "tae" => "css_script_e" );

    $script_css = '';
    $script_css_init =  ' <style type="text/css">' ;
    $script_css_end = ' </style>';
    $scrip_aft = 
                    '.taf'. $css_type .' { float:left ;display: block;; } ' .
                    ' .taa'. $css_type . 
                    ' , .tab'. $css_type . 
                    ' , .tac'. $css_type . 
                    ' , .tad'. $css_type . 
                    ' , .tae'. $css_type .
                    '  , .tag'. $css_type .
                    '  { float:left; position : absolute  !important; box-sizing: none !important; }';
                



    foreach( $_base_temp_ as $element => $_idx_ ){

                    $script_css .= '.' . $element . $css_type . ' { ' ;
        
                    //encoding_args() propriety of Db_manage() read table css table  $_tab_option = encoding_arg( $_idx_ );
                    $_elem_temp_ = $_db_man->encoding_arg( $_idx_ );
                    $temp_top = $_elem_temp_["top"] ; $temp_height = $_elem_temp_["height"] ;
                    $temp_right = $_elem_temp_["left"] ; $temp_width = $_elem_temp_["width"] ;

                    foreach( $_elem_temp_ as $_elem_tag_ => $val){

                            if($_elem_tag_ == "top" ){ if( $_find_top <= $val ) { $_find_top = $val ; $_find_height = $temp_height ; } }   //  
                            if($_elem_tag_ == "left" ){ if( $_find_right <= $val ) { $_find_right = $val ; $_find_width = $temp_width ; } }  
                            
    //include css terms which do not accept the setting in px  
    //filter ----->>      set voice   px   %   number dimension sett in $_px = "%"
                            if( ! in_array($_elem_tag_ , $_db_man->_no_px_ )){
                                    $_px = 'px;' ;
                            }else{ $_px = ';' ; }

                            $script_css .=  trim( $_elem_tag_ , " " ) . " : " . $val  . $_px ;

                    }
                    $script_css .=  ' }  ' ;

    }
    // composer script ...   css

    $script_css = $script_css_init . $script_css . $scrip_aft . $script_css_end ;


    $_find_right += $_find_width + 50 ;
    $_find_top += $_find_height + 50;
    /*  css part to add 
    $script_css .= '    #resizable { width: 150px; height: 150px; padding: 0.5em; }
                        #resizable h3 { text-align: center; margin: 0; }';
    $script_css .= ' </style>'
    */
    $_dim_layout[0] = $_find_top ; 
    $_dim_layout[1] = $_find_right;
    echo $script_css ;
    unset($_db_man );
    return $_dim_layout ;
 
}

}

