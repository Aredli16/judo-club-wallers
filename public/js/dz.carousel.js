/* JavaScript Document */
jQuery(document).ready(function() {
    'use strict';

	/* testimonial */
	jQuery('.testimonial-bx-1').owlCarousel({
		loop:true,
		margin:60,
		nav:false,
		dots: false,
		navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
		responsive:{
			0:{
				items:1
			},
			480:{
				items:1
			},			
			1024:{
				items:2
			},
			1200:{
				items:2
			}
		}
	})
	/* blog curser */
	jQuery('.card-carousel').owlCarousel({
		loop:true,
		margin:30,
		nav:false,
		dots: false,
		navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
		responsive:{
			0:{
				items:1
			},
			480:{
				items:2
			},			
			1024:{
				items:3
			},
			1200:{
				items:3
			}
		}
	})
	/* blog curser */
	jQuery('.client-logo-carousel').owlCarousel({
		loop:true,
		margin:30,
		nav:false,
		dots: false,
		navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
		responsive:{
			0:{
				items:1
			},
			480:{
				items:2
			},			
			1024:{
				items:4
			},
			1200:{
				items:5
			}
		}
	})
	
	/* blog curser */
	jQuery('.carousel-gallery').owlCarousel({
		loop:true,
		margin:0,
		nav:false,
		dots: false,
		navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
		responsive:{
			0:{
				items:4
			},
			480:{
				items:5
			},			
			1024:{
				items:7
			},
			1200:{
				items:10
			}
		}
	})
	
});
/* Document .ready END */