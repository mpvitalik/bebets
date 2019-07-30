<?php
/*header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
$nav = "prognozi";
require_once "php/Database.php";
$db = new Database();
$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);*/


//$id = isset($_GET['id']) ? intval($_GET['id']) : die("Error post");
//$prognoz = $db->getPrognozById($id);

//$ssilka = isset($_GET['ssilka'])? htmlspecialchars($_GET['ssilka']) : false;
//$prognoz = $db->getPrognozBySsilka($ssilka);
$nav = "championats";
$active_paket = $db->getActivePaket($user->getId());
$championat = $championatvseturi;

$title = str_replace("'",'', $championat->getTitleSeoturi());
$title = str_replace('"','', $title);
$description = str_replace("'",'', $championat->getDescriptionSeoturi());
$description = str_replace('"','', $description);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$title?></title>
    <meta name="description" content="<?=$description?>">
    <?php /*if($prognoz->getImg()!=""):?>
        <meta property="og:image"   content="<?=$prognoz->getImg()?>" />
    <?php else:?>
        <meta property="og:image"   content="https://bebets.ru/images/logo_fb.jpg" />
	<?php endif;*/?>
    <meta property="og:image"   content="" />

    <?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>
    <div class="row">
        <div class="col-md-9">

            <h1><?=$championat->getH1Seoturi()?></h1>

            <?=$championat->getFullMatchi()?>


            <br><br>
        </div>
        <div class="col-md-3 pdleftcomp-no">
            <?php require_once "side.php";?>
        </div>
    </div>
</div>





<?php require_once "footer.php";?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#textinsert iframe').css('width','100%');
        $('#textinsert table').addClass('table').css('width','100%');
        $('#textinsert img').css("width","auto").css('height','auto').addClass('img-responsive');
    });

    $(document).ready(function(){
        $(".block_champprognoz").mCustomScrollbar({
            theme:"dark",
            scrollInertia:200
        });
    });
</script>

</body>
</html>
