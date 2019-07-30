<?php
    $side_banner = $db->getReklamaById(2);
?>

<?php if($user->getId()==0):?>
    <div class="bgform">
        <div class="bgformtitle">Рейтинг букмекеров</div>
        <br>
        <div class="row">
            <div class="col-xs-5 pdleft20">
                <img src="images/1xstavka.png" class="img-responsive img-circle">
            </div>
            <div class="col-xs-6">
                <p><span class="side_name_bookm">1. 1xСтавка</span><br>
                Бонус: 4000 руб</p>
                <a href="1hstavka-bukmekerskaya-kontora-bonus-4000-rubley.html" class="side_obzor_bookm">Обзор</a>
                <a href="//aff1xstavka.top/L?tag=s_181081m_1341c_&site=181081&ad=1341" class="side_nasait_bookm" target="_blank">На сайт</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-5 pdleft20">
                <img src="images/leon.jpg" class="img-responsive img-circle">
            </div>
            <div class="col-xs-6">
                <p><span class="side_name_bookm">2. Леон</span><br>
                Бонус: 3999 руб</p>
                <a href="leon-bukmekerskaya-kontora--registraciya-i-rabochee-zerkalo-leon.html" class="side_obzor_bookm">Обзор</a>
                <a href="//leon.ru/?wm=3028849" class="side_nasait_bookm" target="_blank">На сайт</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-5 pdleft20">
                <img src="images/parimatch.jpg" class="img-responsive img-circle">
            </div>
            <div class="col-xs-6">
                <p><span class="side_name_bookm">3. ПариМатч</span><br>
                Бонус: 2500 руб</p>
                <a href="parimatch-bukmekerskaya-kontora-zerkalo-i-registraciya-na-sayte.html" class="side_obzor_bookm">Обзор</a>
                <a href="//paripartners.ru/C.ashx?btag=a_15016b_792c_&affid=7267&siteid=15016&adid=792&c=" class="side_nasait_bookm" target="_blank">На сайт</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-5 pdleft20">
                <img src="images/liga_stavok.jpg" class="img-responsive img-circle">
            </div>
            <div class="col-xs-6">
                <p><span class="side_name_bookm">4. Лига Ставок</span><br>
                Бонус: 50 000 руб</p>
                <a href="liga-stavok-bukmekerskaya-kontora--registraciya-i-rabochee-zerkalo.html" class="side_obzor_bookm">Обзор</a>
                <a href="//playony.ru/go/286c12f72901426ba0eee42428aa9b3e365b64d1eb0a0b0b" class="side_nasait_bookm" target="_blank">На сайт</a>
            </div>
        </div>
        <!--<hr>
        <div class="row">
            <div class="col-xs-5 pdleft20">
                <img src="images/olimp.jpg" class="img-responsive img-circle">
            </div>
            <div class="col-xs-6">
                <p><span class="side_name_bookm">4. Олимп</span><br>
                Бонус: 10 000 руб</p>
                <a href="#" class="side_obzor_bookm">Обзор</a>
                <a href="#" class="side_nasait_bookm" target="_blank">На сайт</a>
            </div>
        </div>-->
        <br>

    </div>
    <br>

    <div class="hidden-xs hidden-sm centered">
        <?=$side_banner->getKod()?>
    </div>
    <div class="hidden-lg hidden-md centered">
        <?=$side_banner->getKodMob()?>
    </div>

    <div class="bgform">
        <div class="bgformtitle">Вход</div>
        <form class="pdsideform" method="post" action="enter.php">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Email" name="email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Пароль" name="pass">
            </div>
            <button type="submit" class="btnorange">Войти</button>
        </form><br>
        <a href="register.php" class="orange">Регистрация</a> &nbsp;&nbsp;| &nbsp;&nbsp;
        <a href="remember-password.php" class="orange">Восстановить пароль</a>
    </div>
    <br>
    <div class="bgform">
        <div class="bgformtitle-podpiska">Подписка на прогнозы</div>
        <form class="pdsideform">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Email" id="email-podpiska">
            </div>
            <button type="button" class="btnorange btn-podpiska">Подписаться</button>
        </form>
    </div>
