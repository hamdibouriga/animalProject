<?php

namespace animalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use animalBundle\Entity\animal;
use animalBundle\Form\animalType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $animal = new animal();
        $form = $this->createForm( animalType::class, $animal);
        
      return $this->render('animalBundle:Default:index.html.twig',array("formAnimal"=>$form->createView()));
    }
}
