<?php

namespace Model\Repository;
use Model\Entity\Book;
use Model\Entity\Category;

class CategoryRepository
{
    protected $pdo;

    public function setPdo(\PDO $pdo)
    {

        $this->pdo = $pdo;
    }

    public function findAllCategories()
    {
        $collection=[];
        $sth = $this->pdo->query('SELECT  * From category;');
        while ($res = $sth->fetch(\PDO::FETCH_ASSOC)){
            $category =(new Category())
                ->setId($res['id'])
                ->setName($res['name'])
                ;
            $collection[]=$category;
        }
        return $collection;
    }

}