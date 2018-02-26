<?php

$jNewEmails = json_decode('{}');
$jNewEmails->id = uniqid();
$jNewEmails->email = $_POST['emailNewsletter'];

// Load all the users and decode( string -> object) them to an array
$sOldProducts= file_get_contents('emailsNewsletter.txt');
$jOldProducts = json_decode($sOldProducts);

// Add the new user to the array
//array     //value
array_push( $jOldProducts, $jNewEmails );

// Encode all the users and save it to the file;
$sNewProducts = json_encode($jOldProducts);
file_put_contents('emailsNewsletter.txt', $sNewProducts);

echo $sNewProducts;