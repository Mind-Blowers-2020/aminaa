<?php

namespace EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Event/Default/index.html.twig');
    }
    public function clientAction()
    {
        return $this->render('@Event/Default/client.html.twig');
    }
    public function blogAction()
    {
        return $this->render('@Event/Default/blog.html.twig');
    }
    public function produitsAction()
    {
        return $this->render('@Event/Default/produits.html.twig');
    }
    public function commandesAction()
    {
        return $this->render('@Event/Default/commandes.html.twig');
    }
    public function livraisonsAction()
    {
        return $this->render('@Event/Default/livraisons.html.twig');
    }

    public function livreursAction()
    {
        return $this->render('@Event/Default/livreurs.html.twig');
    }
    public function evenementAction()
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('gestioneventBundle:Evenement')->findAll();
        //$modele=$em->getRepository(Modele::class)->findAll();


        return $this->render('@Event/Default/evenement.html.twig', array("evenement" => $evenement));
    }
    public function guidesAction()
    {
        return $this->render('@Event/Default/guides.html.twig');
    }
    public function participantsAction()
    {
        return $this->render('@Event/Default/participants.html.twig');
    }
}
