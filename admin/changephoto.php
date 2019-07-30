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
$output_dir = "../img/";
$post = $db->getPostById($id);

if($_SERVER['REQUEST_METHOD']=="POST"){

        if(isset($_FILES["image"]) && $_FILES["image"]["name"]!="")
        {

            $fileName = $_FILES["image"]["name"];

            if (file_exists($output_dir.$fileName)) {

                $filepath = pathinfo($_FILES["image"]["name"]);
                $fname = $filepath['filename'].rand().".".$filepath['extension'];
                move_uploaded_file($_FILES["image"]["tmp_name"],$output_dir.$fname);

                $post->setImg("img/".$fname);
                $db->changeMainPhotoPost($post);

            }else{
                unlink("../".$post->getImg());
                move_uploaded_file($_FILES["image"]["tmp_name"],$output_dir.$fileName);
                $post->setImg("img/".$fileName);
                $db->changeMainPhotoPost($post);
            }


        }

        header("Location:changepost.php?id=".$post->getId());
        die();


}else{?>

        <form role="form" action="<?=basename(__FILE__)?>" method="post" enctype="multipart/form-data">
            <h3><a href="changepost.php?id=<?=$post->getId()?>"> < Назад</a> </h3>
            <h3>Изменение главной фото</h3>
            <input type="file" name="image" accept="image/jpeg,image/png,image/gif"><br><br>
            <input type="hidden" name="id" value="<?=$post->getId()?>">
            <button type="submit">Сохранить</button>
        </form>

<?php }?>