<?php

namespace App\Controller;

use App\Entity\Work;
use App\Repository\WorkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends AbstractController
{
    /**
     * @Route("/portfolio", name="portfolio")
     * @return Response
     */
    public function index(WorkRepository $repository): Response
    {
        $works = $repository->findAll();

        return $this->render('portfolio/index.html.twig', [
            'works' => $works,
            dump($works)
        ]);
    }

    /**
     * @Route("portfolio/{slug}-{id}", name="work", requirements={"slug": "[a-z0-9\-]*"})
     * @param WorkRepository $repository
     * @return Response
     */
    public function work(Work $work, string $slug, WorkRepository $repository): Response
    {
        if ($work->getSlug() !== $slug) {
            return $this->redirectToRoute('work', [
                'id' => $work->getId(),
                'slug' => $work->getSlug()
            ], 301);
        }

        return $this->render('portfolio/work.html.twig', [
            'work'=> $work,
        ]);

    }
}
