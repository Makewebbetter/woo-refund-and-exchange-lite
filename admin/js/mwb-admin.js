//code for datatable

jQuery(document).ready(function() {

    console.log('you entered');
    jQuery('#wrael-datatable').DataTable({
        stateSave: true,
        dom: '<"mwb-dt-buttons"fB>tr<"bottom"lip>',
        "ordering": true, // enable ordering
   
        
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ],
        language: {
            "lengthMenu": 'Rows per page _MENU_',

            paginate: { next: '<svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.99984 0L0.589844 1.41L5.16984 6L0.589844 10.59L1.99984 12L7.99984 6L1.99984 0Z" fill="#8E908F"/></svg>', previous: '<svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.00016 12L7.41016 10.59L2.83016 6L7.41016 1.41L6.00016 -1.23266e-07L0.000156927 6L6.00016 12Z" fill="#8E908F"/></svg>' }
        },
    });
});

jQuery(document).ready(function() {
	$ = jQuery;
	const MDCText = mdc.textField.MDCTextField;
	const textField = [].map.call(
		document.querySelectorAll('.mdc-text-field'),
		function(el) {
			return new MDCText(el);
		}
	);
	const MDCRipple = mdc.ripple.MDCRipple;
	const buttonRipple = [].map.call(
		document.querySelectorAll('.mdc-button'),
		function(el) {
			return new MDCRipple(el);
		}
	);
	const MDCSwitch = mdc.switchControl.MDCSwitch;
	const switchControl = [].map.call(
		document.querySelectorAll('.mdc-switch'),
		function(el) {
			return new MDCSwitch(el);
		}
	);
	$( window ).load(function() {
		// add select2 for multiselect.
		if ($(document).find('.mwb-defaut-multiselect').length > 0) {
			$(document)
			.find('.mwb-defaut-multiselect')
			.select2();
		}
	});
	// Add class in plugin submenu
	$("a[href='admin.php?page=woo_refund_and_exchange_lite_menu']").addClass('submenu-font-size-fix');
	
	$('.mwb-password-hidden').click(function() {
		if ($('.mwb-form__password').attr('type') == 'text') {
			$('.mwb-form__password').attr('type', 'password');
		} else {
			$('.mwb-form__password').attr('type', 'text');
		}
	});
	$('.mwb_rma_order_statues').select2();

	// Make setting object in js
	var output_setting = [];
	function make_register_setting_obj() {
		let on_setting = [];
		$.each( $('.add_more_rma_policies'), function() {
			var fun = $( this ).children( '.mwb_rma_on_functionality' ).val();
			var set = $( this ).children( '.mwb_rma_settings' ).val();
			var myObj = new Object();
			myObj.name = fun;
			myObj.value = set;
			on_setting.push( myObj );
		});
		on_setting.forEach(function(item) {
			var existing = output_setting.filter(function(v, i) {
				return v.name == item.name;
			});
			if (existing.length) {
				var existingIndex = output_setting.indexOf(existing[0]);
				output_setting[existingIndex].value = output_setting[existingIndex].value.concat(item.value);
			} else {
				if (typeof item.value == 'string')
				item.value = [item.value];
				output_setting.push(item);
			}
		});
	}
	make_register_setting_obj();
	// Function to show correct setting respective selected setting.
	function show_correct_field(){
		$.each( $('.mwb_rma_settings'), function() {
			if( $( this ).val() == '' ) {
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_max_number_days' ).hide();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions1' ).show();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions2' ).hide();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_tax_handling' ).hide();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).hide();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).next().hide();
			} else if( $( this ).val() == 'mwb_rma_maximum_days' ) {
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_max_number_days' ).show();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions1' ).show();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions2' ).hide();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_tax_handling' ).hide();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).hide();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).next().hide();
			} else if ( $( this ).val() == 'mwb_rma_order_status' ) {
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).show();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).next().show();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_tax_handling' ).hide();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions1' ).hide();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions2' ).show();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_max_number_days' ).hide();
			} else if ( $( this ).val() == 'mwb_rma_tax_handling' ) {
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_tax_handling' ).show();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).hide();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).next().hide();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_max_number_days' ).hide();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions1' ).hide();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions_label' ).show();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_settings_label' ).show();
				$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions2' ).show();
			}
		});
	}
	show_correct_field();
	// show correct setting respective selected setting and if remove if setting already is exist and also show an alert.
	$(document).on( 'change', '.mwb_rma_settings, .mwb_rma_on_functionality', function() {
		var current_fun = $( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_on_functionality' ).val();
		var current_set = $( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_settings' ).val();;
		var current_set_obj = $( this );
		if( current_set != '' && current_set != null ) {
			output_setting.forEach(function(item) {
				if( current_fun == item.name && item.value != null &&  $.inArray( current_set, item.value ) != -1 ) {
					alert('Policy already exist');
					current_set_obj.parent( '.add_more_rma_policies' ).remove();
				}
			});
		}
	
		if( current_set_obj.val() == '' ) {
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_max_number_days' ).hide();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions1' ).show();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions2' ).hide();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_tax_handling' ).hide();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).hide();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).next().hide();
		} else if( current_set_obj.val() == 'mwb_rma_maximum_days' ) {
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_max_number_days' ).show();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions1' ).show();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions2' ).hide();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_tax_handling' ).hide();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).hide();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).next().hide();
		} else if ( current_set_obj.val() == 'mwb_rma_order_status' ) {
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).show();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).next().show();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_tax_handling' ).hide();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions1' ).hide();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions2' ).show();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_max_number_days' ).hide();
		} else if ( current_set_obj.val() == 'mwb_rma_tax_handling' ) {
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_tax_handling' ).show();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).hide();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_order_statues' ).next().hide();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_max_number_days' ).hide();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions1' ).hide();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions2' ).show();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_conditions_label' ).show();
			$( this ).parent( '.add_more_rma_policies' ).children( '.mwb_rma_settings_label' ).show();
		}
		output_setting = [];
		make_register_setting_obj();
	});
	// Replace function.
	function escapeRegExp(string){
		return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
	}		
	/* Define function to find and replace specified term with replacement string */
	function replaceAll(str, term, replacement) {
			return str.replace(new RegExp(escapeRegExp(term), 'g'), replacement);
	}
	// Add extra row setting and do the useful functionality.
	$(document).on( 'click', '#mwb_rma_add_more', function() {
		var pro_act = wrael_admin_param.check_pro_active;
		var mwb_rma_get_current_i = $('.add_more_rma_policies').last().children( '.mwb_rma_get_current_i' ).val();
		mwb_rma_get_current_i = parseInt( mwb_rma_get_current_i ) + 1;
		var append_html = $( '#add_more_rma_policies_clone' ).html();
		append_html = replaceAll( append_html, 'mwb_rma_setting[1]', 'mwb_rma_setting['+ mwb_rma_get_current_i +']' );
		append_html = replaceAll( append_html, 'mwb_rma_order_statues1', 'mwb_rma_order_statues' );
		if( pro_act ) {
			append_html = show_correct_field_pro( append_html );
		}
		$('#div_add_more_rma_policies').append( '<div class="add_more_rma_policies">' +append_html + '<input type="button" value="X" class="rma_policy_delete"></div>' );
		$('.add_more_rma_policies').last().children( '.mwb_rma_get_current_i' ).val( mwb_rma_get_current_i );
		$('.mwb_rma_order_statues').select2();
		if( pro_act ) {
			mwb_rma_do_something();
		}
		show_correct_field();
		make_register_setting_obj();
	});
	// Delete selected row.
	$(document).on( 'click', '.rma_policy_delete', function() {
		$(this).parent( '.add_more_rma_policies' ).remove();
		show_correct_field();
		make_register_setting_obj();
	});
	// Refund Request Accept functionality
	$( '.mwb_rma_return_loader' ).hide(); // Hide the loader in the refund request metabox
	$( document ).on( 'click', '#mwb_rma_accept_return', function(){
			$( '#mwb_rma_return_package' ).hide();
			$( '.mwb_rma_return_loader' ).show();
			var orderid = $( this ).data( 'orderid' );
			var date   = $( this ).data( 'date' );
			var data = {
				action:'mwb_rma_return_req_approve',
				orderid:orderid,
				date:date,
				security_check	: wrael_admin_param.mwb_rma_nonce
			};
			$.ajax(
				{
					url: wrael_admin_param.ajaxurl,
					type: 'POST',
					data: data,
					dataType :'json',
					success: function(response)
				{
						$( '.mwb_rma_return_loader' ).hide();
						$( '.refund-actions .cancel-action' ).hide();
						window.location.reload();

					}
				}
			);
		}
	);
	// Refund Request Cancel Functionality
	$( document ).on( 'click', '#mwb_rma_cancel_return', function(){
		$( '.mwb_rma_return_loader' ).show();
		var orderid = $( this ).data( 'orderid' );
		var date = $( this ).data( 'date' );
		var data = {
			action:'mwb_rma_return_req_cancel',
			orderid:orderid,
			date:date,
			security_check	:	wrael_admin_param.mwb_rma_nonce
		};
		$.ajax(
			{
				url: wrael_admin_param.ajaxurl,
				type: 'POST',
				data: data,
				dataType :'json',
				success: function(response){
					$( '.mwb_rma_return_loader' ).hide();
					window.location.reload();
				}
		});
	});
	// Refund Amount functionality
	$( document ).on( 'click', '#mwb_rma_left_amount', function(){
			$( this ).attr( 'disabled','disabled' );
			var check_pro_active = wrael_admin_param.check_pro_active;
			var order_id = $( this ).data( 'orderid' );
			var refund_method = $( this ).data( 'refund_method' );
			var refund_amount = $( '.mwb_rma_total_amount_for_refund' ).val();

			if( refund_method == '' || refund_method == 'manual_method' ) {
				$( 'html, body' ).animate(
					{
						scrollTop: $( '#order_shipping_line_items' ).offset().top
					},
					2000
				);
	
				$( 'div.wc-order-refund-items' ).slideDown();
				$( 'div.wc-order-data-row-toggle' ).not( 'div.wc-order-refund-items' ).slideUp();
				$( 'div.wc-order-totals-items' ).slideUp();
				$( '#woocommerce-order-items' ).find( 'div.refund' ).show();
				$( '.wc-order-edit-line-item .wc-order-edit-line-item-actions' ).hide();
				var refund_reason = $( '#mwb_rma_refund_reason' ).val();
				$( '#refund_amount' ).val( refund_amount );
				$( '#refund_reason' ).val( refund_reason );
	
				var total = accounting.unformat( refund_amount, woocommerce_admin.mon_decimal_point );
	
				$( 'button .wc-order-refund-amount .amount' ).text(
					accounting.formatMoney(
						total,
						{
							symbol:    woocommerce_admin_meta_boxes.currency_format_symbol,
							decimal:   woocommerce_admin_meta_boxes.currency_format_decimal_sep,
							thousand:  woocommerce_admin_meta_boxes.currency_format_thousand_sep,
							precision: woocommerce_admin_meta_boxes.currency_format_num_decimals,
							format:    woocommerce_admin_meta_boxes.currency_format
						}
					)
				);
			} else {
				if( check_pro_active ) {
					if ( typeof mwb_rma_refund_method_wallet == 'function') {
						var response = mwb_rma_refund_method_wallet( order_id, refund_amount );
						if( response ) {
							window.location.reload();
						}
					}
				}

			}

	});
	// Manage Stock functionality start
	$( document ).on( 'click', '#mwb_rma_stock_back', function(){
		$( this ).attr( 'disabled','disabled' );
		var order_id = $( this ).data( 'orderid' );
		var type = $( this ).data( 'type' );
		var data = {
			action   : 'mwb_rma_manage_stock' ,
			order_id : order_id ,
			type     : type,
			security_check : wrael_admin_param.mwb_rma_nonce
		};
		$.ajax({
			url: wrael_admin_param.ajaxurl,
			type: 'POST',
			data: data,
			dataType :'json',
			success: function(response) {
				$( this ).removeAttr( 'disabled' );
				if (response.result) {
					$( '#post' ).prepend( '<div class="updated notice notice-success is-dismissible" id="message"><p>' + response.msg + '</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>' );
					$( 'html, body' ).animate(
						{
							scrollTop: $( 'body' ).offset().top
						},
						2000,
						'linear',
						function(){
							window.setTimeout(
								function() {
									window.location.reload();
								},
								1000
							);
						}
					);
				} else {
					$( '#post' ).prepend( '<div id="messege" class="notice notice-error is-dismissible" id="message"><p>' + response.msg + '</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>' );
					$( 'html, body' ).animate(
						{
							scrollTop: jQuer$( 'body' ).offset().top
						},
						2000,
						'linear',
						function(){
						}
					);
				}
			}
		});
	});
	// Regenerate Api Secret key
	$( document ).on( 'click', '#mwb_rma_generate_key_setting', function(e){
		e.preventDefault();
		var data = {
			action:'mwb_rma_api_secret_key',
			security_check	: wrael_admin_param.mwb_rma_nonce
		};
		$.ajax(
		{
			url: wrael_admin_param.ajaxurl,
			type: 'POST',
			data: data,
			dataType :'json',
			success: function(response) {
				window.location.reload();
			}
		});
	});
});