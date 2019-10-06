<?php
declare(strict_types=1);

namespace App\Admin;

use App\Admin\Form\Type\SalaryFactorsType;
use App\Dto\Message\SalaryFactorUpdateMessage;
use App\Entity\SalaryFactor;
use App\Producer\EventProducerInterface;
use App\Repository\EmployeeRepository;
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
     * @var EventProducerInterface
     */
    private $eventProducer;

    /**
     * @var EmployeeRepository
     */
    private $employeeRepo;

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
                    SalaryFactor::BONUS_TYPE => 'Bonus',
                    SalaryFactor::DEDUCTION_TYPE => 'Deduction',
                ],
            ])
            ->add('valueType', 'choice', [
                'choices' => [
                    SalaryFactor::NUMERIC_VALUE_TYPE => 'Numeric',
                    SalaryFactor::PERCENT_VALUE_TYPE => 'Percent',
                ]
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

    public function setEmployeeRepository(EmployeeRepository $employeeRepo): void
    {
        $this->employeeRepo = $employeeRepo;
    }

    public function setEventProducer(EventProducerInterface $eventProducer): void
    {
        $this->eventProducer = $eventProducer;
    }

    /**
     * {@inheritDoc}
     * @param Employee $object
     */
    public function preUpdate($object)
    {
        $this->employeeRepo->resetActualSalary();
    }

    /**
     * {@inheritDoc}
     * @param Employee $object
     */
    public function prePersist($object)
    {
        $this->employeeRepo->resetActualSalary();
    }

    /**
     * {@inheritDoc}
     */
    public function postUpdate($object)
    {
        $this->updateSalary($object);
    }

    /**
     * {@inheritDoc}
     */
    public function postPersist($object)
    {
        $this->updateSalary($object);
    }

    /**
     * Is called from postUpdate and postPersist methods.
     */
    private function updateSalary(SalaryFactor $factor): void
    {
        $message = new SalaryFactorUpdateMessage();
        $message->addFactor($factor);
        $this->eventProducer->send($message);
    }
}
