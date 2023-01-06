<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request, EmailService $service): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if ($data['files'] != null) {
                $service->sendEmail($data['email'], $data['subject'], $data['message'], $data['files']);

            } else {
                $service->sendEmail($data['email'], $data['subject'], $data['message']);
            }

        }
        $this->redirectToRoute('app_contact', [], Response::HTTP_SEE_OTHER);

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
