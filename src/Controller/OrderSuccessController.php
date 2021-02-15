<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande/succes/{checkout_id}", name="order_success")
     */
    public function index($checkout_id, Cart $cart): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneBy(['checkout_id' => $checkout_id]);

        if(!$order || $order->getUser() != $this->getUser() ){
            return $this->redirectToRoute('home');
        }

        if($order->getPaid() == 0) {

            $cart->remove();

            $order->setPaid(1);
            $this->entityManager->flush();            
        }

        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}
