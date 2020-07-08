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
        $anonymat = $request->request->get('anonymat');
        if($anonymat === "on")
        {
            $participant->setCampaign($campaign);
            $entityManager->persist($participant);
            $entityManager->flush();  
        }
        else{
            $participant->setName($name)
            ->setEmail($email)
            ->setCampaign($campaign);
            $entityManager->persist($participant);
            $entityManager->flush();  
            
        }
        
        $payments = new Payment();
        $amount = $request->request->get('amount');
        $email = $request->request->get('email');
        $name = $request->request->get('name');
        
        if($amount > 0)
        {
            $payments->setAmount($amount)
            ->setParticipant($participant)
            ->setCreatedAt(new \DateTime());
                        try {
                            \Stripe\Stripe::setApiKey('sk_test_51H2XPXKI1XZO9WyCwjTG82KvDP2e9dq6FiW0Y09O6CzacMWf6q5BdgvzlwPEWWtdGVbmjAkzlvtiWh7CycAMSMit00PLLf9q3B');
                
                        // Token is created using Stripe Checkout or Elements!
                        // Get the payment token ID submitted by the form:

                          
                            \Stripe\PaymentIntent::create([
                            'amount' => $payments->getAmount(),
                            'currency' => 'eur',
                            'source' => $request->request->get('stripeToken'),
                            dd('payement réussi !')
                        ]);
                        } 
                        catch(\Exception $e){
                            dd('erreur payment',$e,$e->getMessage());
                        }
        $entityManager->persist($payments);
        $entityManager->flush();  
        return $this->redirectToRoute('campaign_index');
        }
        else{
        
            echo "<script>alert(\"Vous devez entrer un montant supérieur à 0\")</script>";
            return $this->render('campaign/payment.html.twig', [
                'controller_name' => 'PaymentController',
                'campaign' => $campaign,
                'amount' => $amount,
                'email' => $email,
                'name' => $name,
                ]);
        /*     echo '<INPUT type="button" value="back" onClick="window.history.back()">'; */

                    // Set your secret key. Remember to switch to your live secret key in production!
            // See your keys here: https://dashboard.stripe.com/account/apikeys
            

           
        }
            
    } 

   
}