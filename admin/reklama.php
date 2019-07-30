<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();


if($_SERVER['REQUEST_METHOD']=="POST"){

    $data['id'] = intval($_POST['id']);
    $data['kod'] = isset($_POST['kod'])? addslashes($_POST['kod']) : "";
    $data['kod_mob'] = isset($_POST['kod_mob'])? addslashes($_POST['kod_mob']) : "";
    /*$data['ssilka'] = isset($_POST['ssilka'])? $_POST['ssilka'] : "";
    $data['img'] = "";

    if(isset($_FILES["img"]) && $_FILES["img"]["name"]!="")
    {
        $output_dir = "../img/";
        $fileName = $_FILES["img"]["name"];

        if (file_exists($output_dir.$fileName)) {

            $filepath = pathinfo($_FILES["img"]["name"]);
            $fname = $filepath['filename'].rand().rand().".".$filepath['extension'];
            move_uploaded_file($_FILES["img"]["tmp_name"],$output_dir.$fname);
            $data['img'] = "img/".$fname;

        }else{
            move_uploaded_file($_FILES["img"]["tmp_name"],$output_dir.$fileName);
            $data['img'] = "img/".$fileName;
        }
    }*/


    $rs = $db->updateReklama($data);


    header("Location:reklama.php?id=".$data['id']);
    die();

}else{
    $id = isset($_GET['id'])? intval($_GET['id']) : die("Error, go back!");
    $reklama = $db->getReklamaById($id);
}



?>



<!doctype html>
<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <meta charset="utf-8">
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
</head>
<body>
<?php require_once "navbar.php";?>


<div class="container">
    <div class="row">
        <div class="col-md-8" >
            <h2><?=$reklama->getNazva()?></h2>
            <form role="form" action="<?=basename(__FILE__)?>" method="post" enctype="multipart/form-data">
                <strong>Код комп рекламы</strong><br>
                <textarea cols="60" rows="5" name="kod"><?=$reklama->getKod()?></textarea><br><br>
                <strong>Код моб рекламы</strong><br>
                <textarea cols="60" rows="5" name="kod_mob"><?=$reklama->getKodMob()?></textarea><br><br>
                <!--<div class="form-group">
                    <label for="nazva">Ссылка (только для моб. нижний баннер)</label>
                    <input type="text" class="form-control" name="ssilka" value="<?=$reklama->getSsilka()?>">
                </div>
                <?php /*if($reklama->getImg()!=""):?>
                    <img src="../<?=$reklama->getImg()?>" style="width:100px;">
                <?php endif;*/?>
                <div class="form-group">
                    <label for="img">Картинка (только для моб. нижний баннер)</label>
                    <input type="file" name="img">
                </div>-->
                <input type="hidden" name="id" value="<?=$id?>">
                <button type="submit" class="btn btn-default">Сохранить</button><br><br>
            </form>

        </div>

    </div>

</div>






</body>

</html>