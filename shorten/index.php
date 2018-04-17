<?php
//~ die("/shorten/index.php");
//~ echo "<pre>"; print_r($_SERVER); die();
require_once $_SERVER['DOCUMENT_ROOT'].'/shorten/settings.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/shorten/classes/Autoload.php';

use \shorten\classes\DbConnection;
use \shorten\classes\Shorten;

if(isset($_GET['_path']) && @$_GET['_path']!=''){
	
	$shorten = new Shorten();
	$url = $shorten->getUrl($_GET['_path']);

	if($url){
		header('location: '.$url);
		$message = 'REDIRECT to '.$url;	
	} else {
		$message = 'This tiny URL does not exist.';	
	}
		
} else {
	switch(@$_GET['_action']){

		case 'add':
			$shorten = new Shorten();
			$shortUrl = $shorten->url($_POST['url']);
			$message = $shortUrl;
			break;
		default:
			break;
		
	}
}

?><!DOCTYPE>
<html>
<head>
<title>Shorten URL</title>
<style>
body {
	text-align: center;
	font-family: 'Arial';
	padding: 100px 0;
	max-width: 1170px;
	margin: auto;
}	
input[type="submit"] {
	padding: 10px 20px;
	margin: 20px 0;
	border: none;
	background-color: #2196f3;
	color: #fff;
	text-shadow: 0px 0px 40px #6b6b6b;
	font-size: 18pt;
	border-radius: 10px;
}
input[type="text"] {
	padding: 10px;
	border-radius: 10px;
	font-size: 18pt;
	border: 2px solid #e9e9e9;	
}
h1 {
	font-weight: 300;
	color: #666;
}
h2 {
	font-weight: 300;
	color: #da3e32;
}
</style>
</head>
<body>
	<h1>Tiny URL Generator</h1>
	<?php echo (isset($message)?'<h2>'.$message.'</h2>':'')?>
	<form action="/?_action=add" method="post">
		<input type="text" name="url" placeholder="Enter URL"><br>
		<input type="submit" value="Generate">
	</form>
</body>
</html>