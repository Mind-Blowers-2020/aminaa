<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Front/Default/index.html.twig');
    }

    public function accueilAction()
    {
        return $this->render('@Front/Default/index.html.twig');
    }

    public function proposAction()
    {
        return $this->render('@Front/Default/propos.html.twig');
    }

    public function evenementsAction()
    {
        return $this->render('@Front/Default/evenements.html.twig');
    }

    public function produitAction()
    {
        return $this->render('@Front/Default/produit.html.twig');
    }

    public function wishlistAction()
    {
        return $this->render('@Front/Default/wishlist.html.twig');
    }

    public function promotionAction()
    {
        return $this->render('@Front/Default/promotion.html.twig');
    }


    public function PanierAction()
    {
        return $this->render('@Front/Default/Panier.html.twig');
    }

    public function CheckoutAction()
    {
        return $this->render('@Front/Default/Checkout.html.twig');
    }

    public function blogsAction()
    {
        return $this->render('@Front/Default/blogs.html.twig');
    }


    public function documentationAction()
    {
        return $this->render('@Front/Default/documentation.html.twig');
    }

    public function contactAction()
    {
        return $this->render('@Front/Default/contact.html.twig');
    }


    public function ppanierAction()
    {
        return $this->render('@Front/Default/ppanier.html.twig');
    }
}
