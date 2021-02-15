<?php

namespace App\Classes;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

class Cart {

  private $session;
  private $entityManager;

  public function __construct(SessionInterface $session, EntityManagerInterface $entityManager) {
    $this->session = $session;
    $this->entityManager = $entityManager;    
  }

  public function add($id) {

    $cart = $this->session->get('cart', []);

    if (!empty($cart[$id])) {
      $cart[$id]++;
    }
    else {
      $cart[$id] = 1;
    }

    $this->session->set('cart', $cart);
  }

  public function get() {
    return $this->session->get('cart');
  }

  public function remove() {
    return $this->session->remove('cart');
  }
  public function delete($id) {

    $cart = $this->session->get('cart', []);

    unset($cart[$id]);

    return $this->session->set('cart', $cart);
  }

  public function decrease($id) {

    $cart = $this->session->get('cart', []);

    if ($cart[$id] > 1){
      $cart[$id]--;
    }
    else {
      unset($cart[$id]);
    }
    return $this->session->set('cart', $cart);
  }

  public function getCartDetails() {
    
    $cartInfoComplete = [];       

        if ($this->get()){

        foreach ($this->get() as $id => $quantity) {

            $product_object = $this->entityManager->getRepository(Product::class)->findOneBy((['id' => $id]));

            if (!$product_object) {
                $this->delete($id);
                continue;
            }

            $cartInfoComplete[] = [
                'product' => $product_object,
                'quantity' => $quantity
            ];
        }
  }
  return $cartInfoComplete;
  }
}