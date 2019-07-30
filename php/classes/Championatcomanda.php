<?php


class Championatcomanda{
    private $id;
    private $id_championat;
    private $nazva;

    public function setChampionatcomanda($row){
        $this->id = (int)$row['id'];
        $this->id_championat = $row['id_championat'];
        $this->nazva = $row['nazva'];
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
    public function getIdChampionat()
    {
        return $this->id_championat;
    }

    /**
     * @return mixed
     */
    public function getNazva()
    {
        return $this->nazva;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @param mixed $id_championat
     */
    public function setIdChampionat($id_championat)
    {
        $this->id_championat = (int)$id_championat;
    }

    /**
     * @param mixed $nazva
     */
    public function setNazva($nazva)
    {
        $this->nazva = $nazva;
    }

}