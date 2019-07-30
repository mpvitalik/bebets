<?php

require_once "db.php";
require_once "classes/Post.php";
require_once "classes/Category.php";
require_once "classes/Reklama.php";
require_once "classes/User.php";
require_once "classes/Usersession.php";
require_once "classes/Comment.php";
require_once "classes/Predlogpost.php";
require_once "classes/Prognoz.php";
require_once "classes/Express.php";
require_once "classes/Zakaz.php";
require_once "classes/Otherpage.php";
require_once "classes/Podpiska.php";
require_once "classes/Otziv.php";
require_once "classes/Userprognoz.php";
require_once "classes/Prognozcomment.php";
require_once "classes/Prognozcommentlike.php";
require_once "classes/Prognozgolosovanie.php";
require_once "classes/Tag.php";
require_once "classes/Postcomment.php";
require_once "classes/Postcommentlike.php";
require_once "classes/Championat.php";
require_once "classes/Championatcomanda.php";



class Database
{

    private $mysql;

    public function __construct()
    {
        $this->mysql = new mysqli(HOST, USER, PASS, DB);
        $this->mysql->query('SET NAMES utf8');
    }

    public function __destruct()
    {
        $this->mysql->close();
    }



    /*===============================ADMIN===================================*/


    /*--------------------CATEGORIES------------------*/

    public function getCategoryByEng($nazva_eng){
        $name = $this->mysql->real_escape_string($nazva_eng);
        $rs = $this->mysql->query("select * from categories where nazva_eng='".$name."'");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();

        $category = new Category();
        $category->setCategory($row);

        return $category;
    }


    public function getAllCategories(){
        $rs = $this->mysql->query("select * from categories");
        $categories = array();
        while(($row = $rs->fetch_assoc())!=false){
            $category = new Category();
            $category->setCategory($row);
            $categories[] = $category;
        }

        return $categories;
    }

    

    /*----------------------POSTS----------------------------*/

    public function getPostById($id){
        $id = intval($id);
        $rs = $this->mysql->query("select * from posts where id=$id");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $post = new Post();
        $post->setPost($row);
        return $post;

    }

    public function getPostBySsilka($ssilka){

        $rs = $this->mysql->query("select * from posts where ssilka='{$ssilka}'");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $post = new Post();
        $post->setPost($row);
        return $post;

    }

