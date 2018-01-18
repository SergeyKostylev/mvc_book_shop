<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 15.12.2017
 * Time: 16:28
 */

namespace Model\Repository;


use Model\Entity\FeedBack;

class FeedbackRepository
{
    /**
     *  @var \PDO
     */
    protected $pdo;

    public function setPdo(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save (FeedBack $feedBack)
    {
        $email= $feedBack->getEmail();
        $message =$feedBack->getMessage();
        $phone = $feedBack->getPhone();
        $ip_addres = $feedBack->getIp_address();

        $sth = $this->pdo->prepare('INSERT INTO feedback(email, phone, message,ip_address) VALUES (:email, :phone, :message, :ip_addres)');
        $sth->execute(['email' => $email,
                    'phone' => $phone,
                    'message' => $message,
                    'ip_addres' => $ip_addres]);

    }
}