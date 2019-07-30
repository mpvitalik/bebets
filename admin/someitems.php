<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";

$db = new Database();

$ids = isset($_POST['ids'])? $_POST['ids'] : die("Error, go back");
$action = isset($_POST['action'])? $_POST['action'] : die("Error, go back");
$type = isset($_POST['type'])? $_POST['type'] : die("Error, go back");

$ids = json_decode($ids);
if(!is_array($ids)){
    die("Error");
}
$ids = array_reverse($ids);

if($type=="prognoz"){
    if($action=="copy"){
        foreach($ids as $id){
            $db->copyPrognoz($id);
        }
    }elseif($action=="delete"){
        foreach($ids as $id){
            $db->deletePrognoz($id);
        }
    }

}elseif($type=="post"){
    if($action=="copy"){
        foreach($ids as $id){
            $db->copyPost($id);
        }
    }elseif($action=="delete"){
        foreach($ids as $id){
            $db->deletePost($id);
        }
    }
}elseif ($type=="user"){
    if($action=="delete"){
        foreach($ids as $id){
            $db->deleteUserById($id);
        }
    }
}elseif ($type=="otziv"){
    if($action=="delete"){
        foreach($ids as $id){
            $db->deleteOtziv($id);
        }
    }
}elseif ($type=="podpiski"){
    if($action=="delete"){
        foreach($ids as $id){
            $db->deletePodpiska($id);
        }
    }
}elseif ($type=="chat"){
    if($action=="copy"){
        foreach($ids as $id){
            $db->copyUserPrognoz($id);
        }
    }elseif($action=="delete"){
        foreach($ids as $id){
            $db->deleteUserPrognoz($id);
        }
    }
}elseif($type=="prognozcomments"){
    if($action=="delete"){
        foreach($ids as $id){
            $db->deleteCommentPrognoz($id);
        }
    }
}elseif($type=="postcomments"){
    if($action=="delete"){
        foreach($ids as $id){
            $db->deleteCommentPost($id);
        }
    }
}elseif($type=="tag"){
    if($action=="copy"){
        foreach($ids as $id){
            $db->copyTagAdmin($id);
        }
    }elseif($action=="delete"){
        foreach($ids as $id){
            $db->deleteTagAdmin($id);
        }
    }
}elseif($type=="championat"){
    if($action=="copy"){
        foreach($ids as $id){
            $db->copyChampionatAdmin($id);
        }
    }elseif($action=="delete"){
        foreach($ids as $id){
            $db->deleteChampionat($id);
        }
    }
}elseif($type=="championatprognoz"){
    if($action=="copy"){
        foreach($ids as $id){
            $db->copyChampionatPrognoz($id);
        }
    }elseif($action=="delete"){
        foreach($ids as $id){
            $db->deleteChampionatPrognoz($id);
        }
    }
}

echo "ok";
