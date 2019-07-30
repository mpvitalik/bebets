<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();


if($_SERVER['REQUEST_METHOD']=="POST"){

    $data = array();
    $data['id_champ'] = (int)$_POST['id_champ'];
    $data['comanda1'] = (int)$_POST['comanda1'];
    $data['comanda2'] = (int)$_POST['comanda2'];
    $data['nazva'] = $_POST['nazva'];
    $data['matchnazva'] = $_POST['matchnazva'];
    $data['ssilka'] = $_POST['ssilka'];
    $data['type'] = $_POST['type'];
    $data['koeficient'] = str_replace(',','.',$_POST['koeficient']);
    $data['date'] = $_POST['date'];
    $data['time'] = $_POST['time'];
    $data['year'] = $_POST['year'];
    $data['img'] = "";
    $data['description'] = $_POST['description'];
    $data['text'] = $_POST['text'];
    $data['text_email'] = $_POST['text_email'];
    $data['showing'] = $_POST['showing'];
    $data['showing_main'] = $_POST['showing_main'];
    $data['tags'] = $_POST['tags'];

    $date_sort = DateTime::createFromFormat('Y.d.m H:i', $data['year'].".".$data['date']." ".$data['time']);
    $data['date_sort'] = $date_sort->format("Y-m-d H:i:s");

    if(isset($_FILES["image"]) && $_FILES["image"]["name"]!="")
    {
        $output_dir = "../img/";
        $fileName = $_FILES["image"]["name"];
        $_FILES['image']['type'] = "image/jpeg";

        if (file_exists($output_dir.$fileName)) {
            $filepath = pathinfo($_FILES["image"]["name"]);
            $fname = $filepath['filename'].rand().rand().".".$filepath['extension'];
            move_uploaded_file($_FILES["image"]["tmp_name"],$output_dir.$fname);
            $img="img/".$fname;
        }else{
            move_uploaded_file($_FILES["image"]["tmp_name"],$output_dir.$fileName);
            $img="img/".$fileName;
        }

        $data['img'] = $img;
    }


    $db->addChampionatprognoz($data);
    $championat = $db->getChampionatById($data['id_champ']);
    header("Location:championat-prognozi.php?id_champ=".$championat->getId());
    die();

}else{
    $id_champ = isset($_GET['id_champ'])? intval($_GET['id_champ']) : 0;
    $championat = $db->getChampionatById($id_champ);
    if($championat->getId()==0){
        die("Error, go back!");
    }
    $championatcomandi = $db->getChampionatcomandiByChampId($championat->getId());
}




