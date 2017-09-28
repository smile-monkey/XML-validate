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

				$url = 'https://api-cyprus.validex.net/api/validate';
				$headers = array('Content-Type: application/json','Authorization: apikey=39c70bcd75fa5020ed001dc9a28c22a0');
				$filename = $_FILES['xml_file']['name'];
				$filepath = $_FILES['xml_file']['tmp_name'];
				$filesize = $_FILES['xml_file']['size'];

				$contents = file_get_contents($filepath);
				
				$fileContents64 = base64_encode($contents);

				// var_dump($fileContents64);exit;

				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_HEADER, FALSE);
				curl_setopt($ch, CURLOPT_POST, TRUE);
				curl_setopt($ch, CURLOPT_POSTFIELDS, {
					"userId:2",
					"forced":{
						"documentTypes":[
						"doc/xml",
						"doc/xml/ubl2",
						"doc/xml/ubl2/inv",
						"doc/xml/ubl2/inv/bii2",
						"doc/xml/ubl2/inv/bii2/t10",
						"doc/xml/ubl2/inv/bii2/t10/p05",
						"doc/xml/ubl2/inv/bii2/t10/p05/peppol"
						]
				    },
				    "filename": $filename,
				    "fileContents": $contents,
				    "fileContents64": $fileContents64
				});

				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

				$response = curl_exec($ch);
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
				var_dump($response);exit;				
		    }

		 //    if($xml_url) {
		 //        $response['status'] = "success";
		 //        $response['xml_url'] = $xml_url;
		 //    }else {
		 //        $response['status'] = "fail";
		 //    }
		 //    echo json_encode($response);
			// exit();
		}
	}
}

$xml_validation = new XML_VALIDATE();
?>