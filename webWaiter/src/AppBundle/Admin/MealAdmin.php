<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class MealAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('category', EntityType::class, array(
                'class'=>'AppBundle\Entity\Category',
                'choice_label'=>'name'
            ))
            ->add('meal_name', TextType::class)
            ->add('description', TextType::class)
            ->add('price', NumberType::class)
            ->add('img', HiddenType::class, array(
                'data'=>'0'
            ));

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        // ... configure $listMapper

        $listMapper
            ->addIdentifier('category_id', 'sonata_type_model', array(
                'class'=>'AppBundle\Entity\Category',
                'choice_label'=>'name'
            ))
            ->addIdentifier('meal_name')
            ->addIdentifier('description')
            ->addIdentifier('price');
    }

    public function toString($object)
    {
        return $object instanceof Meal
            ? $object->getMealName()
            : 'Meal'; // shown in the breadcrumb on the create view
    }
}