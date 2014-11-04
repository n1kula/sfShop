<?php
namespace App\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\Common\Collections\ArrayCollection;

class CartController extends Controller
{
    
	
	public function indexAction()
    {
        $products = $this->getProducts();
                
        return $this->render('AppProductBundle:Main:index.html.twig', array(
                'products' => $products,        		
        	));   
    }
    public function addToCartAction($id)
    {
        $product = $this->getDoctrine()
            ->getRepository('AppProductBundle:Product')
            ->find($id);
    	
    	if (!$product) {
    	    throw $this->createNotFoundException('Produkt nie istnieje');
    	}
    	
    	$this->get('shop_cart')
    	   ->add($product);
    	//$cart->add($product, 1);
    	
    	return $this->redirect($this->generateUrl('cart'));
    }
    
    /**
     * @Template()
     */
    public function cartAction()
    {
    	$products = $this->get('shop_cart')
    	   ->getProducts();
    	
    	$products = $this->getDoctrine()
    	   ->getRepository('AppProductBundle:Product')
    	   ->findBy([
                'id' => $products->getKeys()
    	   ]);
    	
    	return ['products' => $products];
    }
    
    private function getProducts()
    {
    	return $this->getDoctrine()
            ->getRepository('AppProductBundle:Product')
            ->findAll();
    }
}