$date_now = new DateTime();
date_default_timezone_set('Europe/Kiev');
$year_today = $date_now->format('Y');
$date_today = $date_now->format('Y-m-d');

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
        <div class="col-md-8" >
            <a href="championat-prognozi.php?id_champ=<?=$championat->getId()?>" style="font-size: 18px;">< Назад</a>
            <h3>Добавление прогноза в - <?=$championat->getNazva()?></h3>
            <br><br>
            <form role="form" action="<?=basename(__FILE__)?>" method="post" enctype="multipart/form-data">
                <div class="form-group" style="display:inline-block;width:30%;">
                    <label for="sel1">Команда 1:</label>
                    <select class="form-control" id="comanda1" name="comanda1">
                        <option value="0">Выбрать</option>
                        <?php foreach ($championatcomandi as $championatcomanda):?>
                            <option value="<?=$championatcomanda->getId()?>"><?=$championatcomanda->getNazva()?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group" style="display:inline-block;width:30%;">
                    <label for="sel1">Команда 2:</label>
                    <select class="form-control" id="comanda2" name="comanda2">
                        <option value="0">Выбрать</option>
                        <?php foreach ($championatcomandi as $championatcomanda):?>
                            <option value="<?=$championatcomanda->getId()?>"><?=$championatcomanda->getNazva()?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nazva">Название</label><br>
                    <textarea cols="60" rows="1" name="nazva" id="nazva"></textarea>
                </div>
                <div class="form-group">
                    <label for="nazva">Ссылка <span id="ssilkaexist"></span></label><br>
                    <textarea cols="60" rows="1" name="ssilka" id="ssilka"></textarea>
                </div>
                <div class="form-group">
                    <label for="nazva">Чемпионат</label><br>
                    <textarea cols="60" rows="1" name="matchnazva" id="matchnazva"><?=$championat->getNazva()?></textarea>
                </div>
                <div>
                    <div class="form-group" style="display:inline-block;width:30%">
                        <label for="sel1">Отображать на главной:</label>
                        <select class="form-control" name="showing_main" style="width:200px;">
                            <option value="no">Нет</option>
                            <option value="yes">Да</option>
                        </select>
                    </div>
                    <div class="form-group" style="display:inline-block;width:30%">
                        <label for="sel1">Отображать на сайте:</label>
                        <select class="form-control" name="showing" style="width:200px;">
                            <option value="yes">Да</option>
                            <option value="no">Нет</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="sel1">Тип прогноза:</label>
                    <select class="form-control" name="type" style="width:200px;">
                        <option value="normal">Обычный</option>
                        <option value="vip">VIP</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nazva">Коефициент</label>
                    <input type="text" class="form-control bfh-phone" data-format="d.dd" name="koeficient" style="width:200px;">
                </div>
                <div class="form-group">
                    <label for="nazva">Дата</label>
                    <input type="text" class="form-control bfh-phone" data-format="dd.dd" name="date" style="width:200px;" required>
                </div>
                <div class="form-group">
                    <label for="nazva">Время</label>
                    <input type="text" class="form-control bfh-phone" data-format="dd:dd" name="time" style="width:200px;" required>
                </div>
                <div class="form-group">
                    <label for="nazva">Год</label>
                    <input type="text" class="form-control bfh-phone" data-format="dddd" name="year" value="<?=$year_today?>" style="width:200px;" required>
                </div>
                <div class="form-group">
                    <label for="image">Картинка</label>
                    <input type="file" id="image" name="image">
                </div>
                <div class="form-group">
                    <label for="text_email">Сообщение на email (для Вип прогноза)</label><br>
                    <textarea cols="60" rows="3" name="text_email"></textarea>
                </div>
                <div class="form-group">
                    <label for="description">Описание</label><br>
                    <textarea cols="60" rows="3" name="description"></textarea>
                </div><br>
                <strong>Текст ( Отображается в беспл. прогнозах. В вип - только для Пакета 1,2,3)</strong><br>
                <textarea cols="60" rows="15" name="text"></textarea><br>
                <div class="form-group">
                    <label for="tags">Теги</label><br>
                    <input type="text" class="form-control" id="tag"  list="tagslist" style="width:300px;display:inline-block;">
                    <datalist id="tagslist">
                    </datalist>
                    <button type="button" class="btn btn-success addtag" style="display:inline-block;">добавить</button><br><br><br>
                    <input type="hidden" class="form-control" name="tags" id="tags">
                </div>
                <style>
                    .singletag{background-color:lightgrey;padding:5px;display:inline-block; margin:1px;font-size:12px;}
                    .deletetag{color:red;cursor:pointer;}
                </style>
                <div class="spisoktegov">
                </div>
                <input type="hidden" name="id_champ" value="<?=$championat->getId()?>">
                <hr>
                <button type="submit" class="btn btn-default">Сохранить</button><br><br>
            </form>

        </div>

    </div>

</div>
<script src="js/bootstrap-formhelpers-phone.js"></script>

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
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script>

    CKEDITOR.replace('text_email',{
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    });
    CKEDITOR.replace('text',{
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    });

    CKEDITOR.replace('description',{
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    });
</script>


<script>
    $('#comanda1, #comanda2').change(function(){
        var comanda1_nazva = $( "#comanda1 option:selected" ).text();
        var comanda2_nazva = $( "#comanda2 option:selected" ).text();
        var nazva = comanda1_nazva+" - "+comanda2_nazva+" прогноз на матч";
        $('#nazva').val(nazva);
        var ssilka = urlRusLat(nazva);
        ssilka = ssilka.replace('---','-');
        $('#ssilka').val(ssilka);
        $.post('checkssilka.php',{ssilka:ssilka,type:"championatprognoz"},function(data){
            if(data=="yes"){
                $('#ssilkaexist').text("- Можно").css('color','green');
            }else{
                $('#ssilkaexist').text("- Нельзя").css('color','red');
            }

        });

    });
    $('#nazva').keyup(function(){
        var nazva = $(this).val();
        var ssilka = urlRusLat(nazva);
        ssilka = ssilka.replace('---','-');
        $('#ssilka').val(ssilka);
        $.post('checkssilka.php',{ssilka:ssilka,type:"championatprognoz"},function(data){
            if(data=="yes"){
                $('#ssilkaexist').text("- Можно").css('color','green');
            }else{
                $('#ssilkaexist').text("- Нельзя").css('color','red');
            }

        });
    });

    $('#ssilka').keyup(function(){
        var ssilka = $(this).val();
        $.post('checkssilka.php',{ssilka:ssilka,type:"championatprognoz"},function(data){
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



    var tagcount=1;
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