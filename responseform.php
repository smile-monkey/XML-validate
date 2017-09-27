<?php
session_start();
echo '<pre>';
print_r( $_POST);
die();
// Continue the session
$theResult = $_POST['result'];

?>
<html>
<head>
<title>Response | Validex</title>
</head>
<body>

<table>
	
<p style="text-align: center;">
	Date: <?= date("Y/m/d")?><br>
	Response: <?= $theResult?><br></p>
<?php
//remove all session variables
session_unset();
//destroy the session
session_destroy();
?>
</table>
<p style="text-align:center"><a href="http://ebizforall.com">back to homepage</a><p>
<p style="text-align:center">&copy; 2017 ebizforall Ltd. All rights reserved.</p>
</body>
</html>