<?php

die();
// BCVTC
// By Ahmed LAGGOUN
// Ahmed at reizon.net

class Api
{
    public $Response;
    
    private $Data;
    
    private $Link;

    public function __construct($Data,$Link)
    {
        $this->Data = $Data;
        $this->Link = $Link;
    }

    public function SendData()
    {
        $curl = curl_init();

            curl_setopt_array($curl,[

                CURLOPT_RETURNTRANSFER => 1,

                CURLOPT_URL => $this->Link,

                CURLOPT_POST => 1,

                CURLOPT_SSL_VERIFYPEER => 0,

                CURLOPT_POSTFIELDS => http_build_query($this->Data)

            ]);

            $response = curl_exec($curl);

            $this->Response = $response;

        curl_close($curl);
    }
    
    public function ReturnResponse()
    {
        return $this->Response;
    }
    
    public function EchoResponse()
    {
        echo $this->Response;
    }
}

class BCVTC
{

    protected static $ApiLink = "http://www.bcvtc.fr/api/v2/";
    
    protected $ApiKey;
    
    public function __construct($ApiKey)
    {
        $this->ApiKey = $ApiKey;
    }

}

class RequestPrice extends BCVTC
{
    public $Endpoint;
    
    public $Data=[];

    public function __construct($ApiKey)
    {
        parent::__construct($ApiKey);
        
        $this->Data["apikey"] = $ApiKey;
        
        $this->Endpoint = BCVTC::$ApiLink."request/";
    }
    
    public function PickUpAddress($value) {
        
        $this->Data["pickupaddress"] = $value;
    }
    
    public function DropOffAddress($value) {
        
        $this->Data["dropoffaddress"] = $value;
    }
    
    public function TripType($value) {
        
        $this->Data["triptype"] = $value;
    }
    
    public function MadKms($value) {
        
        $this->Data["MadKms"] = $value;
    }
    
    public function MadHours($value) {
        
        $this->Data["MadHours"] = $value;
    }
    
    public function Send()
    {       
        $NewApiCall = new Api($this->Data,$this->Endpoint);
        
        $NewApiCall->SendData();
        
        return $NewApiCall->EchoResponse();
    }
}


class Ticket extends BCVTC
{
    
    public $Data =[];
    
    public function __construct($ApiKey)
    {
        parent::__construct($ApiKey);
        
        $this->Data["apikey"] = $ApiKey;
        
        $this->Endpoint = BCVTC::$ApiLink."ticket/";
    }
    
    public function GetTicket($TicketId)
    {      
        $NewApiCall = new Api($this->Data,$this->Endpoint);
        
        $NewApiCall->SendData();
        
        return $NewApiCall->EchoResponse();
    }
}


class Create extends BCVTC
{
    public function __construct($ApiKey)
    {
        parent::__construct($ApiKey);
        
        $this->Data["apikey"] = $ApiKey;
        
        $this->Endpoint = BCVTC::$ApiLink."create/";
    }
    
    public function CreateTicket($Data)
    {
        $Data["apikey"] = $this->ApiKey;
      
        $NewApiCall = new Api($Data,$this->Endpoint);
        
        
        $NewApiCall->SendData();
        
        return $NewApiCall->EchoResponse();
    }
}


$Key = "YOUR_API_KEY";

$data = [
    'request'                   => "1",			
    'client_civ'                => 'Mr',
    'client_first_name'         => "Ahmed",			
    'client_last_name'          => "Laggoun",			
    'client_email'              => 'mail@site.fr',
    'client_phone'              => "0601020304",			
    'client_comment'            => "Bonjour",			
    'paxes'                     => '1',
    'pickupaddress'             => "37 Rue du Rocher, 75008 Paris",			
    'dropoffaddress'            => "50 avenue daumesnil 75012 paris",			
    'triptype'                  => '10',
    'carid'                     => "3",			
    'distancetext'              => "20 kms",			
    'durationtext'              => '20 minutes',
    'price_ht'                  => 20.00,			
    'price_ttc'                 => 20.20,			
    'pay_methode'               => 'es',
    'pickupdatetime'            => '2017-06-03 20:20:20',
    'driverid'                  => '2'
    ];

$CreateTicket = new Create($Key);

$CreateTicket->CreateTicket($data);
        








//$TicketId = "eyIJX2rmhbL7";
//
//$Ticket = new Ticket($Key);
//
//echo $Ticket->GetTicket($TicketId);



//$Request = new RequestPrice($Key);
//
//$Request->PickUpAddress("37 Rue du Rocher, 75008 Paris");
//
//$Request->DropOffAddress("37 Rue du Rocher, 75008 Paris");
//
//$Request->TripType("10");
//
//$Request->BuildData();
//
//$Request->Send();

?>