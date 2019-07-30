<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();


if($_SERVER['REQUEST_METHOD']=="POST"){
    $data = array();
    $data['id'] = (int)$_POST['id'];
    $data['nazva'] = $_POST['nazva'];
    $data['ssilka'] = $_POST['ssilka'];
    $data['sort'] = (int)$_POST['sort'];
    $data['href_tablica'] = $_POST['href_tablica'];
    $data['href_matchi'] = $_POST['href_matchi'];
    $data['description'] = $_POST['description'];
    $data['text'] = $_POST['text'];
    $data['text_prognozi_bottom'] = $_POST['text_prognozi_bottom'];
    $data['title_seoturi'] = $_POST['title_seoturi'];
    $data['description_seoturi'] = $_POST['description_seoturi'];
    $data['h1_seoturi'] = $_POST['h1_seoturi'];

    $championat = $db->getChampionatById($data['id']);
    $data['img'] = $championat->getImg();

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

        $data['img'] = $img;

    }

    $db->changeChampionat($data);
    header("Location:championats.php");
    die();

}else{
    $id = isset($_GET['id'])? intval($_GET['id']) : die("Error,go back");
    $championat = $db->getChampionatById($id);
    $championat_comandi = $db->getChampionatcomandiByChampId($championat->getId());
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
    <style>
        a{cursor: pointer;}
    </style>
</head>
<body>
<?php require_once "navbar.php";?>


<div class="container">
    <div class="row">
        <div class="col-md-8" >
            <a href="championats.php" style="font-size: 18px;">< Назад</a>
            <h3><?=$championat->getNazva()?></h3>
            <h4><a href="championat-prognozi.php?id_champ=<?=$championat->getId()?>">[ Открыть прогнозы ]</a></h4>
            <br>
            <form role="form" action="<?=basename(__FILE__)?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nazva">Название</label><br>
                    <textarea cols="60" rows="1" name="nazva" id="nazva"><?=$championat->getNazva()?></textarea>
                </div>
                <div class="form-group">
                    <label for="nazva">Ссылка <span id="ssilkaexist"></span></label><br>
                    <textarea cols="60" rows="1" name="ssilka" id="ssilka"><?=$championat->getSsilka()?></textarea>
                </div>
                <div class="form-group">
                    <label for="nazva">Очередь на сайте</label><br>
                    <textarea cols="10" rows="1" name="sort"><?=$championat->getSort()?></textarea>
                </div>
                <div class="form-group">
                    <label for="nazva">URL - таблицы (Терикон) <small>Т: <?=$championat->getDateSyncTablica()?></small></label><br>
                    <textarea cols="60" rows="1" name="href_tablica"><?=$championat->getHrefTablica()?></textarea>
                </div>
                <div class="form-group">
                    <label for="nazva">URL - матчи (Терикон) <small>М: <?=$championat->getDateSyncMatchi()?></small></label><br>
                    <textarea cols="60" rows="1" name="href_matchi"><?=$championat->getHrefMatchi()?></textarea>
                </div>
                <div class="form-group">
                    <label for="description">Краткое описание (Description)</label><br>
                    <textarea cols="60" rows="3" name="description"><?=$championat->getDescription()?></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Картинка</label><br>
                    <?php if($championat->getImg()!=""):?>
                        <a href="../<?=$championat->getImg()?>" target="_blank">
                            <img src="../<?=$championat->getImg()?>" style="width: 200px;">
                        </a><br>
                    <?php endif;?>[Изменить]
                    <input type="file" id="image" name="image">
                </div>

                <strong>Текст</strong><br>
                <textarea cols="60" rows="15" name="text"><?=$championat->getText()?></textarea><br>

                <input type="hidden" name="text_prognozi_bottom">
                <!--<strong>Текст внизу всех прогнозов на чемпионат</strong><br>
                <textarea cols="60" rows="15" name="text_prognozi_bottom"><?=''//$championat->getTextPrognoziBottom()?></textarea><br>-->

                <hr>
                <h4>Seo блок для списка туров</h4>
                <div class="form-group">
                    <label for="nazva">Title</label><br>
                    <textarea cols="60" rows="1" name="title_seoturi"><?=$championat->getTitleSeoturi()?></textarea>
                </div>
                <div class="form-group">
                    <label for="nazva">Description</label><br>
                    <textarea cols="60" rows="2" name="description_seoturi"><?=$championat->getDescriptionSeoturi()?></textarea>
                </div>
                <div class="form-group">
                    <label for="nazva">H1</label><br>
                    <textarea cols="60" rows="1" name="h1_seoturi"><?=$championat->getH1Seoturi()?></textarea>
                </div>
                <hr>


                <input type="hidden" name="id" value="<?=$championat->getId()?>">
                <hr>
                <button type="submit" class="btn btn-default">Сохранить</button><br><br>
            </form>
            

            <br><br><br><br>

        </div>
        <div class="col-md-4" style="border:1px solid grey;">
            <form role="form" action="addchampionat-comanda.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <br>
                    <input type="text" name="nazva" placeholder="Название команды">
                    <input type="hidden" name="championatid" value="<?=$championat->getId()?>">
                    <button type="submit" class="btn btn-default">Сохранить команду</button>
                </div>
            </form>
            <div style="border-bottom: 1px solid grey"></div>
            <h4 style="font-weight:bold;text-align:center;">Список команд:</h4>
            <table class="table" >
                <tbody>
                    <?php foreach ($championat_comandi as $championat_comanda):?>
                        <tr>
                            <td><?=$championat_comanda->getNazva()?></td>
                            <td>
                                <a href="changechamp-comand.php?id=<?=$championat_comanda->getId()?>">Измен</a> &nbsp;
                                <a class="deletecomanda" data-id="<?=$championat_comanda->getId()?>" style="color:red;">Х</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
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
    CKEDITOR.replace('text_prognozi_bottom',{
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
        $.post('checkssilka.php',{ssilka:ssilka,type:"championat"},function(data){
            if(data=="yes"){
                $('#ssilkaexist').text("- Можно").css('color','green');
            }else{
                $('#ssilkaexist').text("- Нельзя").css('color','red');
            }

        });
    });

    $('#ssilka').keyup(function(){
        var ssilka = $(this).val();
        $.post('checkssilka.php',{ssilka:ssilka,type:"championat"},function(data){
            if(data=="yes"){
                $('#ssilkaexist').text("- Можно").css('color','green');
            }else{
                $('#ssilkaexist').text("- Нельзя").css('color','red');
            }

        });
    });

    $('.deletecomanda').click(function(){
        var idproduct = $(this).attr('data-id');

        if (confirm("Удалить?")) {
            window.location.href = "deletechamp-comanda.php?id="+idproduct;
        }
    });

</script>



</body>

</html>