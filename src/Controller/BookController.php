<?php

namespace Controller;

use Framework\BaseController;
use Framework\Request;
use Framework\RepositoryFactory;
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
    public function pdfExportAction()
    {
        $this->conteiner->get('pdf_export')->export();

    }


}