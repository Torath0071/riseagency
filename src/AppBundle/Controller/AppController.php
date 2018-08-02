<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Subscription;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AppController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        // Ajax request
        if ($request->isXmlHttpRequest()) {
            $method = $request->request->get('action');
            if (!$method || !method_exists($this, $method)) {
                throw new BadRequestHttpException('Invalid request');
            }
            return new JsonResponse(['data' => call_user_func([$this, $method], $request)]);
        }

        // Simple display
        $twigVariables = [
        ];
        return $this->render('default/index.html.twig', $twigVariables);
    }

    public function subscribe(Request $request):array
    {
        $email = $request->request->get('EMAIL');
        if (!$email) {
            return ['error' => 'Veuillez entrer votre email'];
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['error' => 'Veuillez entrer un email valide'];
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $exist = $em->getRepository(Subscription::class)
                ->findBy(['email' => $email]);
            if (!$exist) {
                $em->persist((new Subscription())
                    ->setEmail($email)
                    ->setCreationDate(new \DateTime())
                    ->setIpAddress($request->getClientIp())
                );
                $em->flush();
            }
        } catch (\Exception $e) {
            return ['error' => "Erreur lors de l'enregistrement"];
        }
        return ['success' => "Inscription validée"];
    }

    public function contact(Request $request):array
    {
        $ret = [];
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $subject = $request->request->get('subject');
        $message = $request->request->get('message');

        if (!$name) {
            $ret['empty-name'] = "Veuillez entrer votre nom";
        }
        if (!$email) {
            $ret['empty-email'] = 'Veuillez entrer votre email';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $ret['invalid-email'] = 'Veuillez entrer un email valide';
        }
        if (!$subject) {
            $ret['empty-subject'] = 'Veuillez entrer un objet';
        }
        if (!$message) {
            $ret['empty-message'] = 'Veuillez entrer un message';
        }
        if (count($ret)) {
            return $ret;
        }

        try {
            $contact = (new Contact())
                ->setName($name)
                ->setEmail($email)
                ->setSubject($subject)
                ->setMessage($message)
                ->setCreationDate(new \DateTime())
                ->setIpAddress($request->getClientIp());

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            if (!$this->sendContactMail($contact)) {
                return ['error' => 'Votre message a bien été enregistré mais ne peut pas être envoyé pour le moment. Nous le recevrons sous peu'];
            } else {
                $contact->setSent(true);
                $em->flush();
            }
        } catch(\Exception $e) {
            return ['error' => "Erreur lors de l'envoi du message " . $e->getMessage() ];
        }

        return ['success' => "Message envoyé avec succès"];
    }

    /**
     * @param Contact $contact
     * @return bool
     * @throws \Exception
     */
    private function sendContactMail(Contact $contact):bool
    {
        try {
            $message = \Swift_Message::newInstance()
                ->setFrom($this->container->getParameter('contact_from_email'), $this->container->getParameter('contact_from_name'))
                ->setTo($this->container->getParameter('contact_to_email'), $this->container->getParameter('contact_to_name'))
                ->setReplyTo($contact->getEmail())
                ->setSubject("[Rise Agency - Contact]" . $contact->getSubject())
                ->setBody($this->renderView('Email/contact.html.twig', ['contact' => $contact]), 'text/html');

            $this->get('mailer')->send($message);
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
