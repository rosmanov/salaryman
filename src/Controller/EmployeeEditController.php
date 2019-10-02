<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeEditController extends AbstractPageController
{
    /**
     * @Route("/employee/edit/{id}", name="employee_edit", requirements={"id"="\d+"})
     */
    public function index(int $id, EmployeeRepository $employeeRepo, Request $request, SerializerInterface $serializer)
    {
        if ($request->getRealMethod() === 'POST') {
            /**
             * @var Employee|null $employee
             */
            $employee = $serializer->deserialize(
                $request->getContent(),
                Employee::class,
                'json',
                SerializationContext::create()->setGroups(['editable'])
            );
            if (!$employee || $employee->getId() != $id) {
                $this->addFlash('error', 'Could not deserialize request data');
                $employee = $employeeRepo->findById($id);
            }
        } else {
            $employee = $employeeRepo->findById($id);
        }

        $parameters['employee'] = $employee;

        return $this->renderPage('employee/edit.html.twig', $parameters);
    }
}
