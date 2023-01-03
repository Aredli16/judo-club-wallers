/**
Core script to handle the entire theme and core functions
**/

var Karate = function(){
	
	var screenWidth = jQuery( window ).width();
	var topSearch = function(){
		'use strict';
		$('.search-icon').on('click', function(){
			$('.full-search-bar').css('display','table').show();
		});
		
		$('.search-close').on('click',function(){
			$('.full-search-bar').hide();
		});
	}
	
	var handelShuffle = function(){
		'use strict';
		if($('.w3-shuffle').length)
		{
			var Shuffle = window.Shuffle;
			var w3Shuffle = new Shuffle(document.querySelector('.w3-shuffle'), {
				  itemSelector: '.image-item',
				  sizer: '.my-sizer-element',
				  buffer: 1,
			});
			window.jQuery('input[name="shuffle-filter"]').on('change', function (evt) {
				  var input = evt.currentTarget;
				  if (input.checked) {
					w3Shuffle.filter(input.value);
				  }
			});	
		}
	}
	
	var handelMagnificPopup = function(){
		'use strict';
		if($('.gallery').length)
		{
			$('.gallery').magnificPopup({
				delegate: '.mfp-box',
				type: 'image',
				closeOnContentClick: false,
				closeBtnInside: false,
				mainClass: 'mfp-with-zoom mfp-img-mobile',
				image: {
					verticalFit: true,
					titleSrc: function(item) {
						return item.el.attr('title') + ' &middot; <a class="image-source-link" href="'+item.el.attr('data-source')+'" target="_blank"></a>';
					}
				},
				gallery: {
					enabled: true
				},
				zoom: {
					enabled: true,
					duration: 300, // don't foget to change the duration also in CSS
					opener: function(element) {
						return element.find('img');
					}
				}
			});

		}	
	
		if($('.popup-youtube, .popup-vimeo, .popup-gmaps').length)
		{
			$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
				disableOn: 700,
				type: 'iframe',
				mainClass: 'mfp-fade',
				removalDelay: 160,
				preloader: false,

				fixedContentPos: false
			});	
		}
	}
	
	
	var navbar = document.getElementById("navbar");
	var sticky = navbar.offsetTop;
	var handelStickyHeader = function(){
		if (window.pageYOffset >= sticky) {
			navbar.classList.add("sticky");
			
		} else {
			navbar.classList.remove("sticky");
		}
	}	
	
	var handelResizeElement = function(){
		var HeaderHeight = $('.header').height();
		$('.header').css('height', HeaderHeight);
	}
	
	
	
	/* Load File ============ */
	var dzTheme = function(){
		 'use strict';
		 var loadingImage = '<img src="images/loading.gif">';
		 jQuery('.dzload').each(function(){
		 var dzsrc =   siteUrl + $(this).attr('dzsrc');
		  //jQuery(this).html(loadingImage);
		 	jQuery(this).hide(function(){
				jQuery(this).load(dzsrc, function(){
					jQuery(this).fadeIn('slow');
				}); 
			})
			
		 });
		
		 if(screenWidth < 991)
		{
			if($('.mo-left .navbar-item').children('div').length == 0){
				var logoData = jQuery('<div>').append($('.mo-left .header-logo').clone()).html();
				jQuery('.mo-left .navbar-item').prepend(logoData);
				jQuery('.mo-left .navbar-item .header-logo > a > img').attr('src','images/logo-black.png');
				jQuery('.mo-left.lw .navbar-item .header-logo > a > img').attr('src','images/logo-white.png');
			}
		}else{
			jQuery('.mo-left .navbar-item div').remove();
			jQuery('.mo-left.lw .navbar-item div').remove();
		}
				
		if(screenWidth <= 991 ){
			jQuery('.navbar-nav > li > a, .dropdown-menu > li > a').unbind().on('click', function(e){
				
				if(jQuery(this).parent().hasClass('open'))
				{
					jQuery(this).parent().removeClass('open');
				}
				else{
					jQuery(this).parent().parent().find('li').removeClass('open');
					jQuery(this).parent().addClass('open');
				}
			});
		}
	}
	
	var setDivHeight = function(){	
		'use strict';
		var allHeights = [];
		jQuery('.dzseth > div, .dzseth .img-cover').each(function(e){
			allHeights.push(jQuery(this).height());
		})

		jQuery('.dzseth > div, .dzseth .img-cover').each(function(e){
			var maxHeight = Math.max.apply(Math,allHeights);
			jQuery(this).css('height',maxHeight);
		})
		
		allHeights = [];
		/* Removice */
		var screenWidth = $( window ).width();
		if(screenWidth < 767)
		{
			jQuery('.dzseth > div, .dzseth .img-cover').each(function(e){
				jQuery(this).css('height','');
			})
		}
	}
	
	var handelSideBarMenu = function(){
		$('.openbtn').on('click',function(e){
			e.preventDefault();
			if($('#mySidenav').length > 0)
			{
				document.getElementById("mySidenav").style.left = "0";
			}

			if($('#mySidenav1').length > 0)
			{
				document.getElementById("mySidenav1").style.right = "0";
			}
			
		})
		
		$('.closebtn').on('click',function(e){
			e.preventDefault();
			if($('#mySidenav').length > 0)
			{
				document.getElementById("mySidenav").style.left = "-300px";
			}
			
			if($('#mySidenav1').length > 0)
			{
				document.getElementById("mySidenav1").style.right = "-820px";
			}
		})
	}
	
	/* Countdown ============ */
	var handleCountDown = function(WebsiteLaunchDate){
		/* Time Countr Down Js */
		if($(".countdown").length)
		{
			$('.countdown').countdown({date: WebsiteLaunchDate+' 23:5'}, function() {
				$('.countdown').text('we are live');
			});
		}
		/* Time Countr Down Js End */
	}
	
	var handelCounter = function(){
		if(jQuery('.counter').length)
		{
			jQuery('.counter').counterUp({
				delay: 10,
				time: 500
			});
		}
	}
	
	var handelCustomScroll = function(){
		/* all available option parameters with their default values */
		if($(".content-scroll").length)
		{
			$(".content").mCustomScrollbar({
				setWidth:false,
				setHeight:false,
				axis:"y"
			});	
		}
	}
	
	var handelLoadingImage = function(){
		if($('#loadingDiv').length)
		{
			setTimeout(function(){
				$('#loadingDiv').remove();
			}, 0);			
		}
	}
	
	var scrollTop = function (){
		'use strict';
		
		var scrollTop = jQuery(".scrollTop");
		scrollTop.on('click',function() {
			jQuery("html, body").animate({
				scrollTop: 0
			}, 1000);
			return false;
		})

		jQuery(window).bind("scroll", function() {
			var scroll = jQuery(window).scrollTop();
			if (scroll > 900) {
				jQuery(".scrollTop").fadeIn(1000);
			} else {
				jQuery(".scrollTop").fadeOut(1000);
			}
		});
		
	}
	
	var equalHeight = function(container) {
	
		var currentTallest = 0, 
			currentRowStart = 0, 
			rowDivs = new Array(), 
			$el, topPosition = 0;
			
		$(container).each(function() {
			$el = $(this);
			$($el).height('auto')
			topPostion = $el.position().top;

			if (currentRowStart != topPostion) {
				for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
					rowDivs[currentDiv].height(currentTallest);
				}
				rowDivs.length = 0; // empty the array
				currentRowStart = topPostion;
				currentTallest = $el.height();
				rowDivs.push($el);
			} else {
				rowDivs.push($el);
				currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
			}
			for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
				rowDivs[currentDiv].height(currentTallest);
			}
		});
	}
	
	/* Website Launch Date */ 
	var WebsiteLaunchDate = new Date();
	monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	WebsiteLaunchDate.setMonth(WebsiteLaunchDate.getMonth() + 1);
	WebsiteLaunchDate =  WebsiteLaunchDate.getDate() + " " + monthNames[WebsiteLaunchDate.getMonth()] + " " + WebsiteLaunchDate.getFullYear(); 
	/* Website Launch Date END */ 
	
	
	return {
		init:function(){
			dzTheme();
			topSearch();
			handelShuffle();
			handelMagnificPopup();
			setDivHeight();
			handelSideBarMenu();
			handelCounter();
			handelCustomScroll();
			scrollTop();
			handelResizeElement();
			handleCountDown(WebsiteLaunchDate);
			
		},
		scroll: function(){
			handelStickyHeader();
		},
		load: function(){
			handelLoadingImage();
			equalHeight('.equal-wraper .equal-col');
		},
		resize: function(){
			screenWidth = jQuery( window ).width();
			handelResizeElement();
			setDivHeight();
			dzTheme();
		}
	}
}();	


jQuery(document).ready(function() {
	'use strict';
	Karate.init();
	
	jQuery('.navbar-toggler').on('click',function(){
		$(this).toggleClass('open');
	});
	
});

window.onscroll = function() {
	'use strict';
	Karate.scroll();

};

jQuery(window).on('load',function(){
	'use strict';
	Karate.load();
});

jQuery(window).on('resize',function(){
	'use strict';
	Karate.resize();
});
