<?php


class Usersession{
    private $id;
    private $user_id;
    private $user_agent;
    private $user_session;

    public function setUsersessionClass($row){
        $this->id = (int)$row['id'];
        $this->user_id = (int)$row['user_id'];
        $this->user_agent = $row['user_agent'];
        $this->user_session = $row['user_session'];
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
    public function getUserAgent()
    {
        return $this->user_agent;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getUserSession()
    {
        return $this->user_session;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @param mixed $user_agent
     */
    public function setUserAgent($user_agent)
    {
        $this->user_agent = $user_agent;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = (int)$user_id;
    }

    /**
     * @param mixed $user_session
     */
    public function setUserSession($user_session)
    {
        $this->user_session = $user_session;
    }

}