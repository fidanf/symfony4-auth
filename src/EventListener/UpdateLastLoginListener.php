<?php


namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class UpdateLastLoginListener implements AuthenticationSuccessHandlerInterface
{
    private $em;

    private $r;

    public function __construct(EntityManagerInterface $em, RouterInterface $r)
    {
        $this->em = $em;
        $this->r = $r;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $token = $event->getAuthenticationToken();
        $request = $event->getRequest();
        $this->onAuthenticationSuccess($request, $token);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();
        $user->setLastLogin(new \DateTime());
        $this->em->persist($user);
        $this->em->flush();

        return new RedirectResponse(
            $request->getSession()->get('_security.main.target_path') ??
            $this->r->generate('index')
        );
    }
}