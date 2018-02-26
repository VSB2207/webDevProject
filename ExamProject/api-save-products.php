<?php

$sFileExtension = pathinfo($_FILES['pictureProduct']['name'], PATHINFO_EXTENSION);
$sFolder = 'productPictures/';
$sFileName = 'pictureProduct-'.uniqid().'.'.$sFileExtension;
$sSaveFileTo = $sFolder.$sFileName;
move_uploaded_file( $_FILES['pictureProduct']['tmp_name'], $sSaveFileTo);


$jNewProducts = json_decode('{}');
$jNewProducts->id = uniqid();
$jNewProducts->productName = $_POST['nameProduct'];
$jNewProducts->price = $_POST['priceProduct'];
$jNewProducts->productPicture = $sFolder.$sFileName;


// Load all the users and decode( string -> object) them to an array
$sOldProducts= file_get_contents('data.txt');
$jOldProducts = json_decode($sOldProducts);

// Add the new user to the array
                //array     //value
array_push( $jOldProducts, $jNewProducts );

// Encode all the users and save it to the file;
$sNewProducts = json_encode($jOldProducts);
file_put_contents('data.txt', $sNewProducts);

echo $sNewProducts;