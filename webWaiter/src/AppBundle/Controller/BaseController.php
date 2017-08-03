<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class BaseController extends Controller
{
    protected function getAllCategories(){
        $em = $this->getDoctrine()->getRepository("AppBundle\Entity\Category");
        return $em->findAll();
    }
}