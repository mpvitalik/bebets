<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();



if($_SERVER['REQUEST_METHOD']=="POST"){
    $text = $_POST['text'];
    $id = isset($_POST['id'])? intval($_POST['id']) : die("Error1");
    $text2 = "";
    $text3 = "";

    if($id==2){
        $text2 = $_POST['text2'];
        $text3 = $_POST['text3'];
    }
    $db->updateOtherPage($id,$text,$text2,$text3);
    $successmess = "Сохранено";
}else{
    $id = isset($_GET['id'])? intval($_GET['id']) : die("Error");
}
$otherpage = $db->getOtherPageById($id);
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
            <h1><?=$otherpage->getNazva()?></h1>
            <form role="form" action="<?=basename(__FILE__)?>" method="post" enctype="multipart/form-data">
                <br>
                <input type="hidden" name="id" value="<?=$otherpage->getId()?>">
                <textarea cols="60" rows="15" name="text"><?=$otherpage->getText()?></textarea><br>
                <?php if($id==2):?>
                    <textarea cols="60" rows="15" name="text2"><?=$otherpage->getText2()?></textarea><br>
                    <textarea cols="60" rows="15" name="text3"><?=$otherpage->getText3()?></textarea><br>
                <?php endif;?>
                <button type="submit" class="btn btn-default">Сохранить</button><br><br>
            </form>

        </div>

    </div>

</div>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('text',{
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    });
</script>
<?php if($id==2):?>
    <script>
        CKEDITOR.replace('text2',{
            filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',
            filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',
            filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
    </script>
    <script>
        CKEDITOR.replace('text3',{
            filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',
            filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',
            filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
    </script>
<?php endif;?>





</body>

</html>
