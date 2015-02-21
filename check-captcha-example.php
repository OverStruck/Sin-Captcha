<?php
	session_start();
	
	if ($_POST['customName'] === $_SESSION['sin-captcha'])
		echo 'Correct Answer!';
	else
		echo 'Sorry try again...<br>Correct Answer: ' , $_SESSION['sin-captcha'];
	
	session_unset();
	session_destroy(); 
?>