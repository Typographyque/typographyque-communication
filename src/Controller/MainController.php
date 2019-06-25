<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/slider", name="slider")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function slider(): Response
    {
        return $this->render('main/slider.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/", name="home")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home(): Response
    {
        return $this->render('main/home.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/services", name="servises")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function services(): Response
    {
        return $this->render('main/services.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/edition", name="edition")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edition(): Response
    {
        return $this->render('main/edition.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/graphisme", name="graphisme")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function graphisme(): Response
    {
        return $this->render('main/graphisme.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/web", name="web")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function web(): Response
    {
        return $this->render('main/web.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function contact(Request $request, ContactNotification $notification): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $notification->notify($contact);
            $this->addFlash('success', 'Votre menssage a bien été envoyé');
            return $this->redirectToRoute('contact');
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
