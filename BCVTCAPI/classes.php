<?php
///////////////////////////////////////
// Développé et créé par :
// AHMED LAGGOUN © 2016
// Ahmedlaggoun.com
// Ahmed@creative-ids.com
//
//
// Documentation de l'API BCVTC 
// http://www.bcvtc.fr/docs/api.php
//
//
///////////////////////////////////////

class BCBuilder
{
	public $APIkey;
	public $SECRETkey;
	
	function __construct($APIkey,$SECRETkey)
	{
		$this->APIkey = $APIkey;
		$this->SECRETkey = $SECRETkey;
	}
	
	public function PrepareData($post)
	{
		$BookingData['key'] 			= $this->APIkey;
		$BookingData['secret'] 			= $this->SECRETkey;
		$BookingData['civ'] 			= $post ['Civ'];
		$BookingData['name'] 			= $post ['Name'];
		$BookingData['surname']			= $post ['SurName'];
		$BookingData['email'] 			= $post ['ClientEmail'];
		$BookingData['addclient'] 		= "n";                 // Ajouter ce client à votre liste ( y / n )
		$BookingData['phone'] 			= $post ['Tel'];
		$BookingData['pax'] 			= $post ['Pax'];
		$BookingData['FullDate'] 		= $post ['PickDate'].' '.$post ['PickTime'];
		$BookingData['date'] 			= $post ['PickDate'];
		$BookingData['time'] 			= $post ['PickTime'];	
		$BookingData['pickup'] 			= $post ['PickUp'];
		$BookingData['dropoff']			= $post ['DropOff'];
		$BookingData['km'] 				= $post ['TripKM'];
		$BookingData['minutes'] 		= $post ['TripTIME'];
		
		if($post ['TripType'] === '1.1')// 1.1 = Déplacement & 1.2 = Mise à dispo
		{
			$BookingData['type'] 			= 'd'; 
		}
		else
		{
			$BookingData['type'] 			= 'm';
		}
		$BookingData['ttc'] 			= number_format($post ['TTCprice'],2,'.','');      
		$BookingData['payment'] 		= $post ['Payment'];
		
		return $BookingData;
	}

}

class BCBridge
{
	public $Data;
	public $Access;
	function __construct($Data)
	{
		$this->Data = $Data;
	}
	public function CreatTicket()
	{
		if(function_exists('curl_version'))
		{

		  $curl = curl_init();
		  curl_setopt_array($curl,[
		  
			  CURLOPT_RETURNTRANSFER => 1,
			  
			  CURLOPT_URL => "http://www.bcvtc.fr/api/createticket/",
			  
			  CURLOPT_POST => 1,
			  
			  CURLOPT_SSL_VERIFYPEER => 0,
			  
			  CURLOPT_POSTFIELDS => http_build_query($this->Data)
			  
		  ]);
		  $res = curl_exec($curl);
		  echo $res;
		  curl_close($curl);
		}
	}
}

class BCGate
{
	public $APIkey;
	public $SECRETkey;
	
	function __construct($APIkey, $SECRETkey)
	{
		$this->APIkey = $APIkey;
		$this->SECRETkey = $SECRETkey;
	}
	
	public function GetInfos()
	{
		if(function_exists('curl_version'))
		{

		  $curl = curl_init();
		  curl_setopt_array($curl,[
		  
			  CURLOPT_RETURNTRANSFER => 1,
			  			  
			  CURLOPT_URL => "http://www.bcvtc.fr/api/user/key={$this->APIkey}&secret={$this->SECRETkey}",
			  
			  CURLOPT_SSL_VERIFYPEER => 0,

		  ]);
		  $res = json_decode(curl_exec($curl),true);
		  return $res;
		  curl_close($curl);
		}
	}
}

class BCTicket
{
	public $APIkey;
	public $SECRETkey;
	
	function __construct($APIkey, $SECRETkey)
	{
		$this->APIkey 		= $APIkey;
		$this->SECRETkey 	= $SECRETkey;
	}
	public function Ticket($TicketID)
	{
		if(function_exists('curl_version'))
		{

		  $curl = curl_init();
		  curl_setopt_array($curl,[
		  
			  CURLOPT_RETURNTRANSFER => 1,
			  			  
			  CURLOPT_URL => "http://www.bcvtc.fr/api/ticket/key={$this->APIkey}&secret={$this->SECRETkey}&ticket={$TicketID}",
			  
			  CURLOPT_SSL_VERIFYPEER => 0,

		  ]);
		  $res = curl_exec($curl);
		  return $res;
		  curl_close($curl);
		}
	}
}
?>