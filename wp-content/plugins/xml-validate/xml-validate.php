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
		    $xml_url = '';
		    if (isset($_FILES['xml_file'])){
				// session_start();
				// Start the session
				$url = 'https://api-cyprus.validex.net/api/validate';
				//$url = "https://api.validex.net/validate/";
				$headers = array('Content-Type: application/json','Authorization: apikey=39c70bcd75fa5020ed001dc9a28c22a0');
				$filename = $_FILES['xml_file']['name'];
				$filedata = $_FILES['xml_file']['tmp_name'];
				$filesize = $_FILES['xml_file']['size'];
				$fields = array("filedata" => "@$filedata", "filename" => $filename);
				//$fields = array('filename' => '@' . $_FILES['xml_file']['tmp_name'][0]);
				//$token = 'NfxoS9oGjA6MiArPtwg4aR3Cp4ygAbNA2uv6Gg4m';
				 
				$ch = curl_init();
				$options = array(
				        CURLOPT_URL => $url,
				        CURLOPT_HEADER => true,
				        CURLOPT_POST => 1,
				        CURLOPT_HTTPHEADER => $headers,
				        CURLOPT_POSTFIELDS => $fields,
				        CURLOPT_INFILESIZE => $filesize,
				        CURLOPT_RETURNTRANSFER => true
				    ); // cURL options
				curl_setopt_array($ch, $options);
				$result = curl_exec($ch);
				if(!curl_errno($ch))
				{
					$info = curl_getinfo($ch);
					if ($info['http_code'] == 200)
					$errmsg = "File uploaded successfully";
				}else
				{
					$errmsg = curl_error($ch);
				}
				curl_close($ch);
				var_dump($errmsg);exit;
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

$xml_validation = new XML_VALIDATE();
?>