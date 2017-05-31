<?php
	session_start();
	// Pear Mail Library
	require_once "Mail.php";
	require_once "enc_dec.php";
	
	
	if(isset($_GET['email']) )
	{
		$from = 'sender@gmail.com';       // Sender
		$to = $_GET['email'];                     // Reciver
		
		$crypted = fnEncrypt($_SESSION["data"], $Pass);		
	
		$subject = 'Hi!';
		$body = "Hi,\n\nhttp://localhost/myWork/chart-pdf/figure2.php?data=".$crypted;

		$headers = array(
			'From' => $from,
			'To' => $to,
			'Subject' => $subject
		);

		$smtp = Mail::factory('smtp', array(
				'host' => 'smtp.gmail.com',
				'port' => '587',
				'auth' => true,
				'username' => 'sender@gmail.com',
				'password' => 'password'
			));

		$mail = $smtp->send($to, $headers, $body);

		if (PEAR::isError($mail)) {
			echo( $mail->getMessage() );
		} else {
			echo('Message successfully sent!');
		}
	}
	

?>