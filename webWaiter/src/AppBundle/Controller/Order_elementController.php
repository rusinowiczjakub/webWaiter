<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order_element;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Order_element controller.
 *
 * @Route("order_element")
 */
class Order_elementController extends BaseController
{
    /**
     * Lists all order_element entities.
     *
     * @Route("/", name="order_element_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $order_elements = $em->getRepository('AppBundle:Order_element')->findAll();

        return $this->render('order_element/index.html.twig', array(
            'order_elements' => $order_elements,
        ));
    }

    /**
     * Creates a new order_element entity.
     *
     * @Route("/new", name="order_element_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $order_element = new Order_element();
        $form = $this->createForm('AppBundle\Form\Order_elementType', $order_element);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order_element);
            $em->flush();

            return $this->redirectToRoute('order_element_show', array('id' => $order_element->getId()));
        }

        return $this->render('order_element/new.html.twig', array(
            'order_element' => $order_element,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a order_element entity.
     *
     * @Route("/{id}", name="order_element_show")
     * @Method("GET")
     */
    public function showAction(Order_element $order_element)
    {
        $deleteForm = $this->createDeleteForm($order_element);

        return $this->render('order_element/show.html.twig', array(
            'order_element' => $order_element,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing order_element entity.
     *
     * @Route("/{id}/edit", name="order_element_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Order_element $order_element)
    {
        $deleteForm = $this->createDeleteForm($order_element);
        $editForm = $this->createForm('AppBundle\Form\Order_elementType', $order_element);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_element_edit', array('id' => $order_element->getId()));
        }

        return $this->render('order_element/edit.html.twig', array(
            'order_element' => $order_element,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a order_element entity.
     *
     * @Route("/{id}", name="order_element_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Order_element $order_element)
    {
        $form = $this->createDeleteForm($order_element);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($order_element);
            $em->flush();
        }

        return $this->redirectToRoute('order_element_index');
    }

    /**
     * Creates a form to delete a order_element entity.
     *
     * @param Order_element $order_element The order_element entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Order_element $order_element)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('order_element_delete', array('id' => $order_element->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
