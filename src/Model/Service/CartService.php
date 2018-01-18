<?php

namespace Model\Service;

use Framework\Cookie;

class CartService
{
    const COOKIE_CART_NAME = 'cart';

    public function addItem($id)
    {
        $cart = $this->getCartItems();
        $cart[] = $id;

        // kostyl - remove pls
        $cart = array_unique($cart);

        $this->save($cart);
    }

    public function getCartItems()
    {
        $cart = Cookie::get(self::COOKIE_CART_NAME);

        if (!$cart) {
            return [];
        }

        // todo: check if we can unserialize

        return unserialize($cart);
    }

    private function save(array $cart)
    {

        $cart = serialize($cart);

        Cookie::set(self::COOKIE_CART_NAME, $cart);
    }

    public function removeItem($id)
    {
        $cart = $this->getCartItems();
        if (!$cart){
           return [];
        }
        foreach($cart as $key=>$item)
        {
            if($item == $id)
            {unset($cart[$key]);}
        }
        $cart = array_values($cart);
        $this->save($cart);
    }

    public function clearCart()
    {
        Cookie::remove(self::COOKIE_CART_NAME);
    }


}