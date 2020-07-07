<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Participant;
use App\Entity\Payment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $campaigns = $this->getDoctrine()
        ->getRepository(Campaign::class)
        ->findAll();
    

        $participants = $this->getDoctrine()
        ->getRepository(Participant::class)
        ->findBy(["campaign"=>$campaigns]);
        
   foreach($campaigns as $campaign){
        $participantCount=count($participants);
     /*    dd($participantCount);       
   */}
        $payments = $this->getDoctrine()
        ->getRepository(Payment::class)
        ->findAll();
      
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'campaigns' => $campaigns,
            'payments' => $payments,
            'participantCount'=>$participantCount
        ]);
      
    }

}
