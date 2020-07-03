<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Payment;
use App\Entity\Participant;
use Doctrine\DBAL\Driver\SQLSrv\LastInsertId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class PaymentController extends AbstractController
{
    /**
     * @Route("/payment/{id}", name="payment")
     */
   public function index(Campaign $campaign): Response
    {
        return $this->render('campaign/payment.html.twig', [
            'controller_name' => 'PaymentController',
            'campaign' => $campaign,
            ]);
    }   

     /**
     * @Route("/payment_send/{id}", name="payment_send")
     */
   public function newPayment(Request $request, Campaign $campaign): Response
    {
        $participant = new Participant();
        $amount = $request->request->get('amount');
        $entityManager = $this->getDoctrine()->getManager();


        $name = $request->request->get('name');
        $email = $request->request->get('email');
        
        $participant->setName($name)
                    ->setEmail($email)
                    ->setCampaign($campaign);
        $entityManager->persist($participant);
        $entityManager->flush();  
        
        $payments = new Payment();
        $amount = $request->request->get('amount');
        $payments->setAmount($amount)
                ->setParticipant($participant)
                ->setCreatedAt(new \DateTime());
        $entityManager->persist($payments);
        $entityManager->flush();  
            
        return $this->redirectToRoute('campaign_index');;
    } 
}

/**
     * @Route("/payment", name="payment")
     */
/* 
 public function index()
    {
        $participants = $this->getDoctrine()
            ->getRepository(Participant::class)
            ->findAll();
        $payments = $this->getDoctrine()
            ->getRepository(Payment::class)
            ->findAll();
        $campaigns = $this->getDoctrine()
            ->getRepository(Campaign::class)
            ->findAll();    
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
            'participants' => $participants,
            'payments' => $payments,
        ]); */

/*     public function new(Request $request): Response
    {
        $payments = new Payment();
       if(null!==('SubmitPayment')){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($payments);
            $entityManager->flush();
       }

            return $this->redirectToRoute('payment/index.html.twig');
        } */
