
/* -----------------------
 * Progress bars Animation
* --------------------- */

$(document).ready(function () {
	var $progress_bar = $('.skills-item');

	$progress_bar.each(function () {
		$progress_bar.appear({force_process: true});
		$progress_bar.on('appear', function () {
			var current_bar = $(this);
			if (!current_bar.data('inited')) {
				current_bar.find('.skills-item-meter-active').fadeTo(300, 1).addClass('skills-animate');
				current_bar.data('inited', true);
			}
		});
	});
});
/* -----------------------
 * Fixed Header
 * --------------------- */


$(document).ready(function () {
	var $header = $('#header--standard');

	if ($header.length) {
		$header.headroom(
			{
				"offset": 210,
				"tolerance": 5,
				"classes": {
					"initial": "animated",
					"pinned": "slideDown",
					"unpinned": "slideUp"
				}
			}
		);
	}
});

//Global var to avoid any conflicts
var CRUMINA = {};

(function ($) {

	// USE STRICT
	"use strict";

	//----------------------------------------------------/
	// Predefined Variables
	//----------------------------------------------------/
	var $window = $(window),
		$document = $(document),
		$body = $('body'),
        $sidebar = $('.fixed-sidebar');

	//Scroll to top.
        jQuery('.back-to-top').on('click', function () {
            $('html,body').animate({
                scrollTop: 0
            }, 1200);
            return false;
        });

	/* -----------------------------
	 Custom input type="number"
	 https://bootsnipp.com/snippets/featured/bootstrap-number-spinner-on-click-hold
	 * ---------------------------*/

	$(function () {
		var action;
		$(document).on("touchstart mousedown",".number-spinner button",function(){
			var btn = $(this);
			var input = btn.closest('.number-spinner').find('input');
			btn.closest('.number-spinner').find('button').prop("disabled", false);

			if (btn.attr('data-dir') == 'up') {
				action = setInterval(function () {
					if (input.attr('max') == undefined || parseInt(input.val()) < parseInt(input.attr('max'))) {
						input.val(parseInt(input.val()) + 1);
					} else {
						btn.prop("disabled", true);
						clearInterval(action);
					}
				}, 50);
			} else {
				action = setInterval(function () {
					if (input.attr('min') == undefined || parseInt(input.val()) > parseInt(input.attr('min'))) {
						input.val(parseInt(input.val()) - 1);
					} else {
						btn.prop("disabled", true);
						clearInterval(action);
					}
				}, 50);
			}
		});
		$(document).on("touchend mouseup",".number-spinner button",function() {
			clearInterval(action);
		});
	});

	/* -----------------------------
	 * Toggle functions
	 * ---------------------------*/

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href"); // activated tab
        if('#events' === target){
            $('.fc-state-active').click();
        }
    });

	// Toggle aside panels
	$(".js-sidebar-open").on('click', function () {
		var mobileWidthApp = $('body').outerWidth();
		if(mobileWidthApp <= 560) {
			$(this).closest('body').find('.popup-chat-responsive').removeClass('open-chat');
		}

        $(this).toggleClass('active');
        $(this).closest($sidebar).toggleClass('open');
        return false;
    });

	// Close on "Esc" click
    $window.keydown(function (eventObject) {
        if (eventObject.which == 27 && $sidebar.is(':visible')) {
            $sidebar.removeClass('open');
        }
    });

    // Close on click outside elements.
    $document.on('click', function (event) {
        if (!$(event.target).closest($sidebar).length && $sidebar.is(':visible')) {
            $sidebar.removeClass('open');
        }
    });

    // Toggle inline popups

    var $popup = $('.window-popup');

    $(".js-open-popup").on('click', function (event) {
        var target_popup = $(this).data('popup-target');
        var current_popup = $popup.filter(target_popup);
        var offset = $(this).offset();
        current_popup.addClass('open');
        current_popup.css('top', (offset.top - (current_popup.innerHeight() / 2)));
        $body.addClass('overlay-enable');
        return false;
    });

    // Close on "Esc" click
    $window.keydown(function (eventObject) {
        if (eventObject.which == 27) {
            $popup.removeClass('open');
            $body.removeClass('overlay-enable');
			$('.profile-menu').removeClass('expanded-menu');
			$('.popup-chat-responsive').removeClass('open-chat');
			$('.profile-settings-responsive').removeClass('open');
			$('.header-menu').removeClass('open');
        }
    });

    // Close on click outside elements.
    $document.on('click', function (event) {
        if (!$(event.target).closest($popup).length) {
            $popup.removeClass('open');
            $body.removeClass('overlay-enable');
			$('.profile-menu').removeClass('expanded-menu');
			$('.header-menu').removeClass('open');
        }
    });

    // Close active tab on second click.
    $('[data-toggle=tab]').on('click', function(){
		/*$body.toggleClass('body--fixed');*/
        if ($(this).hasClass('active') && $(this).closest('ul').hasClass('mobile-app-tabs')){
            $($(this).attr("href")).toggleClass('active');
            $(this).removeClass('active');
            return false;
        }
    });


    // Close on "X" click
    $(".js-close-popup").on('click', function () {
        $(this).closest($popup).removeClass('open');
        $body.removeClass('overlay-enable');
        return false
    });

	$(".profile-settings-open").on('click', function () {
		$('.profile-settings-responsive').toggleClass('open');
		return false
	});

	$(".js-expanded-menu").on('click', function () {
		$('.header-menu').toggleClass('expanded-menu');
		return false
	});

	$(".js-chat-open").on('click', function () {
		$('.popup-chat-responsive').toggleClass('open-chat');
		return false
	});
    $(".js-chat-close").on('click', function () {
        $('.popup-chat-responsive').removeClass('open-chat');
        return false
    });

	$(".js-open-responsive-menu").on('click', function () {
		$('.header-menu').toggleClass('open');
		return false
	});

	$(".js-close-responsive-menu").on('click', function () {
		$('.header-menu').removeClass('open');
		return false
	});


	/* -----------------------------
		 * Scrollmagic scenes animation
	* ---------------------------*/

	CRUMINA.CallToActionAnimation = function () {
		var controller = new ScrollMagic.Controller();

		new ScrollMagic.Scene({triggerElement: ".call-to-action-animation"})
			.setVelocity(".first-img", {opacity: 1, bottom: "0", scale: "1"}, 1200)
			.triggerHook(1)
			.addTo(controller);

		new ScrollMagic.Scene({triggerElement: ".call-to-action-animation"})
			.setVelocity(".second-img", {opacity: 1, bottom: "50%", right: "40%"}, 1500)
			.triggerHook(1)
			.addTo(controller);
	};

	CRUMINA.ImgScaleAnimation = function () {
		var controller = new ScrollMagic.Controller();

		new ScrollMagic.Scene({triggerElement: ".img-scale-animation"})
			.setVelocity(".main-img", {opacity: 1, scale: "1"}, 200)
			.triggerHook(0.3)
			.addTo(controller);

		new ScrollMagic.Scene({triggerElement: ".img-scale-animation"})
			.setVelocity(".first-img1", {opacity: 1, scale: "1"}, 1200)
			.triggerHook(0.8)
			.addTo(controller);

		new ScrollMagic.Scene({triggerElement: ".img-scale-animation"})
			.setVelocity(".second-img1", {opacity: 1, scale: "1"}, 1200)
			.triggerHook(1.1)
			.addTo(controller);

		new ScrollMagic.Scene({triggerElement: ".img-scale-animation"})
			.setVelocity(".third-img1", {opacity: 1, scale: "1"}, 1200)
			.triggerHook(1.4)
			.addTo(controller);
	};

	CRUMINA.PlanerAnimation = function () {
		var controller = new ScrollMagic.Controller();

		new ScrollMagic.Scene({triggerElement: ".planer-animation"})
			.setVelocity(".planer", {opacity: 1, left: "80%", scale: "1"}, 2000)
			.triggerHook(0.1)
			.addTo(controller);

	};

	/* -----------------------------
	 * On DOM ready functions
	 * ---------------------------*/

	$document.ready(function () {


		// Row background animation
		if ($('.call-to-action-animation').length) {
			CRUMINA.CallToActionAnimation();
		}

		if ($('.img-scale-animation').length) {
            CRUMINA.ImgScaleAnimation()
        }

        // Run scripts only if they included on page.

        if (typeof $.fn.gifplayer !== 'undefined'){
            $('.gif-play-image').gifplayer();
        }
        if (typeof $.fn.mediaelementplayer !== 'undefined'){
            $('#mediaplayer').mediaelementplayer({
                "features": ['prevtrack', 'playpause', 'nexttrack', 'loop', 'shuffle', 'current', 'progress', 'duration', 'volume']
            });
        }

        $('.mCustomScrollbar').perfectScrollbar({wheelPropagation:false});

	});
})(jQuery);
/* -----------------------------
     * Material design js effects
     * Script file: material.min.js
     * Documentation about used plugin:
     * http://demos.creative-tim.com/material-kit/components-documentation.html
     * ---------------------------*/


