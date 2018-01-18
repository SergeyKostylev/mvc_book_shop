<?php

namespace Model\Repository;
use Model\Entity\Book;
use Model\Entity\Category;

class BookRepository
{
    protected $pdo;

    public function setPdo(\PDO $pdo)
    {

        $this->pdo = $pdo;
    }

    public function getParamsStr(array $ids)
    {
        if (!$ids) {
            return array();
        }
        $params = array();

        foreach ($ids as $v) {
            $params[] = '?';
        }
        $params = implode(',', $params);
        return $params;
    }

    public function findIdInCart(array $ids)
    {
        $collection=[];
        $params = $this->getParamsSTR($ids);

        if (!$params){return [];}



        $sth = $this->pdo->prepare(
            "SELECT  b.id as book_id, b.title, 
                    b.description,b.price,b.category_id,b.is_active,c.id as id_category, 
                    c.name FROM
                    book b
                    JOIN  category c
                    ON b.category_id =c.id WHERE b.id IN ({$params}) ORDER BY b.price DESC"
        );
        $sth->execute($ids);

        while ($res = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $book = (new Book())
                ->setId($res['book_id'])
                ->setTitle($res['title'])
                ->setDescription($res['description'])
                ->setPrice($res['price'])
                ->setIsActive($res['is_active'])
                ->setCategory((new Category())
                    ->setId($res['id_category'])
                    ->setName($res['name']))
            ;
            $collection[]=$book;
        }

        return $collection;

    }

    public function getSumPriceCart(array $ids)
    {

        $params = $this->getParamsSTR($ids);
        if (!$params){return ['sum_price'=>'0'];}

        $summ_price = $this->pdo->prepare("Select sum(price) AS sum_price from book WHERE id IN ({$params})");
        $summ_price->execute($ids);
        $summ_price = $summ_price->fetch(\PDO::FETCH_ASSOC);

        return $summ_price;

    }


    public function findAllBooks()
    {
        $collection=[];

        $sth = $this->pdo->query('SELECT  b.id as book_id, b.title, 
                                  b.description,b.price,b.category_id,b.is_active,c.id as id_category, 
                                  c.name FROM  book b
                                  JOIN  category c
                                  ON b.category_id =c.id;');
        while ($res = $sth->fetch(\PDO::FETCH_ASSOC)){
            $book =(new Book())
                ->setId($res['book_id'])
                ->setTitle($res['title'])
                ->setDescription($res['description'])
                ->setPrice($res['price'])
                ->setIsActive($res['is_active'])
                ->setCategory((new Category())
                                            ->setId($res['id_category'])
                                            ->setName($res['name']))
                ;
            $collection[]=$book;
        }
        return $collection;
    }

    public  function find($id)
    {
//        $collection=[];
        $sth = $this->pdo->prepare('SELECT * FROM book WHERE id= :id');
        $sth->execute(['id' => $id]);
        $res = $sth->fetch(\PDO::FETCH_ASSOC);

        if (!$res)
            return null;
        return (new Book())
                ->setId($res['id'])
                ->setTitle($res['title'])
                ->setDescription($res['description'])
                ->setPrice($res['price'])
                ->setIsActive($res['is_active'])
                ->setCategory($res['category_id'])
            ;

    }
    public function delete($id)
    {

        $book= $this->find($id);

        if(!$book){
            return null;
        }
        $sth = $this->pdo->prepare('DELETE FROM `book` WHERE `book`.`id` = :id');
        $sth->execute(['id' => $id]);
        return true;
    }
    public function add($title,$description,$price,$category,$is_active)
    {


        $sth = $this->pdo->prepare('INSERT INTO `book` (`id`, `title`, 
                                    `description`, `price`,
                                     `category_id`, 
                                     `is_active`) 
                                     VALUES 
                                     (NULL, :title, :description, :price, :category, :is_active);');
        $sth->execute([
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'category' => $category,
            'is_active' => $is_active
        ]);


    }
    public function edit(Book $book)
    {
        $sth = $this->pdo->prepare('UPDATE book 
                                    SET title = :title,
                                        description = :description,
                                        price = :price,
                                        category_id = :category_id,
                                        is_active = :is_active
                                    WHERE book.id = :id;');
         $sth->execute([
            'title' => $book->getTitle(),
            'description' => $book->getDescription(),
            'price' => $book->getPrice(),
            'category_id' => $book->getCategory(),
            'is_active' => $book->getIsActive(),
            'id' => $book->getId()
        ]);







    }

}