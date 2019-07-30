<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();

$page = isset($_GET['p'])? intval($_GET['p']) : 1;

if($_SERVER['REQUEST_METHOD']=="POST"){
    if(isset($_FILES["image"]) && $_FILES["image"]["name"]!="")
    {
        $output_dir = "../img/";
        $fileName = $_FILES["image"]["name"];
        $_FILES['image']['type'] = "image/jpeg";

        if (file_exists($output_dir.$fileName)) {
            $filepath = pathinfo($_FILES["image"]["name"]);
            $fname = $filepath['filename'].rand().".".$filepath['extension'];
            move_uploaded_file($_FILES["image"]["tmp_name"],$output_dir.$fname);
            $img="img/".$fname;

        }else{
            move_uploaded_file($_FILES["image"]["tmp_name"],$output_dir.$fileName);
            $img="img/".$fileName;
        }

        $db->insertOtziv($img);

    }
}

$otzivi = $db->getOtziviAdmin($page);

$pages_result = $db->pagesResultOtzivi();
$pages = ceil($pages_result/40);

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
    <style>
        a{cursor:pointer;}
    </style>
</head>
<body>
<?php require_once "navbar.php";?></nav>

<div class="container">

    <br><br>
    <h1>Отзывы клиентов</h1>
    <hr>
    <form role="form" action="<?=basename(__FILE__)?>" method="post" enctype="multipart/form-data">

        <label for="image">Загрузить отзыв</label><br>
        <input type="file" id="image" name="image" style="display:inline-block">
        <button type="submit" class="" style="display:inline-block">Сохранить</button>
    </form>
    <hr>

    <p><a class="deletesomeitems">Удалить</a> |
        <a class="otmetitvse">Отметить все</a> | <a class="ubratvidelenie">Убрать выделенные</a></p>
    <br>
    <table class="table" >
        <thead>
        <tr>
            <th></th>
            <th>id</th>
            <th>Картинка</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($otzivi as $otziv):?>
            <tr>
                <td><input type="checkbox" class="checkprognoz" id="<?=$otziv->getId()?>"></td>
                <td><?=$otziv->getId();?></td>
                <td>
                    <a href="../<?=$otziv->getImg();?>" target="_blank">
                        <img src="../<?=$otziv->getImg();?>" style="width:100px;height:auto;">
                    </a>
                </td>
                <td>
                    <a href="deleteotziv.php?id=<?=$otziv->getId();?>">Удалить</a><br>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <div style="border-top: 1px dashed grey;padding:10px;">
        <?php if($pages != 0):?>
            <?php if($page!=1):?>
                <a href="otzivi.php?p=<?=$page-1;?>">назад</a>
            <?php endif;?>
            <?=$page;?> из <?=$pages;?>
            <?php if($page!=$pages):?>
                <a href="otzivi.php?p=<?=$page+1;?>">вперед</a>
            <?php endif;?>
        <?php endif;?>
    </div>



</div>


<script>

    $(".otmetitvse").click(function(){
        $('.checkprognoz').prop("checked", true);
    });

    $(".ubratvidelenie").click(function(){
        $('.checkprognoz').prop("checked", false);
    });


    $(".deletesomeitems").click(function(){
        var deletelist = [];
        $('.checkprognoz').each(function () {
            if($(this).prop('checked')==true){
                deletelist.push($(this).attr('id'));
            }
        });
        var deletelist_json = JSON.stringify(deletelist);
        $.post('someitems.php',{ids:deletelist_json,action:"delete",type:"otziv"},function(data){
            if(data=="ok"){
                window.location.href = "otzivi.php";
            }
        });
    });


</script>

</body>

</html>