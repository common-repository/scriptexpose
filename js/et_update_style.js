(function($){

//control option menu 
	$(document).ready(function() {
		
	$("#new_style_name").fadeOut();
	$("#accept_change").fadeOut();
    	
	$("#sel_function option:first").attr("selected", "selected");
	$( "#menu" ).on('change', 'select', function (e) {

	var tasd =  $(e.target).val(); ;
	var $tag = $("#sel_css"); 
	tasd = $.trim(tasd);

	if(tasd == "new_style" ){
			$("#new_style_name").fadeIn();
			$("#new_style_name").val("type name and click save style");
            $("#accept_change").fadeIn();
            $("#accept_change").text('Load new Style');
           return;
    }else if( tasd  == "delete_style" ){
			$("#new_style_name").fadeOut();
			$("#new_style_name").val(".;ç°§°ç:;,");
            $("#accept_change").fadeIn();
            $("#accept_change").text('accept delete');
            return;
    }else if (tasd == "rename_style" ){
    		$("#accept_change").text('accept rename');
    		$("#accept_change").fadeIn();
    		$("#new_style_name").val("rename " +  $tag.find( 'option:selected' ).val() );
			$("#new_style_name").fadeIn();
    		return;
	}else if (tasd == "save_style" ){
    		$("#new_style_name").val(".;ç°§°ç:;,");
			$("#new_style_name").fadeOut();
			$("#accept_change").fadeIn();
			$("#accept_change").text('accept save');
            //save_script();
            return;
    }else if (tasd == "RELOAD" ){
    		$("#new_style_name").val("");
			$("#new_style_name").fadeOut();
			$("#accept_change").fadeOut();
			$("#accept_change").text('accept change');
            //save_script();
            return;
    }
    	//$(".console").text(tasd + " responce");
	});
  });


    //  spinner -> css frontend  dinamic controll

$(document).ready(function () {
	var temp_val = '' ;
	var prop_css = '' ;

    $('[for^=inp]').spinner({
    	//numberFormat: "n" ,
    	

    spin: function( event, ui ) {


	temp_val  =   $(this).val(); 
    var photo ;

    var prop_css =  $( this ).attr("pcss");
     //prop_css = t.substring(6);   //get attrib. this  inp.  
    var tag_id =  $( this ).attr("css"); 
    var val = ui.value ;
    val = $.trim( val );
    var css = "." + tag_id ;

    
    if( prop_css.indexOf('color')  <= 0){
    
    	val= val+"px";
    	tag_id = $.trim( tag_id );
  		$( css ).css( prop_css , val );
  		$( this ).attr("value" , val );
  	
    }else{

     	val = val;
     	tag_id = $.trim( tag_id );
  		$( css ).css( prop_css , val );
  		$( this ).attr("value" , val );
  		
 	}
     	
     	
//inserisce nel css 
      	
//$(".console").text("yess" + val + " " + tag_id + " " + prop_css + " tmp val " + temp_val + " idd " + idd);

    },
    stop : function(event , ui){

    	if( prop_css.indexOf("color") >= 0 ){ 	
    	//var refr = "#colorpicker-popup";
    	//	$(this).val(temp_val);

				//$(".console").text(" " + temp_val + " " );	
    	}
    	if( prop_css.indexOf("image") >= 0 ){ 
    	//var refr = "#colorpicker-popup";
    	//	$(this).val(temp_val);

				//$(".console").text(" " + temp_val + " " );	
    	}
    },
        
    });
});


 $(document).ready(function () {
    $('[for^=enp]').click(function (){

    	var temp_val  =   $(this).val(); 
    	var type = '' ;
    	var format = '' ;
    	var alpha = false ;

        var prop_css =  $( this ).attr("pcss");
        //var prop_css = t.substring(6);   //get attrib. this  inp.  
        var tag_id =  $( this ).attr("css"); 
        var css = "." + tag_id ;

       switch(prop_css){

        	case 'border-color' :
        	type = prop_css ;
        	format = '#HEX' ;
        	alpha = false;
        		
        	break;
        	case 'background-color':
        	type = prop_css ;
        	format = 'RGBA' ;
        	alpha = true;
        		
        	break;
        	case 'color':
			type = prop_css ;
			format = '#HEX' ;
			alpha = false;
				
        	break;

        }
    if( prop_css.indexOf("color") >= 0 ){ 
    //attach colorpiker to spinner call 
    
		$(this).colorpicker({
		        //altField : ("#" +t) ,
		        //hideOn : (this),
		        //setColor : (temp_val) ,
		        //showOn:				'both',
			/*parts:  [   'header', 'preview', 'hex',
			'rgbslider', 'memory', 'footer'
			],
			layout: {
			preview:    [0, 0, 1, 1],
			hex:        [1, 0, 1, 1],
			rgbslider:  [0, 1, 2, 1],
			memory:     [0, 2, 2, 1]}*/
			buttonImageOnly:	true,
			parts:          'draggable',
			colorFormat : ( format ),
			showOn:         'click',

			autoOpen :(false),
			altField : (css) ,
			altProperties : type,
				//altAlpha: true,									        
			showNoneButton: true,
			alpha:          alpha ,
			init: function(event, color) {
					$(".console").text(color.formatted);
					$(this).attr('value', color.formatted);
				},
			select: function(event, color) {
					$(".console").text(color.formatted);
					$(this).attr('value', color.formatted);
				}
		    });
					//$(".console").text(val + " " + temp_val + " " + format); 
		}
		if(prop_css.indexOf("image") > 0 ){

        

	       	var image = wp.media({title: 'Upload Image', multiple: false }).open().on('select', function(e){
	        var uploaded_image = image.state().get('selection').first();
	        console.log(uploaded_image);
	        photo = uploaded_image.toJSON().url;
	        var load = 'url(' + photo + ')' ;
	        tag_id = $.trim( tag_id );
	        $(css).css("background-image" ,  load );
	        $("#"+t).val(photo);
	   		});
        	
        }
        if(( prop_css.indexOf('image')) >= 0){
        
        	
        	tag_id = $.trim( tag_id );
      		$( css ).css( prop_css , photo );
      		$( this ).attr("value" , photo );
      		

        }           
						
 		});
            //$(".console").text(val + " dddd " + temp_val + " dddd " + format);
    });


//css  update 
$(document).ready(function(){
    $('[id^=data]').selectmenu({

		change : function(event , ui){

			var value = $(this).find( 'option:selected' ).val();
			var opt = $(this).attr("sel_name");  
			var css = $(this).attr("css");
			css  = $.trim( css );
		$( ".console" ).append( value + " " + opt + " " + css + " osss" );

		//value = value + "px";
		 
		$( css ).css( opt , value );
		}
    }); 
});

$(document).ready(function(){
		$('[for^=inp]').spinner({

			//numberFormat: "n",
		});

	});


   
		
function save_script(){	
				
	var tab_css ;
	var data =   new Array ;
	var datb =   new Array ;
	var datc =   new Array;
	var datd =   new Array ;
	var date =   new Array;
	var datf =   new Array;
	//var datx =   new Array;
	var dat_a = {} ;
	var dat_b = {} ;
	var dat_c = {} ;
	var dat_d = {} ;
	var dat_e = {} ;
	var dat_f = {} ;
	//var dat_x = {} ;
	var i =0;
//str.indexOf("welcome");
//---------for menu theme_module -------------------
//var data_css = Array();
// var data_css = document.getElementsByTagName("ta_lab_b");
//var data_lab = document.getElementsByClassName("ta_lab");
//var fields = $( "form" ).serializeArray();
//var fieledb = $('[class^="ta_lab"]').attr("value").serializeArray();
//$( ".console" ).empty();

	tab_css = $("#sel_css").find( 'option:selected' ).val();
	tab_css = $.trim(tab_css);
	

	$('[name^=ref_sp1]').each( function( l, foo  ) { 		 
	dat_a[ $(this).attr("for") ] = $(this).parent().find($('[name^=targ]')).attr("value")  ;	 
	});
	$('[name^=ref_op1]').each( function( l, foo  ) {  
	dat_a[ $(this).attr("for") ] = $(this).parent().find("option:selected").attr("for") ;	 
	});
	data =  JSON.parse(JSON.stringify(dat_a) );


	$('[name^=ref_sp2]').each(  function( l, foo ) {  
	dat_b[ $(this).attr("for") ] = $(this).parent().find($('[name^=targ]')).attr("value")  ;
	});
	$('[name^=ref_op2]').each( function( l, foo  ) { 
	dat_b[ $(this).attr("for") ] = $(this).parent().find("option:selected").attr("for") ;
	});
	datb =  JSON.parse(JSON.stringify(dat_b) );

	
	$('[name^=ref_sp3]').each(  function( l, foo) { 
	dat_c[ $(this).attr("for") ] = $(this).parent().find($('[name^=targ]')).attr("value")  ;
	});
	$('[name^=ref_op3]').each( function( l, foo  ) { 
	dat_c[ $(this).attr("for") ] = $(this).parent().find("option:selected").attr("for") ;
	});
	datc =  JSON.parse(JSON.stringify(dat_c) );


	
	$('[name^=ref_sp4]').each(  function( l, foo ) { 
	dat_d[ $(this).attr("for") ] = $(this).parent().find($('[name^=targ]')).attr("value")  ;	
	});
	$('[name^=ref_op4]').each( function( l, foo  ) { 
	dat_d[ $(this).attr("for") ] = $(this).parent().find("option:selected").attr("for") ;	 
	});
	datd =  JSON.parse(JSON.stringify(dat_d) );

	
	$('[name^=ref_sp5]').each(  function( l, foo ) { 
	dat_e[ $(this).attr("for") ] = $(this).parent().find($('[name^=targ]')).attr("value")  ;		
	});
	$('[name^=ref_op5]').each( function( l, foo  ) { 
	dat_e[ $(this).attr("for") ] = $(this).parent().find("option:selected").attr("for") ;
	});
	date =  JSON.parse(JSON.stringify(dat_e) );
	
		
	$('[name^=ref_sp6]').each(  function( l, foo ) { 
	dat_f[ $(this).attr("for") ] = $(this).parent().find($('[name^=targ]')).attr("value")  ;
	});
	$('[name^=ref_op6]').each( function( l, foo  ) { 
	dat_f[ $(this).attr("for") ] = $(this).parent().find("option:selected").attr("for") ;
	});
	datf =  JSON.parse(JSON.stringify(dat_f) );


 //if add new object 
/*$('[name^=ref_tab7]').each(  function( l, foo ) { 
dat_g[$(foo).text()] = $(this).parent().find($('[name^=targ]')).val();
});
$('[name^=ref_tabB7]').each( function( l, foo  ) {  
dat_x[$(foo).text()] = $(this).parent().find("option:selected").val() ;	 
});
datx =  JSON.parse(JSON.stringify(dat_x) );
//display script ; enabled console to style_page.php file 
$.each( datb , function (b , a){
$(".console").append(" | " + b + " " + a  );
});*/

var var_reed = {

		'action': up_js_data.action ,
		'set_function'	: 'save_style' ,
		'function_args_': 'none' ,
		'trigger'		: 'accept_change',
		'css_script_a'  :  data ,
		'css_script_b'  :  datb ,
		'css_script_c'  :  datc ,
		'css_script_d'  :  datd ,
		'css_script_e'  :  date ,
		'css_script_f'  :  datf , 
		'style_name'	:  tab_css 
		//'data_tab_x' :	datx    
	};

	//$tot = document.querySelector(".taf");
	//$(".console").append( datf );

	/*  verify code post to beckend
	var poinx = 0;
	$.each( datb , function (b , a ){
	$(".console").append(" | " + b + " | " + a + " | " + poinx++  + " " );});
	*/
	
	jQuery.post( up_js_data.ajaxurl , var_reed  , function(response) {
		//$(".console").append("trasmission ok");
		window.location = window.location.href+'?eraseCache=true';
		location.reload(true);
		
	  }); 
}


	
	$(document).ready(function(){
		$("#accept_change , #load_style ").button().click(function(){


		//-----------PAnnel selector munu save delate rename new -------------------------*/

			var new_str = $("#new_style_name").val();
			var tab_str = $("#sel_css").find('option:selected').val();
			var funx    = $("#sel_function").find('option:selected').val();
			
			var button = $(this).attr("id");
			if(button == 'load_style'){		var trig 	= "load_style" ; 
												new_str	= ".;ç°§°ç:;,"   ; }
			if(button == 'accept_change'){	var trig = "accept_change" ; }

		//-----------------------------------------------------------------------------*/

			//is save 
		
			if(funx == "save_style" ){

					save_script();
					return;
			}


		//for rename delete new  
		
			if( ( new_str != "" ) && (new_str.indexOf('rename') == -1) && (new_str.indexOf('type name and click') == -1) ){


			new_str = new_str.replace(/[^a-z0-9\s]/gi, '');
			new_str = $.trim(new_str);

				var var_reed = {
					'action'		: up_js_data.action ,
					'set_function' 	: funx ,
					'function_args_': new_str ,
					'style_name'  	: tab_str ,
					'trigger'		: trig 
				};

					jQuery.post( up_js_data.ajaxurl , var_reed  , function(response) {
					   //$(".console").append(tab_sty );
					   window.location = window.location.href+'?eraseCache=true';
					   location.reload(true);
	  				});

			}else{	alert("give a valid name in the text box ;  special characters will be removed..  "); }
		});
	});

	// dinamic controll css  

	// 
	/*
   */

	//sensity selection template tag -> tab menu propriety 

    $(document).ready(function() {
		$( '[id^=et_tag]' ).click(function(){
			var indx = $(this).attr("for");
			//indx = indx.substring(0,1);
			$( "#tabs" ).tabs({ active: indx });
			//$(".console").append(indx);
		});
			
 //-----------dinamic resize jquery --> update spinner value widht height----------

	$( '[id^=et_tag]' ).resizable({    //resize
		
		start: function( event, ui ) {

			var $ele_div = $(this);
			var tag_name = $(this).attr("name");
			//tag_name = tag_name.substring(10);
			//tag_name = $.trim(tag_name);
			var ind_x =  tag_name + "width" ;
			var ind_y =  tag_name + "height" ;
			
			var $point_w = $(  "#inp" + ind_x );
	  		var $point_h = $(  "#inp" + ind_y );
	  		//$(".console").append("|" + ind_x + "|" + ind_y + "|");

			resize_dim( $ele_div , $point_w  , $point_h );
		},
			
		stop: function( event, ui ) {

			var $ele_div = $(this);
			var tag_name = $(this).attr("name");
			//tag_name = tag_name.substring(10);
			//tag_name = $.trim(tag_name);
			
			var ind_x =  tag_name + "width" ;
			var ind_y =  tag_name + "height" ;
			var $point_w = $( "#inp" + ind_x );
	  		var $point_h = $( "#inp" + ind_y );	

		resize_dim( $ele_div , $point_w  , $point_h );

		  }

	  });

	function resize_dim( $ele_div , $point_w ,  $point_h  ) {

		var height = $ele_div.height();
		var width = $ele_div.width();
		$(  $point_h ).val( Math.floor(height) );
		$(  $point_w ).val( Math.floor(width) );
		$(  $point_h ).attr("value" , Math.floor(height) );
		$(  $point_w ).attr("value" , Math.floor(width) );
	}
	 


	 //Dragable 
	$( '[id^=et_tag]'  ).draggable({

	  start: function( event, ui ) {
		  
  		var $element_div = $(this);
		var tag_name = $(this).attr("name");
		
		//tag_name = tag_name.substring(10);
		//tag_name = $.trim(tag_name);
		var indx =  tag_name + "left" ;
		var indy =  tag_name + "top" ;
		var $point_l = $(  "#inp" + indx );
  		var $point_t = $(  "#inp" + indy );

		update_position( $element_div , $point_t  , $point_l );
	  
	  },
		
		stop: function( event, ui ) {

			var $element_div = $(this);
			var tag_name = $(this).attr("name");
			//tag_name = tag_name.substring(10);
			//tag_name = $.trim(tag_name);
			var indx =  tag_name + "left" ;
			var indy =  tag_name + "top" ;
			var $point_l = $(  "#inp" + indx );
				var $point_t = $(  "#inp" + indy );

		update_position( $element_div , $point_l  , $point_t );
	  }
			
			
	});
});
    

   $(document).ready(function() {
			$( '#draggable' ).draggable();
		});

	$(document).ready(function() {
			$( "#tabs" ).tabs();
	  	}); 


	// set animation at start 
	$(document).ready(function() {
        setTimeout(function(){
            $(".advise").fadeOut();

        }, 7832);
    });

    $(document).ready(function() {
        setTimeout(function(){
        	$('#draggable').css("visibility" , "inherit");
            $('[id^=et_tag]').fadeIn();	               
        }, 300);
    });


    //call position for div 
	function update_position( $element_div , $point_l   , $point_t ) {

		var top = $element_div.position().top;
		var left = $element_div.position().left;
		$(  $point_t ).val( Math.floor(top) );
		$(  $point_l ).val( Math.floor(left) );
		$(  $point_t ).attr("value" , Math.floor(top) );
		$(  $point_l ).attr("value" , Math.floor(left) );
		//$( this ).attr("value" , val );

    }

    function hexToRgb(color , opac ) {
    	
	    var redHex = color.substring(1, 3);
		var greenHex = color.substring(3, 5);
		var blueHex = color.substring(5, 7);
		var redDec = parseInt(redHex ,16 );
		var greenDec = parseInt(greenHex, 16);
		var blueDec = parseInt(blueHex, 16 );
		color = "rgba(" + redDec + ', ' + greenDec + ', ' + blueDec +  ', ' + opac + ')';

    return color;
}

	

})(jQuery);
