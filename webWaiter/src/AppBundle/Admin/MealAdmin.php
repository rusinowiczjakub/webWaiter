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
            ->add('image', 'sonata_type_admin', array(
                'delete' => false
            ));

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        // ... configure $listMapper

        $listMapper
            ->addIdentifier('category_id')
            ->addIdentifier('meal_name')
            ->addIdentifier('description')
            ->addIdentifier('price')
            ->addIdentifier('image_id');
    }

    public function toString($object)
    {
        return $object instanceof Meal
            ? $object->getMealName()
            : 'Meal'; // shown in the breadcrumb on the create view
    }


    public function prePersist($page)
    {
        $this->manageEmbeddedImageAdmins($page);
    }

    public function preUpdate($page)
    {
        $this->manageEmbeddedImageAdmins($page);
    }

    private function manageEmbeddedImageAdmins($page)
    {
        // Cycle through each field
        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
            // detect embedded Admins that manage Images
            if ($fieldDescription->getType() === 'sonata_type_admin' &&
                ($associationMapping = $fieldDescription->getAssociationMapping()) &&
                $associationMapping['targetEntity'] === 'AppBundle\Entity\Image'
            ) {
                $getter = 'get'.$fieldName;
                $setter = 'set'.$fieldName;

                /** @var Image $image */
                $image = $page->$getter();

                if ($image) {
                    if ($image->getFile()) {
                        // update the Image to trigger file management
                        $image->refreshUpdated();
                    } elseif (!$image->getFile() && !$image->getFilename()) {
                        // prevent Sf/Sonata trying to create and persist an empty Image
                        $page->$setter(null);
                    }
                }
            }
        }
    }



}