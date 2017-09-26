<?php
/*
 * Plugin Name: XML Validate
 * Version: 1.0.0
 * Plugin URI: https://github.com/smile-monkey/XML-validate
 * Description: This is a plugin to provide a page to upload an XML which is an electronic invoice for users to validate it. The following shortcode is used for XML Validation: [xml-validate]
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
			$xml_form .= '<div class="page-header"><h1>XML Document Validation</h1></div>';
			$xml_form .= '<form enctype="multipart/form-data" method="post">';
			$xml_form .= '<div class="form-title">Select the XML file for validation and upload it</div>';
			$xml_form .= '<div class="text-center" id="drag-drop-zone">
	                        <div class="text-center" id="drag-drop-text">
	                            <p>Drag and drop a file here</p>
	                            <label class="form-inline browse-label">If you prefer you can also</label>
	                            <span class="file-wrapper">
								  <input type="file" name="photo" id="photo" />
								  <span class="button">Browse...</span>
								</span>
	                        </div>
	                        <div class="pull-right">
			                    <button type="button" class="btn btn-default" onclick="javascript:$('."'vdx-result-line'".
			                ').parent().remove()"><span class="text-muted">Clear</span></button>
			                </div>
                    	  </div>';
			




			$xml_form .= '</form>';
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

$xml_validation = new XML_VALIDATE();
?>