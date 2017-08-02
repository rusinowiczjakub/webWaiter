<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Client_order;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Client_order controller.
 *
 * @Route("client_order")
 */
class Client_orderController extends BaseController
{
    /**
     * Lists all client_order entities.
     *
     * @Route("/", name="client_order_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $client_orders = $em->getRepository('AppBundle:Client_order')->findAll();

        return $this->render('client_order/index.html.twig', array(
            'client_orders' => $client_orders,
        ));
    }

    /**
     * Creates a new client_order entity.
     *
     * @Route("/new", name="client_order_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $client_order = new Client_order();
        $form = $this->createForm('AppBundle\Form\Client_orderType', $client_order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client_order);
            $em->flush();

            return $this->redirectToRoute('client_order_show', array('id' => $client_order->getId()));
        }

        return $this->render('client_order/new.html.twig', array(
            'client_order' => $client_order,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a client_order entity.
     *
     * @Route("/{id}", name="client_order_show")
     * @Method("GET")
     */
    public function showAction(Client_order $client_order)
    {
        $deleteForm = $this->createDeleteForm($client_order);

        return $this->render('client_order/show.html.twig', array(
            'client_order' => $client_order,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing client_order entity.
     *
     * @Route("/{id}/edit", name="client_order_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Client_order $client_order)
    {
        $deleteForm = $this->createDeleteForm($client_order);
        $editForm = $this->createForm('AppBundle\Form\Client_orderType', $client_order);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_order_edit', array('id' => $client_order->getId()));
        }

        return $this->render('client_order/edit.html.twig', array(
            'client_order' => $client_order,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a client_order entity.
     *
     * @Route("/{id}", name="client_order_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Client_order $client_order)
    {
        $form = $this->createDeleteForm($client_order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($client_order);
            $em->flush();
        }

        return $this->redirectToRoute('client_order_index');
    }

    /**
     * Creates a form to delete a client_order entity.
     *
     * @param Client_order $client_order The client_order entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Client_order $client_order)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('client_order_delete', array('id' => $client_order->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
