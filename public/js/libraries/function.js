(function ($) {
    "use strict";
	
	var $window = $(window); 
	var $body = $('body'); 
	
	/* Preloader Effect */
	$window.on( "load", function() {
		$(".preloader").fadeOut(600);
    });
	
	/* Sticky header */
	$window.scroll(function(){
    	if ($window.scrollTop() > 200) {
			$('.navbar').addClass('sticky-header');
		} else {
			$('.navbar').removeClass('sticky-header');
		}
	});
	
	
	/* slick nav */
	$('#main-menu').slicknav({prependTo:'#responsive-menu',label:'', closeOnClick:true});
		
	/* Top Menu */
	$(document).on('click','.navbar-nav li a, #responsive-menu ul li a',function(){
		
		if($(this).hasClass("has-popup")) return false;
		var id = $(this).attr('href');
		if($(id).length) {
			var h = parseFloat($(id).offset().top);
			$('body,html').stop().animate({
				scrollTop: h - 70
			}, 800);
			return false;
		}
		
	});
	
	/* Scroll to anchor when calling URL */
	$(document).ready(function() {
		var elem = window.location.hash.replace('#', '');
		if($('#'+elem).length) {
			 var h = parseFloat($('#'+elem).offset().top);
			$('body,html').stop().animate({
				scrollTop: h - 70
			}, 800);
		}
	});
	
	/* Add active class to tab panel */
	var $card = $(".card"); 
	if($card.length){
		$card.on("show.bs.collapse hide.bs.collapse", function(e) {
			
			if (e.type=='show'){
			  $(this).addClass('active');
			}else{
			  $(this).removeClass('active');
			}
		 });  
	}
	 
	/* Pop up page*/
	var $haspopup = $(".has-popup"); 
	if($haspopup.length){
		$haspopup.magnificPopup({
			type: 'inline',
			fixedContentPos: true,
			fixedBgPos: true,
			overflowY: 'auto',
			closeBtnInside: true,
			removalDelay: 300,
			mainClass: 'mfp-zoom-in',
			callbacks: {
				open: function() {
					$('html').css('margin-right', 0);
					$('html').css('overflow', 'auto');
				}
			}
		});
	}
	
	/* Testimonial slider */
	var testimonial_slider = new Swiper('.testimonial-slider',{
		slidesPerView: 4,
		spaceBetween: 40,
		navigation: {
			nextEl: '.testimonial-next',
			prevEl: '.testimonial-prev',
		},
		breakpoints: {
			991: {
				slidesPerView: 2,
				spaceBetween: 30,
			},
			575: {
				slidesPerView: 1,
				spaceBetween: 20
			}
		}
    });
	
	/* Screenshot slider */
	var screenshot_slider = new Swiper('.screenshot-slider',{
		slidesPerView: 4,
		navigation: {
			nextEl: '.screenshot-next',
			prevEl: '.screenshot-prev',
		},
		breakpoints: {
			991: {
				slidesPerView: 3,
				spaceBetween: 30,
			},
			
			767: {
				slidesPerView: 2,
				spaceBetween: 30
			},
			
			480: {
				slidesPerView: 1,
				spaceBetween: 0
			}
		}
    });
	
	/* version slider */
	var timeline_slider = new Swiper('.history-version-slider', {
		speed: 400,
		slidesPerView: 1,
		navigation: {
			nextEl: '.version-next',
			prevEl: '.version-prev',
		},
		on:{
			init: function () {
				var $CompanyTimelineSlide = $( '.history-version-slider .version-slide' );
				if($CompanyTimelineSlide.length) {
					var $timeline_heading = '';
					$CompanyTimelineSlide.each(function(i){
						var $version = $(this).attr('data-version');
						var $date = $(this).attr('data-date');
						$timeline_heading += '<div class="history-item" id="history_item_'+i+'" data-index="'+i+'"><span class="version">'+$version+'</span><span class="date">'+$date+'</span></div>';
					});
					$('.version-history').html($timeline_heading);
					$('.version-history #history_item_0').addClass('active-version');
				}
			},
		},
	});
	
	$(document).on('click','.version-history .history-item',function(){ 
		timeline_slider.slideTo($(this).attr('data-index'));
		$('.version-history .history-item').removeClass('active-version');
		$($(this)).addClass('active-version');
	});
	
	timeline_slider.on('slideChangeTransitionEnd', function (i) {
		$('.version-history .history-item').removeClass('active-version');
		$('.version-history #history_item_'+timeline_slider.activeIndex).addClass('active-version');
	});

	
	/* Popup video */
	var	$popupvideo = $('.popup-video');
	if($popupvideo.length){
		$popupvideo.magnificPopup({
			type: 'iframe',
			preloader: true,
		});
	}
	
	/* Contact form validation */
	var $contactform = $("#contactForm");
	$contactform.validator({focus: false}).on("submit", function (event) {
		if (!event.isDefaultPrevented()) {
			event.preventDefault();
			submitForm();
		}
	});

	function submitForm(){
		$.ajax({
			type: "POST",
			url: "form-process.php",
			data: $("#contactForm").serialize(),
			success : function(text){
				if (text == "success"){
					formSuccess();
				} else {
					submitMSG(false,text);
				}
			}
		});
	}

	function formSuccess(){
		$contactform[0].reset();
		submitMSG(true, "Message Sent Successfully!")
	}

	function submitMSG(valid, msg){
		if(valid){
			var msgClasses = "h3 text-left text-success";
		} else {
			var msgClasses = "h3 text-left text-danger";
		}
		$("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
	}
	/* Contact form validation end */
	
	/* Animate with wow js */
    new WOW({mobile:false}).init(); 
	
	fakewaffle.responsiveTabs([ 'md' ]);
	
})(jQuery);