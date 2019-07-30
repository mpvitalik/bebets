<?php


class Postcomment{
    private $id;
    private $id_post;
    private $id_user;
    private $text;
    private $id_parent;
    private $login;
    private $iduser_replycomment;
    private $shownpopup_replycomment;
    private $login_replycomment;
    private $text_replycomment;
    private $datee;

    public function setPostcomment($row){
        $this->id = (int)$row['id'];
        $this->id_post = (int)$row['id_post'];
        $this->id_user = (int)$row['id_user'];
        $this->text = $row['text'];
        $this->id_parent = (int)$row['id_parent'];
        $this->iduser_replycomment = (int)$row['iduser_replycomment'];
        $this->shownpopup_replycomment = $row['shownpopup_replycomment'];
        $this->login_replycomment = $row['login_replycomment'];
        $this->text_replycomment = $row['text_replycomment'];
        $this->datee = $row['datee'];
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }
    /**
     * @return mixed
     */
    public function getIduserReplycomment()
    {
        return $this->iduser_replycomment;
    }

    /**
     * @return mixed
     */
    public function getDatee()
    {
        return $this->datee;
    }

    /**
     * @param mixed $shownpopup_replycomment
     */
    public function setShownpopupReplycomment($shownpopup_replycomment)
    {
        $this->shownpopup_replycomment = $shownpopup_replycomment;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIdParent()
    {
        return $this->id_parent;
    }

    /**
     * @return mixed
     */
    public function getIdPost()
    {
        return $this->id_post;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @return mixed
     */
    public function getLoginReplycomment()
    {
        return $this->login_replycomment;
    }

    /**
     * @return mixed
     */
    public function getShownpopupReplycomment()
    {
        return $this->shownpopup_replycomment;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getTextReplycomment()
    {
        return $this->text_replycomment;
    }

    /**
     * @param mixed $datee
     */
    public function setDatee($datee)
    {
        $this->datee = $datee;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @param mixed $id_parent
     */
    public function setIdParent($id_parent)
    {
        $this->id_parent = (int)$id_parent;
    }

    /**
     * @param mixed $id_post
     */
    public function setIdPost($id_post)
    {
        $this->id_post = (int)$id_post;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = (int)$id_user;
    }

    /**
     * @param mixed $iduser_replycomment
     */
    public function setIduserReplycomment($iduser_replycomment)
    {
        $this->iduser_replycomment = (int)$iduser_replycomment;
    }

    /**
     * @param mixed $login_replycomment
     */
    public function setLoginReplycomment($login_replycomment)
    {
        $this->login_replycomment = $login_replycomment;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @param mixed $text_replycomment
     */
    public function setTextReplycomment($text_replycomment)
    {
        $this->text_replycomment = $text_replycomment;
    }

}