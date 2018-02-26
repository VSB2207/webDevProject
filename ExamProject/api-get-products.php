<?php

$sProducts = file_get_contents('data.txt');
$aProducts = json_decode($sProducts);



for ($i = 0; $i < count($aProducts); $i++) {
   $sProductName = $aProducts[$i]->productName;
   $sProductPrice = $aProducts[$i]->price;
   $sProductPicture = $aProducts[$i]->productPicture;
}

$sProducts = json_encode($aProducts);
echo $sProducts;


?>