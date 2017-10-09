<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subscription;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DefaultController extends Controller
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
            return ['error' => 'Veuillez entrer une adresse email'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['error' => 'Format de l\'email incorrect'];
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $exist = $em->getRepository('AppBundle\Entity\Subscription')
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
            return ['error' => "Erreur lors de l'enregistrement " . $e->getMessage() ];
        }
        return ['success' => "Inscription validée"];
    }

    public function contact(Request $request):array
    {

        return [];
    }
}
