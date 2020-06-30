<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Payment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class PaymentController extends AbstractController
{
    /**
     * @Route("/payment", name="payment")
     */
    public function index()
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
    
     /**
     * @Route("/new", name="campaign_new", methods={"GET","POST"})
     */
/*     public function new(Request $request): Response
    {
        $campaign = new Campaign();
        $form = $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $campaign->setId(); //il faut définir l'id de la campagne !
            $em->persist($campaign);
            $em->flush();
        
              return $this->redirectToRoute('campaign_show', ['id' => $campaign->getId()]);
        }  */
}
