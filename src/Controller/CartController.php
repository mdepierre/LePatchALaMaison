<?php

namespace App\Controller;

use App\Classes\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{  
    /**
     * @Route("/mon-panier", name="cart")
     */
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig',[
            'cart' => $cart->getCartDetails()
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="add_to_cart")
     */
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/remove ", name="remove_my_cart")
     */
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('products');
    }

    /**
     * @Route("/cart/delete/{id} ", name="delete_to_cart")
     */
    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/decrease/{id} ", name="decrease_to_cart")
     */
    public function decrease(Cart $cart, $id): Response
    {
        $cart->decrease($id);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/validation ", name="cart_validation")
     */
    public function validate(Cart $cart): Response
    {
        $final_cart = $cart->getCartDetails();
        
        foreach ($final_cart as $k => $v){                    
            if($final_cart[$k]['quantity'] > $final_cart[$k]['product']->getStock())
            {
                return $this->redirectToRoute('cart');
            }
        }
        return $this->redirectToRoute('order');
    }
}
