<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();


if($_SERVER['REQUEST_METHOD']=="POST"){
    $data = array();
    $data['id'] = (int)$_POST['id'];
    $data['nazva'] = $_POST['nazva'];

    $championat_comanda = $db->getChampionatcomandaById($data['id']);

    $db->changeChampionatcomanda($data);
    header("Location:changechampionat.php?id=".$championat_comanda->getIdChampionat());
    die();

}else{
    $id = isset($_GET['id'])? intval($_GET['id']) : die("Error,go back");
    $championat_comanda = $db->getChampionatcomandaById($id);
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
            <a href="changechampionat.php?id=<?=$championat_comanda->getIdChampionat()?>" style="font-size: 18px;">< Назад</a>
            <h3><?=$championat_comanda->getNazva()?></h3>
            <br>
            <form role="form" action="<?=basename(__FILE__)?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nazva">Название</label><br>
                    <textarea cols="60" rows="1" name="nazva" id="nazva"><?=$championat_comanda->getNazva()?></textarea>
                </div>
                <input type="hidden" name="id" value="<?=$championat_comanda->getId()?>">
                <hr>
                <button type="submit" class="btn btn-default">Сохранить</button><br><br>
            </form>

        </div>
    </div>

</div>



</body>

</html>