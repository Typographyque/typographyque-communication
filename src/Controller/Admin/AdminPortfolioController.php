<?php
namespace App\Controller\Admin;

use App\Entity\Work;
use App\Form\WorkType;
use App\Repository\WorkRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

Class AdminPortfolioController extends AbstractController
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
     * AdminPortfolioController constructor.
     * @param WorkRepository $repository
     * @param ObjectManager $manager
     */
    public function __construct(WorkRepository $repository, ObjectManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/portfolio", name="admin.portfolio")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $works = $this->repository->findAll();
        return $this->render("admin/portfolio/index.html.twig", compact('works'));
    }

    /**
     * @Route("/admin/portfolio/create", name="admin.work.new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $work = new Work();
        $form = $this->createForm(WorkType::class, $work);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($work);
            $this->manager->flush();

            /* todo les messages flash ne fonctionent pas */
            $this->addFlash('success', 'Votre élément a bien été créé');

            return $this->redirectToRoute('admin.portfolio');
        }

        return $this->render("admin/portfolio/new.html.twig", [
            'work' => $work,
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/portfolio/{id}", name="admin.work.edit", methods={"GET|POST"})
     * @param Work $work
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Work $work, Request $request)
    {
        $form = $this->createForm(WorkType::class, $work);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', 'Votre élément a bien été modifié');

            return $this->redirectToRoute('admin.portfolio');
        }

        return $this->render("admin/portfolio/edit.html.twig", [
            'work' => $work,
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/portfolio/{id}", name="admin.work.delete", methods={"DELETE"})
     * @param Work $work
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Work $work, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $work->getId(), $request->get('_token'))) {
            $this->manager->remove($work);
            $this->manager->flush();
            $this->addFlash('success', 'Votre élément a bien été supprimé');

        }

        return $this->redirectToRoute('admin.portfolio');

    }
}