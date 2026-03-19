<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Formation;
use App\Entity\Playlist;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;


class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('publishedAt', DateType::class, [
                'widget' => 'single_text',
                'data' => isset($options['data']) &&
                 $options['data']->getPublishedAt() != null ? $options['data']->getPublishedAt() : new DateTime('now'),
                'label' => 'Date'
            ])
            ->add('title', null,[
                'label' => 'Titre'
            ])
            ->add('description', null,[
                'label' => 'Description'
            ])
            // champ youtube 
           /* ->add('videoId', null, [
                   'required' => false,
                    'label' => 'ID YouTube (ex: dQw4w9WgXcQ)'
                  ])*/
            // champ mp4 
            ->add('videoFile', VichFileType::class,[
                'required' => false,
                'label' => 'Sélection Vidéo (MP4)',
                'download_uri' => false
            ])
            
            ->add('playlist', EntityType::class, [
                'class' => Playlist::class,
                'choice_label' => 'id',
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'id',
                'multiple' => true,
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
