//menus.js
jQuery(document).ready(function($) {    
	//--------------------------------------------------------
	//window props
	//--------------------------------------------------------
	var $menu_con	= $('#v_menu_con');
	var $menu_close	= $('#v_menu_close');
	var $menu 		= $('#v_menu_id_select');
	var $item 		= $('#v_menu_item_id_select');
	var $depth 		= $('#v_menu_depth_select');
	var $meta 		= $('#v_menu_meta_select');

	if($meta[0]){
		$meta.find('option').remove().end().append($('<option />').
			text(_wiz_menus.no_meta.name).val(_wiz_menus.no_meta.id));
		if(_wiz_menus.meta){
			for(var i=0; i < _wiz_menus.meta.length; i++){
				$meta.append($('<option />').text(_wiz_menus.meta[i]).val(_wiz_menus.meta[i]));
			}
		}
	}	
	
	$menu.change(function() {
		var index = parseInt($menu_con.attr('wiz-index'));
		var no_sel = $menu.val() == '-1';
		$item.find('option').remove().end().append($('<option />').
			text(_wiz_menus.no_item.name).val(_wiz_menus.no_item.id));
		
		if(!no_sel){
			var arr = _wiz_menus.menus[$menu.val()].items;
			for (var key in arr ){
				$item.append($('<option />').text(arr[key]).val(key));
			}
			if(-1 != index){
				if(-1 != _wiz_menus.io[index].v_item_id){
					$item.find('option[value="'+ _wiz_menus.io[index].v_item_id.toString() + '"]').attr("selected",true);
				}
			}
		}
		if(no_sel){
			$depth.prop('selectedIndex', 0);
			$meta.prop('selectedIndex', 0);
		}
		
		$item.prop('disabled', no_sel);
		$depth.prop('disabled', no_sel);
		$meta.prop('disabled', no_sel);
	
	});

	$menu_close.click(function(e) {
		var ok = false;
		var index = parseInt($menu_con.attr('wiz-index'));
		var mi = parseInt($menu.val());
		var depth = $depth[0] ? parseInt($depth.val()): -1;
		var meta = $meta[0] ? ($meta.val() == "-1" ? "" : $meta.val() ) : "";
			
		if(-1 != mi && (meta || !_wiz_menus.validate_meta) ){
			var item = {v_menu_id: mi,	v_item_id: parseInt($item.val()), v_menu_depth: depth, v_menu_meta: meta };
			if(index == -1) {
				_wiz_menus.io.push(item);
				ok = true;
			}else{
				if(JSON.stringify(item) != JSON.stringify(_wiz_menus.io[index] )){
					_wiz_menus.io[index] = item;
					ok = true;
				}
			}
			
		}else{
			if(-1 < index){
				_wiz_menus.io.splice(index, 1);
				ok = true;
			}
		}
		$menu_con.addClass('v_ihide');
		paintList();
		if(ok){
			update();
		}
	});

	$('#v_menu_cancel').click(function(e) {
		$menu_con.addClass('v_ihide');
		paintList();
	});	
		
	function menuSelectWin(index){
		$menu_con.attr('wiz-index', index.toString());
		if($menu[0]){
			$menu.find('option').remove().end().append($('<option />').text(_wiz_menus.no_menu.name).val(_wiz_menus.no_menu.id));
			for (var key in _wiz_menus.menus){
				$menu.append($('<option />').text(_wiz_menus.menus[key].name).val(key));
			}
			if(-1 != index && -1 != _wiz_menus.io[index].v_menu_id){
				$menu.find('option[value="'+ _wiz_menus.io[index].v_menu_id.toString() + '"]').attr("selected",true);
			}

		}
		if($depth[0]){
			$depth.find('option').remove().end().append($('<option />').text(_wiz_menus.depth_all.name).val(_wiz_menus.depth_all.id));
			for (var i=1; i <=7 ; i++ ){
				$depth.append($('<option />').text(i.toString()).val(i.toString()));
			}
			if(-1 != index && -1 != _wiz_menus.io[index].v_menu_depth){
				$depth.find('option[value="'+ _wiz_menus.io[index].v_menu_depth.toString() + '"]').attr("selected",true);
			}
		}
		if($meta[0]){
			if(-1 != index && "" != _wiz_menus.io[index].v_menu_meta){
				$meta.find('option[value="'+ _wiz_menus.io[index].v_menu_meta + '"]').attr("selected",true);
			}
		}
		
		
		$item.find('option').remove();
		$menu.change();
		if(-1 != index){
			$tr = $('[data-wiz-menu-item=\"'+index.toString() + '\"]');
			$menu_con.insertAfter($tr);
			$tr.remove();
		}else{
			$menu_con.insertAfter($('[data-wiz-menu-item=\"' + (_wiz_menus.io.length-1).toString() + '\"]'));
		}
		$menu_con.removeClass('v_ihide');
		$("[data-wiz-add-menu]").addClass('v_ihide') ;
		$menu.focus();	
	}
	
	function update(info){
		var data = {
			'action': 'wiz_set_menus',
			'type' :  _wiz_menus.type,
			"menus":  _wiz_menus.io,
			'cat_opt': jQuery('#cat_opt').val(),
			'shop_id': jQuery('#shop_id').val(),
		};
		if(info && info.length > 1){
			data[info[0]] = info[1];
		}
		
		if(info){
			jQuery("#overlay").fadeIn(300);
		}
		jQuery.post(ajaxurl, data, function(result){
			if(info){
				location.reload();	
			}
		});
	}
	
	//--------------------------------------------------------
	
	//--------------------------------------------------------
	//list props
	//--------------------------------------------------------
	var _menu_html = $('#v_menu_html').html();
	var $items_list = $('#v_menu_list');
	
	function paintItem(i){
		if(i >= _wiz_menus.io.length) return "";
		
		var menu_id = _wiz_menus.io[i].v_menu_id;
		var item_id = _wiz_menus.io[i].v_item_id;
		var depth_id = _wiz_menus.io[i].v_menu_depth;
		
		var menu_text = "";
		var item_text = "";
		var depth_text = "";
		
		if(menu_id == _wiz_menus.no_menu.id){
			menu_text = _wiz_menus.no_menu.name;
		}else if(_wiz_menus.menus[menu_id]){
			menu_text = _wiz_menus.menus[menu_id].name;
		}
		
		if(item_id == _wiz_menus.no_item.id){
			item_text = _wiz_menus.no_item.name;
		}else if(_wiz_menus.menus[menu_id].items[item_id]){
			item_text = _wiz_menus.menus[menu_id].items[item_id];
		}

		if(_wiz_menus.depth_all && depth_id == _wiz_menus.depth_all.id){
			depth_text = _wiz_menus.depth_all.name;
		}else{
			depth_text = depth_id;
		}
		
		var html_item = _menu_html;
		html_item = html_item.replace(/{{index}}/g, i);
		html_item = html_item.replace(/{{menu_text}}/g,menu_text);
		html_item = html_item.replace(/{{item_text}}/g, item_text);
		html_item = html_item.replace(/{{depth_text}}/g,depth_text);
		html_item = html_item.replace(/{{meta_text}}/g,(_wiz_menus.io[i].v_menu_meta) ? (_wiz_menus.io[i].v_menu_meta) : "" );
		return html_item;
	}
	
	function paintList(){
		$("[data-wiz-menu-item]").remove();
		var html_block = "";
		if($items_list[0]){
			for(var i=0; i< _wiz_menus.io.length; i++){
				html_block += paintItem(i);
			}
			$items_list.append(html_block);
		}
		$('[data-wiz-del-menu-item]').click(function(e) {
			if(_wiz_menus.del_alert && !confirm(_wiz_menus.del_alert)){
				return;
			}
			var index = parseInt(e.target.getAttribute('data-wiz-del-menu-item'));
			var del = _wiz_menus.io.splice(index, 1);
			paintList();
			update( ['delete_1', del[0] ]);
		});
		$('[data-wiz-edit-menu-item]').click(function(e) {
			var index = parseInt(e.target.getAttribute('data-wiz-edit-menu-item'));
			if(!$menu_con.hasClass('v_ihide')){
				paintList();
			}
			menuSelectWin(index);
		});	
		
		$('[data-wiz-update-menu-item]').click(function(e) {
			var index = parseInt(e.target.getAttribute('data-wiz-update-menu-item'));
			if(!$menu_con.hasClass('v_ihide')){
				paintList();
			}
			if(_wiz_menus.upd_alert && !confirm(_wiz_menus.upd_alert)){
				return;
			}
			update(['update_1' , _wiz_menus.io[index]] );
		});	

			
		(_wiz_menus.io.length >= _wiz_menus.max_list) ? 
				$("[data-wiz-add-menu]").addClass('v_ihide') : $("[data-wiz-add-menu]").removeClass('v_ihide');
	}
	
	$('[data-wiz-add-menu]').click(function(e) {
		if(!$menu_con.hasClass('v_ihide')){
			paintList();
		}
		menuSelectWin(-1);
	});	
	//--------------------------------------------------------


	//--------------------------------------------------------
	//init
	//--------------------------------------------------------
	$menu_con.addClass('v_ihide');
	
	_wiz_menus.io = _wiz_menus.io.filter(function(val){
							return (_wiz_menus.no_menu.id != val.v_menu_id && _wiz_menus.menus.hasOwnProperty(val.v_menu_id));
						});
	if($meta[0] && _wiz_menus.validate_meta){
		$meta.change(function(e){
			$menu_close.prop('disabled', $meta.val() == "-1");
		});
		$menu_close.prop('disabled', $meta.val() == "-1");		
	}
	
	paintList();
	
});
