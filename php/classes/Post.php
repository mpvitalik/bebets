<?php


class Post{
    private $id;
    private $cat;
    private $nazva;
    private $ssilka;
    private $description;
    private $img;
    private $video;
    private $text;
    private $date;
    private $date_sort;
    private $tags;
    private $views;
    private $showing;
    private $class_type='post';

    public function setPost($row){
        $this->id = (int)$row['id'];
        $this->cat = $row['cat'];
        $this->nazva = $row['nazva'];
        $this->ssilka = $row['ssilka'];
        $this->description = $row['description'];
        $this->img = $row['img'];
        $this->video = $row['video'];
        $this->text = $row['text'];
        $this->date = $row['date'];
        $this->date_sort = $row['date'];
        $this->tags = $row['tags'];
        $this->views = $row['views'];
        $this->showing = $row['showing'];
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
    public function getSsilka()
    {
        return $this->ssilka;
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
    public function getShowing()
    {
        return $this->showing;
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
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getCat()
    {
        return $this->cat;
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
    public function getDescription()
    {
        return $this->description;
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
     * @return mixed
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param mixed $cat
     */
    public function setCat($cat)
    {
        $this->cat = $cat;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @param mixed $nazva
     */
    public function setNazva($nazva)
    {
        $this->nazva = $nazva;
    }

    /**
     * @param mixed $video
     */
    public function setVideo($video)
    {
        $this->video = $video;
    }
}