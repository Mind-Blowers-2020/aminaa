<?php


namespace FrontBundle\Controller;


use Composer\DependencyResolver\Request;

use gestioneventBundle\Entity\eventcours;
use gestioneventBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class eventController extends Controller
{
public function ajoutereventencoursaction(\Symfony\Component\HttpFoundation\Request $request)
{
    $eventencours= new eventcours();
    $form =$this->createFormBuilder($eventencours)
        ->add('nomEvent')
        ->add('adresse')
        ->add('type')
        ->add('prix')
        ->add('nbPlaces')
        ->add('description')
        ->add('dateDebut')
        ->add('image',FileType::class, array('data_class'=>null, 'required'=>false))
        ->add('dateFin')

        ->getForm();
    $form->handleRequest($request);
    if ($form->isValid())
    {
        $em=$this->getDoctrine()->getManager();
        /** @var UploadedFile $file */
        $file = $eventencours->getImage();
        $filename= md5(uniqid()) . '.' . $file->guessExtension();
        $file->move($this->getParameter('photos_directory'), $filename);
        $eventencours->setImage($filename);
        $em->persist($eventencours);
        $em->flush();
        return $this->redirectToRoute('evenements');
    }
    return $this->render('@Front/Default/ajoutevent.html.twig',array('form'=>$form->createView()));
}
    public function affichereventfrontAction()
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('gestioneventBundle:Evenement')->findAll();

        //$modele=$em->getRepository(Modele::class)->findAll();


        return $this->render('@Front/Default/evenements.html.twig', array("evenement" => $evenement));
    }

    public function DetailsAction(\Symfony\Component\HttpFoundation\Request $request,$id)
    {
        $em= $this->getDoctrine()->getManager();
        $event=$em->getRepository('gestioneventBundle:Evenement')->find($id);
        return $this->render('@Front/Default/detailevent.html.twig', array(
            'id'=>$event->getId(),
            'image'=>$event->getImage(),
            'nomEvent'=>$event->getNomEvent(),
            'description'=>$event->getDescription(),
            'prix'=>$event->getPrix(),
            'adresse'=>$event->getPrix()
        ));
    }



}