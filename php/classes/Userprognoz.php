<?php




class Userprognoz{
    private $id;
    private $id_user;
    private $name;
    private $championat;
    private $time_championat;
    private $comandi;
    private $prognoz;
    private $koeficient;
    private $datee;
    private $datetoday;

    public function setUserprognoz($row){
        $this->id = (int)$row['id'];
        $this->id_user = (int)$row['id_user'];
        $this->championat = $row['championat'];
        $this->time_championat = $row['time_championat'];
        $this->comandi = $row['comandi'];
        $this->prognoz = $row['prognoz'];
        $this->koeficient = $row['koeficient'];
        $this->datee = $row['datee'];
    }

    public function setDatetoday($datetoday){
        $this->datetoday = $datetoday;
    }

    public function getDatetoday(){
        return $this->datetoday;
    }
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function getChampionat()
    {
        return $this->championat;
    }

    /**
     * @return mixed
     */
    public function getComandi()
    {
        return $this->comandi;
    }

    /**
     * @return mixed
     */
    public function getDatee()
    {
        return $this->datee;
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
    public function getKoeficient()
    {
        return $this->koeficient;
    }

    /**
     * @return mixed
     */
    public function getPrognoz()
    {
        return $this->prognoz;
    }

    /**
     * @return mixed
     */
    public function getTimeChampionat()
    {
        return $this->time_championat;
    }

    /**
     * @param mixed $championat
     */
    public function setChampionat($championat)
    {
        $this->championat = $championat;
    }

    /**
     * @param mixed $comandi
     */
    public function setComandi($comandi)
    {
        $this->comandi = $comandi;
    }

    /**
     * @param mixed $datee
     */
    public function setDatee($datee)
    {
        $this->datee = $datee;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = (int)$id_user;
    }

    /**
     * @param mixed $koeficient
     */
    public function setKoeficient($koeficient)
    {
        $this->koeficient = $koeficient;
    }

    /**
     * @param mixed $prognoz
     */
    public function setPrognoz($prognoz)
    {
        $this->prognoz = $prognoz;
    }

    /**
     * @param mixed $time_championat
     */
    public function setTimeChampionat($time_championat)
    {
        $this->time_championat = $time_championat;
    }

}