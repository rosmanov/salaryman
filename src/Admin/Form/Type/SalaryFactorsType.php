<?php
declare(strict_types=1);

namespace App\Admin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalaryFactorsType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'rules' => '{}',
        ]);
    }

    //public function buildForm(FormBuilderInterface $builder, array $options)
    //{
    //}

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['rules'] = $options['rules'] ?? '{}';
        $view->vars['attr'] = $options['attr'] ?? [];
    }
}
