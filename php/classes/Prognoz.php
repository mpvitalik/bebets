<?php


class Prognoz{
    private $id;
    private $id_championat;
    private $id_champkomanda1;
    private $id_champkomanda2;
    private $nazva;
    private $matchnazva;
    private $ssilka;
    private $type;
    private $img;
    private $description;
    private $text_email;
    private $text;
    private $koeficient;
    private $proshel;
    private $date;
    private $time;
    private $year;
    private $views;
    private $date_public;
    private $date_sort;
    private $showing;
    private $showing_main;
    private $tags;
    private $class_type='prognoz';

    public function setPrognoz($row){
        $this->id = (int)$row['id'];
        $this->id_championat = (int)$row['id_championat'];
        $this->id_champkomanda1 = (int)$row['id_champkomanda1'];
        $this->id_champkomanda2 = (int)$row['id_champkomanda2'];
        $this->nazva = $row['nazva'];
        $this->matchnazva = $row['matchnazva'];
        $this->ssilka = $row['ssilka'];
        $this->type = $row['type'];
        $this->img = $row['img'];
        $this->description = $row['description'];
        $this->text = $row['text'];
        $this->koeficient = $row['koeficient'];
        $this->proshel = $row['proshel'];
        $this->date = $row['date'];
        $this->time = $row['time'];
        $this->year = $row['year'];
        $this->views = (int)$row['views'];
        $this->date_public = $row['date_public'];
        $this->date_sort = $row['date_sort'];
        $this->text_email = $row['text_email'];
        $this->showing = $row['showing'];
        $this->showing_main = $row['showing_main'];
        $this->tags = $row['tags'];
    }

    /**
     * @return mixed
     */
    public function getShowingMain()
    {
        return $this->showing_main;
    }

    /**
     * @return mixed
     */
    public function getIdChampkomanda1()
    {
        return $this->id_champkomanda1;
    }

    /**
     * @return mixed
     */
    public function getIdChampkomanda2()
    {
        return $this->id_champkomanda2;
    }

    /**
     * @param mixed $id_champkomanda1
     */
    public function setIdChampkomanda1($id_champkomanda1)
    {
        $this->id_champkomanda1 = (int)$id_champkomanda1;
    }

    /**
     * @param mixed $id_champkomanda2
     */
    public function setIdChampkomanda2($id_champkomanda2)
    {
        $this->id_champkomanda2 = (int)$id_champkomanda2;
    }
    /**
     * @param mixed $id_championat
     */
    public function setIdChampionat($id_championat)
    {
        $this->id_championat = (int)$id_championat;
    }

    /**
     * @return mixed
     */
    public function getIdChampionat()
    {
        return $this->id_championat;
    }

    /**
     * @return string
     */
    public function getClassType()
    {
        return $this->class_type;
    }
    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }
    /**
     * @return mixed
     */
    public function getDateSort()
    {
        return $this->date_sort;
    }

    /**
     * @param mixed $date_sort
     */
    public function setDateSort($date_sort)
    {
        $this->date_sort = $date_sort;
    }

    /**
     * @return mixed
     */
    public function getMatchnazva()
    {
        return $this->matchnazva;
    }

    /**
     * @param mixed $ssilka
     */
    public function setSsilka($ssilka)
    {
        $this->ssilka = $ssilka;
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
    public function getShowing()
    {
        return $this->showing;
    }
    /**
     * @return mixed
     */
    public function getTextEmail()
    {
        return $this->text_email;
    }

    /**
     * @param mixed $text_email
     */
    public function setTextEmail($text_email)
    {
        $this->text_email = $text_email;
    }
    /**
     * @return mixed
     */
    public function getDatePublic()
    {
        return $this->date_public;
    }

    /**
     * @param mixed $date_public
     */
    public function setDatePublic($date_public)
    {
        $this->date_public = $date_public;
    }
    /**
     * @return mixed
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param mixed $views
     */
    public function setViews($views)
    {
        $this->views = (int)$views;
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
    public function getTime()
    {
        return $this->time;
    }
    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }
    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
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
    public function getDate()
    {
        return $this->date;
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
    public function getKoeficient()
    {
        return $this->koeficient;
    }

    /**
     * @return mixed
     */
    public function getProshel()
    {
        return $this->proshel;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @param mixed $koeficient
     */
    public function setKoeficient($koeficient)
    {
        $this->koeficient = $koeficient;
    }

    /**
     * @param mixed $nazva
     */
    public function setNazva($nazva)
    {
        $this->nazva = $nazva;
    }

    /**
     * @param mixed $proshel
     */
    public function setProshel($proshel)
    {
        $this->proshel = $proshel;
    }




}