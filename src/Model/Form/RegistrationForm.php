<?php
namespace Model\Form;

class RegistrationForm
{
    public $email;
    public $password;
    public $repeat_password;

    public function __construct($email = null, $password = null, $repeat_password = null)
    {

        $this->email = $email;
        $this->password = $password;
        $this->repeat_password = $repeat_password;
    }

    public function isValid()
    {
        return !empty($this->email)
                && !empty($this->password)
                && !empty($this->repeat_password);
    }
    public function samePasswords()
    {
        return ($this->password === $this->repeat_password);
    }

}