<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Meal;
use AppBundle\Entity\Order_element;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

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
     * @Route("/order_info", name="order_info")
     * @Method("GET")
     */
    public function orderInfoAction()
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $order = $this->getDoctrine()->getRepository('AppBundle:Client_order')->findBy(['status'=>0, 'user'=>$user]);

        $order_elements = $this->getDoctrine()->getRepository('AppBundle:Order_element')->findBy(['order'=>$order]);



        return $this->render('/order_element/order_info.html.twig', ['order_elements'=>$order_elements, "categories"=>$this->getAllCategories()]);
    }

    /**
     * Creates a new order_element entity.
     *
     * @Route("/new", name="order_element_new")
     * @Method({"POST", "GET"})
     */
    public function newAction(Request $request)
    {

        $session = new Session();

        $meal = $session->get('meal');
        $quantity = $session->get('quantity');
        $mealObject = $this->getDoctrine()->getRepository('AppBundle:Meal')->findBy(['id'=>$meal]);


        $user = $this->get('security.token_storage')->getToken()->getUser();
        $order = $this->getDoctrine()->getRepository('AppBundle:Client_order')->findBy(['status'=>0, 'user'=>$user]);


        $order_element = new Order_element();
        $order_element->setQuantity($quantity);
        $order_element->setMeals($mealObject[0]);
        $order_element->setOrder($order[0]);
        $this->save($order_element);


        //get price of element * quentity
        $priceOfOneElement = $mealObject[0]->getPrice();
        $priceOfThisOrder = $priceOfOneElement * $quantity;
        $priceBeforeOrder = $order[0]->getPrice();
        //update price in Client_order
        $updatedPrice = $priceBeforeOrder + $priceOfThisOrder;
        //save updated price
        $order[0]->setPrice($updatedPrice);
        //save changes to DB
        $this->save($order[0]);

        $session->remove('meal');
        $session->remove('quantity');

        return $this->redirect(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
    }

    /**
     * Finds and displays a order_element entity.
     *
     * @Route("/", name="order_element_show")
     * @Method("GET")
     */
    public function showAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $order = $this->getDoctrine()->getRepository('AppBundle:Client_order')->findBy(['status'=>0, 'user'=>$user]);

        $order_element = $this->getDoctrine()->getRepository()->findBy(['order_id'=>$order]);

        return $this->render('::base.html.twig', ['order_element'=>$order_element]);
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
     */
    public function deleteAction(Request $request, Order_element $order_element)
    {
        $elementToDelete = $this->getDoctrine()->getRepository('AppBundle:Order_element')->find($order_element);
        $em = $this->getDoctrine()->getManager();
        $em->remove($elementToDelete);
        $em->flush();

        return $this->redirect(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
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
