// the semi-colon before the function invocation is a safety
// net against concatenated scripts and/or other plugins
// that are not closed properly.
;(function ($, window, document, undefined) {
	'use strict';

	var Shortcodes  = vc.shortcodes;

	if (window.VcColumnView) {

		//
		// CC module
		// -------------------------------------------------------------------------
		window.CCModuleView  = window.VcColumnView.extend({
			events: {
				'click > .controls .column_add': 'addDirectlyElement',
				'click > .wpb_element_wrapper > .vc_empty-container': 'addDirectlyElement',
				'click > .controls .column_delete': 'deleteShortcode',
				'click > .controls .column_edit': 'editElement',
				'click > .controls .column_clone': 'clone',
			},

			addDirectlyElement: function(e) {
				e.preventDefault();

				var module  = Shortcodes.create({shortcode: 'cc_module_item', parent_id: this.model.id});

				return module;
			},

			setDropable: function () {

			},

			dropButton: function(event, ui) {

			},
		});
	}

	//
	// ATTS
	// -------------------------------------------------------------------------
	_.extend(vc.atts, {
		vc_cc_exploded_textarea: {
			parse: function (param) {
				var $field  = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']');

				return $field.val().replace(/\n/g, '~');
			}
		},
		vc_cc_style_textarea: {
			parse: function(param) {
				var $field  = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']');

				return $field.val().replace(/\n/g, '');
			}
		},
		vc_cc_chosen: {
			parse: function(param) {
				var value = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']').val();

				return ( value ) ? value.join(',') : '';
			}
		},
	});

	// ======================================================
	// VISUAL COMPOSER IMAGE SELECT
	// ------------------------------------------------------
	$.fn.JSCOMPOSER_IMAGE_SELECT = function() {
		return this.each(function() {

		var _el       = $(this),
			_elems    = _el.find('li');

			_elems.each( function (){
				var _this = $(this),
				  _data   = _this.data('value');

				_this.click(function() {
					if (_this.is('.selected')) {
						_this.removeClass('selected');
						_el.next().val('').trigger('keyup');
					} else {
						_this.addClass('selected').siblings().removeClass('selected');
						_el.next().val( _data ).trigger('keyup');
					}
				});
			});
		});
	};
	// ======================================================

	// ======================================================
	// VISUAL COMPOSER SWITCH
	// ------------------------------------------------------
	$.fn.JSCOMPOSER_SWITCH = function() {
		return this.each(function() {

			var _this   = $(this),
			_input  = _this.find('input');

			_this.click(function() {
				_this.toggleClass('switch-active');
				_input.val(( _input.val() == 1 ) ? '' : 1).trigger('keyup');
			});
		});
	};

	// ======================================================
	// RELOAD FRAMEWORK PLUGINS
	// ------------------------------------------------------
	$.CC_VC_RELOAD_PLUGINS = function () {
		$('.chosen').CCFRAMEWORK_CHOSEN();
		$('.cc-field-image-select').CCFRAMEWORK_IMAGE_SELECTOR();
		$('.vc_image_select').JSCOMPOSER_IMAGE_SELECT();
		$('.vc_switch').JSCOMPOSER_SWITCH();
		$('.cc-field-image').CCFRAMEWORK_IMAGE_UPLOADER();
		$('.cc-field-gallery').CCFRAMEWORK_IMAGE_GALLERY();
		$('.cc-field-sorter').CCFRAMEWORK_SORTER();
		$('.cc-field-upload').CCFRAMEWORK_UPLOADER();
		$('.cc-field-typography').CCFRAMEWORK_TYPOGRAPHY();
		$('.cc-field-color-picker').CCFRAMEWORK_COLORPICKER();
		$('.cc-help').CCFRAMEWORK_TOOLTIP();
	};

})(jQuery, window, document);