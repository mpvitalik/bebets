<?php



class Championat{
    private $id;
    private $nazva;
    private $description;
    private $text;
    private $text_prognozi_bottom;
    private $img;
    private $ssilka;
    private $href_tablica;
    private $href_matchi;
    private $full_tablica;
    private $full_matchi;
    private $little_matchi;
    private $date_sync_tablica;
    private $date_sync_matchi;
    private $sort;
    private $showing;
    private $views;
    private $title_seoturi;
    private $description_seoturi;
    private $h1_seoturi;

    public function setChampionat($row){
        $this->id = (int)$row['id'];
        $this->nazva = $row['nazva'];
        $this->description = $row['description'];
        $this->text = $row['text'];
        $this->text_prognozi_bottom = $row['text_prognozi_bottom'];
        $this->img = $row['img'];
        $this->ssilka = $row['ssilka'];
        $this->href_tablica = $row['href_tablica'];
        $this->href_matchi = $row['href_matchi'];
        $this->full_tablica = $row['full_tablica'];
        $this->full_matchi = $row['full_matchi'];
        $this->little_matchi = $row['little_matchi'];
        $this->date_sync_tablica = $row['date_sync_tablica'];
        $this->date_sync_matchi = $row['date_sync_matchi'];
        $this->sort = (int)$row['sort'];
        $this->showing = $row['showing'];
        $this->views = (int)$row['views'];
        $this->title_seoturi = $row['title_seoturi'];
        $this->description_seoturi = $row['description_seoturi'];
        $this->h1_seoturi = $row['h1_seoturi'];
    }

    /**
     * @return mixed
     */
    public function getDescriptionSeoturi()
    {
        return $this->description_seoturi;
    }

    /**
     * @return mixed
     */
    public function getH1Seoturi()
    {
        return $this->h1_seoturi;
    }

    /**
     * @return mixed
     */
    public function getTitleSeoturi()
    {
        return $this->title_seoturi;
    }

    /**
     * @param mixed $description_seoturi
     */
    public function setDescriptionSeoturi($description_seoturi)
    {
        $this->description_seoturi = $description_seoturi;
    }

    /**
     * @param mixed $h1_seoturi
     */
    public function setH1Seoturi($h1_seoturi)
    {
        $this->h1_seoturi = $h1_seoturi;
    }

    /**
     * @param mixed $title_seoturi
     */
    public function setTitleSeoturi($title_seoturi)
    {
        $this->title_seoturi = $title_seoturi;
    }

    /**
     * @return mixed
     */
    public function getDateSyncMatchi()
    {
        return $this->date_sync_matchi;
    }

    /**
     * @return mixed
     */
    public function getDateSyncTablica()
    {
        return $this->date_sync_tablica;
    }

    /**
     * @return mixed
     */
    public function getFullMatchi()
    {
        return $this->full_matchi;
    }

    /**
     * @return mixed
     */
    public function getFullTablica()
    {
        return $this->full_tablica;
    }

    /**
     * @return mixed
     */
    public function getLittleMatchi()
    {
        return $this->little_matchi;
    }

    /**
     * @param mixed $date_sync_matchi
     */
    public function setDateSyncMatchi($date_sync_matchi)
    {
        $this->date_sync_matchi = $date_sync_matchi;
    }

    /**
     * @param mixed $date_sync_tablica
     */
    public function setDateSyncTablica($date_sync_tablica)
    {
        $this->date_sync_tablica = $date_sync_tablica;
    }

    /**
     * @param mixed $full_matchi
     */
    public function setFullMatchi($full_matchi)
    {
        $this->full_matchi = $full_matchi;
    }

    /**
     * @param mixed $full_tablica
     */
    public function setFullTablica($full_tablica)
    {
        $this->full_tablica = $full_tablica;
    }

    /**
     * @param mixed $little_matchi
     */
    public function setLittleMatchi($little_matchi)
    {
        $this->little_matchi = $little_matchi;
    }

    /**
     * @return mixed
     */
    public function getTextPrognoziBottom()
    {
        return $this->text_prognozi_bottom;
    }

    /**
     * @param mixed $text_prognozi_bottom
     */
    public function setTextPrognoziBottom($text_prognozi_bottom)
    {
        $this->text_prognozi_bottom = $text_prognozi_bottom;
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
     * @param mixed $showing
     */
    public function setShowing($showing)
    {
        $this->showing = $showing;
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
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param mixed $sort
     */
    public function setSort($sort)
    {
        $this->sort = (int)$sort;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
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
    public function getHrefMatchi()
    {
        return $this->href_matchi;
    }

    /**
     * @return mixed
     */
    public function getHrefTablica()
    {
        return $this->href_tablica;
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
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


    /**
     * @param mixed $href_matchi
     */
    public function setHrefMatchi($href_matchi)
    {
        $this->href_matchi = $href_matchi;
    }

    /**
     * @param mixed $href_tablica
     */
    public function setHrefTablica($href_tablica)
    {
        $this->href_tablica = $href_tablica;
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