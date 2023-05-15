function respon() {
    var hfoot = parseInt($('.footer-container').outerHeight()),
        hhead = parseInt($('.header-container').outerHeight());
    $('.mm-page').css({ marginBottom: -hfoot });
    $('.main-wrap').css({ paddingBottom: hfoot, paddingTop: hhead});	
}


function zoomDisable(){
    $('head meta[name=viewport]').remove();
    $('head').prepend('<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0" />');
}
function zoomEnable(){
    $('head meta[name=viewport]').remove();
    $('head').prepend('<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1" />');
}


function loadScroll(){
	var thisScroll = $(".xscrollbar");
	thisScroll.each(function(){
		var wThis = parseInt($(this).width());
		$(this).width(wThis);
	});
	thisScroll.mCustomScrollbar({
		axis:"x" 
	});
	var myTimeout;
	$(window).on("resize",function() {
		thisScroll.each(function(){
			$(this).width("100%");
		});
		clearTimeout(myTimeout);
		myTimeout = setTimeout(function(){
			thisScroll.each(function(){
				var seflt = $(this);
				var wThis = parseInt(seflt.width());
				seflt.width(wThis).mCustomScrollbar("update");
			});
		}, 0);
	});
}


$(document).ready(function() {	
	
	setTimeout(function() {
		respon();
	}, 500);
	
	$('.bg').each(function() {
		var imgUrl1 = $(this).find('.bgimg').attr('src');
		$(this).fixbg({ srcimg : imgUrl1});
    });
	
	$("input, textarea, select").on({ 'touchstart' : function() {
        zoomDisable();
    }});
	$("input, textarea, select").on({ 'touchend' : function() {
        setTimeout(zoomEnable, 500);
    }});
	
	
	$(window).scroll(function() {
		var stickyTop = $(this).scrollTop();
		//var hHeader = $(".header-container").outerHeight();
		if (stickyTop > 20) {
			$('.gotop').show();
			$('.header-container').addClass('fixhead');
		} else {
			$('.gotop').hide();
			$('.header-container').removeClass('fixhead');
		}
	});
	
	var dateInput  =  $('.date-wrap input');
	dateInput.datetimepicker({
		format: 'DD/MM/YYYY',
		widgetParent: 'body',
		icons: {
			time: 'far fa-clock',
			date: 'far fa-calendar',
			up: 'fas fa-arrow-up',
			down: 'fas fa-arrow-down',
			previous: 'fas fa-chevron-left',
			next: 'fas fa-chevron-right',
			today: 'fas fa-calendar-check',
			clear: 'far fa-trash-alt',
			close: 'far fa-times-circle'
		}
	});
	dateInput.on('dp.show', function(e){ 
		var selft  = $(e.currentTarget);
		var selftCalandar = $("body > .bootstrap-datetimepicker-widget");
		var offset = selft.offset();
		var offsetLeft = offset.left;
		var hInput = selft.outerHeight() + 5;
		var offsetTop = offset.top + hInput;
		var wWin = $(window).width();
		var hWin = $(window).height();
		var wCanlandar = selftCalandar.outerWidth();
		var hCanlandar = selftCalandar.outerHeight();
		var lbox = wWin - offsetLeft;
		var tbox = hWin - offsetTop;
		if(lbox <  wCanlandar){
			offsetLeft = offsetLeft - wCanlandar + selft.outerWidth();
		}
		selftCalandar.css({"bottom": "auto", "right": "auto", "top": offsetTop, "left": offsetLeft});
	});
	
	var timeInput  =  $('.time-wrap input');
	timeInput.datetimepicker({
		format: 'LT',
		icons: {
			time: 'far fa-clock',
			date: 'far fa-calendar',
			up: 'fas fa-arrow-up',
			down: 'fas fa-arrow-down',
			previous: 'fas fa-chevron-left',
			next: 'fas fa-chevron-right',
			today: 'fas fa-calendar-check',
			clear: 'far fa-trash-alt',
			close: 'far fa-times-circle'
		}
	});
	
	$(".toggle-password").click(function() {
	  $(this).toggleClass("showeye");
	  var input = $($(this).attr("toggle"));
	  if (input.attr("type") == "password") {
		input.attr("type", "text");
	  } else {
		input.attr("type", "password");
	  }
	});
	
	$("#uploadphoto").on('change',function(){
        var input = $(this)[0];
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
	
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	  return new bootstrap.Tooltip(tooltipTriggerEl)
	})
	
});


window.onload = new function() {

    setTimeout(function() {
        $('body').addClass('loaded');
		respon();
		$('.grid-1').each(function () {
			$(this).find('figure').matchHeight();
			$(this).find('h3').matchHeight();
			$(this).find('.descripts').matchHeight();
		});
		$('.grid-3').each(function () {
			$(this).find('figure').matchHeight();
		});
    }, 500);
	
	loadScroll();
	
};

$(window).resize(function() {  
	setTimeout(function() {
		respon();
	}, 500);
});

