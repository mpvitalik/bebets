<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();

$championats = $db->getChampionatsAdmin();

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
<?php require_once "navbar.php";?>

<div class="container">

    <br><br>
    <h1>Чемпионаты
        <small>
            <a href="addchampionat.php">+ Добавить чемпионат</a>
        </small>
    </h1>

    <br>
    <p><a class="copysomeitems">Копировать</a> | <a class="deletesomeitems">Удалить</a> |
        <a class="otmetitvse">Отметить все</a> | <a class="ubratvidelenie">Убрать выделенные</a></p>
    <br>
    <table class="table" >
        <thead>
        <tr>
            <th></th>
            <th>id</th>
            <th>Очередь</th>
            <th>Название</th>
            <th>Картинка</th>
            <th>Отображ.</th>
            <th>Дата синхр.</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($championats as $championat):?>
            <tr>
                <td><input type="checkbox" class="checkprognoz" id="<?=$championat->getId()?>"></td>
                <td><?=$championat->getId();?></td>
                <td><?=$championat->getSort();?></td>
                <td>
                    <a href="changechampionat.php?id=<?=$championat->getId();?>">
                        <?=$championat->getNazva();?>
                    </a>
                    <br>
                    <small style="color:grey;"><?=$championat->getSsilka()?></small>
                    <?php if($championat->getSsilka()==""):?>
                        <small style="color:red;">Ссылка пустая</small>
                    <?php endif;?>
                </td>
                <td>
                    <?php if($championat->getImg()!=""):?>
                        <img src="../<?=$championat->getImg();?>" style="width:100px;height:auto;">
                    <?php endif;?>
                </td>
                <td>
                    <span class="text_showing_<?=$championat->getId()?>">
                        <?php if($championat->getShowing()=="yes"):?>
                            Да
                        <?php elseif($championat->getShowing()=="no"):?>
                            Нет
                        <?php else:?>
                            ---
                        <?php endif;?>
                    </span><br>
                    <a class="changeshowing" prognoz-id="<?=$championat->getId()?>">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </a>
                </td>
                <td>
                    <small>Т: <?=$championat->getDateSyncTablica()?></small><br>
                    <small>М: <?=$championat->getDateSyncMatchi()?></small>
                </td>
                <td>
                    <a class="deleteproduct" data-id="<?=$championat->getId()?>">Удалить</a>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <hr>
    <br>
    <p><b>Для синхронизации всех чемпионатов вручную:</b><br>
        1. Таблицы: <a href="https://bebets.ru/curl_test/curl_table.php" target="_blank">| Синхронизировать все таблицы ></a> <br>
        2. Матчи: <a href="https://bebets.ru/curl_test/curl_matchi.php" target="_blank">| Синхронизировать все матчи ></a>
    </p>
    <br><br><br><br>

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
        $.post('someitems.php',{ids:copylist_json,action:"copy",type:"championat"},function(data){
            if(data=="ok"){
                window.location.href = "championats.php";
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
        $.post('someitems.php',{ids:deletelist_json,action:"delete",type:"championat"},function(data){
            if(data=="ok"){
                window.location.href = "championats.php";
            }
        });
    });

    $('.changeshowing').click(function(){
        var prognoz_id = $(this).attr('prognoz-id');

        $.post('changeshowing.php',{id:prognoz_id,type:"championat"},function(data){
            if(data=="yes"){
                $('.text_showing_'+prognoz_id).text("Да");
            }else{
                $('.text_showing_'+prognoz_id).text("Нет");
            }
        });
    });

    $('.deleteproduct').click(function(){
        var idproduct = $(this).attr('data-id');

        if (confirm("Удалить чемпионат?")) {
            window.location.href = "deletechampionat.php?id="+idproduct;
        }
    });

</script>
</body>

</html>