    public function changePost($post){
        $nazva = $this->mysql->real_escape_string($post->getNazva());
        $description = $this->mysql->real_escape_string($post->getDescription());
        $ssilka = $this->mysql->real_escape_string($post->getSsilka());
        $tags = $this->mysql->real_escape_string($post->getTags());

        $this->mysql->query("UPDATE posts SET nazva='{$nazva}', ssilka='{$ssilka}',
        description='{$description}', text='{$post->getText()}', tags='{$tags}' where id={$post->getId()}");
    }

    public function deletePost($id){
        $id = intval($id);
        $this->mysql->query("delete from posts where id={$id}");
        $this->mysql->query("UPDATE mainpost SET id_post=0 where id_post=$id");
    }

    public function copyPost($id){
        $id = intval($id);
        $this->mysql->query("insert into posts (nazva,description,img,text,showing)
    select nazva,description,img,text,showing from posts where id=$id;");
        $ins_id = $this->mysql->insert_id;
        $this->mysql->query("UPDATE posts SET showing='no' where id={$ins_id}");
    }

    public function getPostsAdmin($page){
        $limit = 40;
        $offset = (intval($page)-1)*$limit;

        $rs = $this->mysql->query("select * from posts ORDER BY id DESC LIMIT $offset, $limit");
        $posts = array();
        while(($row = $rs->fetch_assoc())!=false){
            $post = new Post();
            $post->setPost($row);
            $posts[] = $post;
        }
        return $posts;
    }

    public function getPostsByEng($nazva_eng, $page){

        $limit = 40;
        $offset = (intval($page)-1)*$limit;

        $name = $this->mysql->real_escape_string($nazva_eng);
        $rs = $this->mysql->query("select * from posts where cat='".$name."' ORDER BY id DESC LIMIT $offset, $limit");
        $posts = array();
        while(($row = $rs->fetch_assoc())!=false){
            $post = new Post();
            $post->setPost($row);
            $posts[] = $post;
        }
        return $posts;
    }

    public function pagesResultPosts(){

        $res = $this->mysql->query("select COUNT(*) as cnt from posts")->fetch_assoc();

        return (int)$res['cnt'];
    }

    public function pagesResultPostsFrontend(){
        $res = $this->mysql->query("select COUNT(*) as cnt from posts WHERE showing='yes'")->fetch_assoc();
        return (int)$res['cnt'];
    }

    public function savePost($post){
        $nazva = $this->mysql->real_escape_string($post->getNazva());
        $description = $this->mysql->real_escape_string($post->getDescription());
        $ssilka = $this->mysql->real_escape_string($post->getSsilka());
        $tags = $this->mysql->real_escape_string($post->getTags());

        $this->mysql->query("Insert into posts (nazva,ssilka,description,img,text,showing,tags) VALUES
         ('{$nazva}','{$ssilka}','{$description}','{$post->getImg()}','{$post->getText()}','yes','{$tags}')");
    }

    public function changeMainPhotoPost($post){
        $this->mysql->query("UPDATE posts SET img='{$post->getImg()}' where id={$post->getId()}");
    }

    public function changePostShowing($id){
        $id = intval($id);
        $ps = $this->getPostById($id);
        if($ps->getId()>0){
            $show = $ps->getShowing();
            if($show=="yes"){
                $this->mysql->query("UPDATE posts SET showing='no' where id={$id}");
                return "no";
            }else{
                $this->mysql->query("UPDATE posts SET showing='yes' where id={$id}");
                return "yes";
            }
        }
        return "error";
    }

    /*------------------------PROGNOZ-------------------------*/

    public function getPrognozById($id){
        $id = intval($id);
        $rs = $this->mysql->query("select * from prognozi where id=$id");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $prognoz = new Prognoz();
        $prognoz->setPrognoz($row);
        return $prognoz;
    }

    public function getPrognozBySsilka($ssilka){
        $rs = $this->mysql->query("select * from prognozi where ssilka='{$ssilka}'");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $prognoz = new Prognoz();
        $prognoz->setPrognoz($row);
        return $prognoz;
    }

    public function getPrognoziByType($type,$page){
        $page = intval($page);
        $limit = 40;
        $offset = (intval($page)-1)*$limit;
        $type = $this->mysql->real_escape_string($type);

        if($type=="all"){
            $rs = $this->mysql->query("select * from prognozi ORDER BY id DESC LIMIT $offset, $limit");
        }else{
            $rs = $this->mysql->query("select * from prognozi where type='".$type."' ORDER BY id DESC LIMIT $offset, $limit");
        }

        $prognozi = array();
        while(($row = $rs->fetch_assoc())!=false){
            $prognoz = new Prognoz();
            $prognoz->setPrognoz($row);
            $prognozi[] = $prognoz;
        }
        return $prognozi;
    }

    public function getAllPrognozi(){
        $rs = $this->mysql->query("select * from prognozi");
        $prognozi = array();
        while(($row = $rs->fetch_assoc())!=false){
            $prognoz = new Prognoz();
            $prognoz->setPrognoz($row);
            $prognozi[] = $prognoz;
        }
        return $prognozi;
    }

    public function getAllShowingPrognozi(){
        $rs = $this->mysql->query("select * from prognozi where showing='yes'");
        $prognozi = array();
        while(($row = $rs->fetch_assoc())!=false){
            $prognoz = new Prognoz();
            $prognoz->setPrognoz($row);
            $prognozi[] = $prognoz;
        }
        return $prognozi;
    }

    public function getPrognoziThisDate($thisprognozid,$thisdate,$thisyear){
        $thisprognozid = intval($thisprognozid);
        $rs = $this->mysql->query("select * from prognozi where date='{$thisdate}' and year='{$thisyear}' and showing='yes' AND showing_main='yes' ORDER BY date_sort DESC");
        $prognozi = array();
        while(($row = $rs->fetch_assoc())!=false){
            $prognoz = new Prognoz();
            $prognoz->setPrognoz($row);
            if($prognoz->getId()!=$thisprognozid){
                $prognozi[] = $prognoz;
            }
        }
        return $prognozi;
    }

    public function changeDateSortPrognoz($id,$datesort){
        $id = intval($id);
        $this->mysql->query("UPDATE prognozi SET date_sort='{$datesort}' where id={$id}");
    }

    public function changePrognoz($data){
        $nazva = $this->mysql->real_escape_string($data['nazva']);
        $text_email = $this->mysql->real_escape_string($data['text_email']);
        $description = $this->mysql->real_escape_string($data['description']);
        $matchnazva = $this->mysql->real_escape_string($data['matchnazva']);
        $tags = $this->mysql->real_escape_string($data['tags']);

        $this->mysql->query("UPDATE prognozi SET id_championat={$data['id_champ']}, nazva='{$nazva}', matchnazva='{$matchnazva}', ssilka='{$data['ssilka']}', type='{$data['type']}',
        description='{$description}', text_email='{$text_email}', text='{$data['text']}', koeficient='{$data['koeficient']}',
        date='{$data['date']}', time='{$data['time']}', year='{$data['year']}', date_sort='{$data['date_sort']}', tags='{$tags}' where id={$data['id']}");
    }

    public function deletePrognoz($id){
        $id = intval($id);
        $this->mysql->query("delete from prognozi where id={$id}");
    }


    public function addPrognoz($data){
        $nazva = $this->mysql->real_escape_string($data['nazva']);
        $text_email = $this->mysql->real_escape_string($data['text_email']);
        $ssilka = $this->mysql->real_escape_string($data['ssilka']);
        $description = $this->mysql->real_escape_string($data['description']);
        $matchnazva = $this->mysql->real_escape_string($data['matchnazva']);
        $tags = $this->mysql->real_escape_string($data['tags']);

        $this->mysql->query("Insert into prognozi (id_championat,nazva,matchnazva,ssilka,type,img,description,text_email,text,koeficient,date,time,year,date_sort,showing,showing_main,tags) VALUES
         ({$data['id_champ']},'{$nazva}','{$matchnazva}','{$ssilka}','{$data['type']}','{$data['img']}','{$description}','{$text_email}',
         '{$data['text']}','{$data['koeficient']}','{$data['date']}','{$data['time']}', '{$data['year']}', '{$data['date_sort']}', '{$data['showing']}', '{$data['showing_main']}', '{$tags}')");
    }

    public function copyPrognoz($id){
        $id = intval($id);
        $this->mysql->query("insert into prognozi (nazva,matchnazva,type,img,description,text_email,text,koeficient,date,time,year,date_sort,showing)
    select nazva,matchnazva,type,img,description,text_email,text,koeficient,date,time,year,date_sort,showing from prognozi where id=$id;");
        $ins_id = $this->mysql->insert_id;
        $this->mysql->query("UPDATE prognozi SET showing='no' where id={$ins_id}");
    }

    public function pagesResultPrognozi($type){
        $type = $this->mysql->real_escape_string($type);
        if($type=="all"){
            $res = $this->mysql->query("select COUNT(*) as cnt from prognozi")->fetch_assoc();
        }else{
            $res = $this->mysql->query("select COUNT(*) as cnt from prognozi where type='{$type}'")->fetch_assoc();
        }
        return (int)$res['cnt'];
    }

    public function pagesResultPrognoziFrontend($type){
        $type = $this->mysql->real_escape_string($type);
        if($type=="all"){
            $res = $this->mysql->query("select COUNT(*) as cnt from prognozi WHERE showing='yes'")->fetch_assoc();
        }else{
            $res = $this->mysql->query("select COUNT(*) as cnt from prognozi where showing='yes' AND type='{$type}'")->fetch_assoc();
        }
        return (int)$res['cnt'];
    }


    public function changeStatusPrognoz($id,$status){
        $id = intval($id);
        $status = $this->mysql->real_escape_string($status);
        if($status=="without"){
            $status="";
        }
        $this->mysql->query("UPDATE prognozi SET proshel='{$status}' where id={$id}");
    }

    public function changeMainPhotoPrognoz($img,$id){
        $id = intval($id);
        $img = $this->mysql->real_escape_string($img);
        $this->mysql->query("UPDATE prognozi SET img='{$img}' where id={$id}");
    }

    public function changePrognozShowing($id){
        $id = intval($id);
        $pr = $this->getPrognozById($id);
        if($pr->getId()>0){
            $show = $pr->getShowing();
            if($show=="yes"){
                $this->mysql->query("UPDATE prognozi SET showing='no' where id={$id}");
                return "no";
            }else{
                $this->mysql->query("UPDATE prognozi SET showing='yes' where id={$id}");
                return "yes";
            }
        }
        return "error";
    }

    /*------------------------EXPRESS-------------------------*/


    public function getExpresstById($id){
        $id = intval($id);
        $rs = $this->mysql->query("select * from express where id=$id");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $express = new Express();
        $express->setRowClass($row);
        return $express;
    }

    public function changeExpress($data){
        $nazva = $this->mysql->real_escape_string($data['nazva']);
        $text_email = $this->mysql->real_escape_string($data['text_email']);
        $textpopup = $this->mysql->real_escape_string($data['textpopup']);

        $this->mysql->query("UPDATE express SET nazva='{$nazva}',
        description='{$data['description']}', text='{$data['text']}', text_email='{$text_email}', textpopup='{$textpopup}'
        where id={$data['id']}");
    }

    public function changeMainPhotoExpress($img,$id){
        $id = intval($id);
        $img = $this->mysql->real_escape_string($img);
        $this->mysql->query("UPDATE express SET img='{$img}' where id={$id}");
    }

    public function changeExpressStatus($id,$action){
        $id = intval($id);
        $action = $this->mysql->real_escape_string($action);
        var_dump($action);
        $rs = $this->mysql->query("UPDATE `express` SET `show`='{$action}' WHERE id={$id}");
        var_dump($rs);
    }



    /*------------------------POPULAR-------------------------*/

    public function updatePopular($id,$id_post,$type){
        $this->mysql->query("UPDATE popular SET id_post=$id_post, cat='{$type}' where id=$id");
    }

    /*------------------------MAIN POST------------------------*/

    public function makeMainPost($id){
        $id = intval($id);
        $this->mysql->query("UPDATE mainpost SET id_post=$id where id=1");
    }

    public function makeMainPostSecond($id){
        $id = intval($id);
        $this->mysql->query("UPDATE mainpost SET id_post=$id where id=2");
    }

    public function deleteMainPost($id){
        $id = intval($id);
        $this->mysql->query("UPDATE mainpost SET id_post=0 where id_post=$id");
    }

    /*public function deleteMainPostSecond(){
        $this->mysql->query("UPDATE mainpost SET id_post=0 where id=2");
    }*/

    public function getMainPostsAdmin(){
        $rs = $this->mysql->query("select * from mainpost");
        $posts = array();
        while(($row = $rs->fetch_assoc())!=false){
            if(intval($row['id_post'])!=0){
                $post = $this->getPostById(intval($row['id_post']));
                $posts[] = $post;
            }
        }
        return $posts;
    }

    /*-------------------------REKLAMA-------------------------*/

    public function getReklamaById($id){
        $id = (int)$id;
        $rs = $this->mysql->query("select * from reklama where id=".$id);
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");

        $row = $rs->fetch_assoc();
        $reklama = new Reklama();
        $reklama->setReklama($row);

        return $reklama;
    }

    public function updateReklama($data){
        $rs = $this->mysql->query("UPDATE reklama SET kod='{$data['kod']}',
          kod_mob='{$data['kod_mob']}' WHERE id={$data['id']}");
        return $rs;
    }

    /*-------------------------USERS------------------------------*/

    public function getUsersAdmin($page){
        $page = intval($page);
        $limit = 40;
        $offset = (intval($page)-1)*$limit;

        $rs = $this->mysql->query("select * from users where podtverzden='yes' ORDER BY id DESC LIMIT $offset, $limit");

        $users = array();
        while(($row = $rs->fetch_assoc())!=false){
            $user = new User();
            $user->setUser($row);
            $users[] = $user;
        }
        return $users;
    }

    public function pagesResultUsers(){
        $res = $this->mysql->query("select COUNT(*) as cnt from users where podtverzden='yes'")->fetch_assoc();
        return (int)$res['cnt'];
    }

    /*------------------------OTZIVI-------------------------*/

    public function getOtziviAdmin($page){
        $page = intval($page);
        $limit = 40;
        $offset = (intval($page)-1)*$limit;
        $rs = $this->mysql->query("select * from otzivi ORDER BY id DESC LIMIT $offset, $limit");

        $otzivi = array();
        while(($row = $rs->fetch_assoc())!=false){
            $otziv = new Otziv();
            $otziv->setOtziv($row);
            $otzivi[] = $otziv;
        }
        return $otzivi;

    }

    public function getOtzivi($page){
        $page = intval($page);
        $limit = 30;
        $offset = (intval($page)-1)*$limit;
        $rs = $this->mysql->query("select * from otzivi ORDER BY id DESC LIMIT $offset, $limit");

        $otzivi = array();
        while(($row = $rs->fetch_assoc())!=false){
            $otziv = new Otziv();
            $otziv->setOtziv($row);
            $otzivi[] = $otziv;
        }
        return $otzivi;

    }

    public function getAllOtzivi(){
        $rs = $this->mysql->query("select * from otzivi");
        $otzivi = array();
        while(($row = $rs->fetch_assoc())!=false){
            $otziv = new Otziv();
            $otziv->setOtziv($row);
            $otzivi[] = $otziv;
        }
        return $otzivi;

    }

    public function deleteOtziv($id){
        $id = intval($id);
        $this->mysql->query("delete from otzivi where id={$id}");
    }

    public function pagesResultOtzivi(){
        $res = $this->mysql->query("select COUNT(*) as cnt from otzivi")->fetch_assoc();
        return (int)$res['cnt'];
    }
    public function insertOtziv($img){
        $this->mysql->query("insert into otzivi (img) VALUES ('{$img}')");
    }

    /*============================SITE============================*/


    /*-------------------------PROGNOZI-------------------------*/

    public function getPrognoziIndex(){
        $limit = 20;

        $rs = $this->mysql->query("select * from prognozi WHERE showing='yes' AND showing_main='yes' ORDER BY date_sort DESC LIMIT $limit");
        $prognozi = array();
        while(($row = $rs->fetch_assoc())!=false){
            $prognoz = new Prognoz();
            $prognoz->setPrognoz($row);
            $prognozi[] = $prognoz;
        }
        return $prognozi;
    }

    public function getPrognozi($page){
        $limit = 30;
        $offset = (intval($page)-1)*$limit;

        $rs = $this->mysql->query("select * from prognozi WHERE showing='yes' ORDER BY date_sort DESC LIMIT $offset, $limit");

        $prognozi = array();
        while(($row = $rs->fetch_assoc())!=false){
            $prognoz = new Prognoz();
            $prognoz->setPrognoz($row);
            $prognozi[] = $prognoz;
        }
        return $prognozi;
    }

    /*---------------------------NEWS--------------------------*/

    public function getPosts($page){
        $limit = 5;
        $offset = (intval($page)-1)*$limit;

        $posts = array();
        $rs = $this->mysql->query("select * from posts where showing='yes' ORDER BY id DESC LIMIT $offset, $limit");
        while(($row = $rs->fetch_assoc())!=false){
            $post = new Post();
            $post->setPost($row);
            $posts[] = $post;
        }
        return $posts;
    }

    public function getAllShowingPosts(){

        $posts = array();
        $rs = $this->mysql->query("select * from posts where showing='yes'");
        while(($row = $rs->fetch_assoc())!=false){
            $post = new Post();
            $post->setPost($row);
            $posts[] = $post;
        }
        return $posts;
    }

    public function incrementPost($id){
        $id = intval($id);
        $post  = $this->getPostById($id);
        $increment = $post->getViews()+1;
        $this->mysql->query("UPDATE posts SET views={$increment} where id=$id");

    }

    public function incrementPrognoz($id){
        $id = intval($id);
        $prognoz  = $this->getPrognozById($id);
        $increment = $prognoz->getViews()+1;
        $this->mysql->query("UPDATE prognozi SET views={$increment} where id=$id");

    }
    public function getMainPost(){
        $row = $this->mysql->query("select * from mainpost where id=1")->fetch_assoc();
        $post = $this->getPostById(intval($row['id_post']));
        return $post;
    }

    public function getMainPostSecond(){
        $row = $this->mysql->query("select * from mainpost where id=2")->fetch_assoc();
        $post = $this->getPostById(intval($row['id_post']));
        return $post;
    }

    /*---------------------------POPULAR---------------------*/

    public function getPopularPosts(){

        $rs = $this->mysql->query("select * from popular");
        $posts = array();

        while(($row = $rs->fetch_assoc())!=false){
            $post = $this->getPostById($row['id_post']);
            $posts[] = $post;
        }
        return $posts;
    }

    /*---------------------------TAGS--------------------------*/

    public function getPostsByTag($tag,$page){
        $limit = 15;
        $offset = (intval($page)-1)*$limit;

        $tag = $this->mysql->real_escape_string($tag);
        $rs = $this->mysql->query("select * from posts where tags LIKE '%".$tag."%' ORDER BY id DESC LIMIT $offset, $limit");
        $posts = array();

        while(($row = $rs->fetch_assoc())!=false){
            $post = new Post();
            $post->setPost($row);
            $posts[] = $post;
        }
        return $posts;
    }

    public function pagesResultByTag($tag){
        $tag = $this->mysql->real_escape_string($tag);
        $res = $this->mysql->query("select COUNT(*) as cnt from posts where tags like '%$tag%'")->fetch_assoc();
        return $res['cnt'];
    }

    public function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }


    /*----------------------REGISTER KABINET-------------------------*/

    public function checkRegister($login,$email,$pass){
        $error_mess = array('error'=>'false','mess'=>'');

        if($login==""){
            $error_mess = array('error'=>'empty_login','mess'=>'Введите логин!');
        }
        if($email==""){
            $error_mess = array('error'=>'empty_email','mess'=>'Введите email!');
        }
        if($pass==""){
            $error_mess = array('error'=>'empty_pass','mess'=>'Введите пароль!');
        }
        if($this->checkExistsLogin($login)){
            $error_mess = array('error'=>'exists_login','mess'=>'Такой логин уже существует!');
        }
        if($this->checkExistsEmail($email)){
            $error_mess = array('error'=>'exists_email','mess'=>'Такой email уже существует!');
        }

        return $error_mess;
    }

    public function checkRememberPass($email){
        $error_mess = array('error'=>'false','mess'=>'');

        if($email==""){
            $error_mess = array('error'=>'empty_email','mess'=>'Введите email!');
        }
        if(!$this->checkExistsEmail($email)){
            $error_mess = array('error'=>'notexists_email','mess'=>'Пользователь с даным email адресом не зарегистрирован!');
        }

        if($error_mess['error']=='false'){
            $user = $this->getUserByEmail($email);
            if($user->getId()!=0){
                mail($email, 'Bebets.ru - Восстановление пароля', "Для восстановления пароля перейдите по ссылке: <a href='https://bebets.ru/remember-password.php?id_user=".$user->getId()."&kod=".$user->getKodpodtverzdenia()."'>Подтвердить</a>",'Content-Type: text/html; charset=UTF-8', '-f admin@bebets.ru');
            }
        }

        return $error_mess;
    }

    public function changeUserPass($id_user,$password){
        $retval = false;
        $id_user = intval($id_user);
        $password = $this->mysql->real_escape_string($password);
        $hash_pass = crypt($password,'lollol');
        if($password!=""){
            $this->mysql->query("UPDATE users SET hash_pass ='{$hash_pass}', pass='{$password}' where id={$id_user}");
            $retval = true;
        }
        return $retval;
    }

    public function checkExistsEmail($email){
        $email = $this->mysql->real_escape_string($email);
        $rs = $this->mysql->query("select * from users where email='{$email}'");
        if($rs->num_rows>0){
            $ret_bool = true;
        }else{
            $ret_bool = false;
        }
        return $ret_bool;
    }

    public function checkExistsLogin($login){
        $login = $this->mysql->real_escape_string($login);
        $rs = $this->mysql->query("select * from users where login='{$login}'");
        if($rs->num_rows>0){
            $ret_bool = true;
        }else{
            $ret_bool = false;
        }
        return $ret_bool;
    }

    public function registerNewUser($login,$email,$pass){
        $login = $this->mysql->real_escape_string($login);
        $email = $this->mysql->real_escape_string($email);
        $pass = $this->mysql->real_escape_string($pass);
        $hash_pass = crypt($pass,'lollol');
        $kodpodtverzdenia = crypt($email,'lollol');

        $rs = $this->mysql->query("Insert into users (login,hash_pass,email,pass,podtverzden,kodpodtverzdenia) VALUES
         ('{$login}','{$hash_pass}','{$email}','{$pass}','no','{$kodpodtverzdenia}')");
        $id_user = (int)$this->mysql->insert_id;
        //Отправить код тут который ведет на podtverditemail.php
        mail($email, 'Bebets.ru - Подтверждение email', "Для подтверждения email-адреса перейдите по ссылке: <a href='https://bebets.ru/podtverditemail.php?id_user=".$id_user."&kod=".$kodpodtverzdenia."'>Подтвердить</a>",'Content-Type: text/html; charset=UTF-8', '-f admin@bebets.ru');

        return $id_user;
    }

    public function sendRememberPassword($id_user,$kod){
        $success = false;
        $id_user = intval($id_user);
        $kod = $this->mysql->real_escape_string($kod);
        $user = $this->getUserById($id_user);

        if($user->getId()!=0 && $kod==$user->getKodpodtverzdenia()){
            $this->mysql->query("UPDATE users SET podtverzden='yes' where id={$id_user}");
            $success = true;
        }

        return $success;
    }

    public function emailPodtverzdenieNewUser($id_user, $kod){
        $success = false;
        $id_user = intval($id_user);
        $kod = $this->mysql->real_escape_string($kod);
        $user = $this->getUserById($id_user);

        if($user->getId()!=0 && $kod==$user->getKodpodtverzdenia()){
            $this->mysql->query("UPDATE users SET podtverzden='yes' where id={$id_user}");
            $success = true;
        }

        return $success;
    }


    public function registerNewUserFB($login,$fb_user_id){
        $login = $this->mysql->real_escape_string($login);
        $fb_user_id = $this->mysql->real_escape_string($fb_user_id);

        $hash_pass = crypt($fb_user_id,'lollol');

        $rs = $this->mysql->query("Insert into users (login,hash_pass,fb_user) VALUES
         ('{$login}','{$hash_pass}','{$fb_user_id}')");

        return $this->mysql->insert_id;
    }

    /*---------------------VHOD V KABINET------------------*/

    public function checkUserVhod($email,$pass){
        $error_mess = array('error'=>'false','mess'=>'');
        if($email==""){
            $error_mess = array('error'=>'empty_email','mess'=>'Введите email!');
        }
        if($pass==""){
            $error_mess = array('error'=>'empty_pass','mess'=>'Введите пароль!');
        }

        return $error_mess;
    }


    public function makeUserVhod($email,$pass){
        $email = $this->mysql->real_escape_string($email);
        $pass = $this->mysql->real_escape_string($pass);
        $hash_pass = crypt($pass,'lollol');

        $rs = $this->mysql->query("select * from users where email='{$email}' and hash_pass='{$hash_pass}'");
        $user = new User();
        while(($row = $rs->fetch_assoc())!=false){
            $user->setUser($row);
        }

        if($user->getId()==0){
            $rs = $this->mysql->query("select * from users where login='{$email}' and hash_pass='{$hash_pass}'");
            $user = new User();
            while(($row = $rs->fetch_assoc())!=false){
                $user->setUser($row);
            }
        }

        return $user;
    }

    public function makeUserVhodFB($login,$fb_user_id){
        $login = $this->mysql->real_escape_string($login);
        $fb_user_id = $this->mysql->real_escape_string($fb_user_id);

        $rs = $this->mysql->query("select * from users where login='{$login}' 
        and fb_user='{$fb_user_id}'");
        $user = new User();
        while(($row = $rs->fetch_assoc())!=false){
            $user->setUser($row);
        }

        return $user;
    }



    /*---------------------USER--------------------*/

    public function loginUserWithCookie($user_session){
        $user = new User();
        if($user_session==false){
            return $user;
        }
        $user_session = $this->mysql->real_escape_string($user_session);
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $user_session_class = $this->getUsersessionClass($user_session,$user_agent);
        if($user_session_class->getUserId()!=0){
            $user = $this->getUserById($user_session_class->getUserId());
            setcookie ("user_session",$user_session,time()+2592000,"/");
        }
        return $user;
    }

    public function insertUserToUserSession($id_user){
        $id_user = intval($this->mysql->real_escape_string($id_user));
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $user_session = crypt(time().$id_user.$user_agent,'lollol');
        setcookie ("user_session",$user_session,time()+2592000,"/");
        $rs = $this->mysql->query("Insert into users_sessions (user_id,user_agent,user_session) 
          VALUES ({$id_user},'{$user_agent}','{$user_session}')");

        if($rs==true){
            return $user_session;
        }else{
            return false;
        }
    }

    public function getUsersessionClass($user_session, $user_agent){
        $user_session = $this->mysql->real_escape_string($user_session);
        $user_agent = $this->mysql->real_escape_string($user_agent);
        $rs = $this->mysql->query("select * from users_sessions where user_session='{$user_session}' and user_agent='{$user_agent}'");
        $user_session_Class = new Usersession();
        while(($row = $rs->fetch_assoc())!=false){
            $user_session_Class->setUsersessionClass($row);
        }
        return $user_session_Class;
    }

    public function getUserById($user_id){
        $user_id = (int)$this->mysql->real_escape_string($user_id);
        $rs = $this->mysql->query("select * from users where id={$user_id}");
        $user = new User();
        while(($row = $rs->fetch_assoc())!=false){
            $user->setUser($row);
        }
        return $user;
    }

    public function getUserByEmail($email){
        $email = $this->mysql->real_escape_string($email);
        $rs = $this->mysql->query("select * from users where email='{$email}'");
        $user = new User();
        while(($row = $rs->fetch_assoc())!=false){
            $user->setUser($row);
        }
        return $user;
    }


    public function unsetUserCookie(){
        setcookie ("user_session","",time()-200,"/");
    }

    public function deleteCookieFromDb($user_session, $user_agent, $user_id){
        $user_id = (int)$this->mysql->real_escape_string($user_id);
        $user_session = $this->mysql->real_escape_string($user_session);
        $user_agent = $this->mysql->real_escape_string($user_agent);


        $this->mysql->query("delete from users_sessions where user_id={$user_id} and
        user_agent='{$user_agent}' and user_session='{$user_session}'");
    }

    public function updateUserPhoto($user_id,$img){
        $user_id = (int)$this->mysql->real_escape_string($user_id);
        $img = $this->mysql->real_escape_string($img);
        $this->mysql->query("UPDATE users SET img='{$img}' where id={$user_id}");
    }

    public function deleteUserById($user_id){
        $this->mysql->query("delete from users_sessions where user_id={$user_id}");
        $this->mysql->query("delete from users where id={$user_id}");
        $this->mysql->query("delete from zakaz where user_id={$user_id}");
    }


    /*-----------------------COMMENTS-------------------------*/

    public function getCommentById($id){
        $id = intval($id);
        $rs = $this->mysql->query("select * from comments where id=$id");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $comment = new Comment();
        $comment->setComment($row);
        return $comment;
    }

    public function getCommentsByIdPost($post_id){
        $post_id = intval($post_id);
        $rs = $this->mysql->query("select * from comments where post_id={$post_id} ORDER BY id DESC");
        $comments = array();
        while(($row = $rs->fetch_assoc())!=false){
            $comment = new Comment();
            $comment->setComment($row);
            $comments[] = $comment;
        }
        return $comments;
    }

    public function addCommentToPost($user_id,$post_id,$comment){
        $user_id = (int)$this->mysql->real_escape_string($user_id);
        $post_id = (int)$this->mysql->real_escape_string($post_id);
        $comment = $this->mysql->real_escape_string($comment);

        $rs = $this->mysql->query("Insert into comments (user_id,post_id,text) 
          VALUES ({$user_id},{$post_id},'{$comment}')");

    }

    public function deleteComment($comment_id){
        $comment_id = intval($comment_id);
        $this->mysql->query("delete from comments where id={$comment_id}");
    }


    /*---------------------------PREDLOG POST------------------------------*/

    public function getPredlogPostById($id){
        $id = intval($id);
        $rs = $this->mysql->query("select * from predlog_post where id=$id");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $predlogpost = new Predlogpost();
        $predlogpost->setPredlogpost($row);
        return $predlogpost;

    }

    public function insertPredlogPost($predlogpost){
        $user_id = (int)$predlogpost->getUserId();
        $cat = $this->mysql->real_escape_string($predlogpost->getCat());
        $nazva = $this->mysql->real_escape_string($predlogpost->getNazva());
        $description = $this->mysql->real_escape_string($predlogpost->getDescription());
        $img = $this->mysql->real_escape_string($predlogpost->getImg());
        $video = $this->mysql->real_escape_string($predlogpost->getVideo());
        $text = $this->mysql->real_escape_string($predlogpost->getText());

        $this->mysql->query("Insert into predlog_post (user_id,cat,nazva,description,img,video,text,status) VALUES
         ($user_id,'{$cat}','{$nazva}','{$description}','{$img}','{$video}','{$text}','rassmotr')");
    }


    public function getPredlogPostsAdmin($page){
        $limit = 40;
        $offset = (intval($page)-1)*$limit;
        $rs = $this->mysql->query("select * from predlog_post ORDER BY id DESC LIMIT $offset, $limit");
        $predlogposts = array();
        while(($row = $rs->fetch_assoc())!=false){
            $predlogpost = new Predlogpost();
            $predlogpost->setPredlogpost($row);
            $predlogposts[] = $predlogpost;
        }
        return $predlogposts;
    }


    public function pagesResultPredlogPosts(){
        $res = $this->mysql->query("select COUNT(*) as cnt from predlog_post")->fetch_assoc();
        return $res['cnt'];
    }

    public function changeMainPhotoPredlogPost($predlogpost){
        $this->mysql->query("UPDATE predlog_post SET img='{$predlogpost->getImg()}' where id={$predlogpost->getId()}");
    }

   public function changePredlogPost($predlogpost){
        $this->mysql->query("UPDATE predlog_post SET cat='{$predlogpost->getCat()}',
        nazva='{$predlogpost->getNazva()}', description='{$predlogpost->getDescription()}', 
        video='{$predlogpost->getVideo()}', text='{$predlogpost->getText()}', status='public',
        tags='{$predlogpost->getTags()}' where id={$predlogpost->getId()}");
   }

   public function opublikovatPredlogPost($predlogpost){
       $this->mysql->query("Insert into posts (cat,nazva,description,img,video,text, tags) VALUES
         ('{$predlogpost->getCat()}','{$predlogpost->getNazva()}','{$predlogpost->getDescription()}',
         '{$predlogpost->getImg()}','{$predlogpost->getVideo()}','{$predlogpost->getText()}', 
         '{$predlogpost->getTags()}')");
   }

   public function otklonitPredlogPost($id){
       $id = intval($id);
       $rs = $this->mysql->query("UPDATE predlog_post SET status='otklon'
        where id={$id}");

   }

   public function deletePhotoPredlogPost($id){
       $this->mysql->query("UPDATE predlog_post SET img='' where id={$id}");
   }

   public function getAllUserNews($user_id){
       $user_id = intval($user_id);
       $rs = $this->mysql->query("select * from predlog_post where user_id=$user_id ORDER BY id DESC");
       $predlogposts = array();
       while(($row = $rs->fetch_assoc())!=false){
           $predlogpost = new Predlogpost();
           $predlogpost->setPredlogpost($row);
           $predlogposts[] = $predlogpost;
       }
       return $predlogposts;
   }

   /*--------------------ZAKAZ------------------------*/

   public function insertToZakazIntercassa($data,$id_zakaz){
       $id_zakaz = intval($id_zakaz);
       $this->mysql->query("Insert into zakaz_intercassa (`id_zakaz`,`intercassa_response`) VALUES ({$id_zakaz},'{$data}')");
   }

   public function getZakazById($id){
       $id = intval($id);
       $rs = $this->mysql->query("select * from zakaz where id=$id");
       if(!isset($rs))die("Bad");
       if(empty($rs))die("Bad");
       $row = $rs->fetch_assoc();
       $zakaz = new Zakaz();
       $zakaz->setRowClass($row);
       return $zakaz;

   }

   public function zakazBuyOneItem($data){
        $data['email'] = $this->mysql->real_escape_string($data['email']);
        $data['type'] = $this->mysql->real_escape_string($data['type']);
        $this->mysql->query("Insert into zakaz (user_id,email,type,details,summa) VALUES
         ({$data['user_id']},'{$data['email']}','{$data['type']}',{$data['details']},{$data['summa']})");

        return (int)$this->mysql->insert_id;
   }

   public function zakazBuyPaket($data){
        $data['email'] = $this->mysql->real_escape_string($data['email']);
        $data['type'] = $this->mysql->real_escape_string($data['type']);
        $this->mysql->query("Insert into zakaz (user_id,email,type,summa) VALUES
         ({$data['user_id']},'{$data['email']}','{$data['type']}',{$data['summa']})");

        return (int)$this->mysql->insert_id;
   }

   public function updateZakazDateOplata($id_zakaz,$date_oplati){
       $date_oplati = $this->mysql->real_escape_string($date_oplati);
       $id_zakaz = intval($id_zakaz);

       $zakaz = $this->getZakazById($id_zakaz);
       if($zakaz->getType()=="paket_two" || $zakaz->getType()=="paket_three"){
           $user_active_paket = $this->getActivePaket($zakaz->getUserId());
           if($user_active_paket['name']!=false && $user_active_paket['date_ends']!=false){
               date_default_timezone_set('Europe/Kiev');
               $datetime_oplati = DateTime::createFromFormat('Y-m-d H:i:s', $date_oplati);
               $date_ends = $user_active_paket['date_ends'];
               $raznica_dat = $datetime_oplati->diff($date_ends);
               $datetime_oplati->add($raznica_dat);
               $str_format = $datetime_oplati->format("Y-m-d H:i:s");
               $this->mysql->query("UPDATE zakaz SET date_oplata='{$str_format}' where id={$id_zakaz}");
           }else{
               $this->mysql->query("UPDATE zakaz SET date_oplata='{$date_oplati}' where id={$id_zakaz}");
           }
       }else{
           $this->mysql->query("UPDATE zakaz SET date_oplata='{$date_oplati}' where id={$id_zakaz}");
       }

   }

   public function issetPaketOneInZakazByUserId($user_id){
       $paket_days = 14;
       $nazva_paketa = "paket_one";
       $retval = array('isset'=>false, 'date_ends'=>false);
       $user_id = intval($user_id);
       date_default_timezone_set('Europe/Kiev');
       $datetime_now = new DateTime(date('Y-m-d H:i:s'));

       $rs = $this->mysql->query("select * from zakaz where user_id=$user_id and type='{$nazva_paketa}'");

       while(($row = $rs->fetch_assoc())!=false){
           $zakaz = new Zakaz();
           $zakaz->setRowClass($row);
           if($zakaz->getDateOplata()=="0000-00-00 00:00:00"){
               continue;
           }else{
               $datezakaz = new DateTime($zakaz->getDateOplata());
               $datezakaz->add(new DateInterval('P'.$paket_days.'D'));
               if($datezakaz>$datetime_now){
                   $retval['isset'] = true;
                   $retval['date_ends'] = $datezakaz;
                   break;
               }
           }

       }

       return $retval;
   }

    public function issetPaketTwoInZakazByUserId($user_id){
        $paket_days = 14;
        $nazva_paketa = "paket_two";
        $retval = array('isset'=>false, 'date_ends'=>false);
        $user_id = intval($user_id);
        date_default_timezone_set('Europe/Kiev');
        $datetime_now = new DateTime(date('Y-m-d H:i:s'));

        $rs = $this->mysql->query("select * from zakaz where user_id=$user_id and type='{$nazva_paketa}'");

        while(($row = $rs->fetch_assoc())!=false){
            $zakaz = new Zakaz();
            $zakaz->setRowClass($row);
            if($zakaz->getDateOplata()=="0000-00-00 00:00:00"){
                continue;
            }else{
                $datezakaz = new DateTime($zakaz->getDateOplata());
                $datezakaz->add(new DateInterval('P'.$paket_days.'D'));
                if($datezakaz>$datetime_now){
                    $retval['isset'] = true;
                    $retval['date_ends'] = $datezakaz;
                    break;
                }
            }

        }

        return $retval;
    }

    public function issetPaketThreeInZakazByUserId($user_id){
        $paket_days = 31;
        $nazva_paketa = "paket_three";
        $retval = array('isset'=>false, 'date_ends'=>false);
        $user_id = intval($user_id);
        date_default_timezone_set('Europe/Kiev');
        $datetime_now = new DateTime(date('Y-m-d H:i:s'));

        $rs = $this->mysql->query("select * from zakaz where user_id=$user_id and type='{$nazva_paketa}'");

        while(($row = $rs->fetch_assoc())!=false){
            $zakaz = new Zakaz();
            $zakaz->setRowClass($row);
            if($zakaz->getDateOplata()=="0000-00-00 00:00:00"){
                continue;
            }else{
                $datezakaz = new DateTime($zakaz->getDateOplata());
                $datezakaz->add(new DateInterval('P'.$paket_days.'D'));
                if($datezakaz>$datetime_now){
                    $retval['isset'] = true;
                    $retval['date_ends'] = $datezakaz;
                    break;
                }
            }

        }

        return $retval;
    }

    public function getActivePaket($user_id){
        $user_id = intval($user_id);
        $paketone = $this->issetPaketOneInZakazByUserId($user_id);
        $pakettwo = $this->issetPaketTwoInZakazByUserId($user_id);
        $paketthree = $this->issetPaketThreeInZakazByUserId($user_id);
        $retval_active = array('name'=>false, 'date_ends'=>false);

        if($paketthree['isset']==true && $paketthree['date_ends']!=false){
            $retval_active['name'] = 'paket_three';
            $retval_active['date_ends'] = $paketthree['date_ends'];
        }elseif ($pakettwo['isset']==true && $pakettwo['date_ends']!=false){
            $retval_active['name'] = 'paket_two';
            $retval_active['date_ends'] = $pakettwo['date_ends'];
        }elseif($paketone['isset']==true && $paketone['date_ends']!=false){
            $retval_active['name'] = 'paket_one';
            $retval_active['date_ends'] = $paketone['date_ends'];
        }

        return $retval_active;

    }

    public function zakazBuyOneItemAdmin($data){
        $data['email'] = $this->mysql->real_escape_string($data['email']);
        $data['type'] = $this->mysql->real_escape_string($data['type']);
        date_default_timezone_set('Europe/Kiev');
        $datetime_now = new DateTime();
        $date_oplata = $datetime_now->format('Y-m-d H:i:s');

        $this->mysql->query("UPDATE zakaz SET date_oplata='0000-00-00 00:00:00' where user_id={$data['user_id']}");

        $this->mysql->query("Insert into zakaz (user_id,email,type,details,summa,date_oplata) VALUES
         ({$data['user_id']},'{$data['email']}','{$data['type']}',{$data['details']},{$data['summa']},'{$date_oplata}')");

        return (int)$this->mysql->insert_id;

    }

    public function obnulitPaketAdmin($user_id){
        $user_id = intval($user_id);
        $this->mysql->query("UPDATE zakaz SET date_oplata='0000-00-00 00:00:00' where user_id={$user_id}");
    }


    /*----------------OTHER pages----------------*/

    public function getOtherPageById($id){
        $id = (int)$id;
        $rs = $this->mysql->query("select * from otherpages where id=".$id);
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");

        $row = $rs->fetch_assoc();
        $otherpage = new Otherpage();
        $otherpage->setOtherpage($row);
        return $otherpage;
    }

    public function updateOtherPage($id,$text,$text2,$text3){
        $id = (int) $id;
        $rs = $this->mysql->query("UPDATE otherpages SET text='{$text}', text2='{$text2}', text3='{$text3}' WHERE id=$id");
        return $rs;
    }

    /*------------------PODPISKA--------------------*/

    public function getPodpiski($type){
        $type = $this->mysql->real_escape_string($type);
        if($type=="all"){
            $rs = $this->mysql->query("select * from podpiska where public>0 ORDER BY id DESC");
        }else{
            $rs = $this->mysql->query("select * from podpiska where public>0 and type='{$type}' ORDER BY id DESC");
        }
        $podpiski = array();
        while(($row = $rs->fetch_assoc())!=false){
            $podpiska = new Podpiska();
            $podpiska->setPodpiska($row);
            $podpiski[] = $podpiska;
        }
        return $podpiski;
    }

    public function sendEmailPodpiska($email){
        $email = $this->mysql->real_escape_string($email);
        $ins_id = $this->insertSamostoyatelnayaPodpiska($email);
        if($ins_id>0){
            mail($email, 'Bebets.ru - Подписка', "Для оформления подписки на новости сайта Bebets.ru - перейдите по ссылке: <a href='https://bebets.ru/podpiska-complated.php?id=".$ins_id."&email=".$email."'>Подтвердить</a>",'Content-Type: text/html; charset=UTF-8', '-f admin@bebets.ru');
            return true;
        }
        return false;
    }

    public function makePublicPodpiska($id,$email){
        $id = (int) $id;
        $email = $this->mysql->real_escape_string($email);
        $rs = $this->mysql->query("UPDATE podpiska SET public=1 WHERE id=$id and email='{$email}'");
        return $rs;
    }

    public function insertPodpiska($email){
        $rs = $this->mysql->query("select * from podpiska WHERE email='{$email}' and public>0");
        if($rs->num_rows==0){
            $this->mysql->query("Insert into podpiska (email,public,type) VALUES ('{$email}',1,'buysomething')");
            return $this->mysql->insert_id;
        }else{
            return 0;
        }
    }

    public function insertSamostoyatelnayaPodpiska($email){
        $rs = $this->mysql->query("select * from podpiska WHERE email='{$email}' and public>0");
        if($rs->num_rows==0){
            $this->mysql->query("Insert into podpiska (email,public,type) VALUES ('{$email}',0,'sam')");
            return $this->mysql->insert_id;
        }else{
            return 0;
        }
    }

    public function deletePodpiska($id){
        $id = intval($id);
        $this->mysql->query("delete from podpiska where id={$id}");
    }

    /*----------------------SSILKA transliteracia-------------------*/

    public function isSsilkaExistPost($ssilka){
        $rs = $this->mysql->query("select * from posts WHERE ssilka='{$ssilka}'");
        if($rs->num_rows==0){
            return false;
        }else{
            return true;
        }
    }

    public function isSsilkaExistPrognoz($ssilka){
        $rs = $this->mysql->query("select * from prognozi WHERE ssilka='{$ssilka}'");
        if($rs->num_rows==0){
            return false;
        }else{
            return true;
        }
    }

    public function isSsilkaExistTag($ssilka){
        $rs = $this->mysql->query("select * from tags WHERE ssilka='{$ssilka}'");
        if($rs->num_rows==0){
            return false;
        }else{
            return true;
        }
    }

    /*---------------------------STATISTICS--------------------------*/

    public function getStatisctics(){
        $rs = $this->mysql->query("select * from prognozi WHERE showing='yes' and (proshel='yes' or proshel='no')");
        $proshli = array();
        $neproshli = array();
        $prognozi = array();
        $koef_proshli = (float)0;

        while(($row = $rs->fetch_assoc())!=false){
            $prognoz = new Prognoz();
            $prognoz->setPrognoz($row);
            $prognozi[] = $prognoz;
            if($prognoz->getProshel()=='yes'){
                $proshli[] = $prognoz;
                $koef_proshli += floatval(str_replace(',','.',$prognoz->getKoeficient()));
            }elseif($prognoz->getProshel()=='no'){
                $neproshli[] = $prognoz;
            }
        }

        $count_vseprognozi = count($prognozi);
        $count_proshli = count($proshli);
        $count_neproshli = count($neproshli);
        $percent_proshli = $count_proshli/$count_vseprognozi*100;
        $percent_neproshli = $count_neproshli/$count_vseprognozi*100;

        $roi = ($koef_proshli-$count_vseprognozi)/$count_vseprognozi*100;

        $retval = array(
            'count_vse'=>$count_vseprognozi,
            'count_proshli'=>$count_proshli,
            'count_neproshli'=>$count_neproshli,
            'percent_proshli'=>$percent_proshli,
            'percent_neproshli'=>$percent_neproshli,
            'roi'=>$roi
        );

        return $retval;
    }


    /*---------------------------CHAT---------------------------*/

    public function getUserPrognozById($id){
        $id = intval($id);
        $rs = $this->mysql->query("select * from user_prognoz where id=$id");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $post = new Userprognoz();
        $post->setUserprognoz($row);
        return $post;
    }

    public function getAllUsersPrognoziAdmin($page){
        $limit = 40;
        $offset = (intval($page)-1)*$limit;

        $rs = $this->mysql->query("select * from user_prognoz ORDER BY id DESC LIMIT $offset, $limit");
        $posts = array();
        while(($row = $rs->fetch_assoc())!=false){
            $post = new Userprognoz();
            $post->setUserprognoz($row);
            $user_obj = $this->getUserById($post->getIdUser());
            $post->setName($user_obj->getLogin());
            $posts[] = $post;
        }
        return $posts;
    }

    public function pagesResultUsersPrognozi(){
        $res = $this->mysql->query("select COUNT(*) as cnt from user_prognoz")->fetch_assoc();
        return (int)$res['cnt'];
    }

    public function insertUserPrognoz($data){
        $data['user_id'] = intval($data['user_id']);
        $data['championat'] = $this->mysql->real_escape_string($data['championat']);
        $data['time'] = $this->mysql->real_escape_string($data['time']);
        $data['komandi'] = $this->mysql->real_escape_string($data['komandi']);
        $data['prognoz'] = $this->mysql->real_escape_string($data['prognoz']);
        $data['koef'] = $this->mysql->real_escape_string($data['koef']);

        $this->mysql->query("Insert into user_prognoz (id_user,championat,time_championat,comandi,prognoz,koeficient) 
          VALUES ({$data['user_id']}, '{$data['championat']}','{$data['time']}', '{$data['komandi']}', '{$data['prognoz']}', '{$data['koef']}')");

        $data['insert_id'] = (int)$this->mysql->insert_id;
        return $data;
    }

    public function getUsersPrognoziToday(){
        date_default_timezone_set('Europe/Kiev');
        $datetime_now = new DateTime();
        $date_now = $datetime_now->format('Y-m-d');
        $date_start = $date_now ." 00:00:01";
        $date_end = $date_now ." 23:59:59";
        $datetoday = $datetime_now->format('d.m');

        $rs = $this->mysql->query("select * from user_prognoz WHERE datee>'$date_start' and datee<'$date_end' ORDER BY id DESC");
        $posts = array();
        while(($row = $rs->fetch_assoc())!=false){
            $post = new Userprognoz();
            $post->setUserprognoz($row);
            $user_obj = $this->getUserById($post->getIdUser());
            $post->setName($user_obj->getLogin());
            $post->setDatetoday($datetoday);
            $posts[] = $post;
        }
        return $posts;
    }

    public function changeUserPrognoz($data){
        $data['id'] = intval($data['id']);
        $data['championat'] = $this->mysql->real_escape_string($data['championat']);
        $data['time'] = $this->mysql->real_escape_string($data['time']);
        $data['komandi'] = $this->mysql->real_escape_string($data['komandi']);
        $data['prognoz'] = $this->mysql->real_escape_string($data['prognoz']);
        $data['koef'] = $this->mysql->real_escape_string($data['koef']);

        $this->mysql->query("UPDATE user_prognoz SET championat='{$data['championat']}', time_championat='{$data['time']}',
        comandi='{$data['komandi']}', prognoz='{$data['prognoz']}', koeficient='{$data['koef']}' where id={$data['id']}");
    }

    public function deleteUserPrognoz($id){
        $id = intval($id);
        $this->mysql->query("delete from user_prognoz where id={$id}");
    }

    public function copyUserPrognoz($id){
        $id = intval($id);
        $this->mysql->query("insert into user_prognoz (id_user,championat,time_championat,comandi,prognoz,koeficient,datee)
    select id_user,championat,time_championat,comandi,prognoz,koeficient,datee from user_prognoz where id=$id;");
        $ins_id = $this->mysql->insert_id;
        $this->mysql->query("UPDATE posts SET showing='no' where id={$ins_id}");
    }

    /*-------------------------Prognoz comment---------------------*/

    public function insertUserPrognozcomment($data){
        $data['id_user'] = intval($data['id_user']);
        $data['id_prognoz'] = intval($data['id_prognoz']);
        $data['comment'] = $this->mysql->real_escape_string($data['comment']);

        $this->mysql->query("Insert into prognoz_comment (id_user,id_prognoz,text) 
          VALUES ({$data['id_user']}, {$data['id_prognoz']},'{$data['comment']}')");

        $insert_id = (int)$this->mysql->insert_id;
        return $insert_id;
    }

    public function getPrognozCommentById($id){
        $id = intval($id);
        $rs = $this->mysql->query("select * from prognoz_comment where id=$id");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $prognozcomment = new Prognozcomment();
        $prognozcomment->setPrognozcomment($row);
        return $prognozcomment;
    }

    public function getPrognozComments($idprognoz){
        $idprognoz = intval($idprognoz);

        $rs = $this->mysql->query("select * from prognoz_comment where id_prognoz=$idprognoz AND id_parent=0 ORDER BY id DESC");
        $comments = array();
        while(($row = $rs->fetch_assoc())!=false){
            $comment = new Prognozcomment();
            $comment->setPrognozcomment($row);
            $user_obj = $this->getUserById($comment->getIdUser());
            $comment->setLogin($user_obj->getLogin());
            $comment_likes_dislikes = $this->getCommentLikesDislikes($comment->getId());
            $comment_childs = $this->getPrognozCommentsChilds($comment->getId());
            $comments[] = array(
                'comment'=>$comment,
                'likes'=>$comment_likes_dislikes['likes'],
                'dislikes'=>$comment_likes_dislikes['dislikes'],
                'comment_childs'=>$comment_childs
            );
        }
        return $comments;
    }

    public function getPrognozCommentsSortPopular($idprognoz){
        $idprognoz = intval($idprognoz);

        $rs = $this->mysql->query("select * from prognoz_comment where id_prognoz=$idprognoz AND id_parent=0 ORDER BY id DESC");
        $comments = array();
        while(($row = $rs->fetch_assoc())!=false){
            $comment = new Prognozcomment();
            $comment->setPrognozcomment($row);
            $user_obj = $this->getUserById($comment->getIdUser());
            $comment->setLogin($user_obj->getLogin());
            $comment_likes_dislikes = $this->getCommentLikesDislikes($comment->getId());
            $comment_childs = $this->getPrognozCommentsChilds($comment->getId());
            $comments[] = array(
                'comment'=>$comment,
                'likes'=>$comment_likes_dislikes['likes'],
                'dislikes'=>$comment_likes_dislikes['dislikes'],
                'comment_childs'=>$comment_childs
            );
        }

        uasort($comments,"sortPopularComments");
        return $comments;
    }

    public function getAllCommentsPrognozAdmin($page){
        $page = intval($page);
        $limit = 40;
        $offset = ($page-1)*$limit;

        $rs = $this->mysql->query("select * from prognoz_comment ORDER BY id DESC LIMIT $offset, $limit");
        $comments = array();
        while(($row = $rs->fetch_assoc())!=false){
            $comment = new Prognozcomment();
            $comment->setPrognozcomment($row);
            $comments[] = $comment;
        }
        return $comments;
    }

    public function pagesResultCommentsPrognoz(){
        $res = $this->mysql->query("select COUNT(*) as cnt from prognoz_comment")->fetch_assoc();
        return (int)$res['cnt'];
    }

    public function deleteCommentPrognoz($id){
        $id = intval($id);
        $this->mysql->query("delete from prognoz_comment where id={$id}");
    }

    public function getAllCommentsUserAdmin($iduser){
        $iduser = intval($iduser);

        $rs = $this->mysql->query("select * from prognoz_comment where id_user=$iduser");
        $comments = array();
        while(($row = $rs->fetch_assoc())!=false){
            $comment = new Prognozcomment();
            $comment->setPrognozcomment($row);
            $comments[] = $comment;
        }
        return $comments;
    }

    public function getCountLikesUserPostavilAdmin($iduser){
        $iduser = intval($iduser);

        $rs = $this->mysql->query("select * from prognoz_comment_like where id_user=$iduser");
        $likes = array('likes'=>array(),'dislikes'=>array());
        while(($row = $rs->fetch_assoc())!=false){
            $prognozcommentlike = new Prognozcommentlike();
            $prognozcommentlike->setPrognozcommentlike($row);
            if($prognozcommentlike->getTypeLike()=="like"){
                $likes['likes'][] = $prognozcommentlike;
            }elseif($prognozcommentlike->getTypeLike()=="dislike"){
                $likes['dislikes'][] = $prognozcommentlike;
            }
        }
        return $likes;
    }

    public function getCountLikesUserPoluchilAdmin($iduser){
        $iduser = intval($iduser);

        $rs = $this->mysql->query("SELECT * FROM `prognoz_comment` as pc JOIN `prognoz_comment_like` as pcl
        ON pc.`id` = pcl.`id_prognozcomment` where pc.`id_user`=$iduser");

        $likes = array('likes'=>array(),'dislikes'=>array());
        while(($row = $rs->fetch_assoc())!=false){
            $prognozcommentlike = new Prognozcommentlike();
            $prognozcommentlike->setPrognozcommentlike($row);
            if($prognozcommentlike->getTypeLike()=="like"){
                $likes['likes'][] = "like";
            }elseif($prognozcommentlike->getTypeLike()=="dislike"){
                $likes['dislikes'][] = "dislike";
            }
        }
        return $likes;


    }

   public function getCommentLikesDislikes($idcomment){
       $idcomment = intval($idcomment);

       $rs = $this->mysql->query("select * from prognoz_comment_like where id_prognozcomment=$idcomment ORDER BY id DESC");
       $likes = array('likes'=>array(),'dislikes'=>array());
       while(($row = $rs->fetch_assoc())!=false){
           $prognozcommentlike = new Prognozcommentlike();
           $prognozcommentlike->setPrognozcommentlike($row);
           if($prognozcommentlike->getTypeLike()=="like"){
               $likes['likes'][] = $prognozcommentlike;
           }elseif($prognozcommentlike->getTypeLike()=="dislike"){
               $likes['dislikes'][] = $prognozcommentlike;
           }
       }
       return $likes;
   }

   public function getPrognozCommentsChilds($idcomment){
       $idcomment = intval($idcomment);

       $rs = $this->mysql->query("select * from prognoz_comment where id_parent=$idcomment ORDER BY id ASC");
       $comments = array();
       while(($row = $rs->fetch_assoc())!=false){
           $comment = new Prognozcomment();
           $comment->setPrognozcomment($row);
           $user_obj = $this->getUserById($comment->getIdUser());
           $comment->setLogin($user_obj->getLogin());
           $comment_likes_dislikes = $this->getCommentLikesDislikes($comment->getId());
           $comments[] = array(
               'comment'=>$comment,
               'likes'=>$comment_likes_dislikes['likes'],
               'dislikes'=>$comment_likes_dislikes['dislikes']
           );
       }
       return $comments;
   }

   public function getUnreadUserPrognoziComments($iduser){
       $iduser = intval($iduser);

       $ids = array();
       $rs = $this->mysql->query("select * from prognoz_comment where iduser_replycomment=$iduser AND id_parent>0 AND shownpopup_replycomment!='yes' ORDER BY id DESC");
       $prognozi = array();
       while(($row = $rs->fetch_assoc())!=false){
           $id_prognoz = intval($row['id_prognoz']);
           if(!in_array($id_prognoz,$ids)){
               $ids[]=$id_prognoz;
               $prognoz = $this->getPrognozById($id_prognoz);
               $prognozi[] = $prognoz;
           }

       }

       //$new_prognozi_arr = array_slice($prognozi,0,3);

       return $prognozi;
   }

    public function getUnreadUserThisPrognozComments($iduser,$idprognoz){
        $iduser = intval($iduser);
        $idprognoz = intval($idprognoz);

        $rs = $this->mysql->query("select * from prognoz_comment where iduser_replycomment={$iduser} AND id_prognoz={$idprognoz} AND id_parent>0 AND shownpopup_replycomment!='yes' ORDER BY id DESC");
        $commentsids = array();
        while(($row = $rs->fetch_assoc())!=false){
            $commentsids[] = $row['id'];
        }

        return $commentsids;
    }

    public function makereadUserPrognozComments($idprognoz,$iduser){
        $iduser = intval($iduser);
        $idprognoz = intval($idprognoz);
        $this->mysql->query("UPDATE prognoz_comment SET shownpopup_replycomment='yes' where id_prognoz=$idprognoz and iduser_replycomment=$iduser");
    }

    public function insertReplyComment($iduser,$idprognoz,$idcomment,$iduser_replycomment,$comment,$login_replycomment,$text_replycomment){
        $iduser = intval($iduser);
        $idprognoz = intval($idprognoz);
        $idcomment = intval($idcomment);
        $iduser_replycomment = intval($iduser_replycomment);
        $comment = $this->mysql->real_escape_string($comment);
        $login_replycomment = $this->mysql->real_escape_string($login_replycomment);
        $text_replycomment = $this->mysql->real_escape_string($text_replycomment);

        $this->mysql->query("Insert into prognoz_comment (id_user,id_prognoz,text,id_parent,iduser_replycomment,shownpopup_replycomment,login_replycomment,text_replycomment) 
          VALUES ({$iduser}, {$idprognoz},'{$comment}',{$idcomment},{$iduser_replycomment},'no','{$login_replycomment}','{$text_replycomment}')");

        $insert_id = (int)$this->mysql->insert_id;
        return $insert_id;
    }

   public function getPrognozCommentUserLikeDislike($iduser,$idcomment){
       $iduser = intval($iduser);
       $idcomment = intval($idcomment);

       $rs = $this->mysql->query("select * from prognoz_comment_like where id_prognozcomment=$idcomment and id_user=$iduser");
       if(!isset($rs))die("Bad");
       if(empty($rs))die("Bad");
       $row = $rs->fetch_assoc();
       $prognozcommentlike = new Prognozcommentlike();
       $prognozcommentlike->setPrognozcommentlike($row);

       return $prognozcommentlike;
   }

   public function insertPrognozCommentLikeDislike($iduser,$idcomment,$datatype){
       $iduser = intval($iduser);
       $idcomment = intval($idcomment);
       $datatype = $this->mysql->real_escape_string($datatype);

       $this->mysql->query("Insert into prognoz_comment_like (id_prognozcomment,id_user,type_like) 
          VALUES ({$idcomment}, {$iduser},'{$datatype}')");
   }

   public function updatePrognozCommentLikeDislike($iduser,$idcomment,$datatype){
       $iduser = intval($iduser);
       $idcomment = intval($idcomment);
       $datatype = $this->mysql->real_escape_string($datatype);

       $this->mysql->query("UPDATE prognoz_comment_like SET type_like='{$datatype}' where id_prognozcomment=$idcomment and id_user=$iduser");
   }
    /*-------------------POST COMMENT-----------------*/

    public function insertUserPostcomment($data){
        $data['id_user'] = intval($data['id_user']);
        $data['id_post'] = intval($data['id_post']);
        $data['comment'] = $this->mysql->real_escape_string($data['comment']);

        $this->mysql->query("Insert into post_comment (id_user,id_post,text) 
          VALUES ({$data['id_user']}, {$data['id_post']},'{$data['comment']}')");

        $insert_id = (int)$this->mysql->insert_id;
        return $insert_id;
    }

    public function insertReplyPostComment($iduser,$idpost,$idcomment,$iduser_replycomment,$comment,$login_replycomment,$text_replycomment){
        $iduser = intval($iduser);
        $idpost = intval($idpost);
        $idcomment = intval($idcomment);
        $iduser_replycomment = intval($iduser_replycomment);
        $comment = $this->mysql->real_escape_string($comment);
        $login_replycomment = $this->mysql->real_escape_string($login_replycomment);
        $text_replycomment = $this->mysql->real_escape_string($text_replycomment);

        $this->mysql->query("Insert into post_comment (id_user,id_post,text,id_parent,iduser_replycomment,shownpopup_replycomment,login_replycomment,text_replycomment) 
          VALUES ({$iduser}, {$idpost},'{$comment}',{$idcomment},{$iduser_replycomment},'no','{$login_replycomment}','{$text_replycomment}')");

        $insert_id = (int)$this->mysql->insert_id;
        return $insert_id;
    }

    public function getPostCommentById($id){
        $id = intval($id);
        $rs = $this->mysql->query("select * from post_comment where id=$id");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $postcomment = new Postcomment();
        $postcomment->setPostcomment($row);
        return $postcomment;
    }

    public function getPostComments($idpost){
        $idpost = intval($idpost);

        $rs = $this->mysql->query("select * from post_comment where id_post=$idpost AND id_parent=0 ORDER BY id DESC");
        $comments = array();
        while(($row = $rs->fetch_assoc())!=false){
            $comment = new Postcomment();
            $comment->setPostcomment($row);
            $user_obj = $this->getUserById($comment->getIdUser());
            $comment->setLogin($user_obj->getLogin());
            $comment_likes_dislikes = $this->getPostCommentLikesDislikes($comment->getId());
            $comment_childs = $this->getPostCommentsChilds($comment->getId());
            $comments[] = array(
                'comment'=>$comment,
                'likes'=>$comment_likes_dislikes['likes'],
                'dislikes'=>$comment_likes_dislikes['dislikes'],
                'comment_childs'=>$comment_childs
            );
        }
        return $comments;
    }

    public function getPostCommentsSortPopular($idprognoz){
        $idprognoz = intval($idprognoz);

        $rs = $this->mysql->query("select * from post_comment where id_post=$idprognoz AND id_parent=0 ORDER BY id DESC");
        $comments = array();
        while(($row = $rs->fetch_assoc())!=false){
            $comment = new Postcomment();
            $comment->setPostcomment($row);
            $user_obj = $this->getUserById($comment->getIdUser());
            $comment->setLogin($user_obj->getLogin());
            $comment_likes_dislikes = $this->getPostCommentLikesDislikes($comment->getId());
            $comment_childs = $this->getPostCommentsChilds($comment->getId());
            $comments[] = array(
                'comment'=>$comment,
                'likes'=>$comment_likes_dislikes['likes'],
                'dislikes'=>$comment_likes_dislikes['dislikes'],
                'comment_childs'=>$comment_childs
            );
        }

        uasort($comments,"sortPopularComments");
        return $comments;
    }

    public function getPostCommentLikesDislikes($idcomment){
        $idcomment = intval($idcomment);

        $rs = $this->mysql->query("select * from post_comment_like where id_postcomment=$idcomment ORDER BY id DESC");
        $likes = array('likes'=>array(),'dislikes'=>array());
        while(($row = $rs->fetch_assoc())!=false){
            $postcommentlike = new Postcommentlike();
            $postcommentlike->setPostcommentlike($row);
            if($postcommentlike->getTypeLike()=="like"){
                $likes['likes'][] = $postcommentlike;
            }elseif($postcommentlike->getTypeLike()=="dislike"){
                $likes['dislikes'][] = $postcommentlike;
            }
        }
        return $likes;
    }

    public function getPostCommentsChilds($idcomment){
        $idcomment = intval($idcomment);

        $rs = $this->mysql->query("select * from post_comment where id_parent=$idcomment ORDER BY id ASC");
        $comments = array();
        while(($row = $rs->fetch_assoc())!=false){
            $comment = new Postcomment();
            $comment->setPostcomment($row);
            $user_obj = $this->getUserById($comment->getIdUser());
            $comment->setLogin($user_obj->getLogin());
            $comment_likes_dislikes = $this->getPostCommentLikesDislikes($comment->getId());
            $comments[] = array(
                'comment'=>$comment,
                'likes'=>$comment_likes_dislikes['likes'],
                'dislikes'=>$comment_likes_dislikes['dislikes']
            );
        }
        return $comments;
    }

    public function getPostCommentUserLikeDislike($iduser,$idcomment){
        $iduser = intval($iduser);
        $idcomment = intval($idcomment);

        $rs = $this->mysql->query("select * from post_comment_like where id_postcomment=$idcomment and id_user=$iduser");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $postcommentlike = new Postcommentlike();
        $postcommentlike->setPostcommentlike($row);

        return $postcommentlike;
    }

    public function insertPostCommentLikeDislike($iduser,$idcomment,$datatype){
        $iduser = intval($iduser);
        $idcomment = intval($idcomment);
        $datatype = $this->mysql->real_escape_string($datatype);

        $this->mysql->query("Insert into post_comment_like (id_postcomment,id_user,type_like) 
          VALUES ({$idcomment}, {$iduser},'{$datatype}')");
    }

    public function updatePostCommentLikeDislike($iduser,$idcomment,$datatype){
        $iduser = intval($iduser);
        $idcomment = intval($idcomment);
        $datatype = $this->mysql->real_escape_string($datatype);

        $this->mysql->query("UPDATE post_comment_like SET type_like='{$datatype}' where id_postcomment=$idcomment and id_user=$iduser");
    }

    public function getUnreadUserPostComments($iduser){
        $iduser = intval($iduser);

        $ids = array();
        $rs = $this->mysql->query("select * from post_comment where iduser_replycomment=$iduser AND id_parent>0 AND shownpopup_replycomment!='yes' ORDER BY id DESC");
        $posts = array();
        while(($row = $rs->fetch_assoc())!=false){
            $id_post = intval($row['id_post']);
            if(!in_array($id_post,$ids)){
                $ids[]=$id_post;
                $post = $this->getPostById($id_post);
                $posts[] = $post;
            }
        }

        //$new_prognozi_arr = array_slice($prognozi,0,3);

        return $posts;
    }

    public function makereadUserPostComments($idpost,$iduser){
        $iduser = intval($iduser);
        $idpost = intval($idpost);
        $this->mysql->query("UPDATE post_comment SET shownpopup_replycomment='yes' where id_post=$idpost and iduser_replycomment=$iduser");
    }

    public function getUnreadUserThisPostComments($iduser,$idpost){
        $iduser = intval($iduser);
        $idpost = intval($idpost);

        $rs = $this->mysql->query("select * from post_comment where iduser_replycomment={$iduser} AND id_post={$idpost} AND id_parent>0 AND shownpopup_replycomment!='yes' ORDER BY id DESC");
        $commentsids = array();
        while(($row = $rs->fetch_assoc())!=false){
            $commentsids[] = $row['id'];
        }

        return $commentsids;
    }

    public function getAllCommentsPostAdmin($page){
        $page = intval($page);
        $limit = 40;
        $offset = ($page-1)*$limit;

        $rs = $this->mysql->query("select * from post_comment ORDER BY id DESC LIMIT $offset, $limit");
        $comments = array();
        while(($row = $rs->fetch_assoc())!=false){
            $comment = new Postcomment();
            $comment->setPostcomment($row);
            $comments[] = $comment;
        }
        return $comments;
    }

    public function pagesResultCommentsPost(){
        $res = $this->mysql->query("select COUNT(*) as cnt from post_comment")->fetch_assoc();
        return (int)$res['cnt'];
    }

    public function deleteCommentPost($id){
        $id = intval($id);
        $this->mysql->query("delete from post_comment where id={$id}");
    }
    /*-----------------PROGNOZ GOLOSOVANIE----------------------*/

    public function getPrognozgolosovanieAll($idprognoz,$iduser=0){
        $idprognoz = intval($idprognoz);

        $rs = $this->mysql->query("select * from prognoz_golosovanie where id_prognoz=$idprognoz");
        $golosovanie = array('prohod'=>array(),'neprohod'=>array(),'usergolosoval'=>'no');
        while(($row = $rs->fetch_assoc())!=false){
            $golos = new Prognozgolosovanie();
            $golos->setPrognozgolosovanie($row);
            if($golos->getProhod()=="prohod"){
                $golosovanie['prohod'][] = $golos;
            }elseif($golos->getProhod()=="neprohod"){
                $golosovanie['neprohod'][] = $golos;
            }
            if($iduser!=0 && intval($iduser)==$golos->getIdUser()){
                $golosovanie['usergolosoval'] = 'yes';
            }
        }
        $golosovanie['summagolosov'] = count($golosovanie['prohod']) + count($golosovanie['neprohod']);
        return $golosovanie;
    }

    public function checkGolosovalUserInPrognoz($iduser){
        $iduser = intval($iduser);
        $rs = $this->mysql->query("select * from prognoz_golosovanie where id_user=$iduser");
        $golosovanie = array();
        while(($row = $rs->fetch_assoc())!=false){
            $golos = new Prognozgolosovanie();
            $golos->setPrognozgolosovanie($row);
            $golosovanie[] = $golos;
        }
        if(count($golosovanie)>0){
            return "golosoval";
        }else{
            return "negolosoval";
        }
    }

    public function checkGolosovalUserInThisPrognoz($iduser,$idprognoz){
        $iduser = intval($iduser);
        $idprognoz = intval($idprognoz);
        $rs = $this->mysql->query("select * from prognoz_golosovanie where id_user=$iduser AND id_prognoz=$idprognoz");
        $golosovanie = array();
        while(($row = $rs->fetch_assoc())!=false){
            $golos = new Prognozgolosovanie();
            $golos->setPrognozgolosovanie($row);
            $golosovanie[] = $golos;
        }
        if(count($golosovanie)>0){
            return "golosoval";
        }else{
            return "negolosoval";
        }
    }

    public function insertPrognozgolos($data){
        $idprognoz = intval($data['id_prognoz']);
        $prohod = $this->mysql->real_escape_string($data['prohod']);
        $comment = $this->mysql->real_escape_string($data['comment']);
        $iduser = intval($data['id_user']);

        $this->mysql->query("Insert into prognoz_golosovanie (id_prognoz,id_user,prohod,comment) 
          VALUES ({$idprognoz}, {$iduser},'{$prohod}','{$comment}')");
    }

    public function makeGolosCookie($data){
        $idprognoz = intval($data['id_prognoz']);
        $prohod = $this->mysql->real_escape_string($data['prohod']);
        $comment = $this->mysql->real_escape_string($data['comment']);

        setcookie ("golos_idprognoz",$idprognoz,time()+86400,"/"); //На один день куки
        setcookie ("golos_prohod",$prohod,time()+86400,"/"); //На один день куки
        setcookie ("golos_comment",$comment,time()+86400,"/"); //На один день куки
        setcookie ("golos_status","notsaved",time()+86400,"/"); //На один день куки
    }

    public function makeCommentPrognozCookie($data){
        $idprognoz = intval($data['id_prognoz']);
        $comment = $this->mysql->real_escape_string($data['comment']);
        setcookie ("prognoz_idprognoz",$idprognoz,time()+86400,"/"); //На один день куки
        setcookie ("prognoz_comment",$comment,time()+86400,"/"); //На один день куки
    }

    public function makeCommentPostCookie($data){
        $idpost = intval($data['id_post']);
        $comment = $this->mysql->real_escape_string($data['comment']);
        setcookie ("post_idpost",$idpost,time()+86400,"/"); //На один день куки
        setcookie ("post_comment",$comment,time()+86400,"/"); //На один день куки
    }


    public function unsetGolosCookie(){
        setcookie ("golos_idprognoz","",time()-86400,"/");
        setcookie ("golos_prohod","",time()-86400,"/");
        setcookie ("golos_comment","",time()-86400,"/");
        setcookie ("golos_status","saved",time()-86400,"/");
    }

    public function unsetCommentPrognozCookie(){
        setcookie ("prognoz_idprognoz","",time()-86400,"/");
        setcookie ("prognoz_comment","",time()-86400,"/");
    }

    public function unsetCommentPostCookie(){
        setcookie ("post_idpost","",time()-86400,"/");
        setcookie ("post_comment","",time()-86400,"/");
    }

    public function unsetSortCommentsCookie(){
        setcookie ("scrollfromtop","",time()-86400,"/");
        setcookie ("comment_sort","",time()-86400,"/");
    }
    /*--------------TAGS--------------*/

    public function getTagById($id){
        $id = intval($id);
        $rs = $this->mysql->query("select * from tags where id=$id");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $tag = new Tag();
        $tag->setTag($row);
        return $tag;
    }

    public function getTagByNazva($tagname){
        $tagname = $this->mysql->real_escape_string($tagname);
        $rs = $this->mysql->query("select * from tags where nazva='{$tagname}'");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $tag = new Tag();
        $tag->setTag($row);
        return $tag;
    }

    public function getTagBySsilka($ssilka){
        $ssilka = $this->mysql->real_escape_string($ssilka);
        $rs = $this->mysql->query("select * from tags where ssilka='{$ssilka}'");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $tag = new Tag();
        $tag->setTag($row);
        return $tag;
    }

    public function getTagsByLikeTagname($tagname){
        $tagname = $this->mysql->real_escape_string($tagname);

        $rs = $this->mysql->query("select * from tags where nazva LIKE '%{$tagname}%'");
        $tags = array();
        while(($row = $rs->fetch_assoc())!=false){
            $tag = new Tag();
            $tag->setTag($row);
            $tags[] = $tag;
        }
        return $tags;
    }

    public function getTagsAdmin($page){
        $page = intval($page);
        $limit = 40;
        $offset = ($page-1)*$limit;

        $rs = $this->mysql->query("select * from tags ORDER BY id DESC LIMIT $offset, $limit");
        $tags = array();
        while(($row = $rs->fetch_assoc())!=false){
            $tag = new Tag();
            $tag->setTag($row);
            $tags[] = $tag;
        }
        return $tags;
    }

    public function getAllTags(){
        $rs = $this->mysql->query("select * from tags ORDER BY id DESC");
        $tags = array();
        while(($row = $rs->fetch_assoc())!=false){
            $tag = new Tag();
            $tag->setTag($row);
            $tags[] = $tag;
        }
        return $tags;
    }

    public function pagesResultTags(){
        $res = $this->mysql->query("select COUNT(*) as cnt from tags")->fetch_assoc();
        return (int)$res['cnt'];
    }

    public function addTagAdmin($data){
        $nazva = $this->mysql->real_escape_string($data['nazva']);
        $ssilka = $this->mysql->real_escape_string($data['ssilka']);
        $description = $this->mysql->real_escape_string($data['description']);

        $this->mysql->query("Insert into tags (nazva,ssilka,description,text) VALUES
         ('{$nazva}','{$ssilka}','{$description}','{$data['text']}')");
    }

    public function changeTagAdmin($data){
        $nazva = $this->mysql->real_escape_string($data['nazva']);
        $ssilka = $this->mysql->real_escape_string($data['ssilka']);
        $description = $this->mysql->real_escape_string($data['description']);

        $this->mysql->query("UPDATE tags SET nazva='{$nazva}', ssilka='{$ssilka}', 
        description='{$description}', text='{$data['text']}' where id={$data['id']}");
    }

    public function deleteTagAdmin($id){
        $id = intval($id);
        $this->mysql->query("delete from tags where id={$id}");
    }

    public function copyTagAdmin($id){
        $id = intval($id);
        $this->mysql->query("insert into tags (nazva,description,text) select nazva,description,text from tags where id=$id;");
        $ins_id = $this->mysql->insert_id;
    }

    public function getTagPrognoziAndPosts($tag,$page){

        $page = intval($page);
        $tag = trim($this->mysql->real_escape_string($tag));

        $limit = 5;
        $offset = ($page-1)*$limit;

        $rs = $this->mysql->query("select * from prognozi where tags LIKE '%{$tag}%' ORDER BY id DESC");
        $prognozi = array();
        while(($row = $rs->fetch_assoc())!=false){
            $prognoz = new Prognoz();
            $prognoz->setPrognoz($row);
            $prognozi[] = $prognoz;
        }

        $rs2 = $this->mysql->query("select * from posts where tags LIKE '%{$tag}%' ORDER BY id DESC");
        $posts = array();
        while(($row = $rs2->fetch_assoc())!=false){
            $post = new Post();
            $post->setPost($row);
            $posts[] = $post;
        }

        $obshiy_arr = array_merge($prognozi, $posts);
        uasort($obshiy_arr,"mySortTags");

        $new_obshiy_arr['posts'] = array_slice($obshiy_arr,$offset,$limit);
        $new_obshiy_arr['count'] = count($obshiy_arr);

        return $new_obshiy_arr;

    }


    /*------------------CHAMPIONAT------------------*/

    public function getChampionatById($id){
        $id = intval($id);
        $rs = $this->mysql->query("select * from championats where id=$id");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $championat = new Championat();
        $championat->setChampionat($row);
        return $championat;
    }


    public function getChampionatBySsilka($ssilka){
        $ssilka = $this->mysql->real_escape_string($ssilka);
        $rs = $this->mysql->query("select * from championats where ssilka='{$ssilka}'");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $championat = new Championat();
        $championat->setChampionat($row);
        return $championat;
    }

    public function getChampionatsAdmin(){

        $rs = $this->mysql->query("select * from championats ORDER BY sort ASC");
        $championats = array();
        while(($row = $rs->fetch_assoc())!=false){
            $championat = new Championat();
            $championat->setChampionat($row);
            $championats[] = $championat;
        }
        return $championats;
    }

    public function getChampionatsShowing(){

        $rs = $this->mysql->query("select * from championats where showing='yes' ORDER BY sort ASC");
        $championats = array();
        while(($row = $rs->fetch_assoc())!=false){
            $championat = new Championat();
            $championat->setChampionat($row);
            $championats[] = $championat;
        }
        return $championats;
    }

     public function getAllChampionats(){
        $rs = $this->mysql->query("select * from championats where showing='yes' ORDER BY id ASC");
        $tags = array();
        while(($row = $rs->fetch_assoc())!=false){
            $tag = new Tag();
            $tag->setTag($row);
            $tags[] = $tag;
        }
        return $tags;
    }

    public function incrementChampionat($id){
        $id = intval($id);
        $championat  = $this->getChampionatById($id);
        $increment = $championat->getViews()+1;
        $this->mysql->query("UPDATE championats SET views={$increment} where id=$id");

    }

    public function changeChampionatShowing($id){
        $id = intval($id);
        $ps = $this->getChampionatById($id);
        if($ps->getId()>0){
            $show = $ps->getShowing();
            if($show=="yes"){
                $this->mysql->query("UPDATE championats SET showing='no' where id={$id}");
                return "no";
            }else{
                $this->mysql->query("UPDATE championats SET showing='yes' where id={$id}");
                return "yes";
            }
        }
        return "error";
    }


    public function isSsilkaExistChampionat($ssilka){
        $rs = $this->mysql->query("select * from championats WHERE ssilka='{$ssilka}'");
        if($rs->num_rows==0){
            return false;
        }else{
            return true;
        }
    }

    public function saveChampionat($data){
        $nazva = $this->mysql->real_escape_string($data['nazva']);
        $description = $this->mysql->real_escape_string($data['description']);
        $title_seoturi = $this->mysql->real_escape_string($data['title_seoturi']);
        $description_seoturi = $this->mysql->real_escape_string($data['description_seoturi']);
        $h1_seoturi = $this->mysql->real_escape_string($data['h1_seoturi']);


        $this->mysql->query("Insert into championats (nazva,description,text,text_prognozi_bottom,img,ssilka,href_tablica,href_matchi,sort,showing,title_seoturi,description_seoturi,h1_seoturi) VALUES
         ('{$nazva}','{$description}','{$data['text']}','{$data['text_prognozi_bottom']}','{$data['img']}','{$data['ssilka']}','{$data['href_tablica']}',
         '{$data['href_matchi']}',{$data['sort']},'yes','{$title_seoturi}','{$description_seoturi}','{$h1_seoturi}')");
    }

    public function changeChampionat($data){
        $nazva = $this->mysql->real_escape_string($data['nazva']);
        $description = $this->mysql->real_escape_string($data['description']);
        $id = intval($data['id']);
        $title_seoturi = $this->mysql->real_escape_string($data['title_seoturi']);
        $description_seoturi = $this->mysql->real_escape_string($data['description_seoturi']);
        $h1_seoturi = $this->mysql->real_escape_string($data['h1_seoturi']);

        $this->mysql->query("UPDATE championats SET nazva='{$nazva}', description='{$description}', text='{$data['text']}', text_prognozi_bottom='{$data['text_prognozi_bottom']}',
        img='{$data['img']}', ssilka='{$data['ssilka']}', href_tablica='{$data['href_tablica']}', href_matchi='{$data['href_matchi']}', sort={$data['sort']},
        title_seoturi='{$title_seoturi}', description_seoturi='{$description_seoturi}', h1_seoturi='{$h1_seoturi}' where id={$id}");
    }

    public function deleteChampionat($id){
        $id = intval($id);
        $this->mysql->query("delete from championats where id={$id}");
    }

    public function copyChampionatAdmin($id){
        $id = intval($id);
        $this->mysql->query("insert into championats (nazva,description,text,img) select nazva,description,text,img from championats where id=$id;");
        $ins_id = $this->mysql->insert_id;
    }

    public function updateSyncChampMatchi($id_championat,$full_matchi,$little_matchi){
        $id_championat = intval($id_championat);
        $full_matchi = $this->mysql->real_escape_string($full_matchi);
        $little_matchi = $this->mysql->real_escape_string($little_matchi);

        $this->mysql->query("UPDATE championats SET full_matchi='{$full_matchi}', little_matchi='{$little_matchi}',
        date_sync_matchi=NOW() where id={$id_championat}");
    }

    public function updateSyncChampTablica($id_championat,$full_tablica){
        $id_championat = intval($id_championat);
        $full_tablica = $this->mysql->real_escape_string($full_tablica);

        $this->mysql->query("UPDATE championats SET full_tablica='{$full_tablica}', date_sync_tablica=NOW() where id={$id_championat}");
    }

    /*-----------------CHAMPIONATCOMANDA------------------*/

    public function getChampionatcomandaById($id){
        $id = intval($id);
        $rs = $this->mysql->query("select * from championat_comandi where id=$id");
        if(!isset($rs))die("Bad");
        if(empty($rs))die("Bad");
        $row = $rs->fetch_assoc();
        $championatcomand = new Championatcomanda();
        $championatcomand->setChampionatcomanda($row);
        return $championatcomand;
    }

    public function getChampionatcomandiByChampId($id_championat){
        $id_championat = intval($id_championat);

        $rs = $this->mysql->query("select * from championat_comandi where id_championat=$id_championat ORDER BY nazva ASC");
        $championat_comandi = array();
        while(($row = $rs->fetch_assoc())!=false){
            $championatcomanda = new Championatcomanda();
            $championatcomanda->setChampionatcomanda($row);
            $championat_comandi[] = $championatcomanda;
        }
        return $championat_comandi;
    }

    public function insertChampioncomanda($data){
        $nazva = $this->mysql->real_escape_string($data['nazva']);
        $id = intval($data['championatid']);
        $this->mysql->query("Insert into championat_comandi (id_championat, nazva) VALUES ({$id},'{$nazva}')");
    }

    public function changeChampionatcomanda($data){
        $nazva = $this->mysql->real_escape_string($data['nazva']);
        $id = intval($data['id']);
        $this->mysql->query("UPDATE championat_comandi SET nazva='{$nazva}' where id={$id}");

    }

    public function deleteChampionatcomanda($id){
        $id = intval($id);
        $this->mysql->query("delete from championat_comandi where id={$id}");
    }


    /*------------------CHAMPIONATPROGNOZ----------------*/

    public function getChampionatprognozById($id){
        $prognoz = $this->getPrognozById($id);
        return $prognoz;
    }

    public function getChampionatprognoziSite($id_championat,$page){
        $id_championat = intval($id_championat);
        $page = intval($page);
        $limit = 30;
        $offset = (intval($page)-1)*$limit;

        $prognozi = array();
        if($id_championat!=0){
            $rs = $this->mysql->query("select * from prognozi where id_championat=$id_championat and showing='yes' ORDER BY date_sort DESC LIMIT $offset, $limit");
            while(($row = $rs->fetch_assoc())!=false){
                $prognoz = new Prognoz();
                $prognoz->setPrognoz($row);
                $prognozi[] = $prognoz;
            }
        }

        return $prognozi;
    }

    public function pagesResultChampionatPrognoziSite($id_championat){
        $id_championat = intval($id_championat);

        if($id_championat!=0){
            $res = $this->mysql->query("select COUNT(*) as cnt from prognozi where id_championat={$id_championat}")->fetch_assoc();
            return (int)$res['cnt'];
        }else{
            return 0;
        }

    }

    public function changeChampionatPrognozShowingmain($id){
        $id = intval($id);
        $ps = $this->getPrognozById($id);
        if($ps->getId()>0){
            $show = $ps->getShowingMain();
            if($show=="yes"){
                $this->mysql->query("UPDATE prognozi SET showing_main='no' where id={$id}");
                return "no";
            }else{
                $this->mysql->query("UPDATE prognozi SET showing_main='yes' where id={$id}");
                return "yes";
            }
        }
        return "error";
    }

    /*

    public function getChampionatPrognoziAdmin($id_championat,$type,$page){
        $id_championat = intval($id_championat);
        $page = intval($page);
        $type = $this->mysql->real_escape_string($type);
        $limit = 40;
        $offset = (intval($page)-1)*$limit;

        $sql_type = "";
        if($type!="all" && $id_championat==0){
            $sql_type = "WHERE type='".$type."'";
        }elseif($type!="all" && $id_championat>0){
            $sql_type = "AND type='".$type."'";
        }

        $prognozi = array();
        if($id_championat!=0){
            $rs = $this->mysql->query("select * from prognozi where id_championat=$id_championat $sql_type ORDER BY id DESC LIMIT $offset, $limit");
            while(($row = $rs->fetch_assoc())!=false){
                $prognoz = new Prognoz();
                $prognoz->setPrognoz($row);
                $prognozi[] = $prognoz;
            }
        }

        return $prognozi;
    }





    public function pagesResultChampionatPrognoziAdmin($id_championat,$type){
        $id_championat = intval($id_championat);
        $type = $this->mysql->real_escape_string($type);

        $sql_type = "";
        if($type!="all" && $id_championat==0){
            $sql_type = "WHERE type='".$type."'";
        }elseif($type!="all" && $id_championat>0){
            $sql_type = "AND type='".$type."'";
        }

        if($id_championat!=0){
            $res = $this->mysql->query("select COUNT(*) as cnt from prognozi where id_championat={$id_championat} $sql_type")->fetch_assoc();
            return (int)$res['cnt'];
        }else{
            return 0;
        }

    }


    public function addChampionatprognoz($data){
        $nazva = $this->mysql->real_escape_string($data['nazva']);
        $text_email = $this->mysql->real_escape_string($data['text_email']);
        $ssilka = $this->mysql->real_escape_string($data['ssilka']);
        $description = $this->mysql->real_escape_string($data['description']);
        $matchnazva = $this->mysql->real_escape_string($data['matchnazva']);
        $tags = $this->mysql->real_escape_string($data['tags']);

        $this->mysql->query("Insert into prognozi (id_championat,id_champkomanda1,id_champkomanda2,nazva,matchnazva,ssilka,type,img,description,text_email,text,koeficient,date,time,year,date_sort,showing,showing_main,tags) VALUES
         ({$data['id_champ']},{$data['comanda1']},{$data['comanda2']},'{$nazva}','{$matchnazva}','{$ssilka}','{$data['type']}','{$data['img']}','{$description}','{$text_email}',
         '{$data['text']}','{$data['koeficient']}','{$data['date']}','{$data['time']}', '{$data['year']}', '{$data['date_sort']}', '{$data['showing']}','{$data['showing_main']}', '{$tags}')");
    }

    public function copyChampionatPrognoz($id){
        $id = intval($id);
        $this->mysql->query("insert into prognozi (id_championat,id_champkomanda1,id_champkomanda2,nazva,matchnazva,type,img,description,text_email,text,koeficient,date,time,year,date_sort)
        select id_championat,id_champkomanda1,id_champkomanda2,nazva,matchnazva,type,img,description,text_email,text,koeficient,date,time,year,date_sort from prognozi where id=$id;");
        $ins_id = $this->mysql->insert_id;
        $this->mysql->query("UPDATE championat_prognozi SET showing='no' where id={$ins_id}");
    }


    public function deleteChampionatPrognoz($id){
        $id = intval($id);
        $this->mysql->query("delete from prognozi where id={$id}");
    }


    public function changeChampionatPrognozShowing($id){
        $id = intval($id);
        $ps = $this->getPrognozById($id);
        if($ps->getId()>0){
            $show = $ps->getShowing();
            if($show=="yes"){
                $this->mysql->query("UPDATE prognozi SET showing='no' where id={$id}");
                return "no";
            }else{
                $this->mysql->query("UPDATE prognozi SET showing='yes' where id={$id}");
                return "yes";
            }
        }
        return "error";
    }

    

    public function changeChampionatPrognoz($data){
        $nazva = $this->mysql->real_escape_string($data['nazva']);
        $text_email = $this->mysql->real_escape_string($data['text_email']);
        $description = $this->mysql->real_escape_string($data['description']);
        $matchnazva = $this->mysql->real_escape_string($data['matchnazva']);
        $tags = $this->mysql->real_escape_string($data['tags']);

        $this->mysql->query("UPDATE prognozi SET id_champkomanda1={$data['comanda1']}, id_champkomanda2={$data['comanda2']}, nazva='{$nazva}', matchnazva='{$matchnazva}', ssilka='{$data['ssilka']}', type='{$data['type']}',
        description='{$description}', text_email='{$text_email}', text='{$data['text']}', koeficient='{$data['koeficient']}', img='{$data['img']}',
        date='{$data['date']}', time='{$data['time']}', year='{$data['year']}', date_sort='{$data['date_sort']}', tags='{$tags}' where id={$data['id']}");
    }


    public function changeStatusChampionatPrognoz($id,$status){
        $id = intval($id);
        $status = $this->mysql->real_escape_string($status);
        if($status=="without"){
            $status="";
        }
        $this->mysql->query("UPDATE prognozi SET proshel='{$status}' where id={$id}");
    }*/







    
}

function mySortTags($f1,$f2)
{
    $date_f1 = DateTime::createFromFormat('Y-m-d H:i:s', $f1->getDateSort());
    $date_f2 = DateTime::createFromFormat('Y-m-d H:i:s', $f2->getDateSort());

    if($date_f1 > $date_f2) return -1;
    elseif($date_f1 < $date_f2) return 1;
    else return 0;
}

function sortPopularComments($f1,$f2){
    $likes_f1 = $f1['likes'];
    $likes_f2 = $f2['likes'];

    if($likes_f1 > $likes_f2) return -1;
    elseif($likes_f1 < $likes_f2) return 1;
    else return 0;
}