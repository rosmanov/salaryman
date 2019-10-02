<?php declare(strict_types=1);

namespace App\Service\Generator;

use App\Entity\Page;
use App\Repository\PageRepository;

class PageGenerator
{
    /**
     * @var PageRepository
     */
    private $pageRepo;

    public function __construct(PageRepository $pageRepo)
    {
        $this->pageRepo = $pageRepo;
    }

    /**
     * @return Page[]
     */
    public function generateList() : array
    {
        return $this->pageRepo->findBy([], ['position' => 'ASC']);
    }
}
