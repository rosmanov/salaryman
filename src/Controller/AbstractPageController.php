<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractPageController extends AbstractController
{
    /**
     * @var PageRepository
     */
    protected $pageRepo;

    public function __construct(PageRepository $pageRepo)
    {
        $this->pageRepo = $pageRepo;
    }

    protected function renderPage(string $view, array $parameters = [], Response $response = null) : Response
    {
        return $this->render(
            $view,
            array_merge($this->getDefaultParameters(), $parameters),
            $response
        );
    }

    /**
     * @return array
     */
    private function getDefaultParameters() : array
    {
        /**
         * @var Request
         * @todo Find a better way to get Request via DI
         */
        $request = $this->container->get('request_stack')->getCurrentRequest();

        $parameters['currentPage'] = $request instanceof Request
            ? $this->pageRepo->findOneByUri($request->getPathInfo())
            : null;

        return $parameters;
    }
}
