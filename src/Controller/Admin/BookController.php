<?php

namespace Controller\Admin;

use Framework\BaseController;
use Framework\Request;
use Framework\RepositoryFactory;
use Framework\Session;
use Model\Entity\Book;
use Model\Form\AddBookForm;
use Model\Form\EditBookForm;
use Model\Repository\BookRepository;

class BookController extends BaseController
{


    public function indexAction(Request $request)
    {
//        $books= $this->getRepository('book')->findAllBooks();
        $books= $this->conteiner->get('repositoryFactory')->createRepository('book')->findAllBooks();
        return $this->render('index.html.twig',
                            ['books' => $books]
                            );
    }

    public function showAction(Request $request)
    {
        $id = $request->get('id');
        $book =$this->getRepository('book')->find($id);
        if (!$book) {
            throw new \Exception('Book not foud');
        }


        return $this->render('show.html.twig',['book'=>$book]);
    }
    public function deleteAction(Request $request)
    {
        $id = $request->get('id');

        $rez = $this->getRepository('book')->delete($id);
            if (!$rez){
                Session::setFlash('Book not delete');
            }else

        $books = $this->getRepository('book')->findAllBooks();
        return $this->render('index.html.twig',
            ['books' => $books
            ]);
    }
    public function addAction(Request $request)
    {
            $form = new AddBookForm(
                $request->post('title'),
                $request->post('description'),
                $request->post('price'),
                $request->post('category'),
                $request->post('is_active')
            );

            if($request->isPost()){
                if($form->isValid()){

                    $book = $this->getRepository('book')->add(
                        $form->getTitle(),
                        $form->getDescription(),
                        $form->getPrice(),
                        $form->getCategory(),
                        $form->getIsActive()

                    );

                }

            }
        $categories= $this->getRepository('category')->findAllCategories();


        return $this->render('add.html.twig',
                ['categories' => $categories,
                ]);
    }


    public function editAction(Request $request)
    {
        $id=$request->get('id');
        $book =$this->getRepository('book')->find($id);
        if (!$book) {
            throw new \Exception('Book not foud');
        }

        $categories= $this->getRepository('category')->findAllCategories();


        if($request->isPost()){
            $form = new EditBookForm(
                $request->post('title'),
                $request->post('description'),
                $request->post('price'),
                $request->post('category'),
                $request->post('is_active')
            );
            if($form->isValid()) {
                $book = (new Book())
                    ->setId($id)
                    ->setTitle($form->getTitle())
                    ->setDescription($form->getDescription())
                    ->setPrice($form->getPrice())
                    ->setCategory($form->getCategory())
                    ->setIsActive($form->getIsActive());


                $book = $this->getRepository('book')->edit($book);
                return $this->getRouter()->redirect('admin_books_list');

            }

        }

        return $this->render('edit.html.twig', [
                                                    'book' => $book,
                                                    'categories' => $categories
                                                    ]
                                                    );

dump($categories);
    }

}