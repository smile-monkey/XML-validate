<?php
/*
 * Plugin Name: XML Validate
 * Version: 1.0.0
 * Plugin URI: https://github.com/smile-monkey/XML-validate
 * Description: 
 * Author: Web Expert
 * Author URI: https://github.com/smile-monkey/XML-validate
 * Tested up to: 
 *
 * Text Domain: XML Validate
 * 
 */
/*  Copyright 2017	Web Expert  (email : smilemonkey1230@outlook.com)

 * This program is free software
*/
if ( ! defined( 'ABSPATH' ) ) exit;

if (!class_exists(XML_VALIDATE)){
	class XML_VALIDATE {

		function __construct(){

			add_action( 'wp_enqueue_scripts', array(&$this,'xml_validate_init'));
			add_shortcode( 'xml-validate', array( &$this, 'xml_validate_shortcode' ));
		}
		
		function xml_validate_init(){
			wp_enqueue_script( 'xml-validate-js', plugins_url( '/js/xml_validate.js' , __FILE__ ), array( 'jquery' ),"1.0");
			wp_enqueue_style( 'xml-validate-css', plugins_url('/css/xml_validate.css', __FILE__),15);
		}		

		/**
		* [xml-validate]
		*/
		function xml_validate_shortcode($content) {
			$xml_form = $content;
			$xml_form .= '';
			return $xml_form;
		}		
	}
}
/**
 * 
 */
if (isset( $_POST['download_btn'] ) ) {
    try {

    } catch (Exception $ex) {
        echo "error";
    }
}

$xml_validate = new XML_VALIDATE();
?>