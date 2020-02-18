<?php


namespace EventBundle\Controller;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;

use EventBundle\Form\ModeleForm;
use gestioneventBundle\Entity\Evenement;
use gestioneventBundle\Entity\eventcours;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class evenementController extends Controller
{
public function affichereventAction()
{
    $em = $this->getDoctrine()->getManager();
    $evenement = $em->getRepository('gestioneventBundle:Evenement')->findAll();
    $evenementcours = $em->getRepository('gestioneventBundle:eventcours')->findAll();
    //$modele=$em->getRepository(Modele::class)->findAll();


    return $this->render('@Event/Default/evenement.html.twig', array("evenement" => $evenement,"evenementcours"=>$evenementcours));
}


    public function supprimereventencoursAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $eventcours =$em->getRepository('gestioneventBundle:eventcours')->find($id);
        $em->remove($eventcours);
        $em->flush();
        return $this->redirectToRoute('evenement');
    }

    public  function  modifierAction(Request $request ,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository('gestioneventBundle:eventcours')->find($id);
        $form =$this->createFormBuilder($event)
            ->add('nomEvent')
            ->add('adresse')
            ->add('type')
            ->add('prix')
            ->add('nbPlaces')
            ->add('description')
            ->add('dateDebut')
            ->add('image',FileType::class, array('data_class'=>null, 'required'=>false))
            ->add('dateFin')
            ->add('modifier',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('evenement');
        }

        return $this->render('@Event/Default/updatevent.html.twig',array('form'=>$form->createView()));

    }


    public function confirmerAction(Request $request ,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository('gestioneventBundle:eventcours')->find($id);
  $Eventr=new Evenement();
  $Eventr->setAdresse($event->getAdresse());
  $Eventr->setDateDebut($event->getDateDebut());
  $Eventr->setDateFin($event->getDateFin());
  $Eventr->setDescription($event->getDescription());
      $Eventr->setImage($event->getImage());
      $Eventr->setNbPlaces($event->getNbPlaces());
      $Eventr->setNomEvent($event->getNomEvent());
      $Eventr->setPrix($event->getPrix());
      $Eventr->setType($event->getType());



            $em=$this->getDoctrine()->getManager();
            $em->persist($Eventr);
            $em->remove($event);
            $em->flush();
            return $this->redirectToRoute('evenement');

    }

    public function rechercheEvenementAction(Request $request)
    {
        $event=$request->get('evenm');

        $events=$this->getDoctrine()->getManager()->createQuery("select e from gestioneventBundle:Evenement e where e.nomEvent like '%".$event."%' or e.adresse like '%".$event."%' or e.type like '%".$event."%' or e.prix like '%".$event."%' or e.nbPlaces like '%".$event."%' or e.description like '%".$event."%'or e.dateDebut like '%".$event."%' or e.dateFin like '%".$event."%' or e.image like '%".$event."%' ")
        ->getResult();

        //die("aa");
        $jsonData=array();
        $idx=0;
        foreach ($events as $liv) {
            $temp=array(
                'id'=>$liv->getId(),
                'nomEvent'=>$liv->getNomEvent(),
                'adresse'=>$liv->getAdresse(),
                'type'=>$liv->getType(),
                'prix'=>$liv->getPrix(),
                'nbPlaces'=>$liv->getNbPlaces(),
                'description'=>$liv->getDescription(),
                'dateDebut'=>$liv->getDateDebut(),
                'image'=>$liv->getImage(),
                'dateFin'=>$liv->getDateFin(),

            );
            $jsonData[$idx++]=$temp;

        }

        return new JsonResponse($jsonData);

        //return
    }



    public function statAction(){
        $pieChart = new PieChart();
        $em= $this->getDoctrine()->getManager();
            $query = $em->createQuery('SELECT p  ,UPPER(e.nomEvent) as nom ,COUNT(p.id) as num FROM gestioneventBundle:participant p 
join gestioneventBundle:Evenement e with e.id=p.evenement GROUP BY p.evenement');
        $reservations=$query->getScalarResult();
        $data= array();
        $stat=['evenement', 'id'];
        $i=0;
        array_push($data,$stat);

        $ln= count($reservations);
        for ($i=0 ;$i<count($reservations);$i++){
            $stat=array();
            array_push($stat,$reservations[$i]['nom'],$reservations[$i]['num']/$ln);
            $stat=[$reservations[$i]['nom'],$reservations[$i]['num']*100/$ln];

            array_push($data,$stat);
        }
        $pieChart->getData()->setArrayToDataTable( $data );
        $pieChart->getOptions()->setTitle('Pourcentages des participants par evenement');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        return $this->render('@Event\Default\chartEvent.html.twig', array('piechart' => $pieChart));
    }

}