<?php
session_start();

$sjUser = json_encode($_SESSION['jUser']);
echo $sjUser;


?>