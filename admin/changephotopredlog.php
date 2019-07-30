<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}


require_once "../php/Database.php";
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

$db = new Database();

$id = isset($_GET['id'])? intval($_GET['id']) : intval($_POST['id']);
$output_dir = "../useruploads/";
$predlogpost = $db->getPredlogPostById($id);

if($_SERVER['REQUEST_METHOD']=="POST"){

    if(isset($_FILES["image"]) && $_FILES["image"]["name"]!="")
    {

        $fileName = $_FILES["image"]["name"];

        if (file_exists($output_dir.$fileName)) {

            $filepath = pathinfo($_FILES["image"]["name"]);
            $fname = $filepath['filename'].rand().rand().".".$filepath['extension'];
            move_uploaded_file($_FILES["image"]["tmp_name"],$output_dir.$fname);

            $predlogpost->setImg("useruploads/".$fname);
            $db->changeMainPhotoPredlogPost($predlogpost);

        }else{
            move_uploaded_file($_FILES["image"]["tmp_name"],$output_dir.$fileName);
            $predlogpost->setImg("useruploads/".$fileName);
            $db->changeMainPhotoPredlogPost($predlogpost);
        }


    }

    header("Location:predlogpost.php?id=".$predlogpost->getId());
    die();


}else{?>

    <form role="form" action="<?=basename(__FILE__)?>" method="post" enctype="multipart/form-data">
        <h3><a href="predlogpost.php?id=<?=$predlogpost->getId()?>"> < Назад</a> </h3>
        <h3>Изменение главной фото</h3>
        <input type="file" name="image" accept="image/jpeg,image/png,image/gif"><br><br>
        <input type="hidden" name="id" value="<?=$predlogpost->getId()?>">
        <button type="submit">Сохранить</button>
    </form>

<?php }?>