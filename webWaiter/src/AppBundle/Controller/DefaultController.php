<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;

class DefaultController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $client_order = $this->getUserOrder();
        $allElements = $this->getDoctrine()->getManager()->getRepository("AppBundle:Order_element")->findBy(['order'=>$client_order]);

        return $this->render("::base.html.twig", ['categories'=>$this->getAllCategories(), 'order_element'=>$allElements]);
    }
}
