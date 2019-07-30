<?php


class Otherpage{
    private $id;
    private $nazva;
    private $text;
    private $text2;
    private $text3;

    public function setOtherpage($row){
        $this->id = (int)$row['id'];
        $this->nazva = $row['nazva'];
        $this->text = $row['text'];
        $this->text2 = $row['text2'];
        $this->text3 = $row['text3'];
    }

    /**
     * @return mixed
     */
    public function getText2()
    {
        return $this->text2;
    }

    /**
     * @return mixed
     */
    public function getText3()
    {
        return $this->text3;
    }

    /**
     * @param mixed $text2
     */
    public function setText2($text2)
    {
        $this->text2 = $text2;
    }

    /**
     * @param mixed $text3
     */
    public function setText3($text3)
    {
        $this->text3 = $text3;
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
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }


}