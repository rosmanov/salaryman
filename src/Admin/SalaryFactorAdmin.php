<?php
declare(strict_types=1);

namespace App\Admin;

use App\Admin\Form\Type\SalaryFactorsType;
use App\Entity\SalaryFactor;
use Psr\Log\LoggerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class SalaryFactorAdmin extends AbstractAdmin
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var array
     */
    protected $datagridValues = [
        // name of the ordered field (default = the model's id field, if any)
        '_sort_by' => 'name',
        '_sort_order' => 'ASC'
    ];
    /**
     * @var string
     */
    protected $translationDomain = 'SonataAdminBundle';

    /**
     * @inheritdoc
     * @return void
     */
    protected function configureFormFields(\Sonata\AdminBundle\Form\FormMapper $form)
    {
        $form
            ->add('name', TextType::class)
            ->add('rules', SalaryFactorsType::class)
            ->add('type', ChoiceFieldMaskType::class, [
                'choices' => [
                    'Bonus' => SalaryFactor::BONUS_TYPE,
                    'Deduction' => SalaryFactor::DEDUCTION_TYPE,
                ]
            ])
            ->add('valueType', ChoiceType::class, [
                'choices' => [
                    'Numeric' => SalaryFactor::NUMERIC_VALUE_TYPE,
                    'Percent' => SalaryFactor::PERCENT_VALUE_TYPE,
                ]
            ])
            ->add('value', NumberType::class, [
                'empty_data' => 0,
            ])
        ;
    }

    /**
     * @inheritdoc
     * @return void
     */
    protected function configureDatagridFilters(\Sonata\AdminBundle\Datagrid\DatagridMapper $filter)
    {
        $filter
            ->add('name')
            ->add('type')
            ->add('valueType')
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureListFields(\Sonata\AdminBundle\Datagrid\ListMapper $list)
    {
        $list
            ->addIdentifier('name', 'string')
            ->add('type', 'choice', [
                'choices' => [
                    'Bonus' => SalaryFactor::BONUS_TYPE,
                    'Deduction' => SalaryFactor::DEDUCTION_TYPE,
                ]
            ])
            ->add('valueType', 'choice', [
                    'Numeric' => SalaryFactor::NUMERIC_VALUE_TYPE,
                    'Percent' => SalaryFactor::PERCENT_VALUE_TYPE,
            ])
            ->add('value', 'number', [
                'editable' => true,
            ])
        ;
    }

    /**
     * Used in config/services.yaml
     *
     * @param LoggerInterface $logger
     * @return void
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function postPersist($object): void
    {
    }

    /**
     * @inheritdoc
     */
    public function postUpdate($object): void
    {
    }
}
