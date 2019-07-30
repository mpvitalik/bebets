<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();


if($_SERVER['REQUEST_METHOD']=="POST"){

    $post = new Post();
    $post->setId(intval($_POST['id']));
    $post->setNazva($_POST['nazva']);
    $post->setDescription($_POST['description']);
    $post->setText($_POST['text']);
    $post->setSsilka($_POST['ssilka']);
    $post->setTags($_POST['tags']);

    $db->changePost($post);
    header("Location:posts.php?type=".$_POST['type']);
    die();

}else{
    $id = isset($_GET['id'])? intval($_GET['id']) : die("Error,go back");
    $post = $db->getPostById($id);
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
            <a href="posts.php" style="font-size: 18px;">< Назад</a>
            <h1><?=$post->getNazva()?></h1>
            <?php if($post->getImg()!=""):?>
                <a href="../<?=$post->getImg()?>" target="_blank">
                    <img src="../<?=$post->getImg()?>" style="width: 200px;">
                </a><br>
            <?php endif;?>
            <a href="changephoto.php?id=<?=$post->getId()?>">[ Изменить картинку ]</a><br><br>
            <form role="form" action="<?=basename(__FILE__)?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nazva">Заголовок</label><br>
                    <textarea cols="60" rows="1" name="nazva" id="nazva"><?=$post->getNazva()?></textarea>
                </div>
                <div class="form-group">
                    <label for="nazva">Ссылка <span id="ssilkaexist"></span></label><br>
                    <textarea cols="60" rows="1" name="ssilka" id="ssilka"><?=$post->getSsilka()?></textarea>
                </div>
                <div class="form-group">
                    <label for="description">Краткое описание</label><br>
                    <textarea cols="60" rows="3" name="description"><?=$post->getDescription()?></textarea>
                </div>

                <input type="hidden" name="id" value="<?=$id;?>">

                <strong>Текст</strong><br>
                <textarea cols="60" rows="15" name="text"><?=$post->getText()?></textarea><br>

                <div class="form-group">
                    <label for="tags">Теги</label><br>
                    <input type="text" class="form-control" id="tag"  list="tagslist" style="width:300px;display:inline-block;">
                    <datalist id="tagslist">
                    </datalist>
                    <button type="button" class="btn btn-success addtag" style="display:inline-block;">добавить</button><br><br><br>
                    <input type="hidden" class="form-control" name="tags" id="tags" value="<?=htmlspecialchars($post->getTags())?>">
                </div>
                <style>
                    .singletag{background-color:lightgrey;padding:5px;display:inline-block; margin:1px;font-size:12px;}
                    .deletetag{color:red;cursor:pointer;}
                </style>
                <div class="spisoktegov">
                    <?php
                    $tags = explode(";", $post->getTags());
                    $tagcount = 1;
                    ?>
                    <?php foreach ($tags as $tag):?>
                        <?php if($tag=="" || $tag==" " || $tag=="  ")continue;?>
                        <div class="singletag" tagcount="<?=$tagcount?>"><?=$tag?></div> <a class="deletetag" tagcount="<?=$tagcount?>" onclick='deleteTag(<?=$tagcount?>)'>x |</a>
                        <?php $tagcount++;?>
                    <?php endforeach;?>
                </div>
                <hr>
                <button type="submit" class="btn btn-default">Сохранить</button><br><br>
            </form>

        </div>

    </div>

</div>

<script>
    function urlRusLat(str) {
        str = str.toLowerCase(); // все в нижний регистр
        var cyr2latChars = new Array(
            ['а', 'a'], ['б', 'b'], ['в', 'v'], ['г', 'g'],
            ['д', 'd'],  ['е', 'e'], ['ё', 'yo'], ['ж', 'zh'], ['з', 'z'],
            ['и', 'i'], ['й', 'y'], ['к', 'k'], ['л', 'l'],
            ['м', 'm'],  ['н', 'n'], ['о', 'o'], ['п', 'p'],  ['р', 'r'],
            ['с', 's'], ['т', 't'], ['у', 'u'], ['ф', 'f'],
            ['х', 'h'],  ['ц', 'c'], ['ч', 'ch'],['ш', 'sh'], ['щ', 'shch'],
            ['ъ', ''],  ['ы', 'y'], ['ь', ''],  ['э', 'e'], ['ю', 'yu'], ['я', 'ya'],

            ['А', 'A'], ['Б', 'B'],  ['В', 'V'], ['Г', 'G'],
            ['Д', 'D'], ['Е', 'E'], ['Ё', 'YO'],  ['Ж', 'ZH'], ['З', 'Z'],
            ['И', 'I'], ['Й', 'Y'],  ['К', 'K'], ['Л', 'L'],
            ['М', 'M'], ['Н', 'N'], ['О', 'O'],  ['П', 'P'],  ['Р', 'R'],
            ['С', 'S'], ['Т', 'T'],  ['У', 'U'], ['Ф', 'F'],
            ['Х', 'H'], ['Ц', 'C'], ['Ч', 'CH'], ['Ш', 'SH'], ['Щ', 'SHCH'],
            ['Ъ', ''],  ['Ы', 'Y'],
            ['Ь', ''],
            ['Э', 'E'],
            ['Ю', 'YU'],
            ['Я', 'YA'],

            ['a', 'a'], ['b', 'b'], ['c', 'c'], ['d', 'd'], ['e', 'e'],
            ['f', 'f'], ['g', 'g'], ['h', 'h'], ['i', 'i'], ['j', 'j'],
            ['k', 'k'], ['l', 'l'], ['m', 'm'], ['n', 'n'], ['o', 'o'],
            ['p', 'p'], ['q', 'q'], ['r', 'r'], ['s', 's'], ['t', 't'],
            ['u', 'u'], ['v', 'v'], ['w', 'w'], ['x', 'x'], ['y', 'y'],
            ['z', 'z'],

            ['A', 'A'], ['B', 'B'], ['C', 'C'], ['D', 'D'],['E', 'E'],
            ['F', 'F'],['G', 'G'],['H', 'H'],['I', 'I'],['J', 'J'],['K', 'K'],
            ['L', 'L'], ['M', 'M'], ['N', 'N'], ['O', 'O'],['P', 'P'],
            ['Q', 'Q'],['R', 'R'],['S', 'S'],['T', 'T'],['U', 'U'],['V', 'V'],
            ['W', 'W'], ['X', 'X'], ['Y', 'Y'], ['Z', 'Z'],

            [' ', '-'],['0', '0'],['1', '1'],['2', '2'],['3', '3'],
            ['4', '4'],['5', '5'],['6', '6'],['7', '7'],['8', '8'],['9', '9'],
            ['-', '-']

        );

        var newStr = new String();

        for (var i = 0; i < str.length; i++) {

            ch = str.charAt(i);
            var newCh = '';

            for (var j = 0; j < cyr2latChars.length; j++) {
                if (ch == cyr2latChars[j][0]) {
                    newCh = cyr2latChars[j][1];

                }
            }
            // Если найдено совпадение, то добавляется соответствие, если нет - пустая строка
            newStr += newCh;

        }
        // Удаляем повторяющие знаки - Именно на них заменяются пробелы.
        // Так же удаляем символы перевода строки, но это наверное уже лишнее
        return newStr.replace(/[_]{2,}/gim, '_').replace(/\n/gim, '');
    }
</script>

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

<script>
    $('#nazva').keyup(function(){
        var nazva = $(this).val();
        var ssilka = urlRusLat(nazva);
        ssilka = ssilka.replace('---','-');
        $('#ssilka').val(ssilka);
        $.post('checkssilka.php',{ssilka:ssilka,type:"post"},function(data){
            if(data=="yes"){
                $('#ssilkaexist').text("- Можно").css('color','green');
            }else{
                $('#ssilkaexist').text("- Нельзя").css('color','red');
            }

        });
    });

    $('#ssilka').keyup(function(){
        var ssilka = $(this).val();
        $.post('checkssilka.php',{ssilka:ssilka,type:"post"},function(data){
            if(data=="yes"){
                $('#ssilkaexist').text("- Можно").css('color','green');
            }else{
                $('#ssilkaexist').text("- Нельзя").css('color','red');
            }

        });
    });

    $('#tag').keyup(function(){
        var tag = $(this).val();
        $.post('checktag.php',{tag:tag},function(data){
            $('#tagslist').html(data);
        });
    });

    var tagcount=<?=$tagcount?>;

    $('.addtag').click(function(){
        var tag = $('#tag').val();
        if(tag=="" || tag==" " || tag=="  "){
            alert("Впишите тег!");
        }else{
            $.post('checktagexist.php',{tag:tag},function(data){
                if(data=="yes"){
                    $('.spisoktegov').append("<div class=\"singletag\" tagcount=\""+tagcount+"\">"+tag+"</div> <a class=\"deletetag\" tagcount=\""+tagcount+"\" onclick='deleteTag("+tagcount+")'>x |</a> ");
                    $('#tag').val("");
                    tagcount++;
                    setTagsInput();
                }else{
                    alert("Даного тега не существует!");
                }
            });
        }
    });

    function deleteTag(numb){
        $('.singletag[tagcount="'+numb+'"]').remove();
        $('.deletetag[tagcount="'+numb+'"]').remove();
        setTagsInput();
    }
    function setTagsInput(){
        var str = "";
        $('.singletag').each(function(){
            str += $(this).text()+";";
        });
        $('#tags').val(str);
    }
</script>



</body>

</html>