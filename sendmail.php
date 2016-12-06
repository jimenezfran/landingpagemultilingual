<?php
// Who you want to recieve the emails from the form.
$sendto = 'info@alfacamp.com';

// The subject you'll see in your inbox
if($_REQUEST["tipe"])
{
$subject = 'Formulario '.$_REQUEST["tipe"];
}
else
{
$subject = 'Formulario admisiones';
}

$subject.=" ".$_REQUEST["provincia"];
// Message for the user when he/she doesn't fill in the form correctly.
$errormessage = 'Looks like you are missing some info. Try again.';

//Message for the user when he/she fills in the form correctly.
$thanks = "Thanks for the email. We'll get back to you as soon as we can.";

// Message for the bot when it fills in in at all.
$honeypot = "You filled in the honeypot! If you're human, try again!";

// Various messages displayed when the fields are empty.
$emptyname =  'Entering your name?';
$emptyemail = 'Entering your email address?';
$emptymessage = 'Entering a message?';

// Various messages displayed when the fields are incorrectly formatted.
$alertname =  'Entering your name using only the standard alphabet?';
$alertemail = 'Entering your email in this format: <i>name@example.com</i>?';
$alertmessage = "Making sure you aren't using any parenthesis or other escaping characters in the message? Most URLS are fine though!";

$alert = '';
$pass = 0;

function clean_var($variable) {
	$variable = strip_tags(stripslashes(trim(rtrim($variable))));
	$variable=utf8_decode($variable);
  return $variable;
}

if ( empty($_REQUEST['last']) ) {

  if ( empty($_REQUEST['name']) ) {
	$pass = 1;
	$alert .= "<li>" . $emptyname . "</li>";
	$alert .= "<script>jQuery(\"#name\").addClass(\"error\");</script>";
  } elseif ( ereg( "[][{}()*+?.\\^$|]", $_REQUEST['name'] ) ) {
	$pass = 1;
	$alert .= "<li>" . $alertname . "</li>";
  }
  if ( empty($_REQUEST['email']) ) {
	$pass = 1;
	$alert .= "<li>" . $emptyemail . "</li>";
	$alert .= "<script>jQuery(\"#email\").addClass(\"error\");</script>";
  } elseif ( !eregi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$", $_REQUEST['email']) ) {
	$pass = 1;
	$alert .= "<li>" . $alertemail . "</li>";
  }
  /*
  if ( empty($_REQUEST['message']) ) {
	$pass = 1;
	$alert .= "<li>" . $emptymessage . "</li>";
	$alert .= "<script>jQuery(\"#message\").addClass(\"error\");</script>";
  } elseif ( ereg( "[][{}()*+\\^$|]", $_REQUEST['message'] ) ) {
	$pass = 1;
	$alert .= "<li>" . $alertmessage . "</li>";
  }
*/
  if ( $pass==1 ) {

  echo "<script>$(\".message\").toggle();$(\".message\").toggle().hide(\"slow\").show(\"slow\"); </script>";
  echo "<script>$(\".alert\").addClass('alert-block alert-error').removeClass('alert-success'); </script>";
  echo $errormessage;
  echo $alert;

  } elseif (isset($_REQUEST['name'])) {

	$message = "From: " . clean_var($_REQUEST['name']) . "\n";
	$message .= "Email: " . clean_var($_REQUEST['email']) . "\n";
	$message .= "Telefono: \n" . clean_var($_REQUEST['telefono'])."\n";
	$message .= "Empresa: \n" . clean_var($_REQUEST['empresa'])."\n";
	$message .= "URL: \n" . clean_var($_REQUEST['empresaURL'])."\n";

	if($_REQUEST['idea'])
	{
		$message .= "Idea: \n" . clean_var($_REQUEST['idea'])."\n";
	}
	if($_REQUEST['problema'])
	{
		$message .= "Problema: \n" . clean_var($_REQUEST['problema'])."\n";
	}
	if($_REQUEST['capacidad'])
	{
		$message .= "Capacidad: \n" . clean_var($_REQUEST['capacidad'])."\n";
	}
	if($_REQUEST['dinero'])
	{
		$message .= "Dinero: \n" . clean_var($_REQUEST['dinero'])."\n";
	}
	if($_REQUEST['herramientas'])
	{
		$message .= "Herramientas: \n" . clean_var($_REQUEST['herramientas'])."\n";
	}
	if($_REQUEST['tiempo'])
	{
		$message .= "Tiempo: \n" . clean_var($_REQUEST['tiempo'])."\n";
	}
	if($_REQUEST['mal'])
	{
		$message .= "Mal: \n" . clean_var($_REQUEST['mal'])."\n";
	}
	if($_REQUEST['fundadores'])
	{
		$message .= "Fundadores: \n" . clean_var($_REQUEST['fundadores'])."\n";
	}
	if($_REQUEST['cuando_fundadores'])
	{
		$message .= "Desde cuando: \n" . clean_var($_REQUEST['cuando_fundadores'])."\n";
	}
	if($_REQUEST['mudarte'])
	{
		$message .= "Mudarte: \n" . clean_var($_REQUEST['mudarte'])."\n";
	}

$message .= "Message: \n" . clean_var($_REQUEST['message']);
	$header = 'From:'. clean_var($_REQUEST['email']);

	mail($sendto, $subject, $message, $header);
	echo "<script>$(\".message\").toggle();$(\".message\").toggle().hide(\"slow\").show(\"slow\");$('#contactForm')[0].reset();</script>";
	echo "<script>$(\".alert\").addClass('alert-block alert-success').removeClass('alert-error'); </script>";
	echo $thanks;
	echo "<script>jQuery(\"#name\").removeClass(\"error\");jQuery(\"#email\").removeClass(\"error\");jQuery(\"#message\").removeClass(\"error\");</script>";
	die();

	echo "<br/><br/>" . $message;

	}

} else {
  echo "<script>$(\".message\").toggle();$(\".message\").toggle().hide(\"slow\").show(\"slow\"); </script>";
  echo $honeypot;
}
?>
