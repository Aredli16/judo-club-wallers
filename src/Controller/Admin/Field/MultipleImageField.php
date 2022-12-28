<?php

namespace App\Controller\Admin\Field;

use App\Controller\Admin\Form\ImageType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class MultipleImageField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormTypeOption('label', false)
            ->setFormType(ImageType::class)
            ->onlyOnForms();
    }
}