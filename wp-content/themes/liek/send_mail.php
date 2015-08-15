<?php
$sent = false;

function isValid() {
	return
		!empty($_POST['name'])
		&& !empty($_POST['email'])
		&& !empty($_POST['telephone']);
}

if (isValid()) {
	$headers  = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
	$headers .= "From: contact@aqua-proof.me" . "\r\n";

	$template = "
	<html>
	<head>
		<title>Aqua-proof Contact Form</title>
		<style>
			body { font-family: Arial, Helvetica, sans-serif; }
			label { font-weight: bold; }
		</style>
	</head>
	<body>
		%message%
	</body>
	</html>";

	$message = "<h1>Contact Form</h1>";
	$message .= "<h2>".htmlspecialchars($_POST['name'])."</h2>";
	$message .= "<p><label>Email: </label><a href='mailto:".htmlspecialchars($_POST['email'])."'>".htmlspecialchars($_POST['email'])."</a></p>";
	$message .= "<p><label>Phone: </label>".htmlspecialchars($_POST['telephone'])."</p>";
	if (isset($_POST['code'])) {
		$message .= "<p><label>Voucher Code: </label>".htmlspecialchars($_POST['code'])."</p>";
	}
	if (isset($_POST['address'])) {
		$message .= "<p><label>Address: </label>".htmlspecialchars($_POST['address'])."</p>";
	}
	$message .= "<p><label>Postcode: </label>".htmlspecialchars($_POST['postcode'])."</p>";
	$message .= "<label>Message: </label>";
	$message .= "<p>".str_replace("\r\n", "<br/>", htmlspecialchars($_POST['message']))."</p>";

	$sent = mail($_POST['mailto'], $_POST['subject'], str_replace('%message%', $message, $template), $headers);
}

print($sent ? 'success' : 'error');
?>