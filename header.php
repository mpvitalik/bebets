<div class="container pdleftcomp-no hidden-sm hidden-xs zindex9999">
    <div class="row">
        <div class="col-md-2">
            <a href="/"><img src="images/logo.png" class="logo"></a>
        </div>
        <div class="col-md-6 col-md-offset-4 btntop">
            <?php if($user->getId()>0 && $user->getPodtverzden()=="yes"):?>
                <span class="white font18">
                    <i class="fa fa-user" aria-hidden="true"></i> <?=$user->getLogin()?>
                </span>&nbsp;&nbsp;
                <a href="exit.php" class="btnexit-top">Выход</a>
            <?php else:?>
                <a href="https://aff1xstavka.top/L?tag=s_117381m_1341c_bottom&site=117381&ad=1341" target="_blank" rel="nofollow"><img src="https://cdn.advertserve.com/images/betnetmed.advertserve.com/servlet/files/2135"></a>
                <a href="enter.php" class="btnvhod-top">Вход</a>
                <a href="register.php" class="btnreg-top">Регистрация</a>
            <?php endif;?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="megamenu">
                <a href="prognozi.php" class="upper">
                    <li class="<?php if(isset($nav) && $nav=="prognoz")echo "active";?>">Бесплатные прогнозы</li>
                </a>
                <a href="express-today.php" class="upper">
                    <li class="activeexpress">Экспресс на сегодня</li>
                </a>

                <a href="systema.php" class="upper">
                    <li class="<?php if(isset($nav) && $nav=="systema")echo "active";?>">Системы игры</li>
                </a>
                <a href="podpiska.php" class="upper">
                    <li class="<?php if(isset($nav) && $nav=="podpiska")echo "active";?>">Подписка</li>
                </a>
                <a href="otzivi.php" class="upper">
                    <li class="<?php if(isset($nav) && $nav=="otzivi")echo "active";?>">Отзывы клиентов</li>
                </a>
                <a href="garanty.php" class="upper">
                    <li class="<?php if(isset($nav) && $nav=="garanty")echo "active";?>">Наши гарантии</li>
                </a>
                <a href="championats.php" class="upper">
                    <li class="<?php if(isset($nav) && $nav=="championats")echo "active";?>">Чемпионаты</li>
                </a>
            </ul>
        </div>
    </div>
</div>

 <nav class="navbar navbar-inverse navbar-fixed-top hidden-md hidden-lg">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/"><img src="images/logo.png"></a>
    </div>
    <?php if(!isset($user) || $user->getId()==0):?>
        <div class="vhodmob hidden-lg hidden-md"> 
            <a href="enter.php" class="upper">&nbsp;&nbsp;<img src="images/people_vhod.png" style="width:18px;;"><br>&nbsp;Вход</a>
        </div>
    <?php else:?>
        <div class="username hidden-lg hidden-md"> 
            <span><i class="fa fa-user" aria-hidden="true"></i> <?=$user->getLogin()?></span>
        </div>
        <div class="usernameexit hidden-lg hidden-md"> 
            <a href="exit.php">Выход</a>
        </div>
    <?php endif;?>
    
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="<?php if(isset($nav) && $nav=="prognoz")echo "active";?>"><a href="prognozi.php">Бесплатные прогнозы</a></li>
        <li class="activeexpress"><a href="express-today.php">Экспресс на сегодня</a></li>
        <li class="<?php if(isset($nav) && $nav=="systema")echo "active";?>"><a href="systema.php">Системы игры</a></li>
        <li class="<?php if(isset($nav) && $nav=="podpiska")echo "active";?>"><a href="podpiska.php">Подписка</a></li>
        <li class="<?php if(isset($nav) && $nav=="otzivi")echo "active";?>"><a href="otzivi.php">Отзывы клиентов</a></li>
        <li class="<?php if(isset($nav) && $nav=="garanty")echo "active";?>"><a href="garanty.php">Наши гарантии</a></li>
        <li class="<?php if(isset($nav) && $nav=="championats")echo "active";?>"><a href="championats.php">Чемпионаты</a></li>
      </ul>
    </div>
  </div>
</nav> 

<?php

$is_mobile = isMobile();

function isMobile(){
    $useragent=$_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){

        return true;
    }else{
        return false;
    }

}


?>