CRUMINA.Materialize = function () {
	$.material.init();

	$('.checkbox > label').on('click', function () {
		$(this).closest('.checkbox').addClass('clicked');
	})
};

$(document).ready(function () {
	CRUMINA.Materialize();
});


/* -----------------------------
     * Forms validation added Errors Messages
* ---------------------------*/

CRUMINA.FormValidation = function () {
	$('.needs-validation').each(function () {
		var form = $(this)[0];
		form.addEventListener("submit", function (event) {
			if (form.checkValidity() == false) {
				event.preventDefault();
				event.stopPropagation();
			}
			form.classList.add("was-validated");
		}, false);
	});
};

$(document).ready(function () {
	CRUMINA.FormValidation();
});
/* -----------------------------
     * Bootstrap components init
     * Script file: theme-plugins.js, tether.min.js
     * Documentation about used plugin:
     * https://v4-alpha.getbootstrap.com/getting-started/introduction/
     * ---------------------------*/


CRUMINA.Bootstrap = function () {
	//  Activate the Tooltips
	$('[data-toggle="tooltip"], [rel="tooltip"]').tooltip();

	// And Popovers
	$('[data-toggle="popover"]').popover();

	/* -----------------------------
	   * Replace select tags with bootstrap dropdowns
	   * Script file: theme-plugins.js
	   * Documentation about used plugin:
	   * https://silviomoreto.github.io/bootstrap-select/
	   * ---------------------------*/
	$('.selectpicker').selectpicker();
};

