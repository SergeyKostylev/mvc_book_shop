<?php

namespace Controller;

use Framework\BaseController;
use Framework\Request;
use Framework\Session;


class CartController extends BaseController
{
    public function getArrayIds()
    {
        return $this->conteiner->get('cart_service')->getCartItems();
    }
    public function indexAction()
    {
        $ids = $this->getArrayIds();
        $books = $this->conteiner->get('repositoryFactory')->createRepository('book')->findIdInCart($ids);
        $sum_price =$this->conteiner->get('repositoryFactory')->createRepository('book')->getSumPriceCart($ids)['sum_price'];
        return $this->render('index.html.twig',
            ['books' => $books
                ,
             'sum_price'=>$sum_price
            ]
        );

    }
    public function addAction(Request $request)
    {
        $id = $request->get('id');
        // add to cart
        $this->conteiner->get('cart_service')->addItem($id);
        $this->getRouter()->redirect('books_list');
    }


    public function removeItemAction(Request $request)
    {
        $id = $request->get('id');
        $this->conteiner->get('cart_service')->removeItem($id);
        $this->getRouter()->redirect('cart_list');

    }

    public function clearAction()
    {
        $this->conteiner->get('cart_service')->clearCart();
        $this->getRouter()->redirect('cart_list');
    }
}