<?php


class Prognozcomment{
    private $id;
    private $id_prognoz;
    private $id_user;
    private $text;
    private $id_parent;
    private $iduser_replycomment;
    private $shownpopup_replycomment;
    private $login;
    private $login_replycomment;
    private $text_replycomment;
    private $datee;

    public function setPrognozcomment($row){
        $this->id = (int)$row['id'];
        $this->id_prognoz = (int)$row['id_prognoz'];
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
    public function getIduserReplycomment()
    {
        return $this->iduser_replycomment;
    }

    /**
     * @return mixed
     */
    public function getShownpopupReplycomment()
    {
        return $this->shownpopup_replycomment;
    }

    /**
     * @param mixed $iduser_replycomment
     */
    public function setIduserReplycomment($iduser_replycomment)
    {
        $this->iduser_replycomment = (int)$iduser_replycomment;
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
    public function getLoginReplycomment()
    {
        return $this->login_replycomment;
    }

    /**
     * @param mixed $login_replycomment
     */
    public function setLoginReplycomment($login_replycomment)
    {
        $this->login_replycomment = $login_replycomment;
    }

    /**
     * @return mixed
     */
    public function getDatee()
    {
        return $this->datee;
    }

    /**
     * @param mixed $datee
     */
    public function setDatee($datee)
    {
        $this->datee = $datee;
    }

    /**
     * @return mixed
     */
    public function getTextReplycomment()
    {
        return $this->text_replycomment;
    }

    /**
     * @param mixed $text_replycomment
     */
    public function setTextReplycomment($text_replycomment)
    {
        $this->text_replycomment = $text_replycomment;
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
    public function getIdParent()
    {
        return $this->id_parent;
    }

    /**
     * @param mixed $id_parent
     */
    public function setIdParent($id_parent)
    {
        $this->id_parent = (int)$id_parent;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @return mixed
     */
    public function getIdPrognoz()
    {
        return $this->id_prognoz;
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $id_prognoz
     */
    public function setIdPrognoz($id_prognoz)
    {
        $this->id_prognoz = (int)$id_prognoz;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = (int)$id_user;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

}