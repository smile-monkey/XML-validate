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

			add_action( 'wp_enqueue_scripts', array(&$this,'xml_enqueue_init'));
			add_shortcode( 'xml-validate', array( &$this, 'xml_validate_shortcode' ));
			// Ajax define.
			add_action( 'wp_ajax_validation_xml', array(&$this,'validation_xml'));			
			add_action( 'wp_ajax_nopriv_validation_xml', array(&$this,'validation_xml'));			
		}
		
		function xml_enqueue_init(){
			wp_enqueue_script( 'xml-validate-js', plugins_url( '/js/xml_validate.js' , __FILE__ ), array( 'jquery' ),"1.0");
			wp_enqueue_style( 'xml-validate-css', plugins_url('/css/xml_validate.css', __FILE__),15);
			wp_localize_script( 'xml-validate-js', 'ajax_obj' , array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
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
	                            <p>Drag and drop .xml file here</p>
	                            <span class="file-wrapper">
								  <input type="file" name="photo" id="photo" onchange="select_file(this.files);"/>
								  <span class="button">Browse...</span>
								</span>
	                            <span class="browse-label"></span>
	                        </div>
	                        <div class="pull-right">
			                    <button type="button" class="clear_btn" onclick="clear_file();"><span class="text-muted">Clear</span></button>
			                </div>
                    	  </div>';
			$xml_form .= '<div class="validation_div">
							<button type="button" class="validation_btn">Validation</button>
							<div class="validation_result">Select the XML file for validation and upload it</div>
						   </div>';

			$xml_form .= '</form>';
			return $xml_form;
		}		

		function validation_xml() {
		    $response = array();
		    $xml_url = '';var_dump($_FILES);
		    if (isset($_FILES['xml_file'])){
		        $upload_dir="../wp-content/uploads/";
		        $dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;
		        
		        $upload_dir.="xml/";
		        $dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;
		        
		        $file_name = $_FILES['xml_file']['name'];
					
		        $filename = pathinfo($file_name, PATHINFO_FILENAME);
		        $ext = pathinfo($file_name, PATHINFO_EXTENSION);			
		        
		        $save_name = time().'_'.$filename;
		        $upload_file = $save_name.'.'.$ext;
		        $upload_path = $upload_dir.$upload_file;
		        // upload xml_file
		        move_uploaded_file($_FILES['xml_file']['tmp_name'], $upload_path);
		        $xml_url = $upload_path;
		    }
		    if($xml_url) {
		        $response['status'] = "success";
		        $response['xml_url'] = $xml_url;
		    }else {
		        $response['status'] = "fail";
		    }
		    echo json_encode($response);
			exit();
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