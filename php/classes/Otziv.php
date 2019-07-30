<?php

class Otziv{
    private $id;
    private $img;

    public function setOtziv($row){
        $this->id = (int)$row['id'];
        $this->img = $row['img'];
    }
    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
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
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

}