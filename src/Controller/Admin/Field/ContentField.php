<?php

namespace App\Controller\Admin\Field;

use App\Controller\Admin\Form\ContentType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class ContentField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormTypeOption('label', false)
            ->setFormType(ContentType::class)
            ->onlyOnForms();
    }
}