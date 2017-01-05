<?php

namespace animalBundle\Controller;

use animalBundle\Entity\animal;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Animal controller.
 *
 * @Route("crudAnimaux")
 */
class animalController extends Controller
{
    /**
     * Lists all animal entities.
     *
     * @Route("/", name="crudAnimaux_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $animals = $em->getRepository('animalBundle:animal')->findAll();

        return $this->render('animal/index.html.twig', array(
            'animals' => $animals,
        ));
    }

    /**
     * Creates a new animal entity.
     *
     * @Route("/new", name="crudAnimaux_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $animal = new Animal();
        $form = $this->createForm('animalBundle\Form\animalType', $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($animal);
            $em->flush($animal);

            return $this->redirectToRoute('crudAnimaux_show', array('id' => $animal->getId()));
        }

        return $this->render('animal/new.html.twig', array(
            'animal' => $animal,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a animal entity.
     *
     * @Route("/{id}", name="crudAnimaux_show")
     * @Method("GET")
     */
    public function showAction(animal $animal)
    {
        $deleteForm = $this->createDeleteForm($animal);

        return $this->render('animal/show.html.twig', array(
            'animal' => $animal,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing animal entity.
     *
     * @Route("/{id}/edit", name="crudAnimaux_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, animal $animal)
    {
        $deleteForm = $this->createDeleteForm($animal);
        $editForm = $this->createForm('animalBundle\Form\animalType', $animal);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('crudAnimaux_edit', array('id' => $animal->getId()));
        }

        return $this->render('animal/edit.html.twig', array(
            'animal' => $animal,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a animal entity.
     *
     * @Route("/{id}", name="crudAnimaux_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, animal $animal)
    {
        $form = $this->createDeleteForm($animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($animal);
            $em->flush($animal);
        }

        return $this->redirectToRoute('crudAnimaux_index');
    }

    /**
     * Creates a form to delete a animal entity.
     *
     * @param animal $animal The animal entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(animal $animal)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('crudAnimaux_delete', array('id' => $animal->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
