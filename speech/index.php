<?php

require_once 'includes/dbh.inc.php';
require 'includes/incoming.php';

$voice = new COM("SAPI.SpVoice"); //microsoft text to voice 
$rate = -1.5; //speed of voice
$voice->Rate = $rate;
$voices = $voice->GetVoices();
$desiredVoiceName = "Microsoft Zira Desktop";
foreach ($voices as $voic) {
	if (strpos($voic->GetDescription(), $desiredVoiceName) !== false) {
		$voice->Voice = $voic;
		break;
	}
}



if (!isset($_SESSION['hasShownMessage'])) {

	$starting = "Sir glad to see you back here . Connecting to satellite number 20 . Refreshing the database.";
	$passkey = "Your passkey is required to continue";

	$voice->Speak($starting);
	sleep(2); // Adjust the sleep duration as needed

	$voice->Speak($passkey);

	$_SESSION['hasShownMessage'] = true;
}


if (isset($_GET['result'])) {
	$result1 = $_GET['result'];
	if ($result1 == 1) {
		$file = "includes/result.txt";
		$result = file_get_contents($file);
		$voice->Speak($result);
	} else {
		$voice->Speak($result1);
	}
}
if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($submit) and !empty($word)) {
	$voice->Speak($word);
}
?>


<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="robots" content="noindex, nofollow">
	<title>JARVIS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="img/fav.png" type="image/png">
	<link href="css/style.css" rel="stylesheet">
</head>

<body>

	<br><br><br><br><br><br><br><br><br><br><br><br>
	<style>
		#inputField {
			border-color: none !important;
			border: none !important;
			outline: none;
		}

		#inputField:active {
			border-color: none !important;
			border: none !important;
			outline: none;
		}

		input:focus {
			border: none !important;
			border-color: none !important;

			outline: none;
		}
	</style>
	<center>
		<?php
		if (isset($_GET['result'])) {
			if ($_GET['result'] == "key") {
				echo "<h1>Please enter the access key</h1>";
			}
		}

		?>
		<h1>Press window key and H to unable the voice input</h1>
		<form id="myForm" action="includes/incoming.php" method="post">
			<input style="width:800px;" type="text" name="inputField" id="inputField">
		</form>
	</center>


	<script>
		let inputField = document.getElementById('inputField');
		let form = document.getElementById('myForm');
		let typingTimeout;

		// Function to submit the form
		function submitForm() {
			form.submit();
		}
		var input = document.getElementById('inputField');
		input.focus();
		input.select();
		inputField.addEventListener("blur", function (event) {
			event.preventDefault();
			inputField.focus();
		});
		// Listen for input changes
		inputField.addEventListener('input', function () {
			clearTimeout(typingTimeout); // Clear the previous timeout
			typingTimeout = setTimeout(submitForm, 2000); // Adjust the delay (milliseconds) as needed
		});


	</script>

</body>

</html>