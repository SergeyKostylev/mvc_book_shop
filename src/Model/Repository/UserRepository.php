<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 15.12.2017
 * Time: 16:28
 */

namespace Model\Repository;


use Model\Entity\User;

class UserRepository
{
    /**
     *  @var \PDO
     */
    protected $pdo;

    public function setPdo(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByEmail ($email)
    {
        $sql='SELECT * FROM `user` WHERE email= :email limit 1';
        $sth = $this->pdo->prepare($sql);
        $sth->execute([
                'email'=>$email
        ]);
        $res=$sth->fetch(\PDO::FETCH_ASSOC);

        if (!$res){
            return null;
        }
        $user = (new User ($res['email']))
                ->setPassword($res['password'])
        ;
        return $user;
    }

    public function searchByEmail($email)
    {
        $sql = 'SELECT * FROM `user` WHERE email= :email';
        $sth = $this->pdo->prepare($sql);
        $sth->execute([
                'email' => $email
        ]);
        $res = $sth->fetch(\PDO::FETCH_ASSOC);

        return $res;
    }
    public function userAdd($email, $password)
    {
        $sql ='INSERT INTO `user` (email, password) VALUES (:email, :password)';
        $sth = $this->pdo->prepare($sql);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sth->execute([
            'email' => $email,
            'password' => $password
            ]);

    }


}