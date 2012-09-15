<?php
/**
 * Formatting functions for taking care of proper number formats and such
 *
 * @package     Easy Digital Downloads
 * @subpackage  Formatting functions
 * @copyright   Copyright (c) 2012, Pippin Williamson
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.1.9
*/



/**
 * Format Amount
 *
 * Returns a nicely formatted amount.
 *
 * @access      public
 * @since       1.0
 * @param       $amount string the price amount to format
 * @param       $options array optional parameters, used for defining variable prices
 * @return      string - the newly formatted amount
*/

function edd_format_amount($amount) {
	global $edd_options;
	$thousands_sep 	= isset($edd_options['thousands_separator']) 	? $edd_options['thousands_separator'] 	: ',';
	$decimal_sep 	= isset($edd_options['decimal_separator']) 		? $edd_options['decimal_separator'] 	: '.';

	// sanitize the amount
	if( false !== ( $comma_found = strpos( $amount, ',' ) ) )
		$amount = substr( $amount, 0, $comma_found );

	if( false !== ( $period_found = strpos( $amount, ',' ) ) )
		$amount = substr( $amount, 0, $period_found );

	return number_format($amount, 2, $decimal_sep, $thousands_sep);
}



/**
 * Formats the currency display
 *
 * @access      public
 * @since       1.0 
 * @return      array
*/

function edd_currency_filter( $price ) {
	global $edd_options;
	$currency = isset($edd_options['currency']) ? $edd_options['currency'] : 'USD';
	$position = isset($edd_options['currency_position']) ? $edd_options['currency_position'] : 'before';
	if($position == 'before') :
		switch ($currency) :
			case "GBP" : return '&pound;' . $price; break;
			case "USD" : 
			case "AUD" : 
			case "BRL" : 
			case "CAD" : 
			case "HKD" : 
			case "MXN" : 
			case "SGD" : 
				return '&#36;' . $price; 
			break;
			case "JPY" : return '&yen;' . $price; break;
			default :
			    $formatted = $currency . ' ' . $price;
    		    return apply_filters('edd_' . strtolower($currency) . '_currency_filter_before', $formatted, $currency, $price);
			break;
		endswitch;
	else :
		switch ($currency) :
			case "GBP" : return $price . '&pound;'; break;
			case "USD" : 
			case "AUD" : 
			case "BRL" : 
			case "CAD" : 
			case "HKD" : 
			case "MXN" : 
			case "SGD" : 
				return $price . '&#36;'; 
			break;
			case "JPY" : return $price . '&yen;'; break;
			default : 
			    $formatted = $price . ' ' . $currency;
			    return apply_filters('edd_' . strtolower($currency) . '_currency_filter_after', $formatted, $currency, $price);
			break;
		endswitch;	
	endif;
}