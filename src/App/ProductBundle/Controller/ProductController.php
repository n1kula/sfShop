<?php

namespace App\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\ProductBundle\Form\ProductType;

class ProductController extends Controller
{ 
     public function indexAction()
    {
        $products = $this->getDoctrine()
            ->getRepository('AppProductBundle:Product')
            ->findAll();
        
         return $this->render('AppProductBundle:Product:index.html.twig', array(
                 'products' => $products
            ));    
    }

    public function newAction()
    {
      	$request = $this->getRequest();
    	
    	$form = $this->createForm(new ProductType(),null, []);
    	
    	$form->handleRequest($request);
    	
    	if ($form->isValid()) {
    		$product = $form->getData();
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($product);
    		$em->flush();
    		
    		return $this->redirect($this->generateUrl('product_list'));
    	}
    	
        return $this->render('AppProductBundle:Product:new.html.twig', array(
                 'form' => $form->createView()
            ));    }

    public function deleteAction()
    {
        return $this->render('AppProductBundle:Product:delete.html.twig', array(
                // ...
            ));    }

    public function editAction()
    {
        return $this->render('AppProductBundle:Product:edit.html.twig', array(
                // ...
            ));    }

}
