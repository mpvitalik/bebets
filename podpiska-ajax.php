<?php

header('Powered: test');
header('Content-Type: text/html; charset=utf-8');


require_once "php/Database.php";
$db = new Database();

$email = isset($_POST['email_podpiska'])? htmlspecialchars($_POST['email_podpiska']) : "";

$retval = $db->sendEmailPodpiska($email);
if($retval){
    echo "ok";
}else{
    echo "uzeoformlena";
}
