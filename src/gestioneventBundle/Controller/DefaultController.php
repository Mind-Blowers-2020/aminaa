<?php

namespace gestioneventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('gestioneventBundle:Default:index.html.twig');
    }
}
