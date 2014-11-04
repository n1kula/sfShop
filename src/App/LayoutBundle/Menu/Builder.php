<?php

namespace App\LayoutBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $menu->addChild('Produkty', ['uri' => '#'])
            ->setAttribute('class', 'dropdown')
            ->setLinkAttribute('class', 'dropdown-toggle')
            ->setLinkAttribute('data-toggle', 'dropdown')
            ->setChildrenAttribute('class', 'dropdown-menu');;
        $menu['Produkty']->addChild('Lista Produktów', array('route' => 'product_list'));
        $menu['Produkty']->addChild('Dodaj nowy', array('route' => 'product_new'));
        
        $menu->addChild('Kategorie', ['uri' => '#'])
            ->setAttribute('class', 'dropdown')
            ->setLinkAttribute('class', 'dropdown-toggle')
            ->setLinkAttribute('data-toggle', 'dropdown')
            ->setChildrenAttribute('class', 'dropdown-menu');
        
        $menu['Kategorie']->addChild('Lista', array('route' => 'category'));
        $menu['Kategorie']->addChild('Dodaj nową', array('route' => 'category_new'));
        
        return $menu;
    }
    
    
    public function footerMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-justified');

        $menu->addChild('Produkty', ['route' => 'product_list'])
                ;
        $menu->addChild('Dodaj nowy Produkt', ['route' => 'product_new'])
                ;
        $menu->addChild('Kategorie', ['route' => 'category'])
               ;
        $menu->addChild('Dodaj nową', ['route' => 'category_new'])
                ;
        
        return $menu;
    }
    
}