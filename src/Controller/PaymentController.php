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
   public function index(Request $request, Campaign $campaign): Response
    {
        $amount = $request->request->get('amount');
     
        return $this->render('campaign/payment.html.twig', [
            'controller_name' => 'PaymentController',
            'campaign' => $campaign,
            'amount' => $amount,
            ]);
    }   

     /**
     * @Route("/payment_send/{id}", name="payment_send")
     */
   public function newPayment(Request $request, Campaign $campaign): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $participant = new Participant();
        

        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $participant->setName($name)
                    ->setEmail($email)
                    ->setCampaign($campaign);
        $entityManager->persist($participant);
        $entityManager->flush();  
        
        $payments = new Payment();
        $amount = $request->request->get('amount');
      

        if($amount > 0)
        {
        $payments->setAmount($amount)
                ->setParticipant($participant)
                ->setCreatedAt(new \DateTime());
        $entityManager->persist($payments);
        $entityManager->flush();  
        }
        else{
            dd($amount);
        }
            
        return $this->redirectToRoute('campaign_index');;
    } 

   
}