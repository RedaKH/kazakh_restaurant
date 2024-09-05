<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CustomLoginSuccessHandler implements AuthenticationSuccessHandlerInterface {

    private RouterInterface $router;
    

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        $roles = $token ->getUser()->getRoles();

        //redirige les roles dans leur propre dashboard
        if (in_array('ROLE_LIVREUR',$roles,true)) {

            $redirectURL = $this->router->generate('livreur_dashboard');

        }else {
            $redirectURL = $this->router->generate('employe_dashboard');

        }

        return new RedirectResponse($redirectURL);
        
    }


}






?>