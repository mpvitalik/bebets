<?php

class User{
    private $id;
    private $login;
    private $email;
    private $name;
    private $surname;
    private $img;
    private $fb_user;
    private $podtverzden;
    private $kodpodtverzdenia;

    public function setUser($row){
        $this->id = intval($row['id']);
        $this->login = $row['login'];
        $this->email = $row['email'];
        $this->img = $row['img'];
        $this->fb_user = $row['fb_user'];
        $this->podtverzden = $row['podtverzden'];
        $this->kodpodtverzdenia = $row['kodpodtverzdenia'];
    }

    /**
     * @return mixed
     */
    public function getKodpodtverzdenia()
    {
        return $this->kodpodtverzdenia;
    }

    /**
     * @return mixed
     */
    public function getPodtverzden()
    {
        return $this->podtverzden;
    }

    /**
     * @param mixed $kodpodtverzdenia
     */
    public function setKodpodtverzdenia($kodpodtverzdenia)
    {
        $this->kodpodtverzdenia = $kodpodtverzdenia;
    }

    /**
     * @param mixed $podtverzden
     */
    public function setPodtverzden($podtverzden)
    {
        $this->podtverzden = $podtverzden;
    }

    /**
     * @return mixed
     */
    public function getFbUser()
    {
        return $this->fb_user;
    }

    /**
     * @param mixed $fb_user
     */
    public function setFbUser($fb_user)
    {
        $this->fb_user = $fb_user;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
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
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }


}