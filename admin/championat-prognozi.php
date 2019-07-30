<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();
$id_champ = isset($_GET['id_champ'])? intval($_GET['id_champ']) : 0;
$type = isset($_GET['type'])? $_GET['type'] : "all";
$page = isset($_GET['p'])? intval($_GET['p']) : 1;

$championat = $db->getChampionatById($id_champ);
$championatprognozi = $db->getChampionatPrognoziAdmin($championat->getId(),$type,$page);

$all_championats = $db->getChampionatsAdmin();

$pages_result = $db->pagesResultChampionatPrognoziAdmin($championat->getId(),$type);
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
        .bold{font-weight:bold;}
    </style>
</head>
<body>
<?php require_once "navbar.php";?></nav>

<div class="container">


    <br><br>
    <a href="championat-prognozi.php?type=all" class="<?php if($type=="all")echo "bold";?>">Все прогнозы</a> |
    <a href="championat-prognozi.php?type=vip" class="<?php if($type=="vip")echo "bold";?>">VIP прогнозы</a> |
    <a href="championat-prognozi.php?type=normal" class="<?php if($type=="normal")echo "bold";?>">Обычные прогнозы</a>
    <br><br>
    <div class="dropdown" >
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
            <?php if($championat->getId()==0):?>
                Прогнозы: Выбрать чемпионат
            <?php else:?>
                Прогнозы: <?=$championat->getNazva()?>
            <?php endif;?>
            <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <?php foreach ($all_championats as $all_championat):?>
                <li><a href="championat-prognozi.php?id_champ=<?=$all_championat->getId()?>"><?=$all_championat->getNazva()?></a></li>
            <?php endforeach;?>
        </ul>
        <?php if($championat->getId()>0):?>
            <h4 style="display:inline-block;"><a href="addchamp-prognoz.php?id_champ=<?=$championat->getId()?>">+ Добавить прогноз</a> </h4>
        <?php endif;?>
    </div>


    <br>
    <p style="text-align:right;"><a class="copysomeitems">Копировать</a> | <a class="deletesomeitems">Удалить</a> |
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
        <?php foreach($championatprognozi as $championatprognoz):?>
            <tr>
                <td><input type="checkbox" class="checkprognoz" id="<?=$championatprognoz->getId()?>"></td>
                <td><?=$championatprognoz->getId();?></td>
                <td><?=$championatprognoz->getDate()." / ".$championatprognoz->getTime()?></td>
                <td>
                    <a href="change-champprognoz.php?id=<?=$championatprognoz->getId();?>&type=<?=$type;?>"><?=$championatprognoz->getNazva();?></a><br>
                    <small style="color:grey;"><?=$championatprognoz->getSsilka()?></small>
                    <?php if($championatprognoz->getSsilka()==""):?>
                        <small style="color:red;">Ссылка пустая</small>
                    <?php endif;?>
                </td>
                <td>
                    <?php if($championatprognoz->getImg()!=""):?>
                        <img src="../<?=$championatprognoz->getImg();?>" style="width:100px;height:auto;">
                    <?php endif;?>
                </td>
                <td>
                    <span class="text_showingmain_<?=$championatprognoz->getId()?>">
                        <?php if($championatprognoz->getShowingMain()=="yes"):?>
                            Да
                        <?php elseif($championatprognoz->getShowingMain()=="no"):?>
                            Нет
                        <?php else:?>
                            ---
                        <?php endif;?>
                    </span><br>
                    <a class="changeshowingmain" prognoz-id="<?=$championatprognoz->getId()?>">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </a>
                </td>
                <td>
                    <span class="text_showing_<?=$championatprognoz->getId()?>">
                        <?php if($championatprognoz->getShowing()=="yes"):?>
                            Да
                        <?php elseif($championatprognoz->getShowing()=="no"):?>
                            Нет
                        <?php else:?>
                            ---
                        <?php endif;?>
                    </span><br>
                    <a class="changeshowing" prognoz-id="<?=$championatprognoz->getId()?>">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </a>
                </td>
                <td>
                    <?php if($championatprognoz->getProshel()=="yes"):?>
                        <span style="color:green;">Прошел</span>
                    <?php elseif($championatprognoz->getProshel()=="no"):?>
                        <span style="color:red;">Не прошел</span>
                    <?php else:?>
                        ---
                    <?php endif;?>
                </td>
                <td>
                    <?php if($championatprognoz->getType()=="vip"):?>
                        Vip
                    <?php else:?>
                        Обычный
                    <?php endif;?>
                </td>
                <td>
                    <a href="changestatuschampprognoz.php?id=<?=$championatprognoz->getId();?>&status=yes&p=<?=$page?>&type=<?=$type;?>">Прошел</a> <br>
                    <a href="changestatuschampprognoz.php?id=<?=$championatprognoz->getId();?>&status=no&p=<?=$page?>&type=<?=$type;?>">Не прошел</a> <br>
                    <a href="changestatuschampprognoz.php?id=<?=$championatprognoz->getId();?>&status=without&p=<?=$page?>&type=<?=$type;?>">Без статуса</a>
                </td>
                <td>
                    <a href="deleteprognoz.php?id=<?=$championatprognoz->getId();?>&type=<?=$type;?>">Удалить</a> <br>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <div style="border-top: 1px dashed grey;padding:10px;">
        <?php if($pages != 0):?>
            <?php if($page!=1):?>
                <a href="championat-prognozi.php?p=<?=$page-1;?>&type=<?=$type?>&id_champ=<?=$id_champ?>">назад</a>
            <?php endif;?>
            <?=$page;?> из <?=$pages;?>
            <?php if($page!=$pages):?>
                <a href="championat-prognozi.php?p=<?=$page+1;?>&type=<?=$type?>&id_champ=<?=$id_champ?>">вперед</a>
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
        $.post('someitems.php',{ids:copylist_json,action:"copy",type:"championatprognoz"},function(data){
            if(data=="ok"){
                window.location.reload();
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
        $.post('someitems.php',{ids:deletelist_json,action:"delete",type:"championatprognoz"},function(data){
            if(data=="ok"){
                window.location.reload();
            }
        });
    });

    $('.changeshowing').click(function(){
        var prognoz_id = $(this).attr('prognoz-id');

        $.post('changeshowing.php',{id:prognoz_id,type:"championatprognoz"},function(data){
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