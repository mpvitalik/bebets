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

    /*--------------OTZIVI----------------*/

    public function getAllOtzivi(){
        $rs = $this->mysql->query("select * from otzivi ORDER BY id DESC");
        $otzivi = array();
        while(($row = $rs->fetch_assoc())!=false){
            $otziv = new Otziv();
            $otziv->setOtziv($row);
            $otzivi[] = $otziv->getImg();
        }
        return $otzivi;
    }

    /*---------------NEWS----------------*/

    public function getAllNews(){
        $limit = 500;
        $rs = $this->mysql->query("select * from posts ORDER BY id DESC LIMIT $limit");
        $posts = array();
        while(($row = $rs->fetch_assoc())!=false){
            $post = new Post();
            $post->setPost($row);

            $one_post = array();
            $one_post['nazva'] = $post->getNazva();
            $one_post['description'] = $post->getDescription();
            $one_post['text'] = $post->getText();
            $one_post['image'] = $post->getImg();
            $one_post['date'] = $post->getDate();

            $posts[] = $one_post;
        }
        return $posts;
    }

}

?>