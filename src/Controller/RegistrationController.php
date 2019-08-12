<?php 

namespace App\Controller;
 
use App\Form\UserType;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="security_registration")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param TokenStorageInterface $tokenStorage
     * @return RedirectResponse|Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, TokenStorageInterface $tokenStorage)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
 
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());
            $tokenStorage->setToken($token);

            $this->addFlash('success', 'You have been successfully registered! Congratulations');
            return $this->redirectToRoute('index');
        }
 
        return $this->render(
            'security/register.html.twig',
            array('form' => $form->createView())
        );
    }
}