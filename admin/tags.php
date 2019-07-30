<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();

$page = isset($_GET['p'])? intval($_GET['p']) : 1;

$tags = $db->getTagsAdmin($page);
$pages_result = $db->pagesResultTags();
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



    <h1>Теги
        <small>
            <a href="addtag.php">+ Добавить тег</a>
        </small>
    </h1>
    <br>
    <p><a class="copysomeitems">Копировать</a> | <a class="deletesomeitems">Удалить</a> |
        <a class="otmetitvse">Отметить все</a> | <a class="ubratvidelenie">Убрать выделенные</a></p>
    <br>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>id</th>
            <th>Название</th>
            <th>Ссылка</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($tags as $tag):?>
            <tr>
                <td><input type="checkbox" class="checkprognoz" id="<?=$tag->getId()?>"></td>
                <td><?=$tag->getId();?></td>
                <td>
                    <?=$tag->getNazva();?><br>
                    <small style="color:grey;"><?=$tag->getSsilka()?></small>
                    <?php if($tag->getSsilka()==""):?>
                        <small style="color:red;">Ссылка пустая</small>
                    <?php endif;?>
                </td>
                <td>
                    <a href="changetag.php?id=<?=$tag->getId();?>">Изменить</a> <br>
                    <a href="deletetag.php?id=<?=$tag->getId();?>">Удалить</a> <br>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <div style="border-top: 1px dashed grey;padding:10px;">
        <?php if($pages != 0):?>
            <?php if($page!=1):?>
                <a href="tags.php?p=<?=$page-1;?>">назад</a>
            <?php endif;?>
            <?=$page;?> из <?=$pages;?>
            <?php if($page!=$pages):?>
                <a href="tags.php?p=<?=$page+1;?>">вперед</a>
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

    $(".copysomeitems").click(function(){
        var copylist = [];
        $('.checkprognoz').each(function () {
            if($(this).prop('checked')==true){
                copylist.push($(this).attr('id'));
            }
        });
        var copylist_json = JSON.stringify(copylist);
        $.post('someitems.php',{ids:copylist_json,action:"copy",type:"tag"},function(data){
            if(data=="ok"){
                window.location.href = "tags.php";
            }
        });
    });

    $(".deletesomeitems").click(function(){
        var deletelist = [];
        $('.checkprognoz').each(function () {
            if($(this).prop('checked')==true){
                deletelist.push($(this).attr('id'));
            }
        });
        var deletelist_json = JSON.stringify(deletelist);
        $.post('someitems.php',{ids:deletelist_json,action:"delete",type:"tag"},function(data){
            if(data=="ok"){
                window.location.href = "tags.php";
            }
        });
    });

    $('.changeshowing').click(function(){
        var prognoz_id = $(this).attr('prognoz-id');

        $.post('changeshowing.php',{id:prognoz_id,type:"prognoz"},function(data){
            if(data=="yes"){
                $('.text_showing_'+prognoz_id).text("Да");
            }else{
                $('.text_showing_'+prognoz_id).text("Нет");
            }
        });
    });

</script>
</body>

</html>