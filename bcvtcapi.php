<?php
///////////////////////////////////////
// Développé et créé par :
// AHMED LAGGOUN © 2016
// Ahmedlaggoun.com
// Ahmed@creative-ids.com
//
//
// Utilisez ce fichier pour accueillir les informations envoyées via la méthode ($_POST)
// Nous avons ajouté un filtre classique pour la validation des champs
//
// Documentation de l'API BCVTC 
// http://www.bcvtc.fr/docs/api.php
//
///////////////////////////////////////

if(session_status()!==PHP_SESSION_ACTIVE) {@session_start();}
require_once('BCVTCAPI/classes.php');

$APIkey = 'API_KEY'; 							// <------------ VOTRE CLE API
		
$SECRETkey = 'SECRET_KEY'; 						// <------------ VOTRE CLE SECRET

$EmailAddress = "votreadressemail@site.com"; 	// <------------ VOTRE ADRESSE EMAIl POUR LA PAGE CONTACT
		
$APIclass = new BCBuilder($APIkey,$SECRETkey);

// CreateNew Ticket
if(isset($_POST) && isset($_POST['Token']) && isset($_SESSION['Token']) && $_SESSION['Token'] === $_POST['Token'])
{	
	
	$A = false;
	$B = false;
	$required = array('PickUp', 'DropOff', 'PickDate','PickTime', 'TripType', 'Payment', 'TTCprice', 'TripKM', 'TripTIME', 'Civ', 'Name', 'SurName', 'Pax', 'Tel', 'ClientEmail');
	foreach($required as $field)
	{
		if(!empty($_POST[$field]))
		{
			$A = true;
		}
	}
	if(filter_var($_POST['ClientEmail'],FILTER_VALIDATE_EMAIL))
	{
		$B = true;
	}

	if($A && $B)
	{
		
		$Data = $APIclass->PrepareData($_POST);
		
		$IntiBridge = new BCBridge($Data);
		
		$IntiBridge->CreatTicket();
	}
	
}

// GetTicket Infos
if(isset($_GET['TicketID']) && isset($_SESSION['Token']) && $_SESSION['Token'] === $_GET['Token'] && $_GET['TicketID']!=="")
{
	$initTICKET = new BCTicket($APIkey,$SECRETkey);
	echo $initTICKET->Ticket($_GET['TicketID']);
}

// Send Email
if(isset($_POST['ContactMessage'])  && !empty($_POST['ContactMessage']) && isset($_POST['SenderName'])  && !empty($_POST['SenderName'])&& isset($_POST['ContactEmail']) && filter_var($_POST['ContactEmail'],FILTER_VALIDATE_EMAIL)&& isset($_POST['ContactToken']) && isset($_SESSION['Token']) && $_SESSION['Token'] === $_POST['ContactToken'])
{
		 $to = $EmailAddress;
		 
         $subject = "Message depuis votre site de la part de ".$_POST['SenderName']."";
		 
         $message = $_POST['ContactMessage'];
         
         $header = "From:".$_POST['ContactEmail']." \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
         
         if( $retval == true ) {
            echo "sent";
         }else {
            echo "failed";
         }
}
?>