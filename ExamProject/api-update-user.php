<?php


$sajUsers = file_get_contents('users.txt');
$ajUsers  = json_decode($sajUsers);

$modifiedUserId  = $_POST['id'];
$sNewUserFirstName   = $_POST['updateLoggedUserName'];
$sNewUserEmail	= $_POST['updateLoggedUserEmail'];
$sNewUserPassword	= $_POST['updatedLoggedUserPassword'];
//$sNewPicture = $_POST['updatedPriceProduct'];
for($i=0; $i<count($ajUsers); $i++){
    $currentUserFromFile = $ajUsers[$i];
    //echo $currentUserFromFile->id ;
    if( $modifiedUserId  == $currentUserFromFile->id ){
        $currentUserFromFile->firstName = $sNewUserFirstName;
        $currentUserFromFile->email = $sNewUserEmail;
        $currentUserFromFile->password = $sNewUserPassword;
    }
}

$sajLetters = json_encode( $ajUsers );
file_put_contents( 'users.txt' , $sajLetters );

?>