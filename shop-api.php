<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*----------------------------*/ 
/* claaa WizShop_Api		  */
/*----------------------------*/ 

class WizShop_Api {

	static public function sendReq($param, $options, $lang, &$msg = null) {
		$obj = false;
		if(is_null($options)){
			global $wizshop_settings;
			$options = wizshop_get_option($wizshop_settings['name']);
		}		
		$uc = wizshop_validate_uc($options['shop_id']);
		if(!$lang) 	$lang = wizshop_cur_lang(); 
		if($uc != null and trim($uc) != ""){
			$url = trailingslashit($options['shop_server']). 'WizCgi.cgi?API=Yes&Lang=' . strtoupper($lang) . '&UC='. $uc . $param;
			$obj  = wp_remote_get($url,( is_admin() ? array('timeout' => 120) : array('timeout' => 30)) );
			if(is_wp_error($obj)){
				if(!is_null($msg)) $msg = $obj->get_error_message();
				$obj = false;
			}else{
				$obj = wp_remote_retrieve_body($obj);
				if(is_wp_error($obj)){
					if(!is_null($msg)) $msg = $obj->get_error_message();
					$obj = false;
				}else if(null != $obj){
					$obj = self::resToJson($obj);
				}else{
					$obj = false;
				}
			}		
		}	
		return $obj;
	}
	
	static public function resToJson($json){
		if(!$json || !isset($json))
			return false;
		$len = strlen($json);
		//"%u007b%u0020%u0022%u05de%u05d9"
		$string='';
		for ($i=2; $i < $len-3; $i+=6){
			$string .= iconv('UCS-4BE',"UTF-8",pack("N",hexdec($json[$i].$json[$i+1].$json[$i+2] .$json[$i+3])) );
			//php mb string missing
		//	$string .= mb_convert_encoding(pack("N",hexdec($json[$i].$json[$i+1].$json[$i+2] .$json[$i+3])), "UTF-8", 'UCS-4BE');
		}
		return json_decode($string);
	}
	
	static public function argToApi($arg){
		if(!$arg) return "";
		$arg = strtoupper(bin2hex(iconv('UTF-8','ISO-8859-8', $arg)));
		$len = strlen($arg);
		$string='';
		for ($i=0; $i < $len; $i+=2){
			$string .= "%" . substr($arg, $i, 2);
		}
		return $string;
	}

		
	static public function checkServer(&$options, &$msg = null){
		$uc = wizshop_validate_uc($options['shop_id']);
		$res  = wp_remote_get(wizshopShopUrl . $uc . '&Lang=' . strtoupper(wizshop_cur_lang()));
		if(is_wp_error($res)){
			if(!is_null($msg)) $msg = $res->get_error_message();
			$res = false;
		}else{
			$res = wp_remote_retrieve_body($res);
			if(is_wp_error($res)){
				if(!is_null($msg)) $msg = $res->get_error_message();
				$res = false;
			}else{
				$res = self::resToJson($res);
			}
		}
		$ret = self::admin_json_res($res,$msg);
		if($ret){
			$options['shop_server'] = sanitize_text_field($res->VSUrl);
			$ret = self::validatePass($options,$msg);
		}
		return $ret;
	}
	
	static public function validatePass(&$options, &$msg = null){
		$res = self::sendReq('&HTTPREQ=98&VSWPMode=1&VSWPPs='.$options['shop_pass'],$options, $options['shop_lang'], $msg); 
		$ret = self::admin_json_res($res,$msg);
		if($ret && !is_null($msg)){
			$msg = __('The Shop has been successfully detected by WizShop server.',WizShop);
		}		
		return $ret;
	}
	
	static public function update_cat_img($cat, $img, $options, &$msg = null){
		$image_name = wizshop_cat_image_name($img);
		$res = self::sendReq('&HTTPREQ=98&VSWPMode=2&VSWPPs='.$options['shop_pass']. '&category=' . self::argToApi($cat) . '&VSWPIcon=' . self::argToApi($image_name) ,$options, $options['shop_lang'],$msg); 
		return self::admin_json_res($res,$msg);
	}
	
	static public function get_categories($lang='', &$msg = null){
		$root = false;
		$res = self::sendReq('&HTTPREQ=14&VSTree=Yes&VSOnlyValid=No&VSChkMigvan=No' . self::getWizCustomerPart(), 
									null, $lang, $msg); 
		if(self::admin_json_res($res,$msg)){
			$root = $res->OutTab[0];
		}
		return $root;
	}
	
	static public function get_items($cat_key, $lang='', &$msg = null){
		$ret = false;
		$res = self::sendReq('&HTTPREQ=8&VSMaxItms=ALL&ItmCategory='. self::argToApi($cat_key) . self::getWizCustomerPart(), 
									null, $lang, $msg); 
		if(self::admin_json_res($res,$msg)){
			$ret = $res;
		}
		return $ret;
	}	

	static public function get_item_info($item_key, $lang='', &$msg = null){
		$ret = false;
		$res = self::sendReq('&HTTPREQ=15&VSGetItmCats=Yes&VSSetsEx=Yes&SingleItem='. self::argToApi($item_key). self::getWizCustomerPart(), 
									null, $lang, $msg); 
		if(self::admin_json_res($res,$msg)){
			$ret = $res;
		}
		return $ret;
	}	
	
	static public function get_definitions(&$msg = null){
		$def = false;
		$res = self::sendReq('&HTTPREQ=30&VSDefFull=Yes',null, null, $msg); 
		if(self::admin_json_res($res,$msg)){
			$def = $res;
		}
		return $def;
	}

	static public function getWizCustomerCookie(){ 
		global $wizshop_settings;
		$options = wizshop_get_option($wizshop_settings['name']);		
		$id = 'Cust_'. wizshop_validate_uc($options['shop_id']);
		return isset($_COOKIE[$id]) ? $_COOKIE[$id] :'' ;
	}
	
	static public function getWizCustomerPart($pref = '&'){ 
		$cook = self::getWizCustomerCookie();
		$cus_id = ''; 
		if (isset($cook)) {
			$cus_id = $pref .'WizCustomer='. $cook .'xxxx';
		}
		return $cus_id;
	}		
	
	static function admin_json_res($res,&$msg){
		$ret = false;
		if(false !== $res && is_object($res)){
			if($res->Status != 'OK'){
				if(!is_null($msg)) $msg = $res->Msg;
			}else{
				$ret = true;
			}
		}else{
			if(!is_null($msg)){
				$msg = ( __('Failed to connect to WizShop server.',WizShop) . (("" != $msg) ? PHP_EOL . $msg : ""));
			}
		}	
		return $ret;
	}
	
}; 
?>