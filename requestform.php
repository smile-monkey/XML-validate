<?php
session_start();
// Start the session
$responseURL = "http://ebizforall.com/responseform.php";
$url = 'https://api-cyprus.validex.net/api/validate';
//$url = "https://api.validex.net/validate/";
$apikey = "829c3804401b0727f70f73d4415e162400cbe57b";
$headers = array('Content-Type: multipart/form-data','Authorization: apikey=39c70bcd75fa5020ed001dc9a28c22a0');
//$header = array('Content-Type: application/json','Authorization: apikey=829c3804401b0727f70f73d4415e162400cbe57b');
$filename = $_FILES['filename']['name'];
$filedata = $_FILES['filename']['tmp_name'];
$filesize = $_FILES['filename']['size'];
$fields = array("filedata" => "@$filedata", "filename" => $filename);
//$fields = array('filename' => '@' . $_FILES['filename']['tmp_name'][0]);
//$token = 'NfxoS9oGjA6MiArPtwg4aR3Cp4ygAbNA2uv6Gg4m';
 
$resource = curl_init();
$options = array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => true,
        CURLOPT_POST => 1,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => $fields,
        CURLOPT_INFILESIZE => $filesize,
        CURLOPT_RETURNTRANSFER => true
    ); // cURL options
curl_setopt_array($resource, $options);
/*curl_setopt($resource, CURLOPT_URL, $url);
curl_setopt($resource, CURLOPT_HTTPHEADER, $header);
curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
curl_setopt($resource, CURLOPT_POST, 1);
curl_setopt($resource, CURLOPT_POSTFIELDS, $fields);*/
//$result = json_decode(curl_exec($resource));
$result = curl_exec($resource);
curl_exec($resource);
if(!curl_errno($ch))
{
	$info = curl_getinfo($resource);
	if ($info['http_code'] == 200)
	$errmsg = "File uploaded successfully";
}
else
{
	$errmsg = curl_error($resource);
}
curl_close($resource);
?>

<form method="post" action="" enctype="multipart/form-data">
Upload your file here
    <input name="filename" id="filename" type="file" />
    <input type="submit" value="Upload" />
	<input type="hidden" name="MerRespURL" value="<?= $responseURL ?>"><br>
</form>