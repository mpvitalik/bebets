<?php



class Express{
    private $id;
    private $nazva;
    private $description;
    private $img;
    private $text;
    private $text_email;
    private $show;
    private $textpopup;

    public function setRowClass($row){
        $this->id = (int)$row['id'];
        $this->nazva = $row['nazva'];
        $this->description = $row['description'];
        $this->img = $row['img'];
        $this->text = $row['text'];
        $this->text_email = $row['text_email'];
        $this->show = $row['show'];
        $this->textpopup = $row['textpopup'];
    }

    /**
     * @return mixed
     */
    public function getTextpopup()
    {
        return $this->textpopup;
    }

    /**
     * @param mixed $textpopup
     */
    public function setTextpopup($textpopup)
    {
        $this->textpopup = $textpopup;
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
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
    public function getNazva()
    {
        return $this->nazva;
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
    public function getShow()
    {
        return $this->show;
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
     * @param mixed $show
     */
    public function setShow($show)
    {
        $this->show = $show;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }
}