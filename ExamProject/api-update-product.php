<?php

$sajProducts = file_get_contents('data.txt');
$ajProducts  = json_decode($sajProducts);

$modifiedProductId   = $_POST['id'];
$sNewName   = $_POST['updatedNameProduct'];
$sNewPrice	= $_POST['updatedPriceProduct'];
//$sNewPicture = $_POST['updatedPriceProduct'];
for($i=0; $i<count($ajProducts); $i++){
    $currentProductFromFile = $ajProducts[$i];
    echo $currentProductFromFile->id ;
    if( $modifiedProductId == $currentProductFromFile->id ){
        $currentProductFromFile->productName = $sNewName;
        $currentProductFromFile->price = $sNewPrice;
    }
}

$sajLetters = json_encode( $ajProducts );
file_put_contents( 'data.txt' , $sajLetters );

?>