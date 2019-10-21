<?php

namespace App\Controller\Admin;

use App\Repository\WorkRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @var WorkRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * AdminController constructor.
     * @param WorkRepository $repository
     * @param ObjectManager $manager
     */
    public function __construct(WorkRepository $repository, ObjectManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $works = $this->repository->findLasted();

        return $this->render('admin/index.html.twig', compact('works'));
    }

}