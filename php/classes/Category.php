<?php


class Category{

    private $id;
    private $nazva;
    private $nazva_eng;



    public function setCategory($row){
        $this->id = (int)$row['id'];
        $this->nazva_eng = $row['nazva_eng'];
        $this->nazva = $row['nazva'];
    }

    /**
     * @param mixed $nazva
     */
    public function setNazva($nazva)
    {
        $this->nazva = $nazva;
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNazva()
    {
        return $this->nazva;
    }

    /**
     * @return mixed
     */
    public function getNazvaEng()
    {
        return $this->nazva_eng;
    }

    /**
     * @param mixed $nazva_eng
     */
    public function setNazvaEng($nazva_eng)
    {
        $this->nazva_eng = $nazva_eng;
    }

}