$(document).ready(function () {
	CRUMINA.Bootstrap();
});

/* -----------------------------
	* Isotope sorting
* ---------------------------*/

CRUMINA.IsotopeSort = function () {
	var $containerSort = $('.sorting-container');
	$containerSort.each(function () {
		var $current = $(this);
		var layout = ($current.data('layout').length) ? $current.data('layout') : 'masonry';
		$current.isotope({
			itemSelector: '.sorting-item',
			layoutMode: layout,
			percentPosition: true
		});

		$current.imagesLoaded().progress(function () {
			$current.isotope('layout');
		});

		var $sorting_buttons = $current.siblings('.sorting-menu').find('li');

		$sorting_buttons.on('click', function () {
			if ($(this).hasClass('active')) return false;
			$(this).parent().find('.active').removeClass('active');
			$(this).addClass('active');
			var filterValue = $(this).data('filter');
			if (typeof filterValue != "undefined") {
				$current.isotope({filter: filterValue});
				return false;
			}
		});
	});
};

$(document).ready(function () {
	CRUMINA.IsotopeSort();
});

CRUMINA.StickySidebar = function () {
	var $header = $('#site-header');

	$('.crumina-sticky-sidebar').each(function () {

	var sidebar = new StickySidebar (this, {
		topSpacing: $header.height(),
		bottomSpacing: 0,
		containerSelector: false,
		innerWrapperSelector: '.sidebar__inner',
		resizeSensor: true,
		stickyClass: 'is-affixed',
		minWidth: 0
		})
	});
};

$(document).ready(function () {
	CRUMINA.StickySidebar();
});
