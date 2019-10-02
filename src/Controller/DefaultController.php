<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\EmployeeRepository;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractPageController
{
    /**
     * @Route("/", name="employees")
     */
    public function index(EmployeeRepository $employeeRepo)
    {
        $parameters['employees'] = $employeeRepo->findBy([], ['last_name' => 'ASC']);
        return $this->renderPage('employee/list.html.twig', $parameters);
    }
}
