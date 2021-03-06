<?php
// src/AppBundle/Admin/ImageAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;

use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Image;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('file', 'file', array(
                'required' => false,
            ))
            ->add('meal', EntityType::class, array(
                'choice_label'=>"mealName",
                'class'=>"AppBundle\Entity\Meal"
            ));
    }




    public function prePersist($image)
    {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image)
    {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload($image)
    {
        if ($image->getFile()) {
            $image->refreshUpdated();
        }
    }

    // ...
}