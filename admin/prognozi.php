<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();
$type = isset($_GET['type'])? $_GET['type'] : "all";
$page = isset($_GET['p'])? intval($_GET['p']) : 1;

$prognozi = $db->getPrognoziByType($type,$page);

$pages_result = $db->pagesResultPrognozi($type);
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
    <a href="prognozi.php?type=all">Все прогнозы</a> |
    <a href="prognozi.php?type=vip">VIP прогнозы</a> |
    <a href="prognozi.php?type=normal">Обычные прогнозы</a>
    <h1><?php if($type=="all"){echo "Все";}elseif ($type=="vip"){echo "VIP";}else{echo "Обычные";}?> Прогнозы
        <small>
            <a href="addprognoz.php">+ Добавить прогноз</a>
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
            <th>Дата/время</th>
            <th>Название</th>
            <th>Картинка</th>
            <th>На главной</th>
            <th>Отображ.</th>
            <th>Статус</th>
            <th>Тип</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($prognozi as $prognoz):?>
            <tr>
                <td><input type="checkbox" class="checkprognoz" id="<?=$prognoz->getId()?>"></td>
                <td><?=$prognoz->getId();?></td>
                <td><?=$prognoz->getDate()." / ".$prognoz->getTime()?></td>
                <td>
                    <?=$prognoz->getNazva();?><br>
                    <small style="color:grey;"><?=$prognoz->getSsilka()?></small>
                    <?php if($prognoz->getSsilka()==""):?>
                        <small style="color:red;">Ссылка пустая</small>
                    <?php endif;?>
                </td>
                <td>
                    <?php if($prognoz->getImg()!=""):?>
                        <img src="../<?=$prognoz->getImg();?>" style="width:100px;height:auto;">
                    <?php endif;?>
                </td>
                <td>
                    <span class="text_showingmain_<?=$prognoz->getId()?>">
                        <?php if($prognoz->getShowingMain()=="yes"):?>
                            Да
                        <?php elseif($prognoz->getShowingMain()=="no"):?>
                            Нет
                        <?php else:?>
                            ---
                        <?php endif;?>
                    </span><br>
                    <a class="changeshowingmain" prognoz-id="<?=$prognoz->getId()?>">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </a>
                </td>
                <td>
                    <span class="text_showing_<?=$prognoz->getId()?>">
                        <?php if($prognoz->getShowing()=="yes"):?>
                            Да
                        <?php elseif($prognoz->getShowing()=="no"):?>
                            Нет
                        <?php else:?>
                            ---
                        <?php endif;?>
                    </span><br>
                    <a class="changeshowing" prognoz-id="<?=$prognoz->getId()?>">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </a>
                </td>
                <td>
                    <?php if($prognoz->getProshel()=="yes"):?>
                        <span style="color:green;">Прошел</span>
                    <?php elseif($prognoz->getProshel()=="no"):?>
                        <span style="color:red;">Не прошел</span>
                    <?php else:?>
                        ---
                    <?php endif;?>
                </td>
                <td>
                    <?php if($prognoz->getType()=="vip"):?>
                        Vip
                    <?php else:?>
                        Обычный
                    <?php endif;?>
                </td>
                <td>
                    <a href="changestatusprognoz.php?id=<?=$prognoz->getId();?>&status=yes&p=<?=$page?>&type=<?=$type;?>">Прошел</a> <br>
                    <a href="changestatusprognoz.php?id=<?=$prognoz->getId();?>&status=no&p=<?=$page?>&type=<?=$type;?>">Не прошел</a> <br>
                    <a href="changestatusprognoz.php?id=<?=$prognoz->getId();?>&status=without&p=<?=$page?>&type=<?=$type;?>">Без статуса</a>
                </td>
                <td>
                    <a href="copyprognoz.php?id=<?=$prognoz->getId();?>&type=<?=$type;?>">Копировать</a> <br>
                    <a href="changeprognoz.php?id=<?=$prognoz->getId();?>&type=<?=$type;?>">Изменить</a> <br>
                    <a href="deleteprognoz.php?id=<?=$prognoz->getId();?>&type=<?=$type;?>">Удалить</a> <br>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <div style="border-top: 1px dashed grey;padding:10px;">
        <?php if($pages != 0):?>
            <?php if($page!=1):?>
                <a href="prognozi.php?p=<?=$page-1;?>&type=<?=$type?>">назад</a>
            <?php endif;?>
            <?=$page;?> из <?=$pages;?>
            <?php if($page!=$pages):?>
                <a href="prognozi.php?p=<?=$page+1;?>&type=<?=$type?>">вперед</a>
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
    $.post('someitems.php',{ids:copylist_json,action:"copy",type:"prognoz"},function(data){
        if(data=="ok"){
            window.location.href = "prognozi.php";
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
    $.post('someitems.php',{ids:deletelist_json,action:"delete",type:"prognoz"},function(data){
        if(data=="ok"){
            window.location.href = "prognozi.php";
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

$('.changeshowingmain').click(function(){
    var prognoz_id = $(this).attr('prognoz-id');

    $.post('changeshowing_chempprogmain.php',{id:prognoz_id,type:"championatprognoz"},function(data){
        if(data=="yes"){
            $('.text_showingmain_'+prognoz_id).text("Да");
        }else{
            $('.text_showingmain_'+prognoz_id).text("Нет");
        }
    });
});

</script>
</body>

</html>