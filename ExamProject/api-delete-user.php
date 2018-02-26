<?php
$sUserId = $_GET['id'];

// Load all the users and decode them to an array
$sUsers = file_get_contents('users.txt');
$aUsers = json_decode($sUsers);

for ($i = 0; $i < count($aUsers); $i++) {
    if ($aUsers[$i]->id == $sUserId) {
        array_splice($aUsers, $i, 1);
    }

}
$sjUpdatedProducts =  json_encode($aUsers);
file_put_contents('users.txt', $sjUpdatedProducts);



?>