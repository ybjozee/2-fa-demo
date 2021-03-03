<?php

namespace App\Controller;

use App\Service\AuthyHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticationController extends AbstractController {

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    : Response {

        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/verify", name="app_verify_otp")
     */
    public function verifyOTP(Request $request, AuthyHelper $authy)
    : Response {

        $error = null;
        if ($request->getMethod() === 'POST') {

            $token = $request->request->get('token');
            $userAuthyId = $this->getUser()->getAuthyId();

            try {

                $authy->verifyUserToken($userAuthyId, $token);
                $this->get('session')->set('2fa-verified', true);

                return $this->redirectToRoute('dashboard');

            }
            catch (\App\Exception\VerificationException $exception) {
                $error = $exception->getMessage();
            }
        }

        return $this->render(
            'security/verify.html.twig',
            [
                'error' => $error
            ]
        );
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout() {

        throw new \LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.'
        );
    }
}
