<?php

namespace App\LayoutBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AppLayoutBundle:Default:index.html.twig', array('name' => $name));
    }
}
