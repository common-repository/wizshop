jQuery(document).ready(function($) {  

//checkout-final
(function(){
	//init
	var __login = false;
	var __ver = $("#wiz_page_ver")[0] ? parseFloat($("#wiz_page_ver").val()) : 0;
	
	//events
	$(window).on("message",function(e) {
		var data = null;
		try{
			if(e.originalEvent) data = JSON.parse(e.originalEvent.data);
		}catch (e){
			data = null;
		}                              
		if (data && data.wizshop) {          
			if(data.creditChange){
				setPaymentMethod(data.credit.method);
			}else if(data.cpPainted){
				if(data.id == "step_3"){
					if(!$("#payment_select").hasClass('v_ihide')){
						$meth = $("#payment_select").find("[data-wiz-credit-type].v_iselect");
						setPaymentMethod(parseInt($meth.attr("data-wiz-credit-type")));
						if(!__login && __ver >= 2){
							$("#payment_select").addClass('v_ihide');
						}
					}
					(window.location.hash == "#step_3" && (__login || __ver >= 2)) ?  $('#step_3').removeClass("v_ihide") : $('#step_3').addClass("v_ihide");
				}
			
			}else if(data.userLogin){
				__login = data.login;
				clearStatus(__login ? ["sign-in", "sign-in-b2b", "payment","sign-up"] : ["payment","sign-up"]);
				if(data.cust_obj){
					if(data.cust_obj.hasOwnProperty("VSSameAdd")){
						("1" == data.cust_obj.VSSameAdd) ? $('#collyes').click() : $('#collno').click();
						$('#other_add').prop("checked", "1" != data.cust_obj.VSSameAdd);
						sameAddress("1" == data.cust_obj.VSSameAdd);
					}
					
					if("3" != data.cust_obj.VSSendAdvByMail || "3" != data.cust_obj.VSSendCpn){
						$('#cpn-adv').prop("checked", "1" == data.cust_obj.VSSendAdvByMail || "1" == data.cust_obj.VSSendCpn);
					}else{
						$('#cpn-adv').addClass('v_ihide');
						$('[for="cpn-adv"]').addClass('v_ihide');
					}
				
				}
				checkHash();
			
			}else if(data.purchaseCompleted){
				window.location.hash = "#checkout_report";
			}
		}
	});  

	$(window).bind('hashchange', function() {
 		onHashChange();
 	});
		
	$('[data-cust-type]').click(function(e){
		var type = $(this).attr('data-cust-type');

		if(0 == __ver){
		
			$('[data-cust-type]').removeClass("v_iselect");
			$(this).addClass('v_iselect');

			$('[data-cust-form]').addClass("v_ihide");
			$('[data-cust-form="'+type+'"]').removeClass('v_ihide');
		
		}else{
			if(0 != type){
				var has_select = $(this).hasClass('v_iselect');
				if(has_select){
					$('[data-cust-type]').removeClass("v_iselect");
					$('[data-cust-form="'+type+'"]').addClass("v_ihide");
				}else{
					$('[data-cust-type]').removeClass("v_iselect");
					$(this).addClass('v_iselect');

					$('[data-cust-form]').addClass("v_ihide");
					$('[data-cust-form="'+type+'"]').removeClass('v_ihide');
				}
			}
			$('[data-cust-form="0"]').removeClass("v_ihide");
			clearStatus(["sign-in", "sign-in-b2b", "sign-up"]);
		}
		
		if(0 == type){ 
			window.location.hash = "step_2";
		}else if (1 == type){ 
			window.location.hash = "step_1";
		}else if (2 == type){ 
			window.location.hash = "step_1";
		}
	});
	
	//helpers
	function clearStatus(obj_ids_arr){
		postMessage(JSON.stringify({ status_report_off: true, wizshop: true, 
			object_id: obj_ids_arr}),"*");
	}
	
	
	function checkHash(){
		var cur_hash = window.location.hash.replace(/^#/,'');
		var done = false;
		if(__login){
			if(!cur_hash || "step_1" == cur_hash){
				window.location.hash = $('#step_2')[0] ? "step_2" : "step_3" ; 
				done = true;
			}else if("step_2" == cur_hash && !$('#step_2')[0]){
				window.location.hash = "step_3" ; 
				done = true;
			}
		}else{
			if(__ver < 2 || !cur_hash){
				window.location.hash = "step_1"; 
				if("step_1" != cur_hash){
					done = true;
				}
			}else{
			}
		}
		if(!done){
			onHashChange();
		}
	}
	
	function onHashChange(){
		var hash = window.location.hash.replace(/^#/,'');
		if ("step_1" == hash){
			$('#step_3').addClass("v_ihide");
			
			$('[data-wiz-head="1"]').addClass("dotter");
			$('[data-wiz-head="2"]').removeClass("dotter");
			$('[data-wiz-head="3"]').removeClass("dotter");

			$('[data-wiz-title="1"]').removeClass("title-off");
			$('[data-wiz-title="2"]').addClass("title-off");
			$('[data-wiz-title="3"]').addClass("title-off");
			
			if(0 == __ver){
				$('[data-cust-type]').each(function( index, el ){
					if($(el).hasClass('v_iselect')){
						var type = $(el).attr('data-cust-type');
						$('[data-cust-form]').addClass("v_ihide");
						$('[data-cust-form="'+type+'"]').removeClass('v_ihide');
					}
					
				});			
			}else{
				$('[data-cust-type]').each(function( index, el ){
					if(!$(el).hasClass('v_iselect')){
						var type = $(el).attr('data-cust-type');
						$('[data-cust-form="'+type+'"]').addClass('v_ihide');
					}
				});
				$('[data-cust-form="0"]').removeClass("v_ihide");
			}
			
		}else if("step_2" == hash){
			$('[data-cust-form="0"]').removeClass("v_ihide");
			$('#step_3').addClass("v_ihide");

			$('[data-wiz-head="1"]').addClass("dotter");
			$('[data-wiz-head="2"]').addClass("dotter");
			$('[data-wiz-head="3"]').removeClass("dotter");

			$('[data-wiz-title="2"]').removeClass("title-off");
			$('[data-wiz-title="1"]').addClass("title-off");
			$('[data-wiz-title="3"]').addClass("title-off");

			if(__ver >= 2){
				$('[data-cust-form="1"]').addClass("v_ihide");
				$('[data-cust-form="2"]').addClass("v_ihide");
			}
			
		}else if("step_3" == hash){
			
			if(!__login && __ver >= 2){
				$("#payment_select").addClass('v_ihide')
			}else{
				$('#payment_select').removeClass("v_ihide");
			}
			
			$('[data-wiz-head="1"]').addClass("dotter");
			$('[data-wiz-head="2"]').addClass("dotter");
			$('[data-wiz-head="3"]').addClass("dotter");

			$('[data-wiz-title="3"]').removeClass("title-off");
			$('[data-wiz-title="1"]').addClass("title-off");
			$('[data-wiz-title="2"]').addClass("title-off");
			
			$('[data-cust-form="0"]').addClass("v_ihide");
			
			if(__ver >= 2){
				$('[data-cust-form="1"]').addClass("v_ihide");
				$('[data-cust-form="2"]').addClass("v_ihide");
				if(!__login) 	$('#step_3').removeClass("v_ihide");
			}

		}else if("checkout_report" == hash){
			$('#step_1').addClass("v_ihide");
			$('#step_3').addClass("v_ihide");
			$('#step_3').addClass("v_ihide");
		}
	}
	
	function setPaymentMethod(method){
		if(1==method){
			$('#pay_mehtod_0').addClass("v_ihide");
			$('#pay_mehtod_01').addClass("v_ihide");
			$('#pay_mehtod_1').removeClass("v_ihide");
		}else{
			$('#pay_mehtod_1').addClass("v_ihide");
			$('#pay_mehtod_0').removeClass("v_ihide");
			$('#pay_mehtod_01').removeClass("v_ihide");
		}
	}
	
	//step hash
	$('[data-wiz-step]').click(function(e) {
		clearStatus(["payment","sign-up"]);
		var stp = $(e.target).attr('data-wiz-step');
		if(stp){
			window.location.hash = "#step_"+stp;
		}
	});
	
	$('.showpass').click(function(e) {
		$('.password-block').toggleClass("v_ihide") ;
		$('.showpass').toggleClass("minus-icon") ;
	});

	//collapse 
	$('#collyes').click(function(e) {
		sameAddress(true);
	});

	$('#collno').click(function(e){
		sameAddress(false);
	});
	
	$('#other_add').click(function(e) {
		sameAddress(!this.checked);
	});
	
	function sameAddress(on){
		$('#vs_VSSameAdd').prop( "checked", on );
		if(on){
			if(0 == __ver){ 
				$('.collappse-block').css("display","block") ;
			}else{
				$('.collappse-block').css("display","none") ;
				$('#collyes').removeClass("primary-outline");
				$('#collno').addClass("primary-outline");
			}
		}else{
			if(0 == __ver){ 
				$('.collappse-block').css("display","none") ;
			}else{
				$('.collappse-block').css("display","block") ;
				$('#collno').removeClass("primary-outline");
				$('#collyes').addClass("primary-outline");
			}
		}
	}
	
	$('#cpn-adv').on('click', function(e)  {
		//#class v_ihide is set by component when _VSSendAdvByMail=3 or #vs_VSSendCpn=3
		if(!$('#vs_VSSendAdvByMail').hasClass('v_ihide'))
			$('#vs_VSSendAdvByMail').prop( "checked", this.checked );
		if(!$('#vs_VSSendCpn').hasClass('v_ihide'))
			$('#vs_VSSendCpn').prop( "checked",  this.checked );
	});	
	
})();

});

