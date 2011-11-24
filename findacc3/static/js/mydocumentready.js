$(document).ready(function(){
	//font replace
	Cufon.replace('h3', { fontFamily: 'dinMedium' });
	Cufon.replace('h2', { fontFamily: 'dinMedium' });
	Cufon.replace('span.replace', { fontFamily: 'dinMedium' });
	Cufon.replace('span.replaceReg', { fontFamily: 'dinRegular' });
	Cufon.replace('div.replace', { fontFamily: 'dinMedium' });
	
	//multiselect dropdown
	/*$("#community").dropdownchecklist({ maxDropHeight: 150 });*/
	
	//fields default values
/*	$(".defaultText").focus(function(srcc)
    {
        if ($(this).val() == $(this)[0].title)
        {
            $(this).css({"color":"#666666","font-size":"14px"});
            $(this).val("");
        }
    });
    $(".defaultText").blur(function()
    {
        if ($(this).val() == "")
        {
            $(this).css({"color":"#a1a1a1","font-size":"12px"});
            $(this).val($(this)[0].title);
        }
    });
    $(".defaultText").blur();  */
	//top bar field default values
	$(".topBarField").focus(function(srcc)
    {
        if ($(this).val() == $(this)[0].title)
        {
            $(this).css({"color":"#575757","font-size":"12px"});
            $(this).val("");
        }
    });
    $(".topBarField").blur(function()
    {
        if ($(this).val() == "")
        {
            $(this).css({"color":"#a1a1a1","font-size":"12px"});
            $(this).val($(this)[0].title);
        }
    });
    $(".topBarField").blur();  
	//banner field default values
	$(".banBarField").focus(function(srcc)
    {
        if ($(this).val() == $(this)[0].title)
        {
            $(this).css({"color":"#575757","font-size":"14px"});
            $(this).val("");
        }
    });
    $(".banBarField").blur(function()
    {
        if ($(this).val() == "")
        {
            $(this).css({"color":"#a1a1a1","font-size":"14px"});
            $(this).val($(this)[0].title);
        }
    });
    $(".banBarField").blur();  
	
	
	// datepicker
	$("#availability").datepicker();
    
	//error message operations
	/*$('.success_notify').delay(20000).fadeOut("slow");*/
		
	//greybox initialisation
	  $("body").delegate("a.greybox", "click", function(){
		  var t = this.title || $(this).text() || this.href;
		  var w = parseInt($(this).attr("widt")) || 400;
		  var h = parseInt($(this).attr("heigh")) || 400;
		  GB_show(t,this.href,h,w);
		  return false;
	  });	
	  
	  //for filters accordion
		$('.accHead').click(function(e){
		e.preventDefault();
			if(!$(this).siblings('div.accContent').is(':visible')){
				$('div.accContent:visible').slideUp("fast");
				$('.accHead').removeAttr('style').removeClass('filNewBg');
				var customStyle = 'text-decoration:underline;';
				$(this).attr("style", customStyle).addClass('filNewBg');
				$(this).siblings('div.accContent').slideDown("fast");
			}
			else{
				$(this).siblings('div.accContent').slideUp("fast");
				$(this).removeAttr('style').removeClass('filNewBg');
			}
		});
	
	



	//mega hover menu
	function megaHoverOver(){
		$(this).find(".sub").stop().fadeTo('fast', 1).show(); //Find sub and fade it in 
	}
	//On Hover Out
	function megaHoverOut(){
	  $(this).find(".sub").stop().fadeTo('fast', 0, function() { //Fade to 0 opactiy
		  $(this).hide();  //after fading, hide it
	  });
	}
	//Set custom configurations
	var config = {
		 sensitivity: 2, // number = sensitivity threshold (must be 1 or higher)
		 interval: 0, // number = milliseconds for onMouseOver polling interval
		 over: megaHoverOver, // function = onMouseOver callback (REQUIRED)
		 timeout: 0, // number = milliseconds delay before onMouseOut
		 out: megaHoverOut // function = onMouseOut callback (REQUIRED)
	};
	
	$("ul#topnav li .sub").css({'opacity':'0'}); //Fade sub nav to 0 opacity on default
	$("ul#topnav li").hoverIntent(config); //Trigger Hover intent with custom configurations
	
});

