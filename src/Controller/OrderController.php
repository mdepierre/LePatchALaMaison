<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande", name="order")
     */
    public function index(Cart $cart): Response
    {
        if (!$this->getUser()->getAddresses()->getValues()) {
            return $this->redirectToRoute('account_address_add');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getCartDetails()
        ]);
    }

    /**
     * @Route("/commande/recapitulatif-de-commande", name="order_summary", methods={"POST"})
     */
    public function add(Request $request, Cart $cart): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $date = new \DateTime();
            $delivery = $form->get('addresses')->getData();

            $order_delivery = $delivery->getFirstname() . ' ' . $delivery->getLastname();
            if ($delivery->getCompany()) {
                $order_delivery .= ', ' . $delivery->getCompany();
            }
            $order_delivery .= ', ' . $delivery->getAddress() . ' ' . $delivery->getPostalCode() . ' ' . $delivery->getCity() . ' ' . $delivery->getCountry();
            $order_delivery .= ', ' . $delivery->getPhoneNumber();

            $order = new Order();
            $order->setUser($this->getUser()); 
            $order->setCreationDate($date);
            $order->setDeliveryAddress($order_delivery);
            $order->setPaid(0);

            $this->entityManager->persist($order);

            foreach ($cart->getCartDetails() as $product) {
                $orderDetails = new OrderDetails();
                $orderDetails->setOrderIdentifier($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);

                $this->entityManager->persist($orderDetails);
            }
            
            $this->entityManager->flush();            
            
            return $this->render('order/add.html.twig', [
                'cart' => $cart->getCartDetails(),
                'deliveryaddress' => $order_delivery,
                'orderid' => $order->getId()
            ]);
        }

        return $this->redirectToRoute('cart');
    }
}