<?php



class Comment{
    private $id;
    private $user_id;
    private $post_id;
    private $text;
    private $datee;

    public function setComment($row){
        $this->id = intval($row['id']);
        $this->user_id = intval($row['user_id']);
        $this->post_id = intval($row['post_id']);
        $this->text = $row['text'];
        $this->datee = $row['datee'];
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = (int)$user_id;
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $datee
     */
    public function setDatee($datee)
    {
        $this->datee = $datee;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @param mixed $post_id
     */
    public function setPostId($post_id)
    {
        $this->post_id = (int)$post_id;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

}