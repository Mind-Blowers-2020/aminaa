<?php


namespace FrontBundle\Controller;


use Composer\DependencyResolver\Request;

use gestioneventBundle\Entity\eventcours;
use gestioneventBundle\Entity\Evenement;
use Swift_Mailer;
use Swift_SmtpTransport;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class eventController extends Controller
{

public function ajoutereventencoursaction(\Symfony\Component\HttpFoundation\Request $request,\Swift_Mailer $mailer=null)
{
    $transport = Swift_SmtpTransport::newInstance('smtp.googlemail.com',465, 'ssl')
        ->setUsername('wifek.ouerghemmi@esprit.tn')
        ->setPassword('esprit123.');






    $mailer = Swift_Mailer::newInstance($transport);


    $message = (new \Swift_Message('ajouter evenement'))
        ->setFrom('amina.mtiri@esprit.tn')
        ->setTo('amina.mtiri@esprit.tn')
        ->setBody(' bonjour mr votre evenement a été bien ajouté');
    $mailer->send($message);
$this->get('mailer')->send($message);


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
    public function affichereventfrontAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('gestioneventBundle:Evenement')->findAll();
        $active = $em->getRepository('gestioneventBundle:Evenement')->findAll();

        //$modele=$em->getRepository(Modele::class)->findAll();
        $evenement = $this->get('knp_paginator')->paginate($active, $request->query->get('page', 1), 4);

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