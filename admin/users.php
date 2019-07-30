<?php
session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();
$page = isset($_GET['p'])? intval($_GET['p']) : 1;

$users = $db->getUsersAdmin($page);
$pages_result = $db->pagesResultUsers();
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
        a{cursor:pointer}
    </style>
</head>
<body>
<?php require_once "navbar.php";?></nav>

<div class="container">


    <br><br>

    <h1>
        Пользователи
    </h1>

    <p><a class="deletesomeitems">Удалить</a> |
        <a class="otmetitvse">Отметить все</a> | <a class="ubratvidelenie">Убрать выделенные </a></p>
    <br>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>id</th>
            <th>Login</th>
            <th>Email</th>
            <th>Пакет</th>
            <th>Коммент</th>
            <th><button type="button" class="btn btn-default podtverdit">Разрешить действия</button></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($users as $user):?>
            <?php
                $active_paket = $db->getActivePaket($user->getId());
                $comments_user = $db->getAllCommentsUserAdmin($user->getId());
                $likes_postavil = $db->getCountLikesUserPostavilAdmin($user->getId());
                $likes_poluchil = $db->getCountLikesUserPoluchilAdmin($user->getId());
            ?>
            <tr>
                <td><input type="checkbox" class="checkprognoz" id="<?=$user->getId()?>"></td>
                <td><?=$user->getId()?></td>
                <td><?=$user->getLogin()?></td>
                <td><?=$user->getEmail();?></td>
                <td>
                    <?php if($active_paket['name']!=false):?>
                        Пакет
                        <?php
                            if($active_paket['name']=="paket_one"){
                                echo "№1";
                            }elseif($active_paket['name']=="paket_two"){
                                echo "№2";
                            }elseif($active_paket['name']=="paket_three"){
                                echo "№3";
                            }
                        ?><br>
                        До: <?=$active_paket['date_ends']->format('d.m.Y H:i:s')?>
                    <?php else:?>
                        ---
                    <?php endif;?>
                </td>
                <td>
                    Комментов  <b><?=count($comments_user)?></b><br>
                    Поставил + <b><?=count($likes_postavil['likes'])?></b><br>
                    Поставил - <b><?=count($likes_postavil['dislikes'])?></b><br>
                    Получил + <b><?=count($likes_poluchil['likes'])?></b><br>
                    Получил - <b><?=count($likes_poluchil['dislikes'])?></b><br>
                </td>
                <td>
                    <div class="hideactions">
                        <a class="paket1" user-id="<?=$user->getId()?>">Вкл: Пакет №1</a><br>
                        <a class="paket2" user-id="<?=$user->getId()?>">Вкл: Пакет №2</a><br>
                        <a class="paket3" user-id="<?=$user->getId()?>">Вкл: Пакет №3</a><br>
                        <a class="obnulit" user-id="<?=$user->getId()?>">Обнулить пакет</a><br>
                        <br>
                        <a class="deleteuser" user-id="<?=$user->getId()?>" style="color:red;">Удалить пользователя</a>
                    </div>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <div style="border-top: 1px dashed grey;padding:10px;">
        <?php if($pages != 0):?>
            <?php if($page!=1):?>
                <a href="users.php?p=<?=$page-1;?>">назад</a>
            <?php endif;?>
            <?=$page;?> из <?=$pages;?>
            <?php if($page!=$pages):?>
                <a href="users.php?p=<?=$page+1;?>">вперед</a>
            <?php endif;?>
        <?php endif;?>
    </div>


</div>

<script>
    $('.hideactions').hide();

    $('.podtverdit').click(function(){
        $('.hideactions').toggle();
    });

    $('.paket1').click(function(){
        var butt = $(this);
        var user_id = butt.attr('user-id');
        $.post('useractions.php',{id:user_id,action:'paket1'},function(data){
            location.reload();
        });
    });

    $('.paket2').click(function(){
        var butt = $(this);
        var user_id = butt.attr('user-id');
        $.post('useractions.php',{id:user_id,action:'paket2'},function(data){
            location.reload();
        });
    });

    $('.paket3').click(function(){
        var butt = $(this);
        var user_id = butt.attr('user-id');
        $.post('useractions.php',{id:user_id,action:'paket3'},function(data){
            location.reload();
        });
    });

    $('.obnulit').click(function(){
        var butt = $(this);
        var user_id = butt.attr('user-id');
        $.post('useractions.php',{id:user_id,action:'obnulit'},function(data){
            location.reload();
        });
    });

    $('.deleteuser').click(function(){
        var butt = $(this);
        var user_id = butt.attr('user-id');
        $.post('useractions.php',{id:user_id,action:'deleteuser'},function(data){
            location.reload();
        });
    });
</script>

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
        $.post('someitems.php',{ids:deletelist_json,action:"delete",type:"user"},function(data){
            if(data=="ok"){
                window.location.href = "users.php";
            }
        });
    });

</script>


</body>

</html>
