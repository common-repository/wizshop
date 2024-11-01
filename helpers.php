<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*----------------------------*/ 
/* helpers					  */
/*----------------------------*/ 

//------------------------------------------------------------
function wizshop_is_reg_customer() {
	global $wizshop_plugin;
	return (0 != $wizshop_plugin->isCustRegistered());
}
//------------------------------------------------------------
function wizshop_is_b2b_customer() {
	global $wizshop_plugin;
	return (1 == $wizshop_plugin->isCustRegistered());
}
//------------------------------------------------------------
function wizshop_is_b2c_customer() {
	global $wizshop_plugin;
	return (2 == $wizshop_plugin->isCustRegistered());
}
//------------------------------------------------------------
function wizshop_b2b_customer_details() {
	global $wizshop_plugin;
	return $wizshop_plugin->getB2BSCustDet();
}
?>