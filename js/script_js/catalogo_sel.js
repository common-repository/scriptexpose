(function($){

//paypall
$(document).ready(function(){
 $('#paypal6').ClassyPaypal({
    type: 'donate',
    style: 'square'
 }); });

// assembly all the elements of the catalog in catalog page 
  $(document).ready(function(){
          group_trap();
          $('.module_select').click( function(){
                      group_trap();
              });
          });

    function group_trap(){
          var sel_cat = $.trim($( ".module_select" ).val() ) ;
          var table = document.getElementsByClassName("orr_t");
          var ref , eq ; 
          eq = 0 ;
          for(var i = 0 ; i < table.length ; i++){    
              $(table[i]).fadeOut("10");
              ref = $(table[i]).attr("id");
              eq = ref.indexOf(sel_cat);
                  if(eq >= 0){
                      $(table[i]).fadeToggle("10");
                  }
         
          }

    }

    $(document).ready(function(){
      setTimeout(function(){
                  $('[class^=main_info]').fadeIn();
              }, 500);
    });

    $(document).ready(function(){
                $('[class^=main_info]').click( function(){
                               var index =  $(this).attr("CLASS");
                               index = index.substring(10);
                               $('.contein_info_'+index).fadeToggle("10");
                      }); 
                    
                });

// find dimension of all label and redimension all labal to max value found in assign catalog 
   

	})(jQuery);




   
