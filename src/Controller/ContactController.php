<?php

namespace App\Controller;

use App\Form\ContactEmailType;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;



class ContactController extends AbstractController
{

    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request,EmailService $service) : Response{

        $form = $this->createForm(ContactEmailType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            if($data['fichierjoindre'] != ""){
                $service->sendEmailWithPieceJoin($data['email'],$data['subject'],$data['message'],$data['fichierjoindre']);
            }
            else{
                $service->sendEmail($data['email'],$data['subject'],$data['message']);
            }
        }


        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
