<?php

header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
require_once "php/Database_api.php";
$db = new Database();


$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : false;

switch ($page) {
	case 'feedback':
        $otzivi = $db->getAllOtzivi();
        $retval = array("feedback"=> $otzivi);
        $retval = json_encode($retval,JSON_UNESCAPED_UNICODE);

        //$retval = str_replace('\/','/',$retval);
        echo $retval;
		break;

        case 'news':
            $news = $db->getAllNews();
            $retval = array("news"=> $news);
            $retval = json_encode($retval,JSON_UNESCAPED_UNICODE);

            echo $retval;
            break;

}