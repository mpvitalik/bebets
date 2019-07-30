<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();
$type = isset($_GET['type'])? htmlspecialchars($_GET['type']) : "sam";

$podpiski = $db->getPodpiski($type);

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
        .select{font-weight:900;color:green;}
    </style>
</head>
<body>
<?php require_once "navbar.php";?></nav>

<div class="container">

    <br><br>
    <h1>Подписчики</h1>

    <div style="font-size: 18px;">
        <a href="podpiski.php?type=sam" class="<?php if($type=="sam")echo "select";?>">Сами подписались</a> |
        <a href="podpiski.php?type=buysomething" class="<?php if($type=="buysomething")echo "select";?>">Купили прогноз</a> |
        <a href="podpiski.php?type=all" class="<?php if($type=="all")echo "select";?>">Все подписчики</a>
    </div>

    <br><br>
    <p><a class="deletesomeitems">Удалить</a> |
        <a class="otmetitvse">Отметить все</a> | <a class="ubratvidelenie">Убрать выделенные </a></p>
    <br>
    <table class="table" >
        <thead>
        <tr>
            <th></th>
            <th>id</th>
            <th>Email</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($podpiski as $podpiska):?>
            <tr>
                <td><input type="checkbox" class="checkprognoz" id="<?=$podpiska->getId()?>"></td>
                <td><?=$podpiska->getId();?></td>
                <td><?=$podpiska->getEmail();?></td>

                <td>
                    <a href="deletepodpiska.php?id=<?=$podpiska->getId();?>">Удалить</a><br>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
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
        $.post('someitems.php',{ids:deletelist_json,action:"delete",type:"podpiski"},function(data){
            if(data=="ok"){
                window.location.href = "podpiski.php";
            }
        });
    });

</script>
</body>
</html>
