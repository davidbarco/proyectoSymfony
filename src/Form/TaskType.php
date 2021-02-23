<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class TaskType extends AbstractType{
      
     public function buildForm(FormBuilderInterface $builder, array $options){
             
            /* campos de mi formulario */
            $builder->add('title',TextType::class, array(
                'label'=>'Titulo'

            ))
            ->add('content',TextareaType::class, array(
                'label'=>'Contenido',
               
            ))
            ->add('priority',ChoiceType::class, array(
                'label'=>'Prioridad',
                'choices'=> array(
                    'Alta'=>'high',
                    'Media'=>'medium',
                    'Baja'=>'low',
                )
            ))
            ->add('hours', TextType::class, array(
                'label'=>'Horas Presupuestadas'
            ))
            ->add('submit',SubmitType::class, array(
                'label'=>'Guardar',
                'attr'=> ['class' => 'btn btn-primary']
            ));
        
     }
}














?>