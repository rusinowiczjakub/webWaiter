<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Client_order;
use AppBundle\Entity\Meal;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

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
     * @Method("POST")
     */
    public function newAction(Request $request)
    {

        $quantity = $request->request->get('quantity');
        $meal = $request->request->get('meal');

        $session = new Session();

        $session->set('meal', $meal);
        $session->set('quantity', $quantity);

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $order = $this->getDoctrine()->getRepository('AppBundle:Client_order')->findBy(['status'=>0, 'user'=>$user]);

        if(empty($order)) {
            $client_order = new Client_order();
            $client_order->setPrice(0);
            $client_order->setUser($user);
            $client_order->setStatus(0);

            $this->save($client_order);
        }
        return $this->redirectToRoute('order_element_new');
    }


    /**
     * Deletes a client_order entity.
     *
     * @Route("/delete", name="client_order_delete")
     */
    public function deleteAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $order = $this->getDoctrine()->getRepository('AppBundle:Client_order')->findBy(['status'=>0, 'user'=>$user]);

        if(!empty($order)){
            $order_elements = $this->getDoctrine()->getRepository('AppBundle:Order_element')->findBy(['order'=>$order]);
            $em = $this->getDoctrine()->getManager();
            foreach($order_elements as $element){
            $em->remove($element);
            $em->flush();
            }
            $em->remove($order[0]);
            $em->flush();
        }
            $em = $this->getDoctrine()->getManager();
            $em->remove($order[0]);
            $em->flush();


        return $this->redirectToRoute('homepage');
    }


    /**
     * @Route("/order_status", name="order_status")
     * @Method({"GET", "POST"})
     */
    public function orderPayAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $order = $this->getDoctrine()->getRepository('AppBundle:Client_order')->findBy(['status'=>0, 'user'=>$user]);

        $order[0]->setStatus(2);
        $em = $this->getDoctrine()->getManager();
        $em->persist($order[0]);
        $em->flush();

        return $this->render('client_order/order_status.html.twig', ['order'=>$order[0]]);

    }


}
