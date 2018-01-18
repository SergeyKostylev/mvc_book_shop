<?php
namespace Model\Form;

class FeedbackForm
{
    public $email;
    public $message;
    public $phone;

    public function __construct($email, $phone, $message)
    {
        $this->email = $email;
        $this->message = $message;
        $this->phone = $phone;
    }

    public function isValid()
    {
        return !empty($this->email) && !empty($this->message)&& !empty($this->phone);
    }

}