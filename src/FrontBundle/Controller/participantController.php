<?php


namespace FrontBundle\Controller;


use gestioneventBundle\Entity\Evenement;
use gestioneventBundle\Entity\eventcours;
use gestioneventBundle\Entity\participant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class participantController extends Controller
{
    public function ajouterParticipantAction(Request $request , $idevent)
    {
        $participant= new participant();
        $form =$this->createFormBuilder($participant)
            ->add('nom')
            ->add('prenom')
            ->add('confirmation')


            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid())
        {    $em=$this->getDoctrine()->getManager();
            $participant->setDateInscrit(new \DateTime());
           $participant->setEvenement($em->getRepository(Evenement::class)->find($idevent));
            $event=$em->getRepository('gestioneventBundle:Evenement')->find($idevent);

            $nb=$event->getNbPlaces();
            $nb=$nb-1;
           // dump($nb);
           // die("aa");
            $event->setNbPlaces($nb);
            $em->persist($participant);
            $em->flush();

            return $this->redirectToRoute('evenements');
        }
        return $this->render('@Front/Default/ajoutparticipant.html.twig',array('form'=>$form->createView()));
    }

}