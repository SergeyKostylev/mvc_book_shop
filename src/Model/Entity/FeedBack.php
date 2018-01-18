<?php


namespace Model\Entity;


class FeedBack
{
    private $id;
    private $email;
    private $phone;
    private $message;
    private $ip_address;


    public function __construct($email, $phone, $message)
    {
        $this->email = $email;
        $this->phone = $phone;
        $this->message = $message;
        $this->ip_address = $_SERVER['REMOTE_ADDR'];
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
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
    public function getIp_address()
    {
        return $this->ip_address;
    }


}