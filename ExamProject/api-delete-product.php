<?php
$sProductId = $_GET['id'];

// Load all the users and decode them to an array
$sProducts = file_get_contents('data.txt');
$aProducts = json_decode($sProducts);

for ($i = 0; $i < count($aProducts); $i++) {
    if ($aProducts[$i]->id == $sProductId) {
        array_splice($aProducts, $i, 1);
    }

}
    $sjUpdatedProducts =  json_encode($aProducts);
    file_put_contents('data.txt', $sjUpdatedProducts);



?>