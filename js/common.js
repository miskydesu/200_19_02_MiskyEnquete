$(document).ready(function(){
//マウスオーバー時
function megaHoverOver(){
   	 $(this).find(".sub").stop().fadeTo('fast', 1).show(); 
    (function($) {
        jQuery.fn.calcSubWidth = function() {
            rowWidth = 0;
            $(this).find("ul").each(function() { 
                rowWidth  = $(this).width(); 
            });
        };
    })(jQuery); 

    if ( $(this).find(".row").length > 0 ) {

        var biggestRow = 0;	

        $(this).find(".row").each(function() {
            $(this).calcSubWidth();
            //Find biggest row
            if(rowWidth > biggestRow) {
                biggestRow = rowWidth;
            }
        });

        $(this).find(".sub").css({'width' :biggestRow});
        $(this).find(".row:last").css({'margin':'0'});

    } else { 

        $(this).calcSubWidth(); 
        $(this).find(".sub").css({'width' : rowWidth});

    }
}
//On Hover Out
function megaHoverOut(){
  $(this).find(".sub").stop().fadeTo('fast', 0, function() {
      $(this).hide();  //after fading, hide it
  });
}

var config = {
     sensitivity: 2,
     interval: 100,
     over: megaHoverOver,
     timeout: 500, 
     out: megaHoverOut 
};

$("ul#topnav li .sub").css({'opacity':'0'}); 
$("ul#topnav li").hoverIntent(config); 

});