<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/compte/mes-adresses", name="account_address")
     */

    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    /**
     * @Route("/compte/ajouter-une-adresse", name="account_address_add")
     */

    public function add(Cart $cart, Request $request): Response
    {
        $notification_success = null;

        $notification_error = null;

        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $address->setUser($this->getUser());

            $this->entityManager->persist($address);
            $this->entityManager->flush();

            if ($cart->get()) {
                return $this->redirectToRoute('order');
            }
            else {
                $notification_success = "L'adresse été ajoutée avec succès";
            }          
        }
        else if ($form->isSubmitted()) {
            $notification_error = "L'adresse saisie est invalide";
        }

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView(),
            'notification_success' => $notification_success,
            'notification_error' => $notification_error
        ]);
    }

    /**
     * @Route("/compte/modifier-une-adresse/{id}", name="account_address_edit")
     */
    
    public function edit(Request $request, $id): Response
    {
        $notification_success = null;

        $notification_error = null;

        $address = $this->entityManager->getRepository(Address::class)->findOneBy(['id' => $id]);

        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_address');
        }

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->flush();

            $notification_success = "L'adresse été modifiée avec succès";
        }
        else if ($form->isSubmitted()) {
            $notification_error = "L'adresse saisie est invalide";
        }

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView(),
            'notification_success' => $notification_success,
            'notification_error' => $notification_error
        ]);
    }

    /**
     * @Route("/compte/supprimer-une-adresse/{id}", name="account_address_delete")
     */
    
    public function delete($id): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneBy(['id' => $id]);

        if ($address && $address->getUser() == $this->getUser()) {
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('account_address');
    }

}