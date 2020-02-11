<?php


namespace EventBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class guideController extends Controller
{
    public function afficherguideAction()
    {

        $em = $this->getDoctrine()->getManager();
        $guide = $em->getRepository('gestioneventBundle:guide')->findAll();

        //$modele=$em->getRepository(Modele::class)->findAll();


        return $this->render('@Event/Default/guides.html.twig', array("guide" => $guide));
    }


    public function supprimerguideAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $guides =$em->getRepository('gestioneventBundle:guide')->find($id);
        $em->remove($guides);
        $em->flush();
        return $this->redirectToRoute('guides');
    }

    public  function  modifierguideAction(Request $request ,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $guide=$em->getRepository('gestioneventBundle:guide')->find($id);
        $form =$this->createFormBuilder($guide)
            ->add('nom')
            ->add('prenom')
            ->add('mail')
            ->add('tel')
            ->add('eventType')
            ->add('modifier',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($guide);
            $em->flush();
            return $this->redirectToRoute('guides');
        }

        return $this->render('@Event/Default/updateguide.html.twig',array('form'=>$form->createView()));

    }
}