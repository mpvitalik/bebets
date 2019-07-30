<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

$db = new Database();

$id = isset($_GET['id']) ? intval($_GET['id']) : intval($_POST['id']);

if($_SERVER['REQUEST_METHOD']=="POST"){

    $predlogpost = new Predlogpost();
    $predlogpost->setId($id);
    $predlogpost->setCat($_POST['cat']);
    $predlogpost->setNazva($_POST['nazva']);
    $predlogpost->setDescription($_POST['description']);
    $predlogpost->setImg($_POST['img']);
    $predlogpost->setVideo($_POST['video']);
    $predlogpost->setTags($_POST['tags']);
    $predlogpost->setText($_POST['text']);

    $db->changePredlogPost($predlogpost);
    $db->opublikovatPredlogPost($predlogpost);
    header("Location:predlogposts.php");
    die();

}else{
    $predlogpost = $db->getPredlogPostById($id);
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
            <a href="predlogposts.php" style="font-size: 18px;">< Назад</a>
            <h1><?=$predlogpost->getNazva()?></h1>
            <form role="form" action="<?=basename(__FILE__)?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="cat">Категория новости:</label>
                    <select class="form-control" name="cat" id="cat" style="width:200px;">
                        <option value="news" <?php if($predlogpost->getCat()=='news') echo "selected";?>>Новости</option>
                        <option value="video" <?php if($predlogpost->getCat()=='video') echo "selected";?>>Видео</option>
                        <option value="photos" <?php if($predlogpost->getCat()=='photos') echo "selected";?>>Фото</option>
                        <option value="gifki" <?php if($predlogpost->getCat()=='gifki') echo "selected";?>>Гифки</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nazva">Заголовок</label>
                    <input type="text" class="form-control" id="nazva" name="nazva" value="<?=$predlogpost->getNazva()?>">
                </div>
                <div class="form-group">
                    <label for="description">Подзаголовок</label>
                    <input type="text" class="form-control" id="description" name="description" value="<?=$predlogpost->getDescription()?>">
                </div>
                <hr>
                <div class="form-group">
                    <label for="image">Картинка</label><br>
                    <?php if($predlogpost->getImg()!=""):?>
                        <a href="../<?=$predlogpost->getImg()?>" target="_blank">
                            <img src="../<?=$predlogpost->getImg()?>" style="width:200px;">
                        </a>
                        <input type="hidden" name="img" value="<?=$predlogpost->getImg()?>">
                        <br>
                    <?php else:?>
                        <p>---Картинки нету---</p>
                    <?php endif;?>
                    <a href="changephotopredlog.php?id=<?=$predlogpost->getId()?>">[Изменить картинку]</a>&nbsp; &nbsp;
                    <a href="deletephotopredlog.php?id=<?=$predlogpost->getId()?>">[Удалить картинку]</a>
                </div>
                <hr>
                <strong>Видео</strong><br>
                <?=htmlspecialchars_decode($predlogpost->getVideo())?>
                <hr>
                <strong>Видео (код)</strong><br>
                <textarea cols="60" rows="3" name="video"><?=htmlspecialchars_decode($predlogpost->getVideo())?></textarea><br><br>
                <hr>
                <strong>Тэги ( пишуться через - ";" )</strong><br>
                <textarea cols="60" rows="2" name="tags"><?=$predlogpost->getTags()?></textarea><br><br>
                <input type="hidden" name="id" value="<?=$predlogpost->getId()?>">
                <strong>Текст</strong><br>
                <textarea cols="60" rows="15" name="text"><?=$predlogpost->getText()?></textarea><br>
                <button type="submit" class="btn btn-primary">Опубликовать</button>
                <a href="otklonitpredlog.php?id=<?=$predlogpost->getId()?>" class="btn btn-danger">Отклонить</a>
                <br><br>
            </form>
            <br><br><br><br><br>
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





</body>

</html>