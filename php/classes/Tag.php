<?php


class Tag{
    private $id;
    private $nazva;
    private $ssilka;
    private $description;
    private $text;

    public function setTag($row){
        $this->id = (int)$row['id'];
        $this->nazva = $row['nazva'];
        $this->ssilka = $row['ssilka'];
        $this->description = $row['description'];
        $this->text = $row['text'];
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
    public function getSsilka()
    {
        return $this->ssilka;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @param mixed $nazva
     */
    public function setNazva($nazva)
    {
        $this->nazva = $nazva;
    }

    /**
     * @param mixed $ssilka
     */
    public function setSsilka($ssilka)
    {
        $this->ssilka = $ssilka;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }


}