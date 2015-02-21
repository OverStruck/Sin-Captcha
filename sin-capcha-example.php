<?php
	session_start(); //we use sessions to save the answer to our captcha
	
	//require sin capcha class file
	require 'sin-captcha.class.php';
	
	//example of how to override default settings
	//in this case we just add our own custom class
	$sin_captcha_config = array(
		'btn_class' => 'bntClass',
		'btn_name' => 'customName'
	);

	$captcha = new SinCaptcha($sin_captcha_config);
	$captcha = $captcha -> generate();
	//save answer
	$_SESSION['sin-captcha'] = (string)$captcha['answer'];
	
	//in the page itself we want to show the user the "answer" (what number to click)
	//then we want to output the generated buttons too
	//these information is the in the $captcha array varible
	$output = <<<EOD
	<!DOCTYPE html>
	<html>
	<head>
		<title>Sin Capcha Example</title>
		<style>.bntClass{padding:5px;font-size:30px;}</style>
	</head>
	<body>	
	<form action="check-captcha.php" method="POST">
		<h1>Click $captcha[answer] to continue</h1>
		$captcha[buttons]
	</form>
	</body>
	</html>
EOD;

	echo $output;
?>