<?php elseif ($user->getId()>0 && $user->getPodtverzden()=="yes"):?>
    <div class="bgform">
        <div class="bgformtitle">Мой кабинет</div><br>
        <i class="fa fa-user" aria-hidden="true"></i> <?=$user->getLogin()?><br>
        <?php if(isset($active_paket) && is_array($active_paket) && $active_paket['name']!=false && $active_paket['date_ends']!=false):?>

                <i class="fa fa-star" aria-hidden="true"></i>
                Активный: Пакет
                <?php
                if($active_paket['name']=="paket_one"){
                    echo "№1";
                }elseif($active_paket['name']=="paket_two"){
                    echo "№2";
                }elseif($active_paket['name']=="paket_three"){
                    echo "№3";
                }
                ?>
            <br>
            <i class="fa fa-clock-o" aria-hidden="true"></i>
                Дата окончания: <?=$active_paket['date_ends']->format('d.m.Y')?>
            <div id="CDT"></div>
            <input type="hidden" id="showtimer" value="yes">
            <input type="hidden" id="dateendstimer" value="<?=$active_paket['date_ends']->format('Y/m/d H:i:s')?>">
            <br>
        <?php else:?>
            <input type="hidden" id="showtimer" value="no">
        <?php endif;?>

        <a href="exit.php">Выход</a>
    </div>
    <br>
     <div class="bgform">
        <div class="bgformtitle">Рейтинг букмекеров</div>
        <br>
        <div class="row">
            <div class="col-xs-5 pdleft20">
                <img src="images/1xstavka.png" class="img-responsive img-circle">
            </div>
            <div class="col-xs-6">
                <p><span class="side_name_bookm">1. 1xСтавка</span><br>
                Бонус: 4000 руб</p>
                <a href="1hstavka-bukmekerskaya-kontora-bonus-4000-rubley.html" class="side_obzor_bookm">Обзор</a>
                <a href="//aff1xstavka.top/L?tag=s_181081m_1341c_&site=181081&ad=1341" class="side_nasait_bookm" target="_blank">На сайт</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-5 pdleft20">
                <img src="images/leon.jpg" class="img-responsive img-circle">
            </div>
            <div class="col-xs-6">
                <p><span class="side_name_bookm">2. Леон</span><br>
                Бонус: 3999 руб</p>
                <a href="leon-bukmekerskaya-kontora--registraciya-i-rabochee-zerkalo-leon.html" class="side_obzor_bookm">Обзор</a>
                <a href="//leon.ru/?wm=3028849" class="side_nasait_bookm" target="_blank">На сайт</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-5 pdleft20">
                <img src="images/parimatch.jpg" class="img-responsive img-circle">
            </div>
            <div class="col-xs-6">
                <p><span class="side_name_bookm">3. ПариМатч</span><br>
                Бонус: 2500 руб</p>
                <a href="parimatch-bukmekerskaya-kontora-zerkalo-i-registraciya-na-sayte.html" class="side_obzor_bookm">Обзор</a>
                <a href="//paripartners.ru/C.ashx?btag=a_15016b_792c_&affid=7267&siteid=15016&adid=792&c=" class="side_nasait_bookm" target="_blank">На сайт</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-5 pdleft20">
                <img src="images/liga_stavok.jpg" class="img-responsive img-circle">
            </div>
            <div class="col-xs-6">
                <p><span class="side_name_bookm">4. Лига Ставок</span><br>
                Бонус: 50 000 руб</p>
                <a href="liga-stavok-bukmekerskaya-kontora--registraciya-i-rabochee-zerkalo.html" class="side_obzor_bookm">Обзор</a>
                <a href="//playony.ru/go/286c12f72901426ba0eee42428aa9b3e365b64d1eb0a0b0b" class="side_nasait_bookm" target="_blank">На сайт</a>
            </div>
        </div>
        <!--<hr>
        <div class="row">
            <div class="col-xs-5 pdleft20">
                <img src="images/olimp.jpg" class="img-responsive img-circle">
            </div>
            <div class="col-xs-6">
                <p><span class="side_name_bookm">4. Олимп</span><br>
                Бонус: 10 000 руб</p>
                <a href="#" class="side_obzor_bookm">Обзор</a>
                <a href="#" class="side_nasait_bookm" target="_blank">На сайт</a>
            </div>
        </div>-->
        <br>

    </div>
    <div class="hidden-xs hidden-sm centered">
        <?=$side_banner->getKod()?>
    </div>
    <div class="hidden-lg hidden-md centered">
        <?=$side_banner->getKodMob()?>
    </div>
<?php endif;?>
<br>


