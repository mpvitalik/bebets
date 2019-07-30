<?php


class Reklama{
    private $id;
    private $nazva;
    private $kod;
    private $kod_mob;
    private $ssilka;
    private $img;

    public function setReklama($row){
        $this->id = (int)$row['id'];
        $this->nazva = $row['nazva'];
        $this->kod = $row['kod'];
        $this->kod_mob = $row['kod_mob'];
        $this->ssilka = $row['ssilka'];
        $this->img = $row['img'];
    }

    /**
     * @return mixed
     */
    public function getKodMob()
    {
        return $this->kod_mob;
    }

    /**
     * @param mixed $kod_mob
     */
    public function setKodMob($kod_mob)
    {
        $this->kod_mob = $kod_mob;
    }

    /**
     * @return mixed
     */
    public function getNazva()
    {
        return $this->nazva;
    }

    /**
     * @param mixed $nazva
     */
    public function setNazva($nazva)
    {
        $this->nazva = $nazva;
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
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
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
    public function getKod()
    {
        return $this->kod;
    }

    /**
     * @return mixed
     */
    public function getSsilka()
    {
        return $this->ssilka;
    }

    /**
     * @param mixed $kod
     */
    public function setKod($kod)
    {
        $this->kod = $kod;
    }

    /**
     * @param mixed $ssilka
     */
    public function setSsilka($ssilka)
    {
        $this->ssilka = $ssilka;
    }


}