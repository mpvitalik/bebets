<?php


session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();


if($_SERVER['REQUEST_METHOD']=="POST"){

    $data['championat'] = isset($_POST['championat'])? htmlspecialchars($_POST['championat']) : "";
    $data['time'] = isset($_POST['time'])? htmlspecialchars($_POST['time']) : "";
    $data['komandi'] = isset($_POST['komandi'])? htmlspecialchars($_POST['komandi']) : "";
    $data['prognoz'] = isset($_POST['prognoz'])? htmlspecialchars($_POST['prognoz']) : "";
    $data['koef'] = isset($_POST['koef'])? htmlspecialchars($_POST['koef']) : "";
    $data['id'] = isset($_POST['id'])? intval($_POST['id']) : die("Error!");

    $db->changeUserPrognoz($data);
    header("Location:chat.php");
    die();

}else{
    $id = isset($_GET['id'])? intval($_GET['id']) : die("Error,go back");
    $post = $db->getUserPrognozById($id);
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
        <div class="col-md-9 col-md-offset-1" >
            <a href="chat.php" style="font-size: 18px;">< Назад</a>
            <h1>Изменение прогноза пользователя</h1>
            <br>
            <form role="form" action="<?=basename(__FILE__)?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nazva">Чемпионат</label><br>
                    <textarea cols="60" rows="1" name="championat"><?=$post->getChampionat()?></textarea>
                </div>
                <div class="form-group">
                    <label for="nazva">Время</label><br>
                    <textarea cols="60" rows="1" name="time" ><?=$post->getTimeChampionat()?></textarea>
                </div>
                <div class="form-group">
                    <label for="nazva">Команды</label><br>
                    <textarea cols="60" rows="1" name="komandi"><?=$post->getComandi()?></textarea>
                </div>
                <div class="form-group">
                    <label for="nazva">Прогноз</label><br>
                    <textarea cols="60" rows="1" name="prognoz"><?=$post->getPrognoz()?></textarea>
                </div>
                <div class="form-group">
                    <label for="nazva">Коеф</label><br>
                    <textarea cols="60" rows="1" name="koef"><?=$post->getKoeficient()?></textarea>
                </div>

                <input type="hidden" name="id" value="<?=$id;?>">

                <button type="submit" class="btn btn-default">Сохранить</button><br><br>
            </form>

        </div>

    </div>

</div>



</body>

</html>
