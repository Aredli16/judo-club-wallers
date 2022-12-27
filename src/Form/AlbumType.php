<?php

namespace App\Form;

use App\Entity\Image;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

/**
 * @codeCoverageIgnore
 */
class AlbumType extends AbstractType
{
    public function __construct(private readonly ParameterBagInterface $parameter)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('photos', FileType::class, [
                'label' => false,
                'multiple' => true,
                'attr' => [
                    'accept' => 'image/*'
                ],
                'constraints' => [
                    new All([
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => ['image/*'],
                            'mimeTypesMessage' => 'Veuillez sélectionner uniquement des fichiers images'
                        ])
                    ])
                ],
            ])
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray) {
                },
                function (array $tagsAsString) {
                    $uploaded_files = $tagsAsString['photos'];

                    $images = new ArrayCollection();
                    /** @var UploadedFile $file */
                    foreach ($uploaded_files as $file) {
                        $image = (new Image())
                            ->setName(md5(uniqid()) . '.' . $file->guessExtension());

                        copy($file->getRealPath(), $this->parameter->get('images_directory') . '/' . $image->getName());

                        $images->add($image);
                    }

                    return $images;
                }
            ));
    }
}
