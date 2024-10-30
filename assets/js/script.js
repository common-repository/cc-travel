(function($, window, document) {
    "use strict";

	var CCT;

	CCT = window.CCT || {};

	CCT.General = function () {
		$('<div/>', {
			class: 'cct-load'
		}).appendTo('body');

		$('.cct-load').append('<span></span>');

        $(document).on('click.bs.tab.data-api', '.bs-tab-nav a', function (e) {
            e.preventDefault();
            $(this).tab('show');
            CCT.Isotope();
        });

        $('.cct-fancybox').fancybox();
        $('.cct-slick').slick();

        $('.cc-datepicker').datepicker();
    };

	CCT.Isotope = function (el) {
        var $container = $('.cct-masonry');

        if ($('.cct-masonry').length) {
            if (el) {
                var $c = el;
            } else {
                var $c = $container.data('column');
            }

            $c = parseInt($c);

            var $class;

            if ($c !== 5) {
                $class = '.col-md-' + (12 / $c);
            } else {
                $class = '.cols-md-5';
            }
            $container.imagesLoaded(function () {
                $container.isotope({
                    itemSelector: '.cct-column',
                    masonry: {
                        columnWidth: $class
                    }
                });
            });
        }
    };

	CCT.GetUrlParameter = function (url, sParam) {
        var sPageURL, sParameterName, i;

        if (url !== '') {
            sPageURL = url;
        } else {
            sPageURL = window.location.search.substring(1);
        }

        var sURLPrams 	= sPageURL.split('?'),
        	sURLVariables = sURLPrams[1].split('&');

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    };

	CCT.ToursAjax = function ($ajax_url) {
		var $loading = $('.cct-load');

		$.ajax({
            type: 'POST',
            url: $ajax_url,
            contentType: 'html',
            beforeSend: function () {
                $loading.addClass('loading');
            },
            success: function (response) {
                $loading.removeClass('loading');
                history.pushState(null, null, $ajax_url);

                $('.cct-inner-content').html($(response).find('.cct-inner-content').html());

                $('.cc-travel-widget-filter-by-taxonomy').each(function () {
                    var $this = $(this);

                    $this.html($(response).find('#' + $this.attr('id')).html());
                });

                //CCT.FilterByTaxonomy();
            }
        });
	};

	CCT.FilterByPrice = function() {
		$('.cctw-price').jRange({
			from: parseInt(cc_travel_script.min_price),
			to: parseInt(cc_travel_script.max_price),
			step: 1,
			format: '%s ' + cc_travel_script.price_label,
			showScale: true,
			showLabels: true,
			isRange : true,
			ondragend: function (value) {
				var $current_url = window.location.href, $ajax_url;

				var $price_arr 	= value.split(','),
					$min_price	= $price_arr[0],
					$max_price	= $price_arr[1];

				if ($current_url.indexOf('?') > 0) {
					var $url_params_min_price = CCT.GetUrlParameter($current_url, 'min_price'),
						$url_params_max_price = CCT.GetUrlParameter($current_url, 'max_price');

					if ($current_url.indexOf('min_price') > 0) {
						$ajax_url = $current_url.replace('min_price=' + $url_params_min_price, 'min_price=' + $min_price);
						$ajax_url = $ajax_url.replace('max_price=' + $url_params_max_price, 'max_price=' + $max_price);
					} else {
						$ajax_url = $current_url + '&min_price=' + $min_price + '&max_price=' + $max_price;
					}
				} else {
					$ajax_url = $current_url + '?min_price=' + $min_price + '&max_price=' + $max_price;
				}

				CCT.ToursAjax($ajax_url);
			},
			onbarclicked: function() {

			}
		});
	};

	CCT.FilterByDuration = function() {
		$('.cctw-duration').jRange({
			from: parseInt(cc_travel_script.min_duration),
			to: parseInt(cc_travel_script.max_duration),
			step: 1,
			format: '%s ' + cc_travel_script.duration_label,
			showScale: true,
			showLabels: true,
			isRange : true,
			ondragend: function (value) {
				var $current_url = window.location.href, $ajax_url;

				if ($current_url.indexOf('?') > 0) {
					var $url_params_duration = CCT.GetUrlParameter($current_url, 'duration');

					if ($current_url.indexOf('duration') > 0) {
						$ajax_url = $current_url.replace('duration=' + $url_params_duration, 'duration=' + value);
					} else {
						$ajax_url = $current_url + '&duration=' + value;
					}
				} else {
					$ajax_url = $current_url + '?duration=' + value;
				}

				CCT.ToursAjax($ajax_url);
			},
			onbarclicked: function() {

			}
		});
	};

	CCT.FiterByDepartureDate = function() {
		$('.cct-datepicker').datepicker({
			dateFormat: 'yy-mm-dd',
			onSelect: function(dateText, inst) {
				var $this 	= $(this),
					$val	= $this.val(),
					$name	= $this.data('name');

				var $current_url = window.location.href, $ajax_url;

				if ($current_url.indexOf('?') > 0) {
					var $url_params_duration = CCT.GetUrlParameter($current_url, $name);

					if ($current_url.indexOf($name) > 0) {
						$ajax_url = $current_url.replace($name + '=' + $url_params_duration, $name + '=' + $val);
					} else {
						$ajax_url = $current_url + '&' + $name + '=' + $val;
					}
				} else {
					$ajax_url = $current_url + '?' + $name + '=' + $val;
				}

				CCT.ToursAjax($ajax_url);
			}
		});
	};

	CCT.FilterByTaxonomy = function() {
		$('.cct-filer-by-taxonomy').find('.filter-item').each(function() {
			$(this).on('click', function (el) {
				el.preventDefault();

				var $ajax_url = $(this).attr('href');

				CCT.ToursAjax($ajax_url);
			});
		});
	};

	CCT.SubmitFormBooking = function() {
		var $loading = $('.cct-load');

		$('.cct-booking-form').validate({
			rules: {
				name: "required",
				phone: "required",
				message: "required",
				email: {
					required: true,
					email: true
				},

			}
		});

		$('.cct-booking-submit').on('click', function (el) {
			var $this = $(this),
				$form = $this.parents('.cct-booking-form');

			var data = {
				'action': 'cc_travel_ajax_booking'
			};

			if ($form.valid()) {
				$.ajax({
					type: 'POST',
					url: cc_travel_script.ajax_url + '?' + $form.serialize(),
					data: data,
					dataType: 'json',
					beforeSend: function () {
						$loading.addClass('loading');
					},
					success: function (response) {
						$loading.removeClass('loading');

						$('.cct-booking .container').html(response);
					}
				});
			}
		});
	};

	CCT.BookingChangePerson = function() {
		var $loading = $('.cct-load');

		$('.cct-booking-form .change-person').on('change', function (el) {
			var $this = $(this),
				$person = $this.val(),
				$n_price	= $this.data('n-price'),
				$s_price	= $this.data('s-price');

			var data = {
				'action': 'cc_travel_ajax_general_price',
				'n_price': $n_price,
				's_price': $s_price,
				'person': $person,
			};

			$.ajax({
				type: 'POST',
				url: cc_travel_script.ajax_url,
				data: data,
				dataType: 'json',
				beforeSend: function () {
					$loading.addClass('loading');
				},
				success: function (response) {
					$loading.removeClass('loading');

					$('.cct-booking-form .total span').html(response);
				}
			});


		});
	};

	CCT.Accordion = function () {
        $('.cct-accordion .item-desc.show').show();
        $('.cct-accordion .item-title').click(function (e) {
            e.preventDefault();
            var $this = $(this);

            if ($this.next().hasClass('show')) {
                $this.next().removeClass('show');
                $this.removeClass('on');
                $this.next().slideUp(350);
            } else {
                $this.parents('.cct-accordion').find('.item-desc').removeClass('show');
                $this.removeClass('on');
                $this.parents('.cct-accordion').find('.item-desc').slideUp(350);
                $this.parents('.cct-accordion').find('.item-title').removeClass('on');
                $this.next().toggleClass('show');
                $this.next().slideToggle(350);
                $this.toggleClass('on');
            }
        });
    };

	$(document).ready(function() {
		CCT.General();
		CCT.Isotope();
		CCT.FilterByPrice();
		CCT.FilterByDuration();
		CCT.FiterByDepartureDate();
		CCT.FilterByTaxonomy();
		CCT.SubmitFormBooking();
		CCT.BookingChangePerson();
		CCT.Accordion();
	});

})(jQuery, window, document);