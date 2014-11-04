<?php

namespace App\CartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AppCartBundle:Default:index.html.twig', array('name' => $name));
    }
}
