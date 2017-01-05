<?php

namespace animalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use animalBundle\Entity\animal;
use animalBundle\Form\animalType;
	
use Symfony\Component\HttpFoundation\Request;

class AnimauxController extends Controller {

    public function ajouterAnimalAction(Request $request) {
        
        
   
     $animal = new animal();

    
     $form= $this->createForm(animalType::class,$animal) ; 
     
     $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($animal);
        $em->flush();
        

       $this->get('session')->getFlashBag()->add(
        'notice',
        'Animal Ajouté Avec Succes'
    );
    }

     


        return $this->render('animalBundle:Default:index.html.twig',array("formAnimal"=>$form->createView()));
    }

}
