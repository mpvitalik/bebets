<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();

$page = isset($_GET['p'])? intval($_GET['p']) : 1;

$mainpost = $db->getMainPost();
$mainpost_second = $db->getMainPostSecond();
$posts = $db->getPostsAdmin($page);

$pages_result = $db->pagesResultPosts();
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
<?php require_once "navbar.php";?>

<div class="container">

    <br><br>
    <h1>Новости
        <small>
            <a href="addpost.php">+ Добавить новость</a>
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
            <th>Название</th>
            <th>Картинка</th>
            <th>Отображ.</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($posts as $post):?>
            <tr>
                <td><input type="checkbox" class="checkprognoz" id="<?=$post->getId()?>"></td>
                <td><?=$post->getId();?></td>
                <td>
                    <?=$post->getNazva();?><br>
                    <small style="color:grey;"><?=$post->getSsilka()?></small>
                    <?php if($post->getSsilka()==""):?>
                        <small style="color:red;">Ссылка пустая</small>
                    <?php endif;?>
                </td>
                <td>
                    <?php if($post->getImg()!=""):?>
                        <img src="../<?=$post->getImg();?>" style="width:100px;height:auto;">
                    <?php endif;?>
                </td>
                <td>
                    <span class="text_showing_<?=$post->getId()?>">
                        <?php if($post->getShowing()=="yes"):?>
                            Да
                        <?php elseif($post->getShowing()=="no"):?>
                            Нет
                        <?php else:?>
                            ---
                        <?php endif;?>
                    </span><br>
                    <a class="changeshowing" prognoz-id="<?=$post->getId()?>">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </a>
                </td>
                <td>
                    <a href="copypost.php?id=<?=$post->getId();?>">Копировать</a> <br>
                    <a href="changepost.php?id=<?=$post->getId();?>">Изменить</a> <br>
                    <a href="deletepost.php?id=<?=$post->getId();?>">Удалить</a><br>
                    <?php if($mainpost->getId()==$post->getId()):?>
                        <span style="color:green;"><b>ЗАКРЕПЛЕНА №1</b></span><br>
                    <?php else:?>
                        <a href="mainpost.php?id=<?=$post->getId();?>&action=update&num=1">Закрепить главной №1</a> <br>
                    <?php endif;?>
                    <?php if($mainpost_second->getId()==$post->getId()):?>
                        <span style="color:green;"><b>ЗАКРЕПЛЕНА №2</b></span><br>
                    <?php else:?>
                        <a href="mainpost.php?id=<?=$post->getId();?>&action=update&num=2">Закрепить главной №2</a> <br>
                    <?php endif;?>
                    <!--<a href="comments.php?id=">Комменты</a>-->
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <div style="border-top: 1px dashed grey;padding:10px;">
        <?php if($pages != 0):?>
        <?php if($page!=1):?>
            <a href="posts.php?p=<?=$page-1;?>">назад</a>
        <?php endif;?>
        <?=$page;?> из <?=$pages;?>
        <?php if($page!=$pages):?>
            <a href="posts.php?p=<?=$page+1;?>">вперед</a>
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
        $.post('someitems.php',{ids:copylist_json,action:"copy",type:"post"},function(data){
            if(data=="ok"){
                window.location.href = "posts.php";
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
        $.post('someitems.php',{ids:deletelist_json,action:"delete",type:"post"},function(data){
            if(data=="ok"){
                window.location.href = "posts.php";
            }
        });
    });

    $('.changeshowing').click(function(){
        var prognoz_id = $(this).attr('prognoz-id');

        $.post('changeshowing.php',{id:prognoz_id,type:"post"},function(data){
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