<?php


class Zakaz
{
    private $id;
    private $user_id;
    private $email;
    private $type;
    private $details;
    private $summa;
    private $date_zakaz;
    private $date_oplata;


    public function setRowClass($row){
        $this->id = (int)$row['id'];
        $this->user_id = (int)$row['user_id'];
        $this->email = $row['email'];
        $this->type = $row['type'];
        $this->details = (int)$row['details'];
        $this->summa = (int)$row['summa'];
        $this->date_zakaz = $row['date_zakaz'];
        $this->date_oplata = $row['date_oplata'];
    }

    /**
     * @return mixed
     */
    public function getSumma()
    {
        return $this->summa;
    }

    /**
     * @param mixed $summa
     */
    public function setSumma($summa)
    {
        $this->summa = (int)$summa;
    }
    /**
     * @return mixed
     */
    public function getDateOplata()
    {
        return $this->date_oplata;
    }

    /**
     * @return mixed
     */
    public function getDateZakaz()
    {
        return $this->date_zakaz;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $date_oplata
     */
    public function setDateOplata($date_oplata)
    {
        $this->date_oplata = $date_oplata;
    }

    /**
     * @param mixed $date_zakaz
     */
    public function setDateZakaz($date_zakaz)
    {
        $this->date_zakaz = $date_zakaz;
    }

    /**
     * @param mixed $details
     */
    public function setDetails($details)
    {
        $this->details = (int)$details;
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
        $this->id = (int)$id;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = (int)$user_id;
    }



}