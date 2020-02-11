<?php


namespace EventBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class participantController extends Controller
{
    public function afficherparticipantAction()
    {
        $em = $this->getDoctrine()->getManager();
        $participant = $em->getRepository('gestioneventBundle:participant')->findAll();

        //$modele=$em->getRepository(Modele::class)->findAll();


        return $this->render('@Event/Default/participants.html.twig', array("participant" => $participant));
    }

    public function supprimerparticipantAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $participant =$em->getRepository('gestioneventBundle:participant')->find($id);
        $em->remove($participant);
        $em->flush();
        return $this->redirectToRoute('participants');
    }

    public  function  modifierparticipantAction(Request $request ,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $participant=$em->getRepository('gestioneventBundle:participant')->find($id);
        $form =$this->createFormBuilder($participant)
            ->add('confirmation')

            ->add('modifier',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($participant);
            $em->flush();
            return $this->redirectToRoute('participants');
        }

        return $this->render('@Event/Default/updateparticipants.html.twig',array('form'=>$form->createView()));

    }

}