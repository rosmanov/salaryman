<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class SalaryFactorsController extends AbstractPageController
{
    /**
     * @Route("/salary-factors", name="salary-factors")
     */
    public function index()
    {
        $params['pages'] = $this->pageRepo->findAll();
        return $this->renderPage('salary-factors/list.html.twig', $params);
    }
}
