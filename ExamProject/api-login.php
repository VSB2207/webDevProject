<?php
session_start();

$sUsers = file_get_contents('users.txt');
$aUsers = json_decode($sUsers);

//the info that the user passes in the form

$sUserEmail = $_POST['userEmail'];
$sUserPassword 	= $_POST['userPassword'];


//echo $sUserEmail;
//echo $sUserPassword;


// Load all the users and decode them to an array
for ($i = 0; $i < count($aUsers); $i++) {
    // echo $aUsers[$i]->email;
    //echo $aUsers[$i]->password;
    $jUser = $aUsers[$i] ;

    if ($sUserEmail == $aUsers[$i]->email && $sUserPassword == $aUsers[$i]->password) {
        $_SESSION['jUser'] = $jUser;
        $sjResponse = '{"login":"ok","role":"' . $aUsers[$i]->role . '"}';

        if($aUsers[$i]->role == "admin")
        {
            $_SESSION['sAdmin'] = true;
        }
        else{
            $_SESSION['sAdmin'] = false;
        }
        echo $sjResponse;
        exit;
    }
};

    $sjResponse = '{"login":"error","user":"'+ $_SESSION['jUser']+'"}';
    echo $sjResponse;
    exit;


?>