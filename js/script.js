jQuery.fn.exists = function( callback ) {

	var args = [].slice.call( arguments, 1 );
	if ( this.length ) {
		callback.call( this, args );
	}
	return this;

};

( function($) {

	var khmerScript = {

		initAll: function() {
			this.menuShowHide();
			this.slideShow();
			this.searchOpen();
		},

		menuShowHide: function() {

			var $primary_menu = $('#primary-site-navigation');
			var $secondary_menu = $('#secondary-site-navigation');

			var $first_menu = '';
			var $second_menu = '';

			if ( $primary_menu.length == 0 && $secondary_menu.length == 0 ) {

				return;

			} else {

				if ( $primary_menu.length ) {

					$first_menu = $primary_menu;

				}
			}

			var menu_wrapper = $first_menu.clone().appendTo('#smobile-menu');

			if ( $secondary_menu.length ) {

				if ( $('ul.smenu').length ) {
					var $second_menu = $secondary_menu.find('ul.smenu').clone().insertAfter('#smobile-menu .primary-menu .pmenu');
				} else {
					var $second_menu1 = $secondary_menu.find('.smenu > ul').clone().insertAfter('#smobile-menu .primary-menu .pmenu');
				}

			}

			$('.toggle-mobile-menu').click(function(e) {
				e.preventDefault();
				e.stopPropagation();

				if ( ! $('body').hasClass('mobile-menu-active') ) {

					$('#smobile-menu').show().addClass('show');
					$('body').toggleClass('mobile-menu-active');

				} else {
                    $('#smobile-menu').removeClass('show');
                    jQuery('body').removeClass('mobile-menu-active');
                    jQuery('html').removeClass('noscroll');
                    jQuery('#mobile-menu-overlay').fadeOut();
					//khmerScript.callFunctionHideMenu();

				}

			});

			$('<span class="sub-arrow"><i class="fa fa-angle-down"></i></span>').insertAfter( $('.menu-item-has-children > a, .page_item_has_children > a') );

			$('.menu-item-has-children .sub-arrow, .page_item_has_children .sub-arrow').click(function(e) {
				e.preventDefault();
				e.stopPropagation();

				var subMenuOpen = $(this).hasClass('sub-menu-open');

				if ( subMenuOpen ) {

					$(this).removeClass('sub-menu-open');
					$(this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
					$(this).next('ul.children, ul.sub-menu').removeClass('active').slideUp();

				} else {

					$(this).addClass('sub-menu-open');
					$(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
					$(this).next('ul.children, ul.sub-menu').addClass('active').slideDown();

				}

			});

			if( $('#wpadminbar').length ) {
				$('#smobile-menu').addClass('wpadminbar-active');
			}

		},

		searchOpen: function() {

			$('.btn-search').on('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				$('.search-style-one').addClass('open');
				$('.overlay').find('input').focus();
			});

			$('.overlay-close').on('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				$('.search-style-one').removeClass('open');
			});

			$(document).on('click', function(e) {
				$('.search-style-one').removeClass('open');
			});

			$('.search-style-one').click(function(e) {
				e.preventDefault();
				e.stopPropagation();
			});

		},

		slideShow: function() {

			if( $('.flexslider').length ) {

				$('.flexslider').flexslider({
					animation: "slide",
					minItems: 2,
					maxItems: 4,
					prevText: '',
					nextText: '',
					start: function(){
						$('#homepage-slide, .flex-direction-nav').show();
						$('.flexslider').css('margin-bottom', '30px');
					},
				});

			}

		},

		callFunctionHideMenu: function() {

			//$('#smobile-menu').removeClass('show');
			//jQuery('body').removeClass('mobile-menu-active');
			//jQuery('html').removeClass('noscroll');
			//jQuery('#mobile-menu-overlay').fadeOut();

		}

	};


	$( document ).ready(function(e) {

		khmerScript.initAll();

	}).on('click', function( event ) {

		khmerScript.callFunctionHideMenu();

	});

})(jQuery);

jQuery(document).scroll(function () {
	s_top = $(window).scrollTop();
	if(s_top > 5){
		$('.header-bg').attr("id","sticky-header");
        $('.navbar').attr("id","sticky-header-2");
        /*$('.yandex-cotext').removeAttr("style");
        $('.yandex-cotext').attr("style","display:none;");*/
        //$('#content').attr("style","margin-top:140px");
	}else{
		$('.header-bg').removeAttr("id");
        $('.navbar').removeAttr("id");
        /*$('.yandex-cotext').removeAttr("style");
        $('.yandex-cotext').attr("style","height:auto;max-height:300px;margin: 0 auto;");*/
        //$('#content').removeAttr("style");
	}
});

/**
 * строка поиска десктопная версия
 */
jQuery(".b-navbar-search-btn").click(function(){
	if(jQuery(".b-navbar-search").hasClass("active")){
        jQuery(".b-navbar-search.active .b-navbar-search-area").removeAttr("style");
        jQuery(".b-navbar-search").removeClass("active");
    }else{
		var widthMenu = jQuery(".navbar .navbar-main").width() - 30;
        jQuery(".b-navbar-search-area").attr("style","width:"+ widthMenu+"px;")
        jQuery(".b-navbar-search").addClass("active");
	}

});
jQuery(".b-navbar-search-area input[type=\"submit\"]").click(function(){
	jQuery("#search").addClass("active");

});


/**
 * Поделиться в соцсетях десктопная версия
 */
jQuery(".social-button").click(function(){
	if(jQuery(".b-navbar-search").hasClass("active")){
		jQuery(".b-navbar-search.active .b-navbar-search-area").removeAttr("style");
		jQuery(".b-navbar-search").removeClass("active");
	}else{
		var widthMenu = jQuery(".navbar .navbar-main").width() - 30;
		jQuery(".b-navbar-search-area").attr("style","width:"+ widthMenu+"px;")
		jQuery(".b-navbar-search").addClass("active");
	}

});
jQuery(".b-navbar-search-area input[type=\"submit\"]").click(function(){
	jQuery("#search").addClass("active");

});




