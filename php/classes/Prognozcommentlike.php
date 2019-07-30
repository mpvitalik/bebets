<?php


class Prognozcommentlike{
    private $id;
    private $id_prognozcomment;
    private $id_user;
    private $type_like;

    public function setPrognozcommentlike($row){
        $this->id = (int)$row['id'];
        $this->id_prognozcomment = (int)$row['id_prognozcomment'];
        $this->id_user = (int)$row['id_user'];
        $this->type_like = $row['type_like'];
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = (int) $id_user;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * @return mixed
     */
    public function getIdPrognozcomment()
    {
        return $this->id_prognozcomment;
    }

    /**
     * @return mixed
     */
    public function getTypeLike()
    {
        return $this->type_like;
    }

    /**
     * @param mixed $id_prognozcomment
     */
    public function setIdPrognozcomment($id_prognozcomment)
    {
        $this->id_prognozcomment = (int) $id_prognozcomment;
    }

    /**
     * @param mixed $type_like
     */
    public function setTypeLike($type_like)
    {
        $this->type_like = $type_like;
    }

}