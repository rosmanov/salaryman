<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractPageController
{
    /**
     * @Route("/", name="employee")
     */
    public function index()
    {
        $params['pages'] = $this->pageRepo->findAll();
        return $this->renderPage('employee/list.html.twig', $params);
    }
}
