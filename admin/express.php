<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();
$id = 1;

if($_SERVER['REQUEST_METHOD']=="POST"){

    $data['id'] = (int)$id;
    $data['nazva'] = $_POST['nazva'];
    $data['text_email'] = $_POST['text_email'];
    $data['description'] = $_POST['description'];
    $data['text'] = $_POST['text'];
    $data['textpopup'] = $_POST['textpopup'];

    $db->changeExpress($data);
}

$express = $db->getExpresstById($id);


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
        <div class="col-md-9 col-md-offset-1" >
            <h1>Экспресс</h1>
            <h3>Статус:
                <?php if($express->getShow()=="yes"):?>
                    <span style="color:green;">Отображается</span> -
                    <a href="changeexpressstatus.php?id=<?=$id?>&action=no">Выкл</a>
                <?php else:?>
                    <span style="color:red;">Не отображается</span> -
                    <a href="changeexpressstatus.php?id=<?=$id?>&action=yes">Вкл</a>
                <?php endif;?>
            </h3>
            <br>
            <?php if($express->getImg()!=""):?>
                <a href="../<?=$express->getImg()?>" target="_blank">
                    <img src="../<?=$express->getImg()?>" style="width: 200px;">
                </a><br>
            <?php endif;?>
            <a href="changeexpressphoto.php?id=<?=$express->getId()?>">[ Изменить картинку ]</a><br><br>
            <form role="form" action="<?=basename(__FILE__)?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nazva">Название</label><br>
                    <textarea cols="60" rows="1" name="nazva"><?=$express->getNazva()?></textarea>
                </div>
                <div class="form-group">
                    <label for="description">Сообщение на email</label><br>
                    <textarea cols="60" rows="3" name="text_email"><?=$express->getTextEmail()?></textarea>
                </div>
                <div class="form-group">
                    <label for="description">Текст в Popup</label><br>
                    <textarea cols="60" rows="3" name="textpopup"><?=$express->getTextpopup()?></textarea>
                </div>
                <div class="form-group">
                    <label for="description">Описание (доступно всем)</label>
                    <textarea cols="60" rows="15" name="description"><?=$express->getDescription()?></textarea>
                </div><br>
                <strong>Текст (доступно 3-му пакету)</strong><br><br>
                <textarea cols="60" rows="15" name="text"><?=$express->getText()?></textarea><br>
                <button type="submit" class="btn btn-default">Сохранить</button><br><br>
            </form>

        </div>

    </div>

</div>

<script>

    CKEDITOR.replace('text_email',{
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    });

    CKEDITOR.replace('textpopup',{
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    });

    CKEDITOR.replace('text',{
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    });

    CKEDITOR.replace('description',{
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    });
</script>





</body>

</html>