<?php


class Postcommentlike{
    private $id;
    private $id_postcomment;
    private $id_user;
    private $type_like;

    public function setPostcommentlike($row){
        $this->id = (int)$row['id'];
        $this->id_postcomment = (int)$row['id_postcomment'];
        $this->id_user = (int)$row['id_user'];
        $this->type_like = $row['type_like'];
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = (int)$id_user;
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
    public function getIdPostcomment()
    {
        return $this->id_postcomment;
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
    public function getTypeLike()
    {
        return $this->type_like;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @param mixed $id_postcomment
     */
    public function setIdPostcomment($id_postcomment)
    {
        $this->id_postcomment = (int)$id_postcomment;
    }

    /**
     * @param mixed $type_like
     */
    public function setTypeLike($type_like)
    {
        $this->type_like = $type_like;
    }

}