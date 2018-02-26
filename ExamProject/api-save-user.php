<?php

$sFileExtension = pathinfo($_FILES['userProfilePicture']['name'], PATHINFO_EXTENSION);
$sFolder = 'profilePictures/';
$sFileName = 'image-'.uniqid().'.'.$sFileExtension;
$sSaveFileTo = $sFolder.$sFileName;
move_uploaded_file( $_FILES['userProfilePicture']['tmp_name'], $sSaveFileTo);


$jNewUser = json_decode('{}');
$jNewUser->id = uniqid();
$jNewUser->firstName = $_POST['userFirstName'];
$jNewUser->lastName = $_POST['userLastName'];
$jNewUser->password = $_POST['userPassword'];
$jNewUser->email = $_POST['userEmail'];
$jNewUser->phoneNumber = $_POST['userPhoneNumber'];
$jNewUser->image = $sFolder.$sFileName;


// Load all the users and decode( string -> object) them to an array
$sOldUsers = file_get_contents('users.txt');
$jOldUsers = json_decode($sOldUsers);

// Add the new user to the array
            //array     //value
array_push( $jOldUsers, $jNewUser );

// Encode all the users and save it to the file;
$sNewUsers = json_encode($jOldUsers);
file_put_contents('users.txt', $sNewUsers);

echo $sNewUsers;


?>