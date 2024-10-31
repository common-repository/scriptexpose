(function($){

$(document).ready(function(){
	$('[class^=que_art_]').click(function(){
        
    var filter_text = true ;
	// e.preventDefault();
	var ident = $(this).attr("class");
    var sel_query = $(this).attr("class"); 
	ident = ident.substring(11);
    ident = $.trim(ident);             
    sel_query = sel_query.substring(8,11); 
    
    //str.indexOf("welcome");
    //---------for menu theme_module -------------------
	var mod_text_a     = $(".mod_text_a"+ident ).val() ;
	var mod_text_b     = $(".mod_text_b"+ident ).val() ;
	var mod_text_c     = $(".mod_text_c"+ident ).val() ;
	var mod_text_d     = $(".mod_text_d"+ident ).val() ;
    var mod_url_photo  = $(".url_photo_mod"+ident ).val() ;
    var new_mod_sel    = $(".new_mod_select" ).find( 'option:selected' ).val() ;
    var new_mod_name   = $("#new_mod_name" ).val() ;
     //-------------for menu new theme_module -------------
    var new_module     = $(".new_module"+ident ).val() ;
    var style_table      = $(".style_table"+ident ).find( 'option:selected' ).val();  // css_table  refer to table DB css name field 
    var module_select  = $(".module_select" ).find( 'option:selected' ).val();  // css del theme_module 
   
    var set_module = '' ;
                //find in new module is set text
    
    switch( sel_query ){
        case 'del':
            enable_ = true ;
            set_module = module_select ;
        break;
        case 'upd':
            enable_ = true ; 
            set_module = module_select ;
        break;
        case 'sav':
            enable_ = false ; 
            if( $(".select_new_button_module").attr("for") === 'on'  ){
                set_module = filter_string( new_mod_name   ) ;
                enable_ = ( (set_module !== '' ) && (set_module != null)  ) ? true : false ;
            }else if( $(".select_new_button_module").attr("for") === 'off'  ){
                set_module = filter_string( new_mod_sel   ) ;
                enable_ = ( (set_module !== '' ) && (set_module != null)  ) ? true : false ;
            }
            // $(".console").append(set_module + " " +  set_module + " " + enable_ );
        break;
        case 'Unt':
            enable_ = false ; 
            new_module = filter_string( new_module  ); 
            enable_ = ( ( new_module !== ''  ) && ( new_module != null ) ) ? true : false ;  
             $(".console").append( new_module + " " +  style_table + " " + enable_  );
        break;
        case 'Dnt':
            enable_ = true ; 
        break;
    }
        
    if( enable_  ){
        var var_upgrade = {

        'action'        : up_js_data.action ,
        'nonce'         : up_js_data.nonce ,
        'text_area_a'   : mod_text_a , 
        'text_area_b'   : mod_text_b ,
        'text_area_c'   : mod_text_c ,
        'text_area_d'   : mod_text_d ,
        'url'           : mod_url_photo ,
        'id'            : ident ,
        'theme_module'  : set_module ,
        'new_module'    : new_module ,
        'sel_que'       : sel_query  ,// select button save update delate **
        'style_table'   : style_table ,
        };

        jQuery.post( up_js_data.ajaxurl , var_upgrade , function(response) {


            //.slideUp( 300 ).delay( 800 ).fadeIn( 400 );

        $(".mod_text_d"+ident).css("background-color", "#ffff00");
        $(".mod_text_a"+ident).css("background-color","#ffff00") ;
        $(".mod_text_b"+ident).css("background-color","#ffff00") ;
        $(".id_art"+ident).css("background-color","#ffff00") ;
        $(".mod_text_c"+ident).css("background-color","#ffff00") ;
        $(".url_photo_mod"+ident).css("background-color","#ffff00") ;
        $(".cod_mod"+ident).css("background-color","#ffff00") ; 
       
        
           location.reload(true);
        

        setTimeout(function(){
        $(".mod_text_d"+ident).css("background-color", "white");
        $(".mod_text_a"+ident).css("background-color","white") ;
        $(".mod_text_b"+ident).css("background-color","white") ;
        $(".id_art"+ident).css("background-color","white") ;
        $(".mod_text_c"+ident).css("background-color","white") ;
        $(".url_photo_mod"+ident).css("background-color","white") ;
        $(".cod_mod"+ident).css("background-color","white") ; 
        
        }, 2000);


            // $(".cons").append("text_area_a console " + 'that' );
            //location.reload();
        });

        }else{  

          $("#new_mod_name").css("background-color" , "yellow") ;
          setTimeout(function(){ $("#new_mod_name").css("background-color" , "white") ;},2000); 
          alert(" Set name for new module  "); 
        }
        
                
		});
	});

function filter_string( in_str  ){  
    if( in_str != null || in_str != '' ){
            try{
            in_str = in_str.replace( /[^a-z0-9\s]/gi, '' );
            in_str = $.trim( in_str );
            }catch(error){ in_str = null ; }
        }else{
                in_str = null ; 
        }
            return in_str ;
    }
})(jQuery);