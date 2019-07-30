<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
session_start();

$nav = "championats";
require_once "php/Database.php";
$db = new Database();
$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$active_paket = $db->getActivePaket($user->getId());

$championats = $db->getChampionatsShowing();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Чемпионаты - Bebets.ru</title>
    <meta name="description" content="Чемпионаты">
    <?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>
    <div class="row">
        <div class="col-md-9">
            <h1>Чемпионаты</h1>
            <?php foreach ($championats as $championat):?>
                <div class="listchampionat virovnayt">
                    <a href="<?=$championat->getSsilka()?>.html">
                        <img src="<?=$championat->getImg()?>" class="img-listchamp">
                    </a>
                    <p><a href="<?=$championat->getSsilka()?>.html" class="name-listchamp"><?=$championat->getNazva()?></a></p>
                </div>
            <?php endforeach;?>
        </div>
        <div class="col-md-3 pdleftcomp-no">
            <?php require_once "side.php";?>
        </div>
    </div>
</div>

<?php require_once "footer.php";?>
<script type="text/javascript">
    $(document).on('ready', function() {
        var highestBox = 0;
        $('.virovnayt').each(function(){
            if($(this).height() > highestBox) {
                highestBox = $(this).height();
            }
        });
        $('.virovnayt ').height(highestBox+5);
    });
</script>


</body>
</html>