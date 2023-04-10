<?php

require('vendor/autoload.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


die();
//$pagarme = new PagarMe\Client('ak_live_92T7p32QtOSk9cIck77FM5bXs9UN6k'); //r25
//$pagarme = new PagarMe\Client('ak_test_Z3PPcqLckHaaEKBrVuirFLdkuEzJwq'); //sandalmaq
$pagarme = new PagarMe\Client('ak_test_RSDWUpQOJxwK1GtNSB9SCH9Dsqhw16'); //wibank
//$pagarme = new PagarMe\Client('ak_live_zF15PuFusN4D1wLNfHvqgyjYBOKTv4'); //wibank




/*
$capturedTransaction = $pagarme->transactions()->capture([
    'id' => 'test_transaction_eIqkiiARqRhx0JZAqBid1zoDXsMS5P',
    'amount' => 80
]);*/

/*
$transactions = $pagarme->transactions()->get([
    'id' => 'live_transaction_sIZW3wXC2PqL1Q07TFmWAJyxDmja3r' 
]);


echo '<pre>';
print_r($transaction);

*/


//$planSubscriptions = $pagarme->subscriptions()->getList([
//    'plan_id' => 1713863 //'ID_DO_PLANO'
//]);


//$subscriptions = $pagarme->subscriptions()->getList();
//$canceledSubscription = $pagarme->subscriptions()->cancel([ 'id' => 4785361 ]);
$subscriptions = $pagarme->subscriptions()->get([ 'id' => 4785361 ]);


//4785361


echo '<pre>';
print_r($subscriptions);
die('..');

$itens = [
	[
	  'id' => '1',
	  'title' => 'R2D2',
	  'unit_price' => 300,
	  'quantity' => 1,
	  'tangible' => true
	],
	[
	  'id' => '2',
	  'title' => 'C-3PO',
	  'unit_price' => 700,
	  'quantity' => 1,
	  'tangible' => true
	]
];

print_r($itens);




$transaction = $pagarme->transactions()->create([
    'amount' => 1000,
    'payment_method' => 'credit_card',
    'card_holder_name' => 'Anakin Skywalker',
    'card_cvv' => '123',
    'card_number' => '4242424242424242',
    'card_expiration_date' => '1220',
    'customer' => [
        'external_id' => '1',
        'name' => 'Nome do cliente',
        'type' => 'individual',
        'country' => 'br',
        'documents' => [
          [
            'type' => 'cpf',
            'number' => '00000000000'
          ]
        ],
        'phone_numbers' => [ '+551199999999' ],
        'email' => 'cliente@email.com'
    ],
    'billing' => [
        'name' => 'Nome do pagador',
        'address' => [
          'country' => 'br',
          'street' => 'Avenida Brigadeiro Faria Lima',
          'street_number' => '1811',
          'state' => 'sp',
          'city' => 'Sao Paulo',
          'neighborhood' => 'Jardim Paulistano',
          'zipcode' => '01451001'
        ]
    ],
    'shipping' => [
        'name' => 'Nome de quem receberá o produto',
        'fee' => 1020,
        'delivery_date' => '2018-09-22',
        'expedited' => false,
        'address' => [
          'country' => 'br',
          'street' => 'Avenida Brigadeiro Faria Lima',
          'street_number' => '1811',
          'state' => 'sp',
          'city' => 'Sao Paulo',
          'neighborhood' => 'Jardim Paulistano',
          'zipcode' => '01451001'
        ]
    ],
    'items' => [
        [
          'id' => '1',
          'title' => 'R2D2',
          'unit_price' => 300,
          'quantity' => 1,
          'tangible' => true
        ],
        [
          'id' => '2',
          'title' => 'C-3PO',
          'unit_price' => 700,
          'quantity' => 1,
          'tangible' => true
        ]
    ]
]);

echo '<pre>';
//print_r($pagarme);
print_r($transaction);
die('!!');