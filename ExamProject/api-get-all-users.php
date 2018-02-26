<?php

$sUser = file_get_contents('users.txt');
$aUser = json_decode($sUser);

for ($i = 0; $i < count($aUser); $i++) {
    $sUserFirstName = $aUser[$i]->firstName;
    $sUserLastName = $aUser[$i]->lastName;
    $sUserEmail = $aUser[$i]->email;
    $sUserPhone = $aUser[$i]->phoneNumber;
    $sUserPicture = $aUser[$i]->image;
}

$sUser = json_encode($aUser);
echo $sUser;


?>