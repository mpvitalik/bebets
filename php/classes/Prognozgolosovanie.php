<?php


class Prognozgolosovanie{
    private $id;
    private $id_prognoz;
    private $id_user;
    private $prohod;
    private $comment;

    public function setPrognozgolosovanie($row){
        $this->id = (int)$row['id'];
        $this->id_prognoz = (int)$row['id_prognoz'];
        $this->id_user = (int)$row['id_user'];
        $this->prohod = $row['prohod'];
        $this->comment = $row['comment'];
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
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
    public function getProhod()
    {
        return $this->prohod;
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
     * @param mixed $prohod
     */
    public function setProhod($prohod)
    {
        $this->prohod = $prohod;
    }

}