<div class="bgform">
    <div class="bgformtitle-podpiska">Прогнозы пользователей</div>

    <?php $users_prognozi = $db->getUsersPrognoziToday();?>

    <div class="pdsideform">
        <div class="parentscrollside">
            <form class="form-userprognoz <?php if(count($users_prognozi)==0) echo "showblock";?>" >
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Введите Чемпионат.." id="userprognoz_championat">
                    <span class="robotofamily red font12" id="userprognoz_championat_error"></span>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Введите название команд.." id="userprognoz_komandi">
                    <span class="robotofamily red font12" id="userprognoz_komandi_error"></span>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Введите прогноз.." id="userprognoz_prognoz">
                    <span class="robotofamily red font12" id="userprognoz_prognoz_error"></span>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Введите коэффициет.." id="userprognoz_koef">
                    <span class="robotofamily red font12" id="userprognoz_koef_error"></span>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control bfh-phone" data-format="dd:dd" placeholder="Введите время начала матча.." id="userprognoz_time">
                    <span class="robotofamily red font12" id="userprognoz_time_error"></span>
                </div>

                <?php if($user->getId()>0):?>
                    <button type="button" class="btnorange sendprognoz">Предложить прогноз<br> на сегодня</button>
                <?php else:?>
                    <button type="button" class="btnorange showpredlogprognoz_nouser">Предложить прогноз<br> на сегодня</button>
                    <br><br>
                    <a href="enter.php" class="orange">Вход</a> &nbsp;&nbsp;| &nbsp;&nbsp;
                    <a href="register.php" class="orange">Зарегистрироваться</a>
                    <br>
                <?php endif;?>
            </form>

            <div class="childscrollside">

                <div class="usersprognoz">

                    <?php foreach ($users_prognozi as $user_prognoz):?>
                        <p class="chatp">
                            <span class="chat_championat"><?=$user_prognoz->getChampionat()?></span><br>
                            <span class="chat_championat"><?=$user_prognoz->getComandi()?></span><br>
                            <span class="chat_championat"><?=$user_prognoz->getPrognoz()?></span><br>
                            <span class="chat_koeficient"><?=$user_prognoz->getKoeficient()?></span><br>
                            <span class="chat_date"><?=$user_prognoz->getTimeChampionat()?> &nbsp; <?=$user_prognoz->getDatetoday()?></span><br>
                            <span class="chat_date"><?=$user_prognoz->getName()?></span>
                        </p>
                        <hr>
                    <?php endforeach;?>

                </div>
            </div>
        </div>
        <div class="usersprognoz_buttons <?php if(count($users_prognozi)==0)echo "hideblock";?>">
            <br>
            <?php if($user->getId()>0):?>
                <button type="button" class="btnorange showpredlogprognoz">Предложить прогноз<br> на сегодня</button>
            <?php else:?>
                <button type="button" class="btnorange showpredlogprognoz_nouser">Предложить прогноз<br> на сегодня</button>
                <br><br>
                <a href="enter.php" class="orange">Вход</a> &nbsp;&nbsp;| &nbsp;&nbsp;
                <a href="register.php" class="orange">Зарегистрироваться</a>
            <?php endif;?>
        </div>
    </div>

</div>
<br>



<?php
    $statistics_side = $db->getStatisctics();
?>
<div class="bgform">
    <div class="bgformtitle-podpiska">Статистика</div>
    <div class="pdsideform">
        <div class="row">
            <div class="col-xs-3 col-xs-offset-2">
                <div class="pie green_pie"><?=ceil($statistics_side['percent_proshli'])?>%</div>
            </div>
            <div class="col-xs-6">
                <div class="piecount">
                    <?=$statistics_side['count_proshli']?><br>Прошло
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-3 col-xs-offset-2">
                <div class="pie red_pie"><?=floor($statistics_side['percent_neproshli'])?>%</div>
            </div>
            <div class="col-xs-6">
                <div class="piecount">
                    <?=$statistics_side['count_neproshli']?><br>Не прошло
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-3 col-xs-offset-2">
                <div class="pie yellow_pie"><?=intval(ceil($statistics_side['roi']))?>%</div>
            </div>
            <div class="col-xs-6">
                <div class="piecount">
                    % <br>
                    ROI
                </div>
            </div>
        </div>
        <br>
    </div>
</div>
<br>


<!--<img src="images/reklamma.jpg" class="img-responsive"><br>
<img src="images/reklamma.jpg" class="img-responsive"><br>-->