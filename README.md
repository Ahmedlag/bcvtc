# BCVTC API

this PHP file contains multiple classes that help building request and posting them to the BCVTC API.

---------------EXAMPLES-----------------

<!-- Sending new reservation request -->
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
        


<!-- Get Ticket Informations -->

$TicketId = "eyIJX2rmhbL7";

$Ticket = new Ticket($Key);

echo $Ticket->GetTicket($TicketId);



<!-- Geting trip fare based on the prices indicated by the driver -->

$Request = new RequestPrice($Key);

$Request->PickUpAddress("37 Rue du Rocher, 75008 Paris");

$Request->DropOffAddress("37 Rue du Rocher, 75008 Paris");

$Request->TripType("10");

$Request->BuildData();

$Request->Send();



Doccumentation :
http://www.bcvtc.fr/api

@Ahmed LAGGOUN
BCVTC

