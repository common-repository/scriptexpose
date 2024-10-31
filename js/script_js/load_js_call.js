(function($){

    //open new form module form 
    $(document).ready(function(){
		$(".new_mod_button").click(function(){
			$(".pannel_module").fadeToggle();
			var txt = $(".new_mod_button").text();
            if(txt == 'open new module'){ $(".new_mod_button").text('close'); }else{ $(".new_mod_button").text('open new module'); }
             
		});
	});

//open close new module button ; select new module name or module in list  
	  $(document).ready(function(){
		$(".select_new_button_module").click(function(){
        	$(".new_mod_select").fadeToggle();//selector_module_list
            $("#new_mod_name").val("").fadeToggle();//selector_new_module_name
			($(this).attr("for") === 'on' ) ? $(this).attr("for", "off") : $(this).attr("for" , "on") ;
		});
	});

	
	// -------->>>   load photo from wp_media_archive
	
	jQuery(document).ready(function($){ //[id^=maxa]
    	$('[class^=load_art]').click(function(e) {		
            var ident = $(this).attr("class");
                ident = ident.substring(8);
            e.preventDefault()
            var image = wp.media({
                title: 'Upload Image',
                multiple: false
            }).open()
            .on('select', function(e){
                var uploaded_image = image.state().get('selection').first();
                console.log(uploaded_image);
                var image_url = uploaded_image.toJSON().url;
                 $(".url_photo_mod" + ident ).val(image_url);
                 $(".photo_art" + ident ).attr("src" , image_url);
            });
        });
    });
   

})(jQuery);