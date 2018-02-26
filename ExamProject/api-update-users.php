<?php

$sajUsersList = file_get_contents('users.txt');
$ajUsersList  = json_decode($sajUsersList);

$newModifiedUserId   = $_POST['id'];
echo $newModifiedUserId;

$sNewUserName   = $_POST['updateUserName'];
$sNewUserEmail	= $_POST['updateUserEmail'];
$sNewUserPassword	= $_POST['updateUserPassword'];
//$sNewPicture = $_POST['updatedPriceProduct'];
for($i=0; $i<count($ajUsersList); $i++){
    $currentModifiedUserFromFile = $ajUsersList[$i];
    //echo $currentModifiedUserFromFile->id ;
    if( $newModifiedUserId == $currentModifiedUserFromFile->id ){
        $currentModifiedUserFromFile->firstName = $sNewUserName;
        $currentModifiedUserFromFile->email = $sNewUserEmail;
        $currentModifiedUserFromFile->password = $sNewUserPassword;
    }
}

$sajLetters = json_encode( $ajUsersList );
file_put_contents( 'users.txt' , $sajLetters );

?>