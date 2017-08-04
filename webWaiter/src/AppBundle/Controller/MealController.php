<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Meal;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Meal controller.
 *
 * @Route("meal")
 */
class MealController extends BaseController
{
    /**
     * Lists all meal entities.
     *
     * @Route("/", name="meal_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $meals = $em->getRepository('AppBundle:Meal')->findAll();

        return $this->render('meal/index.html.twig', array(
            'meals' => $meals,
        ));
    }

    /**
     * Creates a new meal entity.
     *
     * @Route("/new", name="meal_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $meal = new Meal();
        $form = $this->createForm('AppBundle\Form\MealType', $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($meal);
            $em->flush();

            return $this->redirectToRoute('meal_show', array('id' => $meal->getId()));
        }

        return $this->render('meal/new.html.twig', array(
            'meal' => $meal,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a meal entity.
     *
     * @Route("/{id}", name="meal_show")
     * @Method("GET")
     */
    public function showAction(Meal $meal)
    {

        return $this->render('meal/show.html.twig', array(
            'meal' => $meal
        ));
    }


    /**
     * @Route("/show/{category}", name="show_meals_by_category")
     */
    public function showByCategoryAction($category)
    {
        $em = $this->getDoctrine()->getManager();

        $meals = $em->getRepository('AppBundle:Meal')->findByCategory($category);


        $client_order = $this->getUserOrder();
        $allElements = $this->getDoctrine()->getManager()->getRepository("AppBundle:Order_element")->findBy(['order'=>$client_order]);

        return $this->render('meal/show_meals_by_category.html.twig', array('meals'=>$meals, 'categories'=>$this->getAllCategories(), 'order_element'=>$allElements));
    }

}
