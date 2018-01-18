<?php
namespace Model\Form;

class LoginForm
{
    public $email;
    public $password;

    public function __construct($email = null, $password = null)
    {

        $this->email = $email;
        $this->password = $password;
    }

    public function isValid()
    {
        return !empty($this->email) && !empty($this->password);
    }

}