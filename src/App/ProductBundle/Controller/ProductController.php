<?php

namespace App\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\ProductBundle\Form\ProductType;
use App\ProductBundle\Form\ContactFormType;

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
    		$this->get('session')->getFlashBag()
    		->add('notice', 'Produkt został pomyślnie dodany');
    		return $this->redirect($this->generateUrl('product_list'));
    	}
    	
        return $this->render('AppProductBundle:Product:new.html.twig', array(
                 'form' => $form->createView()
            ));    }

    public function deleteAction($id)
    {
        $product = $this->getDoctrine()
    		->getRepository('AppProductBundle:Product')
    		->find($id);
    	
    	if (!$product) {
    		$this->get('session')->getFlashBag()
    		->add('notice', 'Brak produktu');
    	    return $this->redirect($this->generateUrl('product_list'));
    	    
    	}
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->remove($product);
    	$em->flush();
    	
    	$this->get('session')->getFlashBag()
    		->add('notice', 'Product został pomyślnie usunięty');
    		
        return $this->redirect($this->generateUrl('product_list'));
    }

    public function editAction($id)
    {
    	$request = $this->getRequest();
    	
    	$product = $this->getDoctrine()
    	->getRepository('AppProductBundle:Product')
    	->find($id);
    	 
    	if (!$product) {
    		$this->get('session')->getFlashBag()
    		->add('notice', 'Brak produktu');
    		return $this->redirect($this->generateUrl('product_list'));
    			
    	}
    	$form =$this->createForm(new ProductType(), $product, []);
    	$form->handleRequest($request);
    	
    	if($form->isValid()) {
    		$product = $form->getData();
    		$em = $this->getDoctrine()->getManager();
    		$em->flush();
    		$this->get('session')->getFlashBag()->add('notice', "Produkt zostal pomyslnie zmieniony");
    		
    		return $this->redirect($this->generateUrl('product_list'));
    	}
    	
    	
        return $this->render('AppProductBundle:Product:edit.html.twig', array(
               'form' => $form->createView()
            ));
        }
    public function showProductInCategoryAction($id)
    {
        $products = $this->getDoctrine()
                ->getRepository('AppProductBundle:Product')
                ->findBy([
                    'category' => $id,
                ]);
        
        return $this->render('AppProductBundle:Main:product_list.html.twig', array(
                'products' => $products,        		
        	));  
    }
    
    public function contactAction()
    {
        $request = $this->getRequest();
        
        $form = $this->createForm(new ContactFormType());
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            
            // name - $data['name']
            
            $message = \Swift_Message::newInstance()
                    ->setSubject('Wiadomość z serwisu sfShop')
                    ->setFrom($data['email'])
                    ->setTo('n1kula@wp.pl')
                    ->setBody(
                            $this->renderView('AppProductBundle:Default:email.html.twig', [
                                'name' => $data['name'],
                                'message' => $data['message'],
                            ]), 'text/html');
            
            if ($this->get('mailer')->send($message)) {
                $this->get('session')->getFlashBag()->add('success', 'Wiadomość została wysłana');
            } else {
                $this->get('session')->getFlashBag()->add('error', 'Błąd wysyłki');
            }
            
            return $this->redirect($this->generateUrl('contact'));            
        }
        
        return $this->render('AppProductBundle:Default:contact.html.twig', [
           'form' => $form->createView(), 
        ]);
    }